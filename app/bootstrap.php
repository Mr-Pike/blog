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

    // Add Swift Mailer service.
    $app->register(new \Silex\Provider\SwiftmailerServiceProvider());
    $app['swiftmailer.options'] = array(
        'host'       => $config['swiftmailer']['host'],
        'port'       => $config['swiftmailer']['port'],
        'username'   => $config['swiftmailer']['username'],
        'password'   => $config['swiftmailer']['password'],
        'encryption' => $config['swiftmailer']['encryption'],
        'auth_mode'  => $config['swiftmailer']['auth_mode']
    );

    // Mount routers.
    $app->mount("/", new app\controller\IndexController());
    $app->mount("/realization", new app\controller\RealizationController());
    $app->mount("/career", new app\controller\CareerController());
    $app->mount("/services", new app\controller\ServicesController());
    $app->mount("/contact", new app\controller\ContactController());

    // Launch application.
    $app->run();