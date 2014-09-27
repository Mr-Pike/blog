<?php
namespace app\controller {

    use Silex\Application;
    use Silex\ControllerProviderInterface;
    use Symfony\Component\HttpFoundation\Request;


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
        public function validate(Request $request)
        {
            // Post data.
            $data = $request->request->all();

            // Return informations.
            $callback = array();
            $callback['errors'] = '';

            // Make some verifications.
            if(trim($data['user']) == '') $callback['errors'] .= '- Votre nom est vide <br />';
            if(!filter_var($data['mail'], FILTER_VALIDATE_EMAIL)) $callback['errors'] .= '- Votre adresse mail n\'est pas valide <br />';
            if(trim($data['object']) == '') $callback['errors'] .= '- Votre objet est vide <br />';
            if(trim($data['messages']) == '') $callback['errors'] .= '- Votre message est vide <br />';

            // Check errors found.
            if($callback['errors'] != '') {
                $callback['send'] = 0;
                $callback['errors'] = 'Votre message n\'a pas été envoyé <br />' . $callback['errors'];
            } else {
                /*require_once('./app/PHPMailer/class.phpmailer.php');
                require_once('./app/config.php');

                // Mail configuration.
                $email             = new PHPMailer();
                $email->CharSet    = $config['phpMailer']['charset'];
                $email->IsSMTP();
                $email->SMTPDebug  = 1;
                $email->SMTPAuth   = true;
                $email->SMTPSecure = "ssl";
                $email->Host       = $config['phpMailer']['host'];
                $email->Port       = $config['phpMailer']['port'];
                $email->Username   = $config['phpMailer']['mail'];
                $email->Password   = $config['phpMailer']['password'];

                // Mail information.
                $email->Sender = $mail;
                $email->SetFrom($mail, $user, false);
                $email->AddAddress($config['phpMailer']['mail'], $config['phpMailer']['name']);
                $email->Subject    = '[Website] - ' . $object;
                $email->MsgHTML('=== INFORMATIONS DU CONTACT === <br />Nom & Prénom : ' . $user . '<br />'.'Mail : ' . $mail . '<br />Objet : ' . $object . '<br />Message : <br />' . $message);

                if(!$email->Send()) {
                    $callback['send'] = 0;
                    $callback['errors'] = 'Une erreur s\'est produite lors de l\'envoi du message. Veuillez réessayer plus tard.';
                } else {
                    $callback['send'] = 1;
                }*/
                $callback['send'] = 1;
            }

            return $callback;
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