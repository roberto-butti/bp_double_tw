<?php
require_once("./vendor/.composer/autoload.php");
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
error_reporting(E_ALL);
ini_set("display_errors", 1);
$app = new Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/vendor/twig/lib',
));

$app->get('/page/{slug}', function (Application $app, $slug) {

  $template_name='pages/'.$app->escape($slug).'.twig';
  if (file_exists(__DIR__.'/views/'.$template_name)) {
    return $app['twig']->render($template_name, array(
      'slug' => $slug,
    ));
  } else {
    $message = "Template ".$app->escape($slug)." not exists";
    return new Symfony\Component\HttpFoundation\Response($message, 404);
  }
});

$app->get('/', function (Application $app) {
  //echo ($app['request']->getBaseUrl());
  $template_name = "index.twig";
    return $app['twig']->render($template_name, array(
    ));
});


$app->error(function (\Exception $e, $code) use ($app) {
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            $template_name = "errors/404.twig";
            return $app['twig']->render($template_name, array(
            ));
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.'.$e->getMessage();
    }

    return new Response($message, $code);
});
$app['debug'] = true;

$app->run();