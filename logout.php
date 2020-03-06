<?php

	require_once '_inc/config.php';

	// you ain't even logged in, what are you doing
	if ( ! logged_in() ) {
		redirect('/');
	}

	// log yourself out, bro
	do_logout();

	// flash it & go home
	flash()->success('Bye bye!');
	redirect('/');