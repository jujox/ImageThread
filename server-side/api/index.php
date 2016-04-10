<?php

// api/index.php
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/controller.php';
require_once __DIR__.'/config.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Init the Silex app : REST API
$app = new Silex\Application();
$app['debug'] = true;
$config = new Config();

// We are using a mysql DB
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver' => 'pdo_mysql',
                'host' => 'localhost',
                'dbname' => 'ImageThread',
                'user' => 'root',
                'password' => '123456',
                'charset' => 'utf8mb4',
            ),
        ));

// Basic error handling
$app->error(function (\Exception $e, $code) {
    error_log("ERROR: " . $e);
    return new Response('{"status": "ERR", "data" : "' . $code . '"}');
});

$controller = new MainController();

// API Methods
$app->get('/', function () use ($controller){
    return $controller->Hello();
});

$app->post('/view', function () use ($controller, $app){
    return $controller->AddView($app);
});

$app->get('/view', function () use ($controller, $app){
    return $controller->GetViews($app);
});

$app->get('/list', function () use ($controller, $app){
    return $controller->ListItems($app);
});

$app->post('/save', function (Request $req) use ($controller, $app, $config){
    $title = $req->get("title");
    $imageFile = $req->files->get("imageFile");
    // Lets do some security checks...
    // TODO: This should be in a separated class/file
    if ($imageFile->getClientSize() > $config->getMaxFileSize()) {
        error_log("FILE TOO LARGE: " . $imageFile->getClientSize());
        return  '{"status": "NOK", "data" : "FILE TOO LARGE"}';
    } else {
        $imageName = $imageFile->getClientOriginalName();
        $imageFile->move($config->getImagePath(), $imageName);
              
        return $controller->SaveItem($app, $title, $imageName);
    }

});

$app->get('/export', function () use ($controller, $app){
    return $controller->Export($app);
});

$app->get('/reset', function () use ($controller, $app){
    return $controller->Reset($app);
});



// Here we go
$app->run();

?>
