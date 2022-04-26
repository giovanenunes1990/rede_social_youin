<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;

class ConfigController extends Controller {

    private $loggedUser;

    public function __construct(){
        $this->loggedUser = UserHandler::checkLogin();

        if($this->loggedUser === false){
        $this->redirect('/login');
        }
 
    }
    private function cutImage($file, $w, $h, $folder){

        list($widthOrig, $heightOrig) = getimagesize($file['tmp_name']);
        $ratio = $widthOrig / $heightOrig;

        $newWidth = $w;
        $newHeight = $newWidth / $ratio;

        if($newHeight < $h){
            $newHeight = $h;
            $newWidth = $newHeight * $ratio;
        }

        $x = $w - $newWidth;
        $y = $h - $newHeight;

        $x = $x < 0 ? $x / 2 : $x;
        $y = $y < 0 ? $y / 2 : $y;

        $finalImage = imagecreatetruecolor($w, $h);
        switch($file['type']){
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($file['tmp_name']);
            break;
            case 'image/png':
                $image = imagecreatefrompng($file['tmp_name']);
            break;
        }

        imagecopyresampled(
            $finalImage, $image,
            $x, $y, 0, 0,
            $newWidth, $newHeight, $widthOrig, $heightOrig,
        );

        $fileName = md5(time().rand(0, 9999)).'.jpg';

        imagejpeg($finalImage, $folder.'/'.$fileName);

        return $fileName;

    }
  
    public function index() {
        $flash = '';
        $success = '';
        if(!empty($_SESSION['flash'])){
          $flash = $_SESSION['flash'];
          $_SESSION['flash'] = '';
        }
        if(!empty($_SESSION['success'])){
            $success = $_SESSION['success'];
            $_SESSION['success'] = '';
          }
        $fullUser = UserHandler::getUser($this->loggedUser->id, true);
        UserHandler::aticivy($this->loggedUser->id);
       
        $this->render('config', [
            'loggedUser' => $this->loggedUser,
            'user'=> $fullUser,
            'flash' => $flash,
            'success' => $success
            
        ]);
    }

    public function indexAction() {
        $data = [];
        $data['id'] = $this->loggedUser->id;
        $fullUser = UserHandler::getUser($this->loggedUser->id, true);

        $name = filter_input(INPUT_POST , 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST , 'email', FILTER_VALIDATE_EMAIL);
        
        $city = filter_input(INPUT_POST, 'city',  FILTER_SANITIZE_SPECIAL_CHARS);
        $work = filter_input(INPUT_POST, 'work',  FILTER_SANITIZE_SPECIAL_CHARS);
        $birthdate = filter_input(INPUT_POST, 'birthdate');

        $password = filter_input(INPUT_POST , 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $passwordConfirm = filter_input(INPUT_POST , 'passwordconfirm', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if($birthdate){
            //Data de nascimento
            $birthdate = explode('/', $birthdate);  
            if(count($birthdate) != 3){
                    $_SESSION['flash'] = 'Data de nascimento inválida!';
                    $this->redirect('/config');
            }
            if(intval($birthdate[0]) > 31 || intval($birthdate[0]) < 1){
                $_SESSION['flash'] = 'Data de nascimento inválida!';
                $this->redirect('/config');
            }
            if(intval($birthdate[1]) > 12 || intval($birthdate[1]) < 1){
                    $_SESSION['flash'] = 'Data de nascimento inválida!';
                    $this->redirect('/config');
            }
            if(intval($birthdate[2]) > date('Y') || intval($birthdate[2]) < 1900){
                    $_SESSION['flash'] = 'Data de nascimento inválida!';
                    $this->redirect('/config');
            }
            
            $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];

           
            if(strtotime($birthdate) === false){
                    $_SESSION['flash'] = 'Data de nascimento inválida!';
                    $this->redirect('/config');
            }
            $data['birthdate'] = $birthdate;
        }else{
            $_SESSION['flash'] = 'Data de nascimento é obrigatório!';
            $this->redirect('/config');
        }
        //passwords
        if($password && $passwordConfirm){         
            if($password === $passwordConfirm){
                $data['password'] = $password;  
            }else{
                $_SESSION['flash'] = 'As senhas não são iguais';
                $this->redirect('/config');
            }
        }
        if($password && empty($passwordConfirm)){
            $_SESSION['flash'] = 'Confirme sua senha!';
            $this->redirect('/config');
        }
        if($passwordConfirm && empty($password)){
            $_SESSION['flash'] = 'Digite uma senha!';
            $this->redirect('/config');
        }

        //email
        if($email){
            if($email != $fullUser->email){
                if(UserHandler::emailExists($email) === false){
                    $data['email'] = $email; 
                }else{
                    $_SESSION['flash'] = 'E-mail já cadastrado!';
                    $this->redirect('/config');
                }  
            }
            $data['email'] = $email;
        }else{
            $_SESSION['flash'] = 'E-mail é obrigatório!';
            $this->redirect('/config');
        }
        if($name){
            $data['name'] = $name;
        }else{
            $_SESSION['flash'] = 'Nome é obrigatório!';
            $this->redirect('/config');
        }   
        $data['city'] = $city;
        $data['work'] = $work;

        //AVATAR
        if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name'])){
            $newAvatar = $_FILES['avatar'];
        
            if(in_array($newAvatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])){
                $avatarName = $this->cutImage($newAvatar, 200, 200, 'media/avatars');
                $data['avatar'] = $avatarName;
            }
        }
        //Cover
        if(isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'])){
            $newCover = $_FILES['cover'];
       
            if(in_array($newCover['type'], ['image/jpeg', 'image/jpg', 'image/png'])){
                $coverName = $this->cutImage($newCover, 850, 310, 'media/covers');
                $data['cover'] = $coverName;
            }
        }
      
        $token = UserHandler::updateUser($data);
        $_SESSION['success'] = 'Dados atualizados com sucesso!';
        $_SESSION['token'] = $token;
        $this->redirect("/config");

    }

    public function removePhoto($attr = []){
        $id = $attr['id'];

        if($id == $this->loggedUser->id){
            
            UserHandler::removePhoto($id);
            $_SESSION['success'] = 'Foto removida com sucesso!';
            $this->redirect('/config');

        }else{
            $this->redirect('/config');
        }
               
    }

    public function removeCover($attr = []){
        $id = $attr['id'];

        if($id == $this->loggedUser->id){
            
            UserHandler::removeCover($id);
            $_SESSION['success'] = 'Imagem de fundo removida com sucesso!';
            $this->redirect('/config');

        }else{
            $this->redirect('/config');
        }
    }

    public function deleteUser($attr = []){
        $id = $attr['id'];
        $password = filter_input(INPUT_POST , 'password', FILTER_SANITIZE_SPECIAL_CHARS);
      
        if($id == $this->loggedUser->id && $password){ 

            $confirm = UserHandler::verifyPassword($password, $this->loggedUser->id);

            if($confirm){ 
                //se a senha bater então ...
             
              UserHandler::deleteUser($id);
              
              $this->redirect('/');
              
            }else{ 
                $_SESSION['flash'] = 'Senha incorreta!';
                $this->redirect('/config');
            }

          
        }else{
            $this->redirect('/config');
        }
        
    }

    
    
}