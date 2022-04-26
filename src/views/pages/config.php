<?= $render('header', ['loggedUser' => $loggedUser, 'success'=> $success, 'flash' => $flash]); ?>
<section class="container main">
    <?= $render('sidebar', ['activeMenu'=>'config']); ?>

    <section class="feed mt-10">
        <div class="config-main">
        <form method="POST" action="<?= $base; ?>/config" enctype="multipart/form-data"> 
     
            <div class="row">
                <div class="column pr-5">

                    <div class="form_item">
                        <div class="form_item_input avatar">
                            <img id="avatar" src="<?= $base ?>/media/avatars/<?= $user->avatar; ?>" />
                            <div class="btn-upload" onclick="uploadAvatar()">
                                Enviar foto de perfil
                            </div>
                            <input type="file" name="avatar">
                            <div class="remove-photo-config" id="removephoto" onclick="openDialog('Tem certeza que deseja remover sua foto de perfil?', '<?= $base; ?>/config/remove-photo/<?= $user->id; ?>')">
                                <div>
                                   <img src="<?= $base; ?>/assets/images/trash.png" alt="">
                               </div>
                               <span>
                                   Remover foto de perfil
                                </span>
                            </div>
                        </div>
 
                        <div class="form_item_input banner">
                            <img  id="cover" src="<?= $base ?>/media/covers/<?= $user->cover; ?>" />
                            <div class="btn-upload"  onclick="uploadCover()">
                                Enviar imagem de fundo
                            </div>
                            <input type="file" name="cover">
                            <div id="removecover" class="remove-photo-config" onclick="openDialog('Tem certeza que deseja remover a imagem de fundo?', '<?= $base; ?>/config/remove-cover/<?= $user->id; ?>')">
                                <div>
                                   <img src="<?= $base; ?>/assets/images/trash.png" alt="Delete">
                               </div>
                               <span>
                                   Remover imagem de fundo
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form_item">
                        <div class="form_item_input">
                          <label for="name">Nome:</label>
                          <input type="text" name="name" placeholder="Nome..." value="<?= $user->name; ?>">
                        </div>

                        <div class="form_item_input">
                          <label for="name">E-mail:</label>
                          <input type="email" name="email" placeholder="E-mail..." value="<?= $user->email; ?>"> 
                        </div>
                    </div>

                    <div class="form_item">
                        <div class="form_item_input">
                          <label for="city">Cidade:</label>
                          <input type="text" name="city" placeholder="Cidade..."  value="<?= $user->city; ?>">
                        </div>

                        <div class="form_item_input">
                          <label for="work">Cargo:</label>
                          <input type="text" name="work" placeholder="Seu cargo..."  value="<?= $user->work; ?>"> 
                        </div>

                        <div class="form_item_input date">
                          <label for="birthdate">Data de nascimento:</label>
                          <input type="text" id="birthdate" name="birthdate" placeholder="Data de nascimento..."  value="<?= date('d/m/Y', strtotime($user->birthdate)); ?>"> 
                        </div>
                    </div>
                    
                    <div class="form_item">
                        
                        <div class="form_item_input">
                            <label for="password">Mudar senha:</label>
                            <input type="password" name="password" placeholder="Nova senha..."> 
                        </div>
                        <div class="form_item_input">
                            <label for="password_confirm">Repita sua nova senha:</label>
                            <input type="password" name="passwordconfirm" placeholder="Nova senha..."> 
                        </div>
                    </div>

                </div>
            </div> 
            <div class="config_submit">
                <input type="submit" class="button" value="Atualizar">
            </div>
            <div class="delete-user">
                <div class="remove-photo-config" onclick="openDialog('Tem certeza que deseja excluir permanentemente sua conta?', '<?= $base; ?>/config/delete-user/<?= $user->id; ?>')">
                    <div>
                    <img src="<?= $base; ?>/assets/images/trash.png" alt="">
                    </div>
                    <span>
                        Exluir minha Conta
                    </span>
                </div>
            </div>
        </form>
        </div>
    </section> 

    <script src="https://unpkg.com/imask"></script>
    <script>
        IMask(
            document.getElementById('birthdate'),
            {
                mask: '00/00/0000'
            }
        )
    </script>
    <?= $render('footer', ['loggedUser' => $loggedUser]); ?>