<?php

	// include
	require '../_inc/config.php';

	// just to be safe
	if ( ! logged_in() ) {
		redirect('/');
	}


	$tag_id = filter_input( INPUT_POST, 'tag_id', FILTER_VALIDATE_INT );

	// does this even exist?
	if ( !$tag_id || !$tag = get_post($tag_id, false) ) {
		flash()->error('no such post');
		redirect('back');
	}

	// is this the author or have a permissions to delete?
	if ( !can( $post, 'tag', 'delete' ) ) {
		flash()->error('what are you trying to pull here');
		redirect('back');
	}


	$query = $db->prepare("
		DELETE FROM tags
		WHERE id = :tag_id
	");

	$delete = $query->execute([
		'tag_id' => $tag_id
	]);


	// we messed up
	if ( ! $delete ) {
		flash()->warning( 'sorry, girl' );
		redirect('back');
	}


	// remove all tags for this post too
	$query = $db->prepare("
		DELETE FROM posts_tags
		WHERE tag_id = :tag_id
	");

	$query->execute([
		'tag_id' => $tag_id
	]);


	// let's go home
	flash()->success( 'goodbye, honey!' );
	redirect('/');