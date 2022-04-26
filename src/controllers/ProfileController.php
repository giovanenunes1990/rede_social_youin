<?php
namespace src\controllers;
 
use \core\Controller;
use \src\handlers\UserHandler; 
use \src\handlers\PostHandler;
use \src\handlers\NotificationHandler;

class ProfileController extends Controller {

    private $loggedUser;

    public function __construct(){
        $this->loggedUser = UserHandler::checkLogin();

        if($this->loggedUser === false){
        $this->redirect('/login');
        }
 
    }
 
    public function index($atts = []) {
        $page = intval(filter_input(INPUT_GET, 'page'));

        //Detectando o usuário acessado
        $id = $this->loggedUser->id;
        if(!empty($atts['id'])){
            $id = $atts['id'];
        }
        //Pegando info do usuario
        $user = UserHandler::getUser($id, true);

        if(!$user){
            $this->redirect('/');
        }
        $dateFrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today');
        $user->ageYears = $dateFrom->diff($dateTo)->y;
        //pegando o feed do usuario
        $feed = PostHandler::getUserFeed($id, $page, $this->loggedUser->id);

        //verificando se EU sigo o usuario
        $isFollowing = false;
        if($user->id != $this->loggedUser->id){
            $isFollowing = UserHandler::isFollowing(
                $this->loggedUser->id,
                $user->id
            );
        }

      $this->render('profile', [
          'loggedUser' => $this->loggedUser,
          'user'=> $user,
          'feed' => $feed,
          'isFollowing' => $isFollowing,
      ]);
    }
 
    public function follow($atts){
          $to = intval($atts['id']);
          $exists = UserHandler::idExists($to);

          if($exists){
            if(UserHandler::isFollowing($this->loggedUser->id, $to)){
                //Unfollow
                UserHandler::unfollow($this->loggedUser->id, $to);
            }else{
                //Follow
                UserHandler::follow($this->loggedUser->id, $to);
                NotificationHandler::addNotificationFollow($to, $this->loggedUser->id);
            }        
          }
          $this->redirect('/perfil/'.$to);
          
    }
   

    public function friends($atts = []){

         //Detectando o usuário acessado
         $id = $this->loggedUser->id;
         if(!empty($atts['id'])){
             $id = $atts['id'];
         }
         //Pegando info do usuario
         $user = UserHandler::getUser($id, true);
         if(!$user){
            $this->redirect('/');
        }
        $dateFrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today');
        $user->ageYears = $dateFrom->diff($dateTo)->y;

        //verificando se EU sigo o usuario
        $isFollowing = false;
        if($user->id != $this->loggedUser->id){
            $isFollowing = UserHandler::isFollowing(
                $this->loggedUser->id,
                $user->id
            );
        }

        //Sugestões para adicionar mais usuarios
        $suggestions = UserHandler::getAllNotFollowing($this->loggedUser->id);



        $this->render('profile_friends', [
            'loggedUser' => $this->loggedUser,
            'user'=> $user,   
            'isFollowing' => $isFollowing,
            'suggestions' => $suggestions,
        ]);

    }

    public function photos($atts = []){

        //Detectando o usuário acessado
        $id = $this->loggedUser->id;
        if(!empty($atts['id'])){
            $id = $atts['id'];
        }
        //Pegando info do usuario
        $user = UserHandler::getUser($id, true);
        if(!$user){
           $this->redirect('/');
       }
       $dateFrom = new \DateTime($user->birthdate);
       $dateTo = new \DateTime('today');
       $user->ageYears = $dateFrom->diff($dateTo)->y;

       //verificando se EU sigo o usuario
       $isFollowing = false;
       if($user->id != $this->loggedUser->id){
           $isFollowing = UserHandler::isFollowing(
               $this->loggedUser->id,
               $user->id
           );
       }

       $this->render('profile_photos', [
           'loggedUser' => $this->loggedUser,
           'user'=> $user,   
           'isFollowing' => $isFollowing,
       ]);

   }

    
}