<?php
namespace src\handlers;

use \src\models\User;
use \src\models\Post;
use \src\models\Notification;
use \src\models\Conversation;
use \src\models\Chat;
use \src\models\UserRelation;
use \src\models\PostLike;
use \src\models\PostComment;
use \src\models\UserPostHandler;
use \src\handlers\PostHandler;


class UserHandler { 

    static public function checkLogin(){
        if(!empty($_SESSION['token'])){

            $token = $_SESSION['token'];

            $data = User::select()->where('token', $token)->one();

            if($data && count($data) > 0) {
                $countNoti = Notification::select()->where([
                    'user_receiver' => $data['id'],
                    'unread' => 'false'
                ])->get();
                $countChats = Conversation::select()->where([
                    'other_user' => $data['id'],
                    'unread' => 'false'
                ])->get();
 
                $loggedUser = new User();
                $loggedUser->id = $data['id'];
                $loggedUser->name = $data['name'];
                $loggedUser->avatar = $data['avatar'];
                $loggedUser->online = $data['online'];
                $loggedUser->fisrttime = $data['firsttime'];
                $loggedUser->unreadNoti = $countNoti;
                $loggedUser->unreadChats = $countChats;
                
                return $loggedUser;

            }
        }else{
            $this->redirect('/login');
        }
     return false;
      
    }

    public static function verifyLogin($email, $password){
        $user = User::select()->where('email', $email)->one();
 
        if($user){
           if(password_verify($password, $user['password'])){
                $token = md5(time().rand(0,9999).time());

                User::update()
                   ->set('token', $token)
                   ->set('online', 'true')
                   ->where('email', $email)
                ->execute();
                
                return $token;
           }
        }else{
            $this->redirect('/login');
        }

         return false;
    }
    public static function logout($token){

        User::update()
            ->set('online', 'false')
            ->set('modification', date('Y-m-d H:i:s')) 
            ->where('token', $token)
        ->execute();

    } 

    public static function aticivy($loggedUserId){

        User::update()->set('firsttime', 'false')->where('id', $loggedUserId)->execute();

    }

    public static function verifyPassword($password, $loggedUserId){
        $user = User::select()->where('id', $loggedUserId)->one();

        if($user){
            if(password_verify($password, $user['password'])){
               return true;
           }else{
            return false;
           }
           
        }
        return false;
         
    }

    public static function idExists($id){
        $user = User::select()->where('id', $id)->one();
        return $user ? true : false;

    } 
    public static function emailExists($email){
        $user = User::select()->where('email', $email)->one();
        return $user ? true : false;
    }
    public static function getEmail($email){
        $user = User::select()->where('email', $email)->one();
        return $user;
    }

    public static function getUser($id, $full = false){
        $data = User::select()->where('id', $id )->one();

        if($data){

            $user = new User(); 
            $user->id = $data['id'];
            $user->name = $data['name'];
            $user->birthdate = $data['birthdate'];
            $user->city = $data['city'];
            $user->work = $data['work'];
            $user->avatar = $data['avatar'];
            $user->cover = $data['cover']; 
            $user->email = $data['email'];
            $user->online = $data['online'];
            $user->modification = $data['modification'];

            if($full){
                $user->followers = [];
                $user->following = []; 
                $user->photos = [];


                //followers
                $followers = UserRelation::select()->where('user_to', $id)->get();
                foreach($followers as $follower){
                    $userData = User::select()->where('id', $follower['user_from'])->one();

                    $newUser = new User();
                    $newUser->id = $userData['id'];
                    $newUser->name = $userData['name'];
                    $newUser->avatar = $userData['avatar'];
                   

                    $user->followers[] = $newUser;
                }
                
                //following
                $following = UserRelation::select()->where('user_from', $id)->get();
                foreach($following as $follower){
                    $userData = User::select()->where('id', $follower['user_to'])->one();

                    $newUser = new User();
                    $newUser->id = $userData['id'];
                    $newUser->name = $userData['name'];
                    $newUser->avatar = $userData['avatar'];

                    $user->following[] = $newUser;
                }

                //photos
                $user->photos = PostHandler::getPhotosFrom($id);

            }

            return $user;

        }
        return false;
    }

    public static function updateUser($data = []){
        $token = md5(time().rand(0,9999).time());

       $thisUser = User::select()->where('id', $data['id'])->one();

        if(key_exists('password', $data)){
          $hash = password_hash($data['password'], PASSWORD_DEFAULT);
          User::update()
             ->set('password', $hash)
             ->where('id', $data['id'])
           ->execute();
        }       
        if(key_exists('avatar', $data)){
           
            if($thisUser['avatar'] != 'default.jpg'){
                $img = __DIR__.'/../../public/media/avatars/'.$thisUser['avatar'];
                if(file_exists($img)){
                    unlink($img);
                }
            }
            User::update()
             ->set('avatar', $data['avatar'])
             ->where('id', $data['id'])
           ->execute();
         }

        if(key_exists('cover', $data)){
            if($thisUser['cover'] != 'cover.jpg'){
                $img = __DIR__.'/../../public/media/covers/'.$thisUser['cover'];
                if(file_exists($img)){
                    unlink($img);
                }
            }
            User::update()
             ->set('cover', $data['cover'])
             ->where('id', $data['id'])
           ->execute();
         }
        
        
         User::update()
            ->set('name', $data['name'])
            ->set('email', $data['email'])
            ->set('city', $data['city'])
            ->set('work', $data['work'])
            ->set('birthdate', $data['birthdate'])
            ->set('token', $token)
            ->where('id', $data['id'])
        ->execute(); 

        return $token;

    }

