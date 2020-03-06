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


	// does this even exist?
	if ( ! $post = get_post($post_id, false) ) {
		flash()->error('no such post');
		redirect('back');
	}

	// is this the author or heave a permission?
	if ( ! can( $post, 'post', 'edit' ) ) {
		flash()->error('what are you trying to pull here');
		redirect('back');
	}

	if ( isset( $_FILES['image']['tmp_name'] ) && !empty( $_FILES['image']['tmp_name'] ) )
	{
		$tmp_file = $_FILES['image']['tmp_name'];
		$file_name = str_replace( '-', '_', $_FILES['image']['name'] );
		$f_name = uniqid() . '-' . $file_name;
		$sourceDir = UPLOAD_DIR . 'source/';
		$thumbDir = UPLOAD_DIR . 'thumb/';

		move_uploaded_file( $tmp_file, $sourceDir . $file_name );

		$image = WideImage::load( $sourceDir . $file_name ); 
		$thumbnail150 = $image->resize( '150', '150', 'inside' )->saveToFile( $thumbDir . '150_x_' . $f_name );
		$thumbnail400 = $image->resize( '400', null, 'inside' )->saveToFile( $thumbDir . '400_x_' . $f_name );
		$thumbnail920 = $image->resize( '920', null, 'inside' )->saveToFile( $thumbDir . '920_x_' . $f_name );

		$img = $f_name;

	}

	// add new title and text
	$update_post = $db->prepare("
		UPDATE posts SET
			title = :title,
			text  = :text,
			image = :image
		WHERE
			id = :post_id
	");

	$update_post->execute([
		'title'   => $title,
		'text'    => $text,
		'post_id' => $post_id,
		'image'   => $img
	]);


	// remove all tags for this post
	$delete_tags = $db->prepare("
		DELETE FROM posts_tags
		WHERE post_id = :post_id
	");

	$delete_tags->execute([
		'post_id' => $post_id
	]);


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

	// redirect
	if ( $update_post->rowCount() )
	{
		flash()->success( 'yay, changed it!' );
		redirect( get_post_link($post) );
	}

	flash()->warning( 'sorry, girl' );
	redirect('back');