<?php
namespace src\controller {

    use Silex\Application;
    use Silex\ControllerProviderInterface;
    use Symfony\Component\HttpFoundation\Request;


    class IndexController implements ControllerProviderInterface
    {
        public function index(Application $app)
        {
            return $app["twig"]->render("index.twig");
        }

        public function realization(Application $app)
        {
            return $app["twig"]->render("realization.twig");
        }

        public function career(Application $app)
        {
            return $app["twig"]->render("career.twig");
        }

        public function services(Application $app)
        {
            return $app["twig"]->render("services.twig");
        }


        public function connect(Application $app)
        {
            $index = $app['controllers_factory'];
            $index->match('/', array($this, 'index'))->bind('index.main');
            $index->match('/realization', array($this, 'realization'), 'realization')->bind('realization.main');
            $index->match('/career', array($this, 'career'))->bind('career.main');
            $index->match('/services', array($this, 'services'), 'services')->bind('services.main');
            return $index;
        }
    }
}