<?php

// api/index.php
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/controller.php';
require_once __DIR__.'/config.php';

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();
$app['debug'] = true;
$config = new Config();

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

$controller = new MainController();

$app->get('/', function () use ($controller){
    return $controller->Hello();
});

$app->get('/list', function () use ($controller, $app){
    return $controller->ListItems($app);
});

$app->post('/save', function (Request $req) use ($controller, $app, $config){
    $title = $req->get("title");
    $imageFile = $req->files->get("imageFile");
    $imageName = $imageFile->getClientOriginalName();
    $imageFile->move($config->getImagePath(), $imageName);
          
    return $controller->SaveItem($app, $title, $imageName);

});

$app->run();

?>
