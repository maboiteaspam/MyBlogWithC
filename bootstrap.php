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

$bootHelper->setup($runtime, $configTokens);

$blogController = new C\Blog\ControllersProvider();
$myBlogController = new \MyBlog\ControllersProvider();

$bootHelper->register(new \C\Eloquent\ServiceProvider());
$bootHelper->register(new \C\BlogData\ServiceProvider());
$bootHelper->register($blogController);
$bootHelper->register($myBlogController);


//$formDemo = new \C\FormDemo\ControllersProvider();
//$bootHelper->register($formDemo);


return $bootHelper;
