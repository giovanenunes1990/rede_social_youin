<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class PostController extends Controller {

    private $loggedUser;
 
    public function __construct(){
        $this->loggedUser = UserHandler::checkLogin();

        if($this->loggedUser === false){
        $this->redirect('/login');
        }

    }
 
    public function index($attr = []){

        $idPost = $attr['id'];

  
        $post = PostHandler::postExist($idPost);

        if($post == false){
            $this->redirect('/');
        }

        $data = PostHandler::getPost($idPost, $this->loggedUser->id);

        $this->render('post', [
            'loggedUser' => $this->loggedUser,  
            'data' => $data,  
        ]);
    }

    public function new() {
        $body = filter_input(INPUT_POST, 'body');
       
       if($body){
           PostHandler::addPost(
               $this->loggedUser->id,
               'text',
               $body
           );
       };
      $this->redirect('/');
    }

    public function delete($atts = []){
         if(!empty($atts['id'])){
             $idPost = $atts['id'];
         }

         PostHandler::delete(
             $idPost,
             $this->loggedUser->id
         );

         $this->redirect('/');


    }

    
}