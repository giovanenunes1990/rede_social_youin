<?= $render('header', ['loggedUser' => $loggedUser]); ?>
<?php require '../src/helpers.php'; ?>
<section class="container main chat-mobile-fix">
    <?= $render('sidebar', ['activeMenu'=>'message']); ?>
    <section class="feed mt-10">
        
        <div class="row conversations">
            <div class="column pr-5 text-center"> 
               
                
                <div class="header-chat" data-other-id="<?= $otherUser->id; ?>" online="<?= $otherUser->online; ?>">
                    <a href="<?= $base; ?>/conversas"><img src="<?= $base; ?>/assets/images/arrow-back.png" alt=""></a>
                    <a href="<?= $base; ?>/perfil/<?= $otherUser->id; ?>">
                        <div class="user-other-photo">
                            <img src="<?= $base; ?>/media/avatars/<?= $otherUser->avatar; ?>" />
                        </div> 
                        <div class="data-chat-header">
                            <h2><?= $otherUser->name; ?></h2>
                            <?php if($otherUser->online == 'true'){ ?>
                                <div class="span flex-alt online"><div class="circle"></div>Online</div>
                            <?php }else if($otherUser->modification != date('Y-m-d H:i:s')){ ?>
                                <div class="span"><i>Visto por último <?= timesGoChat( date('Y-m-d H:i:s', strtotime($otherUser->modification)) ); ?></i></div>
                            <?php }; ?>
                        </div>
                    </a>
                
                </div>
                <div class="chat">
                    
                   
                   <?php foreach($msgs as $msg): ?>
                    <div class="<?= ($msg['sender_id'] ==  $loggedUser->id) ? 'my' : 'other' ?>" data-id="<?= $msg['id']; ?>">
                    <div class="triangle"></div>
                        <div class="message">
                           <p><?= $msg['message']; ?></p>
                          <?php if($msg['image'] != ''): ?>
                            <img src="<?= $base; ?>/media/uploads/<?= $msg['image']; ?>" alt="" />
                          <?php endif; ?>
                          <div class="footer-msg">
                          <?php if($msg['sender_id'] ==  $loggedUser->id): ?>
                            <div class="flex-alt">
                                <?php if( $msg['unread'] == 'false'): ?>
                                <img class="first-check" src="<?= $base; ?>/assets/images/check-gray.png" />
                                <?php endif; ?>
                                <?php if($otherUser->online == 'true' && $otherUserNoti  && $msg['unread'] == 'false'): ?>
                                <img class="second-check" src="<?= $base; ?>/assets/images/check-gray.png" />
                                 <?php endif; ?>

                                <?php if($msg['sender_id'] ==  $loggedUser->id && $msg['unread'] == 'true'): ?>
                                    <img class="first-check" src="<?= $base; ?>/assets/images/check-blue.png" />
                                    <img class="second-check" src="<?= $base; ?>/assets/images/check-blue.png" />
                                <?php endif; ?>
                            </div>
                          <?php endif; ?>
                          <p class="time"><?= $msg['creation']; ?></p>
                          </div>
                        </div> 
                   </div>
                   <?php endforeach; ?>
                 
                </div>

                <div class="chat-buttons feed-new" other-id="<?= $otherUser->id; ?>">
                    <div class="feed-new-avatar">
                        <img src="<?= $base; ?>/media/avatars/<?= $loggedUser->avatar; ?>" />
                    </div>
                    <div class="feed-new-input-placeholder">Enviei uma mensagem...</div>
                    <p class="feed-new-input" contenteditable="true"></p>
                    <div class="feed-new-photo pr-10" onclick="sendImg()">
                        <img src="<?= $base; ?>/assets/images/photo.png" alt="">
                        <input type="file" name="photo" class="file-input-chat" accept="image/jpeg,image/jpg,image/png">
                    </div>
                    <div class="feed-new-send" id="send-message">
                        <img src="<?= $base; ?>/assets/images/send.png" />
                    </div>
                </div>
             
               

            </div>
            <div class="column side pl-5">
                <?= $render('right-side'); ?>
            </div>
        </div>

    </section>
</section>



<?= $render('footer', ['loggedUser' => $loggedUser]); ?>
<script>
    document.querySelector('.chat').scrollTo(0, document.querySelector(".chat").scrollHeight);
    window.scrollTo(0, document.querySelector("body").scrollHeight);
</script>
<script src="<?= $base; ?>/assets/js/chat.js"></script>