<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\ChatHandler;

class ChatController extends Controller {

    private $loggedUser;

    public function __construct(){
        $this->loggedUser = UserHandler::checkLogin();

        if($this->loggedUser === false){
        $this->redirect('/login');
        }
 
    }

    public function index() {
        ChatHandler::clearUnreadConversation($this->loggedUser->id);
        $conversations = ChatHandler::getAllConversations($this->loggedUser->id);
        

        $this->render('conversations', [
            'loggedUser' => $this->loggedUser,
            'conversations' => $conversations,
        ]);
    }
    public function chat($attr = []){
        $idOtherUser = $attr['id'];

        $otherUser = UserHandler::getUser($idOtherUser);
         
        if($otherUser){

            //criar esse conexão no banc ode convertions
            $createConversation = ChatHandler::createConversation($idOtherUser, $this->loggedUser->id);

            $msgs = ChatHandler::getAll($idOtherUser, $this->loggedUser->id);

            $otherUserNoti = ChatHandler::verifyUnreadChat($idOtherUser, $this->loggedUser->id);

            $this->render('chat', [
                'loggedUser' => $this->loggedUser,
                'otherUser' => $otherUser,
                'otherUserNoti' => $otherUserNoti,
                'msgs' => $msgs,
            ]);
          
        }else{
            $this->redirect('/conversas');
        }

       
    }

    public function  sendMessage($attr = []){
        $array = ['error'=> ''];
        $receiverid = $attr['id'];
        $msg = filter_input(INPUT_POST, 'txt');
       

        $otherUser = UserHandler::getUser($receiverid);

        if($otherUser && $msg){
            ChatHandler::createMessage($receiverid,  $this->loggedUser->id ,$msg);
            $array['body'] = $msg;
            $array['time'] = date('Y-m-d H:i:s');
        }
        header('Content-Type: application/json');
        echo json_encode($array);
        exit;

    }

    public function sendPhoto($attr = []){
        $array = ['error'=> ''];
        $receiverid = $attr['id'];

        $otherUser = UserHandler::getUser($receiverid);
        if($otherUser){
            if(isset($_FILES['photo']) && !empty($_FILES['photo']['tmp_name'])){
                $photo = $_FILES['photo'];
    
                $_SESSION['teste'] = 'encontrou a foto';
    
                $maxWidth = 1280;
                $maxHeight = 1280;
    
                if(in_array($photo['type'], ['image/jpeg', 'image/jpg', 'image/png'])){
                   
                    
    
                    list($widthOrig, $heightOrig) = getimagesize($photo['tmp_name']);
    
                    $ratio = $widthOrig / $heightOrig;
    
                    $newWidth = $maxWidth;
                    $newHeight = $maxHeight;
                    $ratioMax = $maxWidth / $maxHeight;
    
                    if($ratioMax > $ratio){
                        $newWidth = $newHeight * $ratio;
                    } else {
                        $newHeight = $newWidth / $ratio;        
                    }
    
                    $finalimage = imagecreatetruecolor($newWidth, $newHeight);
                    switch($photo['type']){
                        case 'image/png':
                            $image = imagecreatefrompng($photo['tmp_name']);
                        break;
                        case 'image/jpeg':
                        case 'image/jpg':
                            $image = imagecreatefromjpeg($photo['tmp_name']);
                        break;
                    }
                    
                    imagecopyresampled(
                        $finalimage, $image,
                        0,0,0,0,
                        $newWidth, $newHeight, $widthOrig, $heightOrig
                    );
    
                    $photoName = md5(time().rand(0,9999)).'.jpg';
                    imagejpeg($finalimage, 'media/uploads/'.$photoName);
    
                    $array['img'] = $photoName;
                    $array['time'] = date('d/m/Y H:i:s');
    
                    ChatHandler::createMessagephoto($receiverid ,$this->loggedUser->id,$photoName);
    
    
    
                }
    
            }else{
                $array['error'] = 'Nenhuma imagem enviada!';
            }



        }
        header('Content-Type: application/json');
        echo json_encode($array);
        exit;

    }

    public function requests($attr = []){

        $array = ['error'=> ''];
        $loggedUserId = $attr['id'];
       
        $user= UserHandler::getUser($loggedUserId);

       if($user->id == $this->loggedUser->id){
           $unreadNow = ChatHandler::verifyUnreadConversation($loggedUserId);
           $array['countchat'] = $unreadNow;
            
       }
        header('Content-Type: application/json');
        echo json_encode($array);
        exit;

    }

    public function getOtherMessage($attr = []){
      
        $otherId = $attr['id'];

        $otherUser = UserHandler::getUser($otherId);

        if($otherUser){
            $msg = ChatHandler::getMessageOtherUnread($otherId,  $this->loggedUser->id );
            $array[] = $msg;
            
        }
        header('Content-Type: application/json');
        echo json_encode($array);
        exit;

    }

     
}