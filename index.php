<?php
ini_set('memory_limit', '-1');
session_cache_limiter(false);
session_start();
require 'vendor/autoload.php';
//require 'app/config/Session.php';
// Prepare app

$app = new \Slim\Slim(array(
	'log.enabled' => false,
    'templates.path' => 'app/templates',
	'debug' => true
));

// Create monolog logger and store logger in container as singleton 
// (Singleton resources retrieve the same log resource definition each time)
/*$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('slim-skeleton');
    $log->pushHandler(new \Monolog\Handler\StreamHandler('app/logs/app.log', \Monolog\Logger::DEBUG));
    return $log;
});*/
// Prepare view
$app->view(new \Slim\Views\Twig());
$app->view->parserOptions = array(
    'charset' => 'utf-8',
    'cache' => realpath('app/templates/cache'),
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true,
	'debug'=>true
);
$app->view->parserExtensions = array(new config\TwigExtension());

$app->session=new config\Session();
//include "app/routes/api.php";
include "app/routes/guest.php";
//include "app/routes/admin.php";
include "app/routes/member.php";
// Run app
$app->run();
