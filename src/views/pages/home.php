<?= $render('header', [ 'loggedUser' => $loggedUser, ]); ?>
<?php if($loggedUser->fisrttime == 'true'): ?>
<div class="welcome-modal">
    <div class="box-welcome">
        <h2>Seja muito bem-vindo(a) !</h2>

        <div class="callToConfig">
            <img src="<?= $base; ?>/media/avatars/<?= $loggedUser->avatar; ?>" alt="">
            <div class="txt">
                <p>Deseja adicionar mais informações ao seu perfil agora?</p>
                <a href="<?= $base; ?>/config">Configurações</a>
            </div>
        </div>
        <div class="close-welcome">Mais tarde</div>

    </div>
</div>
<?php endif; ?>
<section class="container main">
    <?= $render('sidebar', ['activeMenu'=>'home']); ?>
    <section class="feed mt-10">
        
        <div class="row">
            <div class="column pr-5">
                                               
                <?= $render('feed-editor', ['user'=> $loggedUser]); ?>

                 <?php foreach($feed['posts'] as $feedItem): ?>
                    <?= $render('feed-item', [ 
                        'data'=> $feedItem,
                        'loggedUser' => $loggedUser,
                        ]); ?>
                    <?php endforeach; ?>

                    <?php if(count($feed['posts']) == 0): ?>
                       <p class="alone">Siga alguém para ver seus posts aqui...</p>  
                    <?php endif; ?>
                    
                    <?php if($feed['total'] > $feed['perPage']): ?>
                    <div class="feed-pagination">
                    <?php for($q=0; $q<$feed['pageCount']; $q++): ?>
                        <a class="<?= ($q == $feed['currentPage'] ? 'active' : '') ?>" 
                        href="<?= $base ?>/?page=<?= $q; ?>">
                          <?= $q+1; ?>
                        </a>
                        <?php if($q == 28){ ?>
                            ...
                        <?php break; };  ?>
                    <?php endfor; ?>
                    </div>
                    <?php  endif; ?>

            </div>
            <div class="column side pl-5">
                <?= $render('right-side'); ?>
            </div>
        </div>

    </section>
</section>

<?= $render('footer', ['loggedUser' => $loggedUser]); ?>