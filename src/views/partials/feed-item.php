<div class="box feed-item" data-id="<?= $data->id; ?>">
    <div class="box-body">
        <div class="feed-item-head row mt-20 m-width-20">
            <div class="feed-item-head-photo">
                <a href="<?= $base; ?>/perfil/<?= $data->user->id; ?>">
                    <img src="<?= $base; ?>/media/avatars/<?= $data->user->avatar; ?>" />
                </a>
            </div>
            <div class="feed-item-head-info">
                <a href="<?= $base; ?>/perfil/<?= $data->user->id; ?>">
                    <span class="fidi-name"><?= $data->user->name; ?></span>
                </a>
                <span class="fidi-action">
                <?php 
                switch($data->type){
                    case 'text':
                        echo 'Fez um post';
                        break;
                    case 'photo':
                        echo 'Postou uma foto';
                        break;
                } 
                ?>
                <a href="<?= $base; ?>/post/<?= $data->id ?>" class="call-post">Visualizar</a>
                </span>
                <br/> 
                <span class="fidi-date">
                    <?= $data->create_at; ?>
                </span>
            </div>
            <?php if($data->mine): ?>
            <div class="feed-item-head-btn">
                <img src="<?= $base; ?>/assets/images/more.png" />
                <div class="feed-item-more-window">
                     <a onclick="openDialog('Tem certeza que deseja excluir?', '<?= $base; ?>/post/<?= $data->id; ?>/delete')">Excluir</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="feed-item-body mt-10 m-width-20">
            <?php 
                switch($data->type){
                    case 'text':
                        echo '<p class="body-feed">'.nl2br($data->body).'</p>';
                        break;
                    case 'photo':
                        echo '<img src="'.$base.'/media/uploads/'.$data->body.'" />';
                        break;
                } 
            ?>
         
        </div>
        <div class="feed-item-buttons row mt-20 m-width-20">
            <div class="like-btn <?= ($data->liked ? 'on': ''); ?>">
            <?= $data->likeCount; ?>
            </div>
            <div class="msg-btn"><?= count($data->comments); ?></div>
        </div>
        <div class="feed-item-comments">
            <div class="feed-item-comments-area" id="pack-comment">
                        
                <?php foreach($data->comments as $key => $item): ?>

                        <div class="fic-item row m-height-10 m-width-20">
                            <div class="fic-item-photo">
                                <a href="<?= $base; ?>/perfil/<?= $item['user']['id']; ?>">
                                    <img src="<?= $base; ?>/media/avatars/<?= $item['user']['avatar']; ?>" />
                                </a>
                            </div>
                            <div class="fic-item-info">
                                <a href="<?= $base; ?>/perfil/<?= $item['user']['id']; ?>"><?= $item['user']['name']; ?></a>
                                <?= $item['body']; ?>
                            </div>
                        </div>
                       
                        <?php if($key >= 3 ): ?>
                            <div class="fic-item-more"><a href="<?= $base; ?>/post/<?= $data->id; ?>">Ver mais</a></div>
                        <?php break; endif; ?>
                    <?php endforeach; ?>
                    
              
            </div>

            <div class="fic-answer row m-height-10 m-width-20">
                <div class="fic-item-photo">
                    <a href="<?= $base; ?>/perfil/<?= $data->user->id; ?>">
                        <img src="<?= $base; ?>/media/avatars/<?= $loggedUser->avatar; ?>" />
                    </a>
                </div>
                <input type="text" class="fic-item-field" placeholder="Escreva um comentário" />
            </div>

        </div>
    </div>
</div>
 