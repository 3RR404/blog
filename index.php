<?php

	require_once __DIR__ . '/_inc/config.php';

	$routes = [

		// HOMEPAGE
		'/' => [
			'GET'  => 'home.php'
		],

		// USER
		'/user' => [
			'GET'  => 'user.php'             // user profile
		],

		// All users
		'/users' => [
			'GET' => 'users.php',
			'/edit' => [
				'GET' => '',
				'POST' => ''
			],
			'/delete' => [
				'GET' => '',
				'POST' => ''
			]
		],

		// LOGIN
		'/login' => [
			'GET'  => 'login.php',           // login form
			'POST' => 'login.php',           // do login
		],

		// REGISTER
		'/register' => [
			'GET'  => 'register.php',        // register form
			'POST' => 'register.php',        // do register
		],

		// ACTIVATE
		'/activate' => [
			'GET'  => 'activate.php',        // register form
			'POST' => 'activate.php',        // do register
		],

		// LOGOUT
		'/logout' => [
			'GET'  => 'logout.php',          // logout user
		],

		// FORGOT PASS
		'/forgot' => [
			'GET' => 'forgot.php', 			// reset password
			'POST' => 'forgot.php' 			// reset password
		],

		'/reset' => [
			'GET' => 'reset-password.php',	// reset password
			'POST' => 'reset-password.php'	// reset password
		],

		// TAG
		'/tag' => [
			'GET'  => 'tag.php',  // show posts for tag
			'/edit' => [
				'GET'  => 'edit-tag.php',              // edit form
				'POST' => '_admin/tag-edit.php',  // store new values
			],
			'/delete' => [
				'GET'  => 'delete-tag.php',             // delete form
				'POST' => '_admin/tag-delete.php', // make the delete
			]
		],
		'/tags' => [
			'GET'  => 'tags.php',  // show posts for tag
		],

		// POST
		'/post' => [
			'GET'  => 'post.php',		 	  // show post
			'POST' => '_admin/post-add.php',  // add new post
			'/edit' => [
				'GET'  => 'edit.php',              // edit form
				'POST' => '_admin/post-edit.php',  // store new values
			],
			'/delete' => [
				'GET'  => 'delete.php',             // delete form
				'POST' => '_admin/post-delete.php', // make the delete
			]
		],

	];

	$page   = segment(1);
	$method = $_SERVER['REQUEST_METHOD'];
	$action = in_array( segment(2), ['edit', 'create', 'delete']) ? segment(2) : false;

	// guests can go here
	$public = [
		'login',
		'register',
		'activate',
		'forgot',
		'reset'
	];

	// not logged in, you can only visit $public links
	if ( !logged_in() && !in_array( $page, $public ) ) {
		redirect('/login');
	}

	// show page
	if ( ! isset( $routes["/$page"]["/$action"][$method] ) ) {
		
		if ( ! isset( $routes["/$page"][$method] ) ) {
			show_404();
		}
		require $routes["/$page"][$method];

	} else {
		require $routes["/$page"]["/$action"][$method];
	}
	
