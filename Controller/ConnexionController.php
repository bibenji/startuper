<?php

namespace Controller;

use Database\{Connection, Finder, Paginate, Service\UserService};
use Entity\User;
use Engine\Request;

class ConnexionController extends BaseController
{   
    const EMAIL_REGEX = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

    public function handle()
    {   
        if ($this->request->hasParam('deconnexion')) {                
            $this->session->setUserId(NULL);
            $this->session->setUserUsername(NULL);
            header('Location: /blog');
        }        

        $errors = [];
        $successes = [];
        $userService = new UserService($this->connection);

        if (
            $this->request->getParam('login_login') && $this->request->getParam('login_login') != ''
            && $this->request->getParam('login_password') && $this->request->getParam('login_password') != ''
            && $this->request->getParam('login_submit') && $this->request->getParam('login_submit') != ''
        ) {            
            $user = $userService->fetchByUsernameOrEmail($this->request->getParam('login_login'), $this->request->getParam('login_password'));

            if ($user) {
                $this->session->setUserId($user->getId());
                $this->session->setUserUsername($user->getUsername());
                $successes[] = 'Vous êtes connecté !';
            } else {
                $errors[] = 'Identifiants incorrects.';
            }            
        }
        else if (
            $this->request->getParam('register_login') && $this->request->getParam('register_login') != ''
            && $this->request->getParam('register_password') && $this->request->getParam('register_password') != ''
            && $this->request->getParam('register_password_confirm') && $this->request->getParam('register_password_confirm') != ''            
            && $this->request->getParam('register_email') && $this->request->getParam('register_email') != ''
            && $this->request->getParam('register_submit') && $this->request->getParam('register_submit') != ''
        ) { 
            if ($this->request->getParam('register_password') != $this->request->getParam('register_password_confirm')) {
                $errors[] = 'La confirmation du mot de passe ne correspond pas.';                
            } else if (preg_match(self::EMAIL_REGEX, $this->request->getParam('register_email')) > 0) {
                $newUser = new User();
                $newUser->setUsername($this->request->getParam('register_login'));
                $newUser->setPassword($this->request->getParam('register_password'));
                $newUser->setEmail($this->request->getParam('register_email'));

                try {
                    $userService->save($newUser);
                } catch(\PDOException $e) {
                     // unique constraint exception                     
                    if ($e->getCode() == '23000') {
                        if (strpos($e->getMessage(), 'UNIQUE_USERNAME_INDEX')) {                            
                            $errors[] = 'Nom d\'utilisateur déjà pris.';
                        } else if (strpos($e->getMessage(), 'UNIQUE_EMAIL_INDEX')) {
                            $errors[] = 'Adresse email déjà enregistrée.';
                        } else {
                            throw $e;
                        }
                    } else {
                        throw $e;
                    }
                }

                if (count($errors) == 0) {
                    $successes[] = 'Enregistrement réussi ! Vous pouvez dès à présent vous connecter.';
                }
            } else {
                $errors[] = 'Email incorect.';
            }
        }
        else if (
            $this->request->getParam('forgotten_email') && $this->request->getParam('forgotten_email') != ''
            && $this->request->getParam('forgotten_submit') && $this->request->getParam('forgotten_submit') != ''
        ) {
            if (preg_match(self::EMAIL_REGEX, $this->request->getParam('forgotten_email')) > 0) {                
                $errors[] = 'Cette fonctionnalité n\'est pas disponible pour le moment.';
            } else {
                $errors[] = 'Email incorect.';
            }
            
        } else {            
            if ($this->request->getMethod() == Request::METHOD_POST)
                $errors[] = 'Il semble que certains champs n\'aient pas ou mal été remplis.';
        }
        
        $this->renderView('View\ConnexionView', [
            'errors' => $errors,
            'successes' => $successes,
            'params' => $this->request->getParams(),
        ]);
    }
}
