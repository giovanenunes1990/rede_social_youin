<!DOCTYPE html>
<html>
<head> 
    <meta charset="utf-8" />
    <title>Cadastro</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="author" content="Giovane Nunes">
    <link rel="stylesheet" href="<?= $base; ?>/assets/css/login.css" />
    <link rel="shortcut icon" type="image-x/png" href="<?= $base; ?>/assets/images/icon-yin.ico">
</head>
<body>
    <?php if(!empty($flash)): ?>
    <div class="warning flash">
        <div class="box-warning flex-alt">
             <p><?= $flash; ?></p><div class="close">X</div>
        </div>
    </div>
    <?php endif; ?>
    <section class="container main form">
        <div class="alert-login">
            <p>Este é um projeto demonstrativo 
                do meu <a target="_blank" href=" https://giovanenunes.com">portfólio</a>, 
                com o intuito de tangibilizar minhas habilidades, desde já agradeço.
            </p>
        </div>
        <div class="logo"><img src="<?= $base; ?>/assets/images/youin-alt.png" alt="LOGO" /></div>
        <form method="POST" action="<?= $base; ?>/cadastro">

            <input placeholder="Digite seu nome completo" autocomplete="off" class="input" type="text" name="name" />
            <div class="underline-2"></div>
             
            <input placeholder="Digite seu e-mail"  autocomplete="off" class="input" type="email" name="email" />
            <div class="underline-1"></div>
            
            <input placeholder="Digite sua data de nascimento"  autocomplete="off" class="input" type="text" name="birthdate" id="birthdate" />
            <div class="underline-4"></div>
            
            <div class="pack-password">
            <input placeholder="Crie sua senha" class="input" id="password" type="password" name="password" max="10" />
            <div class="underline"></div>
            <div class="eye"><img src="<?= $base; ?>/assets/images/eye-close.png"  width="22px" hegiht="26" alt="EYE"></div>
            </div>

            <div class="verify">
               
                    <p>Sua senha deve conter:</p>
                    <ul>
                        <li id="upper">1 letra maiúscula</li>
                        <li id="lower">1 letra minúscula</li>
                        <li id="num">1 número</li>
                        <li id="spec">1 caractere especial [!,?,@,*,$,#,%,&]</li>
                        <li id="len">6 digitos</li>
                    </ul>    
            </div>
            
            <div class="pack-password" id="repeater-password">
            <input placeholder="Repita sua senha" class="input" id="password2" type="password"  name="passwordrepeter" />
            <div class="underline-3"></div>
            <div class="eye2"><img src="<?= $base; ?>/assets/images/eye-close.png" width="22px" hegiht="26" alt=""></div>
            </div>

             
            
            <input id="submit-signup" class="button mt--20" type="submit" value="Cadastrar" />

            <a href="<?= $base; ?>/login">Já tem uma conta? Entre aqui</a>
        </form>
    </section>

    <script src="https://unpkg.com/imask"></script>
    <script>
        let eye = false;

        document.querySelector('.eye img').addEventListener('click', function () {
            if (eye == false) {
                document.querySelector('.eye img').setAttribute('src', '<?= $base; ?>/assets/images/eye-open.png');
                document.querySelector('#password').setAttribute('type', 'text');
                eye = true;
            } else {
                document.querySelector('.eye img').setAttribute('src', '<?= $base; ?>/assets/images/eye-close.png');
                document.querySelector('#password').setAttribute('type', 'password');
                eye = false;
            }
        });
        document.querySelector('.eye2 img').addEventListener('click', function () {
            if (eye == false) {
                document.querySelector('.eye2 img').setAttribute('src', '<?= $base; ?>/assets/images/eye-open.png');
                document.querySelector('#password2').setAttribute('type', 'text');
                eye = true;
            } else {
                document.querySelector('.eye2 img').setAttribute('src', '<?= $base; ?>/assets/images/eye-close.png');
                document.querySelector('#password2').setAttribute('type', 'password');
                eye = false;
            }
        });
    </script>
    <script src="<?= $base; ?>/assets/js/login.js"></script>
</body>
</html>