<?php             
    
    global $content;
    $message = "";
    if(!empty($_POST["login"]) && !empty($_POST["password"])){
        if(Login::getInstance()->check_password($_POST["login"],$_POST["password"]))
            Login::getInstance()->set_authenticated();       
        else{
            $content['message'] = 'Authentification failed! Check your login or password and try again.';            
        }
    }

    if(Login::getInstance()->is_authenticated()){
          header('Location: index.php');      
      }
