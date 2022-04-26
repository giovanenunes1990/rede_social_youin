<?php
use core\Router;
  
$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/entrar-sem-login', 'LoginController@signinFree');

$router->get('/login', 'LoginController@signin');
$router->post('/login', 'LoginController@signinAction');

$router->get('/cadastro', 'LoginController@signup');
$router->post('/cadastro', 'LoginController@signupAction');

$router->get('/aticivy', 'HomeController@activy');

$router->post('/post/new', 'PostController@new');
$router->get('/post/{id}', 'PostController@index');
$router->get('/post/{id}/delete', 'PostController@delete');

$router->get('/perfil/{id}/fotos', 'ProfileController@photos');
$router->get('/perfil/{id}/amigos', 'ProfileController@friends');
$router->get('/perfil/{id}/follow', 'ProfileController@follow');
$router->get('/perfil/{id}', 'ProfileController@index');
$router->get('/perfil', 'ProfileController@index');

$router->get('/amigos', 'ProfileController@friends');
$router->get('/fotos', 'ProfileController@photos');

$router->get('/pesquisa', 'SearchController@index');
$router->get('/config/remove-photo/{id}', 'ConfigController@removePhoto');
$router->get('/config/remove-cover/{id}', 'ConfigController@removeCover');

$router->get('/config', 'ConfigController@index');
$router->post('/config', 'ConfigController@indexAction');
$router->post('/config/delete-user/{id}', 'ConfigController@deleteUser');
 
$router->get('/conversas', 'ChatController@index');
$router->post('/conversas/{id}', 'ChatController@requests');
$router->get('/chat/{id}', 'ChatController@chat');

$router->post('/message/{id}', 'ChatController@sendMessage');
$router->get('/othermessage/{id}', 'ChatController@getOtherMessage');
$router->post('/photo/{id}', 'ChatController@sendPhoto');
 

$router->get('/notificacoes', 'NotificationController@index');
$router->post('/notifications/{id}', 'NotificationController@requests');
 
 
$router->get('/ajax/like/{id}', 'AjaxController@like');
$router->post('/ajax/comment', 'AjaxController@comment');
$router->post('/ajax/upload', 'AjaxController@upload');

$router->get('/sair', 'LoginController@logout');
 