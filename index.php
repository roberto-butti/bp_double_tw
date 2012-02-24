<?php
require_once("./vendor/.composer/autoload.php");

error_reporting(E_ALL);
ini_set("display_errors", 1);
$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/vendor/twig/lib',
));

$app->get('/page/{slug}', function ($slug) use ($app) {
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

$app->get('/', function () {
    return 'Home ';
});
$app['debug'] = true;

$app->run();