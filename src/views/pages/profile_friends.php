<?= $render('header', ['loggedUser' => $loggedUser]); ?>
<section class="container main">
<?= $render('sidebar', ['activeMenu'=>'friends']); ?>

<section class="feed">

<?= $render('perfil-header', [
    'user'=> $user, 
    'loggedUser'=> $loggedUser,
    'isFollowing'=> $isFollowing,
     ]);
?>
    
<div class="row"> 
    <div class="column">
        <?php if($user->followers || $user->following ): ?>
        <div class="box">
            <div class="box-body">

                <div class="tabs">
                    <div class="tab-item" data-for="followers">
                        Seguidores
                    </div>
                    <div class="tab-item active" data-for="following">
                        Seguindo
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-body" data-item="followers">
                        
                        <div class="full-friend-list">

                        <?php foreach($user->followers as $follower): ?>
                            <div class="friend-icon">
                                <a href="<?= $base; ?>/perfil/<?= $follower->id; ?>">
                                    <div class="friend-icon-avatar">
                                        <img src="<?= $base; ?>/media/avatars/<?= $follower->avatar; ?>" />
                                    </div>
                                    <div class="friend-icon-name">
                                    <?= $follower->name; ?>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                        </div>
            
                    </div>
                    <div class="tab-body" data-item="following">
                        
                        <div class="full-friend-list">
                         
                        <?php foreach($user->following as $follower): ?>
                            <div class="friend-icon">
                                <a href="<?= $base; ?>/perfil/<?= $follower->id; ?>">
                                    <div class="friend-icon-avatar">
                                        <img src="<?= $base; ?>/media/avatars/<?= $follower->avatar; ?>" />
                                    </div>
                                    <div class="friend-icon-name">
                                    <?= $follower->name; ?>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>
        <?php endif; ?>
        <?php if($user->id == $loggedUser->id && count($suggestions) > 0 ): ?>
        <div class="box suggestions">
           <h4>Pessoas que talvez você conheça:</h4>
           
         
           <div class="full-friend-list">

                <?php foreach( $suggestions as $user): ?>
                    <div class="friend-icon">
                        <a href="<?= $base; ?>/perfil/<?= $user->id; ?>">
                            <div class="friend-icon-avatar">
                                <img src="<?= $base; ?>/media/avatars/<?= $user->avatar; ?>" />
                            </div>
                            <div class="friend-icon-name">
                            <?= $user->name; ?>
                            </div>
                        </a>
                        <div class="profile-info-item m-width-20 follow-msg mt-10">
                                <a href="<?= $base ?>/perfil/<?= $user->id ?>/follow" class="button-follow  <?= (!$isFollowing) ? 'follow' : 'leave' ?>">
                                <?= (!$isFollowing) ? 'Seguir' : 'Seguindo' ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

</section>
</section> 
<?= $render('footer', ['loggedUser' => $loggedUser]); ?>