<?php

use basis\core\Router;

$query = rtrim($_SERVER['QUERY_STRING'], '/');

define('DEBUG', 1);
define('WWW', __DIR__);
define('ROOT', dirname(__DIR__));
define('CORE', dirname(__DIR__).'/vendor/basis/core');
define('LIBS', dirname(__DIR__).'/vendor/basis/libs');
define('APP', dirname(__DIR__).'/app');
define('CACHE', dirname(__DIR__).'/tmp/cache');
define('LAYOUT', 'main');
define("FILES", ROOT.'/tmp/files/');

// require '../vendor/core/Router.php';
require '../vendor/basis/libs/functions.php';
require __DIR__.'/../vendor/autoload.php';;

//spl_autoload_register(function($class) {
//	$file = ROOT.'/'.str_replace('\\', '/',$class).'.php';
//	if(is_file($file)) {
//		require_once $file;
//	}
//});

new basis\core\App;

// spetial routs
Router::add('^theories/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Theories']);
Router::add('^theories/(?P<alias>[a-z-]+)$', ['controller' => 'Theories', 'action' => 'news']);
Router::add('^discussions/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Discussions']);
Router::add('^discussions/(?P<alias>[a-z-]+)$', ['controller' => 'Discussions', 'action' => 'news']);
Router::add('^projects/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Projects']);
Router::add('^projects/(?P<alias>[a-z-]+)$', ['controller' => 'Projects', 'action' => 'news']);
Router::add('^management/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Management']);
Router::add('^management/(?P<alias>[a-z-]+)$', ['controller' => 'Management', 'action' => 'news']);

// default routs
Router::add('^users$', ['controller' => 'Main', 'action' => 'news', 'prefix' => 'users']);
Router::add('^users/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'users']);

Router::add('^$', ['controller' => 'Main', 'action' => 'news']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($query);
