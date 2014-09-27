<?php
    $loader = require_once __DIR__ . '/../vendor/autoload.php';
    $loader->add("app", dirname(__DIR__));

    // Instance Silex\Application.
    $app = new Silex\Application();

    // Include configuration file.
    require_once 'config.php';
    $app['config'] = $config;
    $app['debug'] = $app['config']['debug'];

    // Add twig service.
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        "twig.path" => dirname(__DIR__) . "/app/view",
        'twig.options' => array('cache' => dirname(__DIR__).'/cache', 'strict_variables' => true, 'debug' => true)
    ));

    /*$app->before(function (Symfony\Component\HttpFoundation\Request $request) use ($app) {
        $app['twig']->addGlobal('current_page', $request->getRequestUri());
    });*/

    // Mount routers.
    $app->mount("/", new app\controller\IndexController());
    $app->mount("/realization", new app\controller\RealizationController());
    $app->mount("/career", new app\controller\CareerController());
    $app->mount("/services", new app\controller\ServicesController());
    $app->mount("/contact", new app\controller\ContactController());

    // Launch application.
    $app->run();