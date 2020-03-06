<?php

	/**
	 * Get Post
	 *
	 * Tries to fetch a DB item based on $_GET['id']
	 * Returns false if unable
	 *
	 * @param  integer    id of the post to get
	 * @param  bool|true  $auto_format  whether to format all the posts or not
	 * @return DB item    or false
	 */
	function get_post( $id = 0, $auto_format = true )
	{
		// we have no id
		if ( !$id && !$id = segment(3) ) {
			return false;
		}

		// $id must be integer
		if ( ! filter_var( $id, FILTER_VALIDATE_INT ) ) {
			return false;
		}

		global $db;

		$query = $db->prepare( create_posts_query("WHERE p.id = :id") );
		$query->execute([ 'id' => $id ]);

		if ( $query->rowCount() === 1 )
		{
			$result = $query->fetch( PDO::FETCH_ASSOC );

			if ( $auto_format ) {
				$result = format_post( $result, true );
			} else {
				$result = (object) $result;
			}
		}
		else
		{
			$result = [];
		}

		return $result;
	}

	function get_tag( $id = 0, $auto_format = true )
	{
		
		if ( !$id && !$id = segment(3) ) {
			return false;
		}

		global $db;

		$query = $db->prepare( create_tags_query("WHERE id = :id") );
		$query->execute([ 'id' => $id ]);

		if ( $query->rowCount() === 1 )
		{
			$result = $query->fetch( PDO::FETCH_ASSOC );

			if ( $auto_format ) {
				$result = format_post( $result, true );
			} else {
				$result = (object) $result;
			}
		}
		else
		{
			$result = [];
		}

		return $result;

	}



	/**
	 * Get Posts
	 *
	 * Grabs all posts from the DB
	 * And maybe formats them too, depending on $auto_format
	 *
	 * @param  bool|true  $auto_format  whether to format all the posts or not
	 * @return array
	 */
	function get_posts( $auto_format = true )
	{
		global $db;

		$query = $db->query( create_posts_query() );

		if ( $query->rowCount() )
		{
			$results = $query->fetchAll( PDO::FETCH_ASSOC );

			if ( $auto_format ) {
				$results = array_map( 'format_post', $results );
			}
		}
		else
		{
			$results = [];
		}

		return $results;
	}



	/**
	 * Get Posts By Tag
	 *
	 * Grabs posts that have $tag from the DB
	 * And maybe formats them too, depending on $auto_format
	 *
	 * @param  string     $tag
	 * @param  bool|true  $auto_format  whether to format all the posts or not
	 * @return array
	 */
	function get_posts_by_tag( $tag = '', $auto_format = true )
	{
		// we have no id
		if ( !$tag && !$tag = segment(2) ) {
			return false;
		}

		$tag = urldecode( $tag );
		$tag = filter_var( $tag, FILTER_SANITIZE_STRING );

		global $db;

		$query = $db->prepare( create_posts_query("WHERE t.tag = :tag") );
		$query->execute([ 'tag' => $tag ]);

		if ( $query->rowCount() )
		{
			$results = $query->fetchAll( PDO::FETCH_ASSOC );

			if ( $auto_format ) {
				$results = array_map( 'format_post', $results );
			}
		}
		else
		{
			$results = [];
		}

		return $results;
	}



	/**
	 * Get Posts By User
	 *
	 * Grabs posts by user id, if no uid is provided, we get logged users id
	 * And maybe formats them too, depending on $auto_format
	 *
	 * @param  integer    $user_id
	 * @param  bool|true  $auto_format  whether to format all the posts or not
	 * @return array
	 */
	function get_posts_by_user( $user_id = 0, $auto_format = true )
	{
		// we have no id
		if ( !$user_id && !$user_id = get_user()->uid ) {
			return false;
		}

		global $db;

		$query = $db->prepare( create_posts_query("WHERE p.user_id = :uid") );
		$query->execute([ 'uid' => $user_id ]);

		if ( $query->rowCount() )
		{
			$results = $query->fetchAll( PDO::FETCH_ASSOC );

			if ( $auto_format ) {
				$results = array_map( 'format_post', $results );
			}
		}
		else
		{
			$results = [];
		}

		return $results;
	}



	/**
	 * Create Posts Query
	 *
	 * Put together the query to get posts
	 * We can add WHERE conditions too
	 *
	 * @param  string $where
	 * @return string
	 */
	function create_posts_query( $where = '' )
	{
		$query = "
			SELECT p.*, u.username, GROUP_CONCAT(t.tag SEPARATOR '~||~') AS tags
		    FROM posts p
		    LEFT JOIN posts_tags pt ON (p.id = pt.post_id)
		    LEFT JOIN tags t ON (t.id = pt.tag_id)
		    LEFT JOIN users u ON (p.user_id = u.id)
		";

		if ( $where ) {
			$query .= $where;
		}

		$query .= " GROUP BY p.id";
		$query .= " ORDER BY p.created_at DESC";

		return trim( $query );
	}

	function create_tags_query( $where = '' )
	{
		$query = "
			SELECT * FROM tags
		";

		if ( $where ) {
			$query .= $where;
		}

		$query .= " ORDER BY tag ASC";

		return trim( $query );
	}



	/**
	 * Format Post
	 *
	 * Cleans up, sanitizes, formats and generally prepares DB post for displaying
	 *
	 * @param   $post
	 * @param   boolean  $format_text  should only be true on page of the post
	 * @return  object
	 */
	function format_post( $post, $format_text = false )
	{
		// trim dat shit
		$post = array_map( 'trim', $post );

		// clean it up
		$post['title'] = plain( $post['title'] );
		$post['text']  = plain( $post['text'] );
		$post['tags']  = $post['tags'] ? explode( '~||~', $post['tags'] ) : [];
		$post['tags']  = array_map( 'plain', $post['tags'] );

		// tag me up
		if ( $post['tags'] ) foreach ( $post['tags'] as $tag ) {
			$post['tag_links'][$tag] = BASE_URL . '/tag/' . urlencode( $tag );
			$post['tag_links'][$tag] = filter_var( $post['tag_links'][$tag], FILTER_SANITIZE_URL );
		}

		// create link to post [ /post/:id/:slug ]
		$post['link'] = get_post_link( $post );

		// let's go on some dates
		$post['timestamp'] = strtotime( $post['created_at'] );
		$post['time'] = str_replace(' ', '&nbsp;', date( 'j M Y, G:i', $post['timestamp'] ));
		$post['date'] = date( 'Y-m-d', $post['timestamp'] );

		// don't tease me, bro
		$post['teaser'] = word_limiter( $post['text'], 40 );

		// format text
		if ( $format_text ) {
			$post['text'] = filter_url( $post['text'] );
			$post['text'] = add_paragraphs( $post['text'] );
		}

		// user
		$post['email'] = filter_var( $post['email'], FILTER_SANITIZE_EMAIL );
		$post['user_link'] = BASE_URL . '/user/' . $post['user_id'];
		$post['user_link'] = filter_var( $post['user_link'], FILTER_SANITIZE_URL );

		return (object) $post;
	}


	/**
	 * Get Post Link
	 *
	 * Create link to post [ /post/:id/:slug ]
	 *
	 * @param  array|object  $post  post to create link to
	 * @param  string        $type  if it's a post/edit/delete link
	 * @return mixed|string
	 */
	function get_post_link( $post, $resource = 'post', $action = false )
	{
		if ( is_object($post) )
		{
			$id   = $post->id;
			$slug = $post->slug;
		}
		else
		{
			$id   = $post['id'];
			$slug = $post['slug'];
		}

		$link = BASE_URL . "/$resource";

		if( $action )
			$link .= "/$action";
		
		$link .= "/$id";

		if ( $action === FALSE ) {
			$link .= "/$slug";
		}

		$link = filter_var( $link, FILTER_SANITIZE_URL );

		return $link;
	}



	/**
	 * Get Edit Link
	 *
	 * Create link to edit [ /edit/:id ]
	 *
	 * @param $post
	 * @return mixed|string
	 */
	function get_edit_link( $post, $resource )
	{
		return get_post_link( $post, $resource, 'edit' );
	}



	/**
	 * Get Delete Link
	 *
	 * Create link to edit [ /delete/:id ]
	 *
	 * @param $post
	 * @return mixed|string
	 */
	function get_delete_link( $post, $resource )
	{
		return get_post_link( $post, $resource, 'delete' );
	}



	/**
	 * Get All Tags
	 *
	 * Grab tags, if we wanna add them to like an input/edit form
	 * If $post_id is provided, we mark which tags belong to this post
	 *
	 * @param   integer  $post_id
	 * @return  array    list of tags
	 */
	function get_all_tags( $post_id = 0 )
	{
		global $db;

		$query = $db->query("
			SELECT * FROM tags
			ORDER BY tag ASC
		");

		$results = $query->rowCount() ? $query->fetchAll( PDO::FETCH_OBJ ) : [];

		if ( $post_id )
		{
			$query = $db->prepare("
				SELECT t.id FROM tags t
				JOIN posts_tags pt ON t.id = pt.tag_id
				WHERE pt.post_id = :pid
			");

			$query->execute([
				'pid' => $post_id
			]);

			if ( $query->rowCount() )
			{
				$tags_for_post = $query->fetchAll( PDO::FETCH_COLUMN );

				foreach ( $results as $key => $tag )
				{
					if ( in_array( $tag->id, $tags_for_post ) ) {
						$results[$key]->checked = true;
					}
				}
			}
		}

		return $results;
	}



	/**
	 * Validate Post
	 *
	 * Sanitize and Validate, sister
	 *
	 * @return array|bool
	 */
	function validate_post()
	{
		$title = filter_input( INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
		$text  = filter_input( INPUT_POST, 'text', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
		$tags  = filter_input( INPUT_POST, 'tags', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY );

		if ( isset($_POST['post_id']) )
		{
			$post_id = filter_input( INPUT_POST, 'post_id', FILTER_VALIDATE_INT );

			// id is required and has to be int
			if ( ! $post_id ) {
				flash()->error("what are you trying to pull here");
			}
		}
		else
		{
			$post_id = false;
		}


		// title is required
		if ( ! $title = trim($title) ) {
			flash()->error('you forgot your title, dummy');
		}

		// text is required
		if ( ! $text = trim($text) ) {
			flash()->error("write some text, come on");
		}

		// if we have error messages, validation didn't go well
		if ( flash()->hasMessages() )
		{
			$_SESSION['form_data'] = [
				'title' => $title,
				'text'  => $text,
				'tags'  => $tags ?: [],
			];

			return false;
		}


		// return values as array
		return compact(
			'post_id', 'title', 'text', 'tags',
			$post_id, $title, $text, $tags
		);
	}

	/**
	 * Validate tag
	 * 
	 * sanitize and validating fields from form
	 * 
	 * @return bool|array
	 */
	function validate_tag()
	{
		$tag = filter_input( INPUT_POST, 'tag', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );

		if ( isset($_POST['tag_id']) )
		{
			$tag_id = filter_input( INPUT_POST, 'tag_id', FILTER_VALIDATE_INT );
		}
		else
		{
			$tag_id = false;
		}

		if ( ! $tag = trim($tag) ) {
			flash()->error('you forgot your title, dummy');
		}

		// if we have error messages, validation didn't go well
		if ( flash()->hasMessages() )
		{
			$_SESSION['form_data'] = [
				'tag' => $tag,
			];

			return false;
		}

		return compact( 'tag_id', 'tag', $tag_id, $tag );
	}