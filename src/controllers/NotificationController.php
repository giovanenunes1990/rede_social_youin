<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;
use \src\handlers\NotificationHandler;

class NotificationController extends Controller {

    private $loggedUser;

    public function __construct(){
        $this->loggedUser = UserHandler::checkLogin();

        if($this->loggedUser === false){
        $this->redirect('/login');
        }

    }
 
    public function index($atts = []){

        $notifications = NotificationHandler::getAll($this->loggedUser->id);
        NotificationHandler::clearUnread($this->loggedUser->id);


        $this->render('notification', [
            'loggedUser' => $this->loggedUser, 
            'notifications' =>  $notifications,   
        ]);
    }
 
    public function requests($attr = []){
        $array = ['error'=> ''];
        $loggedUserId = $attr['id'];
       
        $user= UserHandler::getUser($loggedUserId);

       if($user->id == $this->loggedUser->id){
           $unreadNow = NotificationHandler::verifyUnread($loggedUserId);
           $array['countnoti'] = $unreadNow;
            
       }
        header('Content-Type: application/json');
        echo json_encode($array);
        exit;
 
    }

     
}