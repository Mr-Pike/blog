<?php
namespace app\controller {

    use Silex\Application;
    use Silex\ControllerProviderInterface;


    class ServicesController implements ControllerProviderInterface
    {
        public function services(Application $app)
        {
            return $app["twig"]->render("services.twig");
        }

        public function connect(Application $app)
        {
            $services = $app['controllers_factory'];
            $services->match('/', array($this, 'services'), 'services');
            return $services;
        }
    }
}