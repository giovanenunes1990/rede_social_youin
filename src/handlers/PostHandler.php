<?php
namespace src\handlers;

use \src\models\Post;
use \src\models\PostLike;
use \src\models\PostComment;
use \src\models\User; 
use \src\models\UserRelation;
use \src\models\Notification;


require '../src/helpers.php';

class PostHandler {
 
    public static function addPost($idUser, $type, $body){
         $body = trim($body);
        if(!empty($idUser) ){

            Post::insert([
                'id_user' => $idUser,
                'type' => $type,
                'create_at' => date('Y-m-d H:i:s'),
                'body' => $body
            ])->execute();
        }

    }
 
    public static function _postListToObject($postList, $loggedUserId){
        $posts = [];
        foreach($postList as $postItem){
            
            $newPost = new Post();
            $newPost->id = $postItem['id'];
            $newPost->type = $postItem['type'];
            // $postItem['create_at']; 
            $newPost->create_at = timesGo( date('Y-m-d H:i:s', strtotime( $postItem['create_at'])) );
            $newPost->body = $postItem['body']; 
            $newPost->mine = false;

            if($postItem['id_user'] == $loggedUserId){
                $newPost->mine = true;
            }

            //4 preencher as infos adicionais no post
            $newUser = User::select()->where('id', $postItem['id_user'])->one();
            $newPost->user = new User();
            $newPost->user->id = $newUser['id'];
            $newPost->user->name = $newUser['name'];
            $newPost->user->avatar = $newUser['avatar'];

            //4.1 Infos de likes
            $likes = PostLike::select()->where('id_post', $postItem['id'])->get();
            $newPost->likeCount = count($likes);
            $newPost->liked = self::isLiked($postItem['id'], $loggedUserId); 

            //4.2 Infos de comentarios
            $newPost->comments = PostComment::select()->where('id_post', $postItem['id'])->get();
            foreach($newPost->comments as $key => $comment){
                $newPost->comments[$key]['user'] = User::select()->where('id', $comment['id_user'])->one();

            }


            $posts[] = $newPost;
        }
         return $posts;
    }


    public static function isLiked($id, $loggedUserId){
        $myLike = PostLike::select()
            ->where('id_post', $id)
            ->where('id_user', $loggedUserId)
        ->get(); 

        if(count($myLike) > 0){
            return true;
        }else{
            return false;
        }

    }

    public static function postExist($id){
        $post = Post::select()->where('id', $id)->get();
        if(count($post) > 0){
            return true;
        }else{
            return false;
        }     
    }

    public static function deleteLike($id, $loggedUserId){

        PostLike::delete()
           ->where('id_post', $id)
           ->where('id_user', $loggedUserId)
        ->execute();

    }

    public static function addLike($id, $loggedUserId){
        PostLike::insert([
            'id_post'=> $id,
            'id_user'=> $loggedUserId,
            'create_at'=> date('Y-m-d H:i:s')
        ])->execute();

        $post = Post::select()->where('id', $id)->one();

        if($loggedUserId != $post['id_user']){
             
            //verificação como o seguir se já nao existe
            $exist = Notification::select()
            ->where('user_receiver', $post['id_user'])
            ->where('user_sender', $loggedUserId)
            ->where('post_id', $id)
            ->where('type', 'love')
            ->one();

            if($exist == false){

                Notification::insert([
                    'type' => 'love',
                    'user_receiver' => $post['id_user'],
                    'user_sender' => $loggedUserId,
                    'create_at' => date('Y-m-d H:i:s'),
                    'post_id' => $id
                ])->execute();
                
            }

        }
       
    }

    public static function addComment($id, $txt, $loggedUserId){

        PostComment::insert([
            'id_post'=> $id,
            'id_user'=> $loggedUserId,
            'create_at'=> date('Y-m-d H:i:s'),
            'body' => $txt
        ])->execute();

        $post = Post::select()->where('id', $id)->one();

        if($loggedUserId != $post['id_user']){


        Notification::insert([
            'type' => 'commented',
            'user_receiver' => $post['id_user'],
            'user_sender' => $loggedUserId,
            'create_at' => date('Y-m-d H:i:s'),
            'post_id' => $id
         ])->execute();

        }

       

    }

