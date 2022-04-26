<?= $render('header', ['loggedUser' => $loggedUser]); ?>
<section class="container main">
    <?= $render('sidebar', ['activeMenu'=>'photos']); ?>

    <section class="feed">

    <?= $render('perfil-header', [
        'user'=> $user, 
        'loggedUser'=> $loggedUser,
        'isFollowing'=> $isFollowing,
        ]);
    ?>
        
        <div class="row">
            <div class="column">        
                <div class="box">
                    <div class="box-body">
                        <div class="full-user-photos">
                            
                            <?php if(count($user->photos) === 0): ?>
                                <?= ($user->name == $loggedUser->name) ? 'Você ainda não possui fotos.' : 'Esse usuário não possui fotos.' ?>
                            <?php endif; ?>

                            <?php foreach($user->photos as $photo): ?>
                                <div class="user-photo-item" id="photos-profile" onclick="callModalPhoto('<?= $base; ?>/media/uploads/<?= $photo->body; ?>')">
                                    <div class="photo" id="modal-<?= $photo->id; ?>">
                                        <img src="<?= $base; ?>/media/uploads/<?= $photo->body; ?>" />
                                    </div>
                                </div>
                            <?php endforeach; ?>
    
                        </div> 
                    </div>
                </div>
            </div>
        </div>
 
    </section>
</section>
<?= $render('footer', ['loggedUser' => $loggedUser]); ?>