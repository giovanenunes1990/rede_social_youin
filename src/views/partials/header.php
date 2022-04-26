<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Cyberlife</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?= $base; ?>/assets/css/style.css" />
    <link rel="shortcut icon" type="image-x/png" href="<?= $base; ?>/assets/images/icon-yin.ico">
    <link rel="stylesheet" href="<?= $base; ?>/assets/css/modal.css" />
</head>
<body>
    <div class="overlay">
        <div class="btn-close"><img src="<?= $base; ?>/assets/images/close.png" alt=""></div>
        <div class="alert">
            <p></p>
            <form method="POST" action="">
            <div class="confirm-delete-bill">
                
                <label for="password">Digite sua senha para confirmar:</label>
                <input type="password" name="password" placeholder="Senha">
               
            </div>
            <div class="btn-confirm">
                <input type="submit" value="Sim">
                <a href="" id="link">Sim</a>
                <a id="close-overlay">Não</a>
            </div>
            </form>
        </div>
    </div>
    <?php  if(!empty($success)){ ?>
    <div class="warning">
        <div class="box-warning flex-alt">
             <p><?= $success; ?></p><div class="close">X</div>
        </div>
    </div>
    <?php }else if(!empty($flash)){ ?>
    <div class="warning flash">
        <div class="box-warning flex-alt">
             <p><?= $flash; ?></p><div class="close">X</div>
        </div>
    </div>
    <?php } ?>
    <header>
        <div class="container">
            <div class="logo">
                <a href="<?= $base; ?>"><img src="<?= $base; ?>/assets/images/youin.png" /></a>
            </div>
            <div class="head-side">
                <div class="head-side-left">
                    <div class="search-area">
                        <form method="GET" action="<?= $base; ?>/pesquisa">
                            <input type="search" placeholder="Pesquisar" name="s" />
                        </form>
                    </div>
                    <div class="extra-mobile">
                        <a href="<?= $base; ?>/config" class="user-logout pl-5">
                           <img class="bell" src="<?= $base; ?>/assets/images/settings-white.png" />
                        </a>
                        <a href="<?= $base; ?>/notificacoes" class="user-logout  noti-menu pr-10">
            
                            <?php if(count($loggedUser->unreadNoti) > 0): ?>
                            <div class="noti-qt count-noti"><?= count($loggedUser->unreadNoti); ?></div>
                            <?php endif; ?>
                           
                           <img class="bell" src="<?= $base; ?>/assets/images/bell.png" />
                        </a>
                        <a onclick="openDialog('Tem certeza que deseja sair?', '<?= $base; ?>/sair')">
                            <img src="<?= $base; ?>/assets/images/power_white.png" alt="exit">
                        </a>  
                    </div>
                </div>
                <div class="head-side-right">

                    <a href="<?= $base; ?>/amigos" class="user-logout pr-10">
                        <img src="<?= $base; ?>/assets/images/friends.png" />
                    </a>

                    <a href="<?= $base; ?>/conversas" class="user-logout noti-menu">
                         <?php if(count($loggedUser->unreadChats) > 0): ?>
                        <div class="noti-qt count-chat ml-10"><?= count($loggedUser->unreadChats); ?></div>
                        <?php endif; ?>
                        <img src="<?= $base; ?>/assets/images/chat-white.png" />
                    </a>

                    <a href="<?= $base; ?>/notificacoes" class="user-logout pr-10 mr-10 noti-menu">
                        <?php if(count($loggedUser->unreadNoti) > 0): ?>
                        <div class="noti-qt count-noti"><?= count($loggedUser->unreadNoti); ?></div>
                        <?php endif; ?>
                        <img src="<?= $base; ?>/assets/images/bell.png" />
                    </a>

                    <a href="<?= $base; ?>/perfil" class="user-area">
                        <div class="user-area-text"><?= $loggedUser->name; ?></div>
                        <div class="user-area-icon">
                            <img src="<?= $base; ?>/media/avatars/<?= $loggedUser->avatar; ?>" />
                        </div>
                    </a>
                    <a class="user-logout" onclick="openDialog('Tem certeza que deseja sair?', '<?= $base; ?>/sair')">
                        <img src="<?= $base; ?>/assets/images/power_white.png" />
                    </a>
                </div>
            </div>
        </div> 
    </header>