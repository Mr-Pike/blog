<?php
namespace src\controller {

    use Silex\Application;
    use Silex\ControllerProviderInterface;


    class IndexController implements ControllerProviderInterface
    {
        public function index(Application $app)
        {
            //return $app["twig"]->render("index.twig", array('current_page' => 'index'));
            return $app["twig"]->render("index.twig");
        }

        public function connect(Application $app)
        {
            $index = $app['controllers_factory'];
            $index->match('/', array($this, 'index'))->bind('index.main');
            return $index;
        }
    }
}