<?php
namespace app\controller {

    use Silex\Application;
    use Silex\ControllerProviderInterface;


    class CareerController implements ControllerProviderInterface
    {
        public function career(Application $app)
        {
            return $app["twig"]->render("career.twig");
        }

        public function connect(Application $app)
        {
            $career = $app['controllers_factory'];
            $career->match('/', array($this, 'career'))->bind('career.main');
            return $career;
        }
    }
}