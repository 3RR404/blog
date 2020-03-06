<?php

	use WideImage\WideImage;

	// include
	require '../_inc/config.php';

	// just to be safe
	if ( ! logged_in() ) {
		redirect('/');
	}

	// c'mon baby do the locomo.. validation
	if ( ! $data = validate_post() ) {
		redirect('back');
	}


	extract( $data );
	$slug = slugify( $title );

	// have a permission?
	$usr = get_user();
	if ( ! can( false, 'post', 'create' ) ) {
		flash()->error('what are you trying to pull here');
		redirect('back');
	}

	if ( isset( $_FILES['image']['tmp_name'] ) && !empty( $_FILES['image']['tmp_name'] ) )
	{
		$tmp_file = $_FILES['image']['tmp_name'];
		$file_name = $_FILES['image']['name'];
		$f_name = uniqid() . '_' . $file_name;
		$sourceDir = UPLOAD_DIR . 'source/';
		$thumbDir = UPLOAD_DIR . 'thumb/';

		if( file_exists( $sourceDir . $file_name ) )
		{
			move_uploaded_file( $tmp_file, $sourceDir . $file_name );
		}

		$thumbnail = WideImage::load( $sourceDir . $file_name );
		$thumbnail->resize( 350, 350 )->saveToFile( $thumbDir . $f_name );
		
		$img = $f_name;
	}

	$query = $db->prepare("
		INSERT INTO posts
			( user_id, title, text, slug, image )
		VALUES
			( :uid, :title, :text, :slug, :image )
	");

	$insert = $query->execute([
		'uid'   => get_user()->uid,
		'title' => $title,
		'text'  => $text,
		'slug'  => $slug,
		'image' => $img
	]);


	if ( ! $insert )
	{
		flash()->warning( 'sorry, girl' );
		redirect('back');
	}


	// great success!
	$post_id = $db->lastInsertId();


	// if we have tags, add them
	if ( isset( $tags ) && $tags = array_filter( $tags ) )
	{
		foreach ( $tags as $tag_id )
		{
			$insert_tags = $db->prepare("
				INSERT INTO posts_tags
				VALUES (:post_id, :tag_id)
			");

			$insert_tags->execute([
				'post_id' => $post_id,
				'tag_id'  => $tag_id
			]);
		}
	}

	// let's visit the new post
	flash()->success( 'yay, new one!' );

	redirect(get_post_link([
		'id'   => $post_id,
		'slug' => $slug,
	]));