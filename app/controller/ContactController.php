<?php
namespace app\controller {

    use Silex\Application;
    use Silex\ControllerProviderInterface;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;


    class ContactController implements ControllerProviderInterface
    {
        public function contact(Application $app)
        {
            return $app["twig"]->render("contact.twig");
        }

        /**
         * User validate contact form.
         * @param Request $request
         * @return string
         */
        public function validate(Application $app, Request $request)
        {
            // Post data.
            $data = $request->request->all();

            // Return informations.
            $callback = array();
            $callback['errors'] = '';
            $callback['send'] = 0;

            // Make some verifications.
            if(trim($data['user']) == '') $callback['errors'] .= '- Votre nom n\'est pas renseigné <br />';
            if(!filter_var($data['mail'], FILTER_VALIDATE_EMAIL)) $callback['errors'] .= '- Votre adresse mail n\'est pas renseignée <br />';
            if(trim($data['object']) == '') $callback['errors'] .= '- Votre objet n\'est pas renseigné <br />';
            if(trim($data['message']) == '') $callback['errors'] .= '- Votre message n\'est pas renseigné <br />';

            // Check errors found.
            if($callback['errors'] != '') {
                $callback['errors'] = 'Votre message n\'a pas été envoyé :<br />' . $callback['errors'];
            } else {
                $message = \Swift_Message::newInstance()
                    ->setSubject('[website] - '. $data['object'])
                    ->setFrom(array($data['mail'] => $data['user']))
                    ->setSender(array($data['mail'] => $data['user']))
                    ->setReplyTo(array($data['mail'] => $data['user']))
                    ->setTo(array($app['config']['swiftmailer']['username']))
                    ->setCharset('utf-8')
                    ->setBody($app['twig']->render('/form/email.html.twig',
                            array('data'      => $data)),'text/html');
                $callback['send'] = $app['mailer']->send($message);

                if($callback['send'] != 1) {
                    $callback['errors'] = 'Une erreur s\'est produite lors de l\'envoi du message. Veuillez réessayer plus tard.';
                }
            }

            return $app->json($callback);
        }

        public function connect(Application $app)
        {
            $contact = $app['controllers_factory'];
            $contact->match('/', array($this, 'contact'));
            $contact->post('/validate', array($this, 'validate'));
            return $contact;
        }
    }
}