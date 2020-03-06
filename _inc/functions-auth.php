<?php


	/**
	 * Logged In
	 *
	 * Is a user logged in?
	 *
	 * @return bool
	 */
	function logged_in()
	{
		global $auth, $auth_config;

		return
			isset($_COOKIE[$auth_config->cookie_name]) &&
			$auth->checkSession($_COOKIE[$auth_config->cookie_name]);
	}



	/**
	 * Do Login
	 *
	 * Create cookie after logging in
	 *
	 * @param   array  $data
	 * @return  bool
	 */
	function do_login( $data )
	{
		global $auth_config;

		return setcookie(
			$auth_config->cookie_name,
			$data['hash'],
			$data['expire'],
			$auth_config->cookie_path,
			$auth_config->cookie_domain,
			$auth_config->cookie_secure,
			$auth_config->cookie_http
		);
	}



	/**
	 * Do Logout
	 *
	 * Log the user out
	 *
	 * @return bool
	 */
	function do_logout()
	{
		if ( ! logged_in() ) return true;

		global $auth, $auth_config;

		return $auth->logout( $_COOKIE[$auth_config->cookie_name] );
	}



	/**
	 * Get user
	 *
	 * Grab data for the logged in user
	 *
	 * @param  integer  $user_id
	 * @return bool|mixed
	 */
	function get_user( $user_id = 0 )
	{

		global $auth, $auth_config;

		if ( ! $user_id && logged_in() ) {
			$user_id = $auth->getSessionUID($_COOKIE[$auth_config->cookie_name]) ?: 0;
		}

		return (object) $auth->getUser( $user_id );
	}

	function get_all_users()
	{
		global $db;

		$query = "
			SELECT * FROM users
		";

		$query .= " ORDER BY username ASC";

		$query = trim( $query );

		$query_rows = $db->query( $query );

		$results = $query_rows->rowCount() ? $query_rows->fetchAll( PDO::FETCH_OBJ ) : [];

		return $results;
	}

	/**
	 * Can Edit
	 *
	 * True if this post was written by the logged in user
	 *
	 * @param  mixed  $post
	 * @return bool
	 */
	function can( $post, $resource, $action )
	{
		// must be logged in
		if ( ! logged_in() ) {
			return false;
		} else {
			$user = get_user();
		}

		if( $post !== FALSE )
		{
			if ( is_object( $post ) ) {
				$post_id = (int) $post->user_id;
			}
			else {
				$post_id = (int) $post['user_id'];
			}
		}

		return $post_id === $user->uid || users_permission( $user->user_roles, $resource, $action );
	}


	function users_permission( $role, $resource, $action )
	{
		$roles = [
			'admin' 	=> [
				'post' 		=> ['delete'],
				'tag'		=> ['delete'],
				'user' 		=> ['view', 'create', 'edit', 'delete']
			],
			'editor'	=> [
				'post' 		=> ['create', 'edit'],
				'tag'		=> ['view', 'create', 'edit']
			],
			'user'			=> [
				'comment'	=> ['add']
			],
			'guest'			=>[
				'home'		=> ['view'],
				'post'		=> ['view'],
				'comment'	=> ['view']
			]
		];

		$roles['user'] = array_merge_recursive( $roles['guest'], $roles['user'] );
		$roles['editor'] = array_merge_recursive( $roles['user'], $roles['editor'] );
		$roles['admin'] = array_merge_recursive( $roles['editor'], $roles['admin'] );

		if( gettype( $action ) === 'array' )
		{
			foreach( $action as $act )
			{
				if( key_exists( $resource, $roles[ $role ] ) && in_array( $act, $roles[ $role ][ $resource ] ) ) return true;
			}
		} 
		else
		{
			if( key_exists( $resource, $roles[ $role ] ) && is_array( $roles[ $role ][ $resource ] ) && in_array( $action, $roles[ $role ][ $resource ] ) ) return true;
		}

		return false;
	}