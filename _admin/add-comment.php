<?php

	// include
	require '../_inc/config.php';

	// just to be safe
	if ( ! logged_in() ) {
		redirect('/');
    }
    
    // c'ment validation
	if ( ! $data = validate_comment() ) {
		redirect('back');
    }
    
    extract( $data );

	// have a permission?
	$usr = get_user();
	if ( ! can( false, 'comment', 'add' ) ) {
		flash()->error('what are you trying to pull here');
		redirect('back');
    }
    
    $query = $db->prepare("
		INSERT INTO comments
			( user_id, text, post_id )
		VALUES
			( :uid, :text, :post_id )
	");

	$insert = $query->execute([
		'uid'           => get_user()->uid,
		'text'          => $text,
        'post_id'       => $post_id,
    ]);
    
    if ( ! $insert )
	{
		flash()->warning( 'sorry, i cant do this' );
		redirect('back');
    }
    
    // great success!
    $comment_id = $db->lastInsertId();
    
    // let's visit the new post
    flash()->success( 'yay, new one!' );
    
    redirect('back');