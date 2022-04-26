<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
 
class LoginController extends Controller {

   public function signin(){ 
       $flash = '';
      if(!empty($_SESSION['flash'])){
          $flash = $_SESSION['flash'];
          $_SESSION['flash'] = '';
      }
        $this->render('signin', [
              'flash' => $flash,
        ]);
   }
   public function signinFree(){
     $email = 'convidado@email.com';
     $password = '1234';
     if($email && $password){

            $token = UserHandler::verifyLogin($email,$password);

            if($token){
                  $_SESSION['token'] = $token;
                  $this->redirect('/');
            }else{
                  $_SESSION['flash'] = 'E-mail e/ou senha estão incorretos';
                  $this->redirect('/login');
            }

           

      }else{
        
            $this->redirect('/login');
      }

   }
   public function signinAction(){
      $email = filter_input(INPUT_POST , 'email', FILTER_VALIDATE_EMAIL);
      $password = filter_input(INPUT_POST , 'password');

      if($email && $password){

            $token = UserHandler::verifyLogin($email,$password);

            if($token){
                  $_SESSION['token'] = $token;
                  $this->redirect('/');
            }else{
                  $_SESSION['flash'] = 'E-mail e/ou senha estão incorretos';
                  $this->redirect('/login');
            }

           

      }else{
        
            $this->redirect('/login');
      }
      
   }
   public function signup(){
      $flash = '';
      if(!empty($_SESSION['flash'])){
          $flash = $_SESSION['flash'];
          $_SESSION['flash'] = '';
      }
        $this->render('signup', [
              'flash' => $flash,
        ]);
   }
   public function signupAction(){
      $name = filter_input(INPUT_POST , 'name', FILTER_SANITIZE_SPECIAL_CHARS);
      $email = filter_input(INPUT_POST , 'email', FILTER_VALIDATE_EMAIL);
      $password = filter_input(INPUT_POST , 'password', FILTER_SANITIZE_SPECIAL_CHARS);
      $passwordRepeater = filter_input(INPUT_POST , 'passwordrepeter', FILTER_SANITIZE_SPECIAL_CHARS);
      $birthdate = filter_input(INPUT_POST, 'birthdate');

      

      if($name && $email && $password && $birthdate && $passwordRepeater){
            if($password != $passwordRepeater){
                  $_SESSION['flash'] = 'As senhas não são iguais';
                  $this->redirect('/cadastro');
      
            }
            
            $birthdate = explode('/', $birthdate);

            if(count($birthdate) != 3){
                  $_SESSION['flash'] = 'Data de nascimento inválida!';
                  $this->redirect('/cadastro');
            }
            if(intval($birthdate[0]) > 31 || intval($birthdate[0]) < 1){
                  $_SESSION['flash'] = 'Data de nascimento inválida!';
                  $this->redirect('/cadastro');
            }
            if(intval($birthdate[1]) > 12 || intval($birthdate[1]) < 1){
                  $_SESSION['flash'] = 'Data de nascimento inválida!';
                  $this->redirect('/cadastro');
            }
            if(intval($birthdate[2]) > date('Y') || intval($birthdate[2]) < 1900){
                  $_SESSION['flash'] = 'Data de nascimento inválida!';
                  $this->redirect('/cadastro');
            }
           
            $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];

            if(strtotime($birthdate) === false){
                  $_SESSION['flash'] = 'Data de nascimento inválida!';
                  $this->redirect('/cadastro');
            } 

            if(UserHandler::emailExists($email) === false){
                  $token = UserHandler::addUser($name, $email, $password, $birthdate);
                  $_SESSION['token'] = $token;
                  $this->redirect("/");
            }else{
                  $_SESSION['flash'] = 'E-mail já cadastrado!';
                  $this->redirect('/cadastro');
            }



      }else{
            $this->redirect('/cadastro');
      }

   }
 
   public function logout(){
         UserHandler::logout($_SESSION['token']);
         $_SESSION['token'] = '';
         $this->redirect('/');
   }

    
}  