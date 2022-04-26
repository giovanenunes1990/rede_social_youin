<?= $render('header', ['loggedUser' => $loggedUser]); ?>
<?php require '../src/helpers.php'; ?>
<section class="container main">
    <?= $render('sidebar', ['activeMenu'=>'message']); ?>
    <section class="feed mt-10">
        
        <div class="row conversations">
            <div class="column pr-5 text-center">
                
                
                <?php if($conversations > 0){ ?>
                <h4>Mensagens recentes:</h4>
                <div class="list-users-chat">

                   <?php foreach($conversations as $user): ?>
                    <div class="item-user-chat">
                        <a href="<?= $base; ?>/chat/<?= $user->id; ?>">
                            <div class="user-chat-avatar">
                                <img src="<?= $base; ?>/media/avatars/<?= $user->avatar; ?>"/>  
                            </div>
                            <div class="message-data">
                                <div class="h5"><?= $user->name; ?>
                                <?php if($user->online == 'true'){ ?>
                                    <div class="span"><div class="circle"></div>Online</div>
                                <?php }else if($user->modification != date('Y-m-d H:i:s')){ ?>
                                    <div class="span last-see">offline <?= timesGoChat( date('Y-m-d H:i:s', strtotime($user->modification)) ); ?></div>
                                <?php }; ?>
                                </div>
                                <p id="chat-message" class="<?= ($user->unreadmsg) ? 'unread-msg' : '' ?>"><?= $user->lastMsg; ?></p>
                            </div>
                        </a>
                    </div>
                   <?php endforeach; ?>   
                   
                  
                     
                </div>
                <?php }else{ ?>
                    <h4>Você ainda não possui nenhuma conversa...</h4>

                <?php } ?>

            </div>
            <div class="column side pl-5">
                <?= $render('right-side'); ?>
            </div>
        </div>

    </section>
</section>

<?= $render('footer', ['loggedUser' => $loggedUser]); ?>