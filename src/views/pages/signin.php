<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" /> 
    <title>Login</title>
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

    <div class="flex">
        <section class="container main form">
        <div class="alert-login">
            <p>Este é um projeto demonstrativo 
                do meu <a target="_blank" href=" https://giovanenunes.com">portfólio</a>, 
                com o intuito de tangibilizar minhas habilidades, desde já agradeço.
            </p>
        </div>

        <div class="logo"><img src="<?= $base; ?>/assets/images/youin-alt.png" alt="LOGO" /></div>

        <form method="POST" action="<?= $base; ?>/login">

            <input placeholder="Digite seu e-mail" autocomplete="off" class="input" type="email" name="email" />
            <div class="underline-1"></div>
            
            <input placeholder="Digite sua senha" class="input" id="password" type="password" name="password" />
            <div class="underline"></div>
            <div class="eye"><img src="<?= $base; ?>/assets/images/eye-close.png" alt=""></div>
           
            <span id="free"><a href="<?= $base; ?>/entrar-sem-login">Entrar como convidado(a)</a></span>

            <input class="button" type="submit" value="Entrar" />

            <a href="<?= $base; ?>/cadastro">Ainda não tem conta? Cadastre-se</a>
        </form>
    </section>
    
    </div>
    
<script type="text/javascript">
    let eye = false;
    document.querySelector('.eye img').addEventListener('click', function() { 
        if(eye == false){
          document.querySelector('.eye img').setAttribute('src', '<?= $base; ?>/assets/images/eye-open.png');
          document.querySelector('#password').setAttribute('type', 'text');
          eye = true;
        }else{
          document.querySelector('.eye img').setAttribute('src', '<?= $base; ?>/assets/images/eye-close.png');
          document.querySelector('#password').setAttribute('type', 'password');
          eye = false;
        }   
    });

    if (document.querySelector(".flash")) {
        setTimeout(() => {
            document.querySelector(".flash").style.display = 'none';
        }, 2500);
    }
   
</script>
</body>
</html>