<?php
require_once("./vendor/.composer/autoload.php");
$app = new Silex\Application();

$app->get('/page/{slug}', function ($slug) use ($app) {
    return 'Load PAGES: '.$app->escape($slug);
});

$app->get('/', function () {
    return 'Home ';
});

$app->run();