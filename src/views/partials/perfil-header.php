<div class="row"> 
        <div class="box flex-1 border-top-flat">
            <div class="box-body">
                <div class="profile-cover" style="background-image: url('<?= $base; ?>/media/covers/<?= $user->cover; ?>');"></div>
                <div class="profile-info m-20 row" >
                    <div class="pack-profile-avatar-name">
                        <div class="profile-info-avatar">
                            <a href="<?= $base ?>/perfil/<?= $user->id ?>">
                            <img src="<?= $base ?>/media/avatars/<?= $user->avatar; ?>" />
                            </a>
                        </div>
                        <div class="profile-info-name">
                            <div class="profile-info-name-text">
                                <a href="<?= $base ?>/perfil/<?= $user->id ?>"><?= $user->name; ?></a></div>
                            <div class="profile-info-location"><?= $user->city; ?></div>
                            <?php if($user->id != $loggedUser->id): ?>
                            <div>
                                <a href="<?= $base ?>/chat/<?= $user->id ?>" class="button-msg">
                                Enviar mensagem</a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="profile-info-data row links">
                    <?php if($user->id != $loggedUser->id): ?>
                    <div class="profile-info-item m-width-20 follow-msg">
                        <a href="<?= $base ?>/perfil/<?= $user->id ?>/follow" class="button-follow  <?= (!$isFollowing) ? 'follow' : 'leave' ?>">
                        <?= (!$isFollowing) ? 'Seguir' : 'Seguindo' ?></a>
                    </div>
                    <?php endif; ?>                     
                        
                    <div class="pack-profile-info-links">
                        <div class="profile-info-item m-width-20">
                            <a href="<?= $base ?>/perfil/<?= $user->id ?>/amigos">
                                <div class="profile-info-item-n"><?= count($user->followers); ?></div>
                                <div class="profile-info-item-s">Seguidores</div>
                                </a>
                            </div>
                            <div class="profile-info-item m-width-20">
                            <a href="<?= $base ?>/perfil/<?= $user->id ?>/amigos">
                                <div class="profile-info-item-n"><?= count($user->following); ?></div>
                                <div class="profile-info-item-s">Seguindo</div>
                            </a>
                            </div>
                            <div class="profile-info-item m-width-20">
                            <a href="<?= $base ?>/perfil/<?= $user->id ?>/fotos">
                                <div class="profile-info-item-n"><?= count($user->photos) ?></div>
                                <div class="profile-info-item-s">Fotos</div>
                            </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>