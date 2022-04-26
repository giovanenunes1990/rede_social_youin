<?php
namespace src\handlers;

use \src\models\User;
use \src\models\Post;
use \src\models\UserPostHandler;
use \src\models\Notification;

require '../src/helpers.php';

class NotificationHandler {

    public static function getAll($idLoggedUser){
        $data = [];
       
        $noti = Notification::select()
            ->where('user_receiver', $idLoggedUser)
            ->orderBy('create_at', 'desc')
            ->limit(25)
        ->get();

        if($noti){
            foreach($noti as $notification){


                if($notification['type'] == 'follow'){
                
                    $newNoti = new Notification();
                    $newNoti->id = $notification['id'];
                    $newNoti->type = $notification['type'];
                    $newNoti->user = $notification['user_sender'];
                    // $notification['create_at']; 
                    $newNoti->createat =  timesGo( date('Y-m-d H:i:s', strtotime( $notification['create_at'])) );

                    $user = User::select()->where('id', $notification['user_sender'])->one();

                    $newUser = new User();

                    $newUser->id = $user['id'];
                    $newUser->name = $user['name'];
                    $newUser->avatar = $user['avatar'];
                    
                    $newNoti->users = $newUser;

                    $data[] = $newNoti;
                    

                }else{
                    $newNoti = new Notification();
                    $newNoti->id = $notification['id'];
                    $newNoti->type = $notification['type'];
                    $newNoti->user = $notification['user_sender'];
                    // $notification['create_at'];
                    $newNoti->createat = timesGo( date('Y-m-d H:i:s', strtotime( $notification['create_at'])) );
                    $newNoti->postid = $notification['post_id'];

                    $user = User::select()->where('id', $notification['user_sender'])->one();
                    
                    $newUser = new User();

                    $newUser->id = $user['id'];
                    $newUser->name = $user['name'];
                    $newUser->avatar = $user['avatar'];
                    
                    $newNoti->users = $newUser;

                    $posts = Post::select()->where('id', $notification['post_id'])->one();

                    $newPost = new Post();

                    $newPost->id = $posts['id'];
                    $newPost->type = $posts['type'];


                    $newNoti->post = $newPost;
                
                $data[] = $newNoti;
               }
            }

        }



        return $data;

    }

    public static function addNotificationFollow($id, $loggedUserId){

        $user = User::select()->where('id', $id)->one();

        if($loggedUserId != $user['id']){

            $exist = Notification::select()
            ->where('user_receiver', $user['id'])
            ->where('user_sender', $loggedUserId)
            ->where('type', 'follow')
            ->one();

            if($exist == false){

                Notification::insert([
                    'type' => 'follow',
                    'user_receiver' => $user['id'],
                    'user_sender' => $loggedUserId,
                    'create_at'=> date('Y-m-d H:i:s'), 
                    'post_id' => ''
                    ])->execute();

            }   

        }

    }

    public static function verifyUnread($loggedUserId){
        $user = User::select()->where('id', $loggedUserId)->one();

        if($user){
            $unreads = Notification::select()
             ->where('user_receiver', $loggedUserId)
             ->where('unread', 'false')
            ->get();

            return count($unreads);

        }

        return false;
    }

    public static function clearUnread($idLoggedUser){

        $user = User::select()->where('id', $idLoggedUser)->one();

        if($user){
             Notification::update()
             ->set('unread', 'true')
             ->where('user_receiver', $idLoggedUser)
            ->execute();

        }
        

    }
   
   
}