    public static function getPost($id, $loggedUserId){
       $data = '';
       
       $post = Post::select()->where('id', $id)->one();

       $newPost = new Post();
       $newPost->id = $post['id'];
       $newPost->type = $post['type'];
       $newPost->create_at = timesGo( date('Y-m-d H:i:s', strtotime( $post['create_at'])) );
       $newPost->body = $post['body']; 
       $newPost->mine = false;

       if($post['id_user'] == $loggedUserId){
           $newPost->mine = true;
       }

       $newUser = User::select()->where('id', $post['id_user'])->one();
       $newPost->user = new User();
       $newPost->user->id = $newUser['id'];
       $newPost->user->name = $newUser['name'];
       $newPost->user->avatar = $newUser['avatar'];

       //4.1 Infos de likes
       $likes = PostLike::select()->where('id_post', $post['id'])->get();
       $newPost->likeCount = count($likes);
       $newPost->liked = self::isLiked($post['id'], $loggedUserId); 

       //4.2 Infos de comentarios
       $newPost->comments = PostComment::select()->where('id_post', $post['id'])->get();
       foreach($newPost->comments as $key => $comment){
           $newPost->comments[$key]['user'] = User::select()->where('id', $comment['id_user'])->one();

       }

       $data = $newPost;

       return $data;

    }

    public static function getHomeFeed($idUser, $page){
        $perPage = 7;
        // 1. Pegar lista de usuarios que EU sigo.
        $userList = UserRelation::select()->where('user_from', $idUser)->get();
        $users = [];

        foreach($userList as $userItem){
            $users[] = $userItem['user_to'];
        }
        $users[] = $idUser;
 

        //2 Pegar os posts dessa galera ordenando pela data.
        $postList = Post::select()
            ->where('id_user', 'in', $users)
            ->orderBy('create_at', 'desc')
            ->page($page, $perPage)
        ->get();

        $total = Post::select()
            ->where('id_user', 'in', $users)
        ->count();
        $pageCount = ceil($total / $perPage);

        //3 trnasformando o resultado em objetos dos models
        $posts = self::_postListToObject($postList, $idUser);
        
        // 5 retornar o resultado
        return [
            'posts' => $posts,
            'pageCount' => $pageCount,
            'currentPage' => $page,
            'total' => $total,
            'perPage' => $perPage
        ];
    }

    public static function getUserfeed($idUser, $page, $loggedUserId){
        $perPage = 7;
         $postList = Post::select()
         ->where('id_user', $idUser)
         ->orderBy('create_at', 'desc')
         ->page($page, $perPage)
     ->get();

     $total = Post::select()
     ->where('id_user', $idUser)
     ->count();
     $pageCount = ceil($total / $perPage);

     //3 trnasformando o resultado em objetos dos models
     $posts = self::_postListToObject($postList, $loggedUserId);
     
     // 5 retornar o resultado
     return [
         'posts' => $posts,
         'pageCount' => $pageCount,
         'currentPage' => $page,
         'total' => $total,
         'perPage' => $perPage
     ];

    }

    public static function getPhotosFrom($idUser){
        $photosData = Post::select()
            ->where('id_user', $idUser)
            ->where('type', 'photo')
        ->get();

        $photos = [];

        foreach($photosData as $photo){
            $newPost = new Post();
            $newPost->id = $photo['id'];
            $newPost->type = $photo['type'];
            $newPost->create_at = $photo['create_at'];
            $newPost->body = $photo['body'];

            $photos [] = $newPost;
        }

        return $photos;

    }

    public static function delete($id, $loggedUserId){
         // 1 verificar se o post existe e se é seu
         $post = Post::select()
             ->where('id', $id)
             ->where('id_user', $loggedUserId)
        ->get();

        if(count($post) > 0){ 
            $post = $post[0];

             //2 deletar os likes e comments
             PostLike::delete()->where('id_post', $id)->execute();
             PostComment::delete()->where('id_post', $id)->execute();

            //3 verifica se o post é do type  photo e se for deleta o arquivo
            if($post['type'] === 'photo'){
                $img = __DIR__.'/../../public/media/uploads/'.$post['body'];
                if(file_exists($img)){
                    unlink($img);
                }
            }
             //4 deletar post
             Post::delete()->where('id', $id)->execute();
             Notification::delete()->where('post_id', $id)->execute();

        }

    }

}