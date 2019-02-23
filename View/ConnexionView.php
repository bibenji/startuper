<?php

namespace View;

class ConnexionView extends AbstractView
{
    private function generateTextField($name, $placeholder, $type, $params) {
        return '<input name="'.$name.'" placeholder="'.$placeholder.'" type="'.$type.'" value="'. ( isset($params[$name]) ? $params[$name] : '' ) .'" />';
    }

    public function render($parameters)
    {
        foreach ($parameters as $key => $value) {            
            $$key = $value;
        }
        
        ob_start ();
?>

<main id="main-blog">
    <div class="row">
    	<div class="col-md-12">

            <form id="connexionForm" method="POST">
                <h1>Connexion</h1>
                <div class="card">
                    <div class="card-body">
                        
                        <div class="row">
                            <?php foreach ($errors as $error) {
                                echo '<div class="col-md-12 connexionError">'.$error.'</div>';
                            } ?>
                            <?php foreach ($successes as $success) {
                                echo '<div class="col-md-12 connexionSuccess">'.$success.'</div>';
                            } ?>

                            <div class="col-md-6">
                                <h3>S'identifier</h3>
                                <?= $this->generateTextField('login_login', 'Identifiant', 'text', $params); ?>
                                <?= $this->generateTextField('login_password', 'Mot de passe', 'password', $params); ?>
                                <input name="login_submit" type="submit" value="M'identifier" />
                            </div>
                            <div class="col-md-6">                        
                                <h3>S'enregistrer</h3>  
                                <?= $this->generateTextField('register_login', 'Identifiant', 'text', $params); ?>
                                <?= $this->generateTextField('register_password', 'Mot de passe', 'password', $params); ?>
                                <?= $this->generateTextField('register_password_confirm', 'Confirmation mot de passe', 'password', $params); ?>
                                <?= $this->generateTextField('register_email', 'Email', 'text', $params); ?>
                                <input name="register_submit" type="submit" value="M'enregistrer" />                                
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer">                    
                        <h4>Mot de passe oublié ?</h4>
                        <div class="row">
                            <div class="col-md-8">
                                <input disabled name="forgotten_email" placeholder="Email" type="text" />
                            </div>
                            <div class="col-md-4">
                                <input disabled name="forgotten_submit" type="submit" value="Envoyer" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
	</div>
</main>

<br />

<?php
        $viewContent = ob_get_contents ();
        ob_end_clean ();        
        return $viewContent;
    }
}
