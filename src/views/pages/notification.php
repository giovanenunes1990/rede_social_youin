<?= $render('header', ['loggedUser' => $loggedUser]); ?>
<section class="container main">
    <?= $render('sidebar', ['activeMenu'=>'notification']); ?>
    <section class="feed mt-10">
        
        <div class="row conversations">
            <div class="column pr-5 text-center">

            
               
                <?php if(count($notifications) > 0){ ?>
                <div class="list-users-chat list-noti">
                    
                    <?php foreach($notifications as $noti): ?>
                        <?php if($noti->type == 'love' || $noti->type == 'commented'): ?>
                            <div class="item-user-chat">
                                <a href="<?= $base; ?>/post/<?= $noti->postid; ?>">
                                    <div class="user-chat-avatar">
                                        <img src="<?= $base; ?>/media/avatars/<?= $noti->users->avatar; ?>"/>  
                                    </div>
                                    <div class="message-data">
                                        <p><span class="name"><?= $noti->users->name; ?></span>

                                        <?php 
                                            if($noti->type == 'love'){
                                                switch($noti->post->type){
                                                    case 'text':
                                                        echo 'curtiu seu post';
                                                        break;
                                                    case 'photo':
                                                        echo 'curtiu sua foto';
                                                        break;
                                                }
                                            }else if($noti->type == 'commented'){
                                                switch($noti->post->type){
                                                    case 'text':
                                                        echo 'comentou seu post';
                                                        break;
                                                    case 'photo':
                                                        echo 'comentou sua foto';
                                                        break;
                                                }
                                            }else if($noti->type == 'follow'){

                                                echo ' começou te seguir';

                                            }
                                        ?>
                                        ...
                                        </p>
                                        <p class="time"><?= $noti->createat; ?></p>
                                    </div>
                                    <div class="user-chat-avatar noti">
                                    <?php 
                                        switch($noti->type){
                                            case 'love':
                                                echo '<img src="'.$base.'/assets/images/heart-on.png" />';
                                                break;
                                            case 'commented':
                                                echo '<img src="'.$base.'/assets/images/comment.png" />';
                                                break;
                                            case 'follow':
                                                echo '<img src="'.$base.'/assets/images/friends-alt.png" />';
                                        }
                                    ?> 
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if($noti->type == 'follow'): ?>
                            <div class="item-user-chat">
                                <a href="<?= $base; ?>/perfil/<?= $noti->users->id; ?>">
                                    <div class="user-chat-avatar">
                                        <img src="<?= $base; ?>/media/avatars/<?= $noti->users->avatar; ?>"/>  
                                    </div>
                                    <div class="message-data">
                                        <p>
                                           <span class="name"><?= $noti->users->name; ?></span>
                                           começou te seguir...
                                        </p>
                                        <p class="time"><?= $noti->createat; ?></p>
                                    </div>
                                    <div class="user-chat-avatar noti">
                                    <img src="<?= $base ?>/assets/images/friends-alt.png" />
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>


                    <?php endforeach; ?>
                       
                </div>
                <?php }else{ ?>
                <h4>Você ainda não possui nenhuma notificação...</h4>
                <?php } ?>


            </div>
            <div class="column side pl-5">
                <?= $render('right-side'); ?>
            </div>
        </div>

    </section>
</section>

<?= $render('footer', ['loggedUser' => $loggedUser]); ?>