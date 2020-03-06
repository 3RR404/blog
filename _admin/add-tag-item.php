<?php

	// include
	require '../_inc/config.php';

	// just to be safe
	if ( ! logged_in() ) {
		redirect('/');
	}



	// c'mon baby do the locomo.. validation
	if ( ! $data = validate_tag() ) {
		redirect('back');
	}


	extract( $data );

	// have a permission?
	$usr = get_user();
	if ( ! can( false, 'tag', 'create' ) ) {
		flash()->error('what are you trying to pull here');
		redirect('back');
	}

	$query = $db->prepare("
		INSERT INTO tags
			( tag )
		VALUES
			( :tag )
	");

	$insert = $query->execute([
		'tag' => $tag
	]);


	if ( ! $insert )
	{
		flash()->warning( 'sorry, girl' );
		redirect('back');
	}


	// great success!
	$last_id = $db->lastInsertId();


	// let's visit the new post
	flash()->success( 'HOLLY MOLLY crap! You did it !!' );

	redirect('back');