    public static function addUser($name, $email, $password, $birthdate){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(time().rand(0,9999).time());

        User::insert([
            'email' => $email,
            'password' => $hash,
            'name' => $name,
            'birthdate' => $birthdate,
            'token' => $token,
            'online' => 'true',
            'modification' => date('Y-m-d H:i:s')
        ])->execute();

        return $token;
    }

    public static function getAllNotFollowing($id){
        $dataMain = [];
        $userList = UserRelation::select()->where('user_from', $id)->get();
        $users = [];

        foreach($userList as $userItem){
            $users[] = $userItem['user_to'];
        }
        $users[] = $id;

        $dataUsers = User::select()->whereNotIn('id', $users)->get();

        if($dataUsers){
            foreach($dataUsers as $user){
                $userData = User::select()->where('id', $user['id'])->one();

                $newUser = new User();
                $newUser->id = $userData['id'];
                $newUser->name = $userData['name'];
                $newUser->avatar = $userData['avatar'];
               

                $dataMain[] = $newUser;
            }
        }
        return  $dataMain;
    }

    public static function isFollowing($from, $to){
      $data = UserRelation::select()
             ->where('user_from', $from)
             ->where('user_to', $to)
        ->one();

        if($data){
            return true; 
        }
        return false;
       
    }

    public static function follow($from,$to){
        UserRelation::insert([
            'user_from'=> $from,
            'user_to'=> $to
        ])->execute();
    }

    public static function unfollow($from,$to){
        UserRelation::delete()
           ->where('user_from', $from)
           ->where('user_to', $to)
        ->execute();
    }

    public static function searchUser($term){
        $users = [];
        $data = User::select()->where('name', 'like', '%'.$term.'%')->get();

        if($data){
            foreach($data as $user){
                $newUser = new User();
                $newUser->id = $user['id'];
                $newUser->name = $user['name'];
                $newUser->avatar = $user['avatar'];

                $users[] = $newUser;

            }

        }

        return $users;
    }

    public static function removePhoto($id){

         $user = User::select()
             ->where('id', $id)
        ->one();
      
        if($user){
            if($user['avatar'] != 'default.jpg'){
                $img = __DIR__.'/../../public/media/avatars/'.$user['avatar'];
                if(file_exists($img)){
                    unlink($img);
                }
    
                User::update()
                    ->set('avatar', 'default.jpg')
                    ->where('id', $id)
                ->execute();
            }
        }
        
    }
    public static function removeCover($id){

        $user = User::select()
            ->where('id', $id)
       ->one();

       if($user){
            if($user['cover'] != 'cover.jpg'){
                $cover = __DIR__.'/../../public/media/covers/'.$user['cover'];
                if(file_exists($cover)){
                    unlink($cover);
                }
            

            User::update()
                  ->set('cover', 'cover.jpg')
                  ->where('id', $id)
           ->execute();
           }
       }

   }
   public static function deleteUser($id){
     //delete todos os commentarios e likes
     PostLike::delete()->where('id_user', $id)->execute();
     PostComment::delete()->where('id_user', $id)->execute();
    
     //delete todas as relações 
     UserRelation::delete()->where('user_from', $id)->execute();
     UserRelation::delete()->where('user_to', $id)->execute();

     //delete todos posts 
     $posts = Post::select()->where('id_user', $id)->get();
     foreach( $posts as $post){
        PostHandler::delete($post['id'], $id);
     }

     //delete todas as notificações
     Notification::delete()->where('user_receiver', $id)->execute();
     Notification::delete()->where('user_sender', $id)->execute();

     //delete todas as conversas
     Conversation::delete()->where('main_user', $id)->execute();
     Conversation::delete()->where('other_user', $id)->execute();

     //delete todas as mensagens?...
     Chat::delete()->where('sender_id', $id)->execute();
     Chat::delete()->where('receiver_id', $id)->execute();

    
    //delete suas fotos e banner e foto de perfil
    $user = User::select()->where('id', $id)->one();
   
     if($user['avatar'] != 'default.jpg'){
        $img = __DIR__.'/../../public/media/avatars/'.$user['avatar'];
        if(file_exists($img)){
            unlink($img);
        }
    }

    if($user['cover'] != 'cover.jpg'){
        $cover = __DIR__.'/../../public/media/covers/'.$user['cover'];
        if(file_exists($cover)){
            unlink($cover);
        }
    }
        
     //por fim deleta o usuario 
     User::delete()->where('id', $id)->execute();

     $_SESSION['token'] = '';

   }

} 