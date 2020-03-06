<?php

// show all errors
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);


// require stuff
if( !session_id() ) @session_start();
require_once __DIR__ . '/vendor/autoload.php';


// constants & settings
define( 'APP_PATH', realpath( __DIR__ . '/../' ) );
define( 'UPLOAD_DIR', APP_PATH . '/upload/' );

if( ( $_SERVER['SERVER_ADDR'] === '127.0.0.1' || $_SERVER['SERVER_NAME'] === 'localhost' ) && $_SERVER['REMOTE_ADDR'] === '::1' ){
	$base_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/blog';
} else {
	$base_uri = 'http://' . $_SERVER['HTTP_HOST'];
}

if( !is_dir( UPLOAD_DIR . '/source/' ) && !is_dir( UPLOAD_DIR . '/thumb/' ) ){
	mkdir( UPLOAD_DIR . '/source', 0755 );
	mkdir( UPLOAD_DIR . '/thumb', 0755 );
}

define( 'BASE_URL', $base_uri );

// configurations
$config = [

	'db' => [
		'type'     => 'mysql',
		'name'     => 'blog',
		'server'   => 'localhost',
		'username' => 'rooter',
		'password' => '',
		'charset'  => 'utf8'
	]

];



// connect to db
$db = new PDO(
	"{$config['db']['type']}:host={$config['db']['server']};
	dbname={$config['db']['name']};charset={$config['db']['charset']}",
	$config['db']['username'], $config['db']['password']
);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);



// global functions
require_once __DIR__ . '/functions-general.php';
require_once __DIR__ . '/functions-string.php';
require_once __DIR__ . '/functions-auth.php';
require_once __DIR__ . '/functions-post.php';
require_once __DIR__ . '/functions-comment.php';



// auth
require_once __DIR__ . '/vendor/PHPAuth/languages/en.php';
require_once __DIR__ . '/vendor/PHPAuth/config.class.php';
require_once __DIR__ . '/vendor/PHPAuth/auth.class.php';

$auth_config = new Config( $db );
$auth = new Auth( $db, $auth_config, $lang );