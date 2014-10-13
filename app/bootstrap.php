<?php
    use Symfony\Component\Yaml\Parser;

    $loader = require_once __DIR__ . '/../vendor/autoload.php';
    $loader->add("src", dirname(__DIR__));

    // Instance Silex\Application.
    $app = new Silex\Application();

    // Include configuration file.
    $app['config'] = (new Parser())->parse(file_get_contents('../app/config.yml'));

    $app['debug'] = $app['config']['debug'];

    // URL Generator Service.
    $app->register(new Silex\Provider\UrlGeneratorServiceProvider());

    // Add Twig service.
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        "twig.path" => dirname(__DIR__) . "/src/view",
        'twig.options' => array('cache' => dirname(__DIR__).'/cache', 'strict_variables' => true, 'debug' => $app['debug'])
    ));

    // Add Doctrine service
    $app->register(new Silex\Provider\DoctrineServiceProvider(), array(
        'db.options' => array(
            'driver'   => $app['config']['database']['driver'],
            'dbname'   => $app['config']['database']['dbname'],
            'host'     => $app['config']['database']['host'],
            'user'     => $app['config']['database']['user'],
            'password' => $app['config']['database']['password'],
            'charset'  => $app['config']['database']['charset']
        )
    ));

    // Add Swift Mailer service.
    $app->register(new \Silex\Provider\SwiftmailerServiceProvider());
    $app['swiftmailer.options'] = array(
        'host'       => $app['config']['swiftmailer']['host'],
        'port'       => $app['config']['swiftmailer']['port'],
        'username'   => $app['config']['swiftmailer']['username'],
        'password'   => $app['config']['swiftmailer']['password'],
        'encryption' => $app['config']['swiftmailer']['encryption'],
        'auth_mode'  => $app['config']['swiftmailer']['auth_mode']
    );

    // Mount routers.
    $app->mount("/", new src\controller\IndexController());
    $app->mount("/realization", new src\controller\RealizationController());
    $app->mount("/career", new src\controller\CareerController());
    $app->mount("/services", new src\controller\ServicesController());
    $app->mount("/contact", new src\controller\ContactController());

    // Manage Errors.
    /*$app->error(function (\Exception $e, $code) use ($app) {

        switch($code) {
            case 404:
                return $app["twig"]->render("/error/404.html.twig");
                break;

            case 405:
                return $app["twig"]->render("/error/405.html.twig");
                break;

            default:
                return $app["twig"]->render("/error/other.html.twig");
                break;
        }
    });*/

    // Launch application.
    $app->run();