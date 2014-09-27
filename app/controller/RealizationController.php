<?php
namespace app\controller {

    use Silex\Application;
    use Silex\ControllerProviderInterface;


    class RealizationController implements ControllerProviderInterface
    {
        public function realization(Application $app)
        {
            return $app["twig"]->render("realization.twig");
        }

        public function connect(Application $app)
        {
            $realization = $app['controllers_factory'];
            $realization->match('/', array($this, 'realization'), 'realization');
            return $realization;
        }
    }
}