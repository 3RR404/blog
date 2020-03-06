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

	// does this even exist?
	if ( ! $tag_data = get_tag($tag_id, false) ) {
		flash()->error('no such post');
		redirect('back');
	}

	// is this the author or heave a permission?
	if ( ! can( false, 'tag', 'edit' ) ) {
		flash()->error('what are you trying to pull here');
		redirect('back');
	}

	// add new title and text
	$update_tag = $db->prepare("
		UPDATE tags SET
			tag = :tag
		WHERE
			id = :tag_id
	");
	
	$update_tag->execute([
		'tag'   => $tag,
		'tag_id' => $tag_id
	]);


	// redirect
	if ( $update_tag->rowCount() )
	{
		flash()->success( 'yay, changed it!' );
		redirect( '/tags' );
	}

	flash()->warning( 'sorry, girl' );
	redirect('back');