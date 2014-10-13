<?php
    use Symfony\Component\Yaml\Parser;

    $loader = require_once __DIR__ . '/../vendor/autoload.php';
    $loader->add("app", dirname(__DIR__));

    // Instance Silex\Application.
    $app = new Silex\Application();

    // Include configuration file.
    $app['config'] = (new Parser())->parse(file_get_contents('../app/config.yml'));

    $app['debug'] = $app['config']['debug'];

    // URL Generator Service.
    $app->register(new Silex\Provider\UrlGeneratorServiceProvider());

    // Add twig service.
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        "twig.path" => dirname(__DIR__) . "/app/view",
        'twig.options' => array('cache' => dirname(__DIR__).'/cache', 'strict_variables' => true, 'debug' => $app['debug'])
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
    $app->mount("/", new app\controller\IndexController());
    $app->mount("/realization", new app\controller\RealizationController());
    $app->mount("/career", new app\controller\CareerController());
    $app->mount("/services", new app\controller\ServicesController());
    $app->mount("/contact", new app\controller\ContactController());

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