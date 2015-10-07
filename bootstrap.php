<?php

$runtime = [
    'debug'                 => true,
    'env'                   => getenv('APP_ENV') ? getenv('APP_ENV') : 'dev',
    'project.path'          => __DIR__,
    'run.path'              => __DIR__.'/run/',
//    'security.firewalls'    => [],
];
$configTokens = [
    'env',
    'run.path',
    'project.path',
];


require 'vendor/autoload.php';
use \C\Bootstrap\Common as BootHelper;
$bootHelper = new BootHelper();

$app = $bootHelper->register($runtime, $configTokens);

$app->register(new \C\BlogData\ServiceProvider());
$blogController = new C\Blog\ControllersProvider();
$myBlogController = new \MyBlog\ControllersProvider();
$app->register($blogController);
$app->register($myBlogController);


//$formDemo = new \C\FormDemo\ControllersProvider();
//$app->register($formDemo);


return $bootHelper;
