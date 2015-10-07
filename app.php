<?php
$bootHelper = require("bootstrap.php");
$app = $bootHelper->app;

$app->mount('/', $myBlogController);
//$app->mount('/form', $formDemo);

$app->run();
