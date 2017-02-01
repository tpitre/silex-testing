<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use GuzzleHttp\Client as GuzzleClient;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

// Here we make Guzzle a part of the app so we can re-use it with our having to
// re-instantiate it a bazillion times. This could be extended to include the
// hostname here, so subsequent calls just have to ask for `/api/stories`...
$app['guzzle'] = function ($app) {
  return new GuzzleClient();
};

// Include separate route files so you don't end up with one really
// long controllers.php file
$app->mount('/', include 'articles.php');

return $app;
