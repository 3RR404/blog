<?php 

function validate_comment()
{
    global $auth;

    $text  = filter_input( INPUT_POST, 'text', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );

    if ( isset($_POST['post_id']) )
        
    {
        $post_id = filter_input( INPUT_POST, 'post_id', FILTER_VALIDATE_INT );
        $user_id = get_user()->uid;
    
        // id is required and has to be int
        if ( ! $post_id ) {
            flash()->error("what are you trying to pull here");
        }
    
        if ( ! $user_id ) {
            flash()->error("Who ?");
        }
    }
    else
    {
        $post_id = false;
        $user_id = false;
    }

    // text is required
	if ( ! $text = trim($text) ) {
		flash()->error("write some text, come on");
    }
    
    // if we have error messages, validation didn't go well
	if ( flash()->hasMessages() )
	{
		$_SESSION['form_data'] = [
			'text'  => $text,
        ];
        
		return false;
    }
    // return values as array
	return compact(
		'post_id', 'text', 'user_id',
		$post_id, $text, $user_id
    );
}

function postHasComments( $post_id )
{
    global $db;

    $result = false;

    $query = $db->query( "SELECT * FROM comments WHERE post_id = $post_id" );

    if ( $query->rowCount() ) $result = true;
    
    return $result;
}

function format_comment( $comment, $format_text )
{
    $comment = array_map( 'trim', $comment );

    $comment['text'] = plain( $comment['text'] );

    // let's go on some dates
	$comment['timestamp'] = strtotime( $comment['created_at'] );
	$comment['time'] = str_replace(' ', '&nbsp;', date( 'j M Y, G:i', $comment['timestamp'] ));
	$comment['date'] = date( 'Y-m-d', $comment['timestamp'] );

    if ( $format_text ) {
        $comment['text'] = filter_url( $comment['text'] );
        $comment['text'] = add_paragraphs( $comment['text'] );
    }

    return (object) $comment;
}

function getComments( $post_id )
{
    global $db;

    $query = $db->query(
        "SELECT c.*, u.username
        FROM comments c 
        LEFT JOIN posts p on (c.post_id = p.id)
        LEFT JOIN users u on (c.user_id = u.id)
        WHERE post_id = $post_id
        GROUP BY c.id
        ORDER BY c.created_at DESC" );

	if ( $query->rowCount() )
	{
        $results = $query->fetchAll( PDO::FETCH_ASSOC );
	}
	else
	{
		$results = [];
    }
    
	return $results;
}
