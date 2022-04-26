<?php
namespace src\handlers;

use \src\models\User;
use \src\models\Chat;
use \src\models\Conversation;
use \src\models\UserPostHandler;

class ChatHandler {
    
    public static function getAllConversations($loggedUserId){
        $users = [];
        $data = Conversation::select()
             ->where('main_user', $loggedUserId)
             ->orderBy('modification', 'desc')
        ->get();
        
        if($data){
            foreach($data as $user){
                  $userData = User::select()->where('id', $user['other_user'])->one();
                 //pega a ultima msg
                $msg = Chat::select()
                    ->where(['receiver_id' => $loggedUserId, 'sender_id' => $user['other_user']])
                    ->orderBy('creation', 'desc')
                ->one(); 
                    
                    if($msg){
                        if($msg['message'] == ''){
                            $last = 'Imagem';
                        }else{
                            $last = $msg['message'];
                        }

                        $unreadmsg = ($msg['unread'] == 'false') ? true : false;
                            
                    }else{
                        $last = ' ';
                        $unreadmsg = '';
                    }

                    $newUser = new User();
                    $newUser->id = $userData['id'];
                    $newUser->name = $userData['name'];
                    $newUser->avatar = $userData['avatar'];
                    $newUser->online = $userData['online'];
                    $newUser->modification = $userData['modification'];
                    $newUser->lastMsg = $last;
                    $newUser->unreadmsg = $unreadmsg;
                   

                    $users[] = $newUser;     
            }
            return $users;
        }
        
        return false;

    }
 
    public static function createConversation($idOtherUser, $loggedUserId){
      
       $data = Conversation::select()
             ->where('main_user', $loggedUserId)
             ->where('other_user', $idOtherUser)
        ->one();

        
        if($data){
            return true;
        }else{
            
            Conversation::insert([
                'main_user' => $loggedUserId,
                'other_user' => $idOtherUser,
                'unread' => 'false',
                'modification' => date('Y-m-d H:i:s'),
                'creation' =>  date('Y-m-d H:i:s')
            ])->execute();

            Conversation::insert([
                'main_user' =>  $idOtherUser,
                'other_user' => $loggedUserId,
                'unread' => 'true',
                'modification' => date('Y-m-d H:i:s'),
                'creation' =>  date('Y-m-d H:i:s')
            ])->execute();
        }
       

    }
    public static function verifyUnreadConversation($loggedUserId){
        $user = User::select()->where('id', $loggedUserId)->one();

        if($user){
            $unreads = Conversation::select()
             ->where('other_user', $loggedUserId)
             ->where('unread', 'false')
            ->get();

            return count($unreads);
        }
        return false;
    }
    public static function verifyUnreadChat($idOtherUser, $loggedUserId){
         
        $exist = Conversation::select()
            ->where(['other_user'=> $loggedUserId,'main_user'=> $idOtherUser, 'unread'=> 'false'])
        ->get();

        if(count($exist) > 0){
            return true;
        }else{
            return false;
        }

    }
    public static function clearUnreadConversation($idLoggedUser){

        $user = User::select()->where('id', $idLoggedUser)->one();

        if($user){
             Conversation::update()
             ->set('unread', 'true')
             ->where('other_user', $idLoggedUser)
            ->execute();
        }
        
    }
    public static function createMessage($idOtherUser, $loggedUserId ,$msg){
         
        Chat::insert([
            'sender_id' => $loggedUserId,
            'receiver_id' => $idOtherUser,
            'message' => $msg,
            'creation' =>  date('Y-m-d H:i:s')
        ])->execute();

        Conversation::update()
            ->set('unread', 'false')
            ->where(['other_user'=> $idOtherUser, 'main_user' => $loggedUserId])
        ->execute();
   
    }
    public static function createMessagephoto($idOtherUser,$loggedUserId,$photoName){

        Conversation::update()
            ->set('unread', 'false')
            ->where(['other_user'=> $idOtherUser, 'main_user' => $loggedUserId])
        ->execute();
       
        Chat::insert([
            'sender_id' => $loggedUserId,
            'receiver_id' => $idOtherUser,
            'image' => $photoName,
            'creation' =>  date('Y-m-d H:i:s')
        ])->execute();

    }

    public static function getAll($idOtherUser,  $loggedUserId){

        Chat::update()
            ->set('unread', 'true')
            ->where(['sender_id'=> $idOtherUser, 'receiver_id' => $loggedUserId])
        ->execute();

        Conversation::update()
            ->set('unread', 'true')
            ->where(['main_user'=> $loggedUserId, 'other_user' => $idOtherUser])
        ->execute();
       
      
      $my = Chat::select()
           ->where([
           'receiver_id'=> $idOtherUser,
            'sender_id' => $loggedUserId
          ])
          ->orderBy('creation', 'desc')
          ->limit(40)
        ->get(); 

        $other = Chat::select()
               ->where([
                'receiver_id'=> $loggedUserId,
                'sender_id' => $idOtherUser
              ])
              ->orderBy('creation', 'desc')
              ->limit(40)
            ->get();

            
        $data = array_merge($my, $other);

        array_multisort(array_map(function($element) {
            return $element['creation'];
        }, $data), SORT_ASC, $data);
       
      return  $data;

    }

    public static function getMessageOtherUnread($otherUserId,  $loggedUserId){
         
        $allMsgUnread =  Chat::select()
            ->where(['sender_id' => $otherUserId, 'receiver_id'=> $loggedUserId,'unread'=> 'false' ])
        ->get();
        Chat::update()
            ->set('unread', 'true')
            ->where(['sender_id'=> $otherUserId, 'receiver_id' => $loggedUserId])
        ->execute();

        return $allMsgUnread;

    }
   
}  