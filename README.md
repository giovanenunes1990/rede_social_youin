## Descrição

Uma rede social baseada no Facebook com elementos do instagram, seguindo a estrutura MVC em PHP, usando <a href="https://clancats.io/hydrahon/master/"> SQL QUERY BUILDER - Hydrahon</a>.

<div align="center">
  <div style="display: flex; align-items: flex-start; justify-content: center;">
    <img width="250px" src="https://github.com/giovanenunes1990/rede_social_youin/blob/main/screenshots/chat.png"/>
    <img width="250px" src="https://github.com/giovanenunes1990/rede_social_youin/blob/main/screenshots/home%20mobile.png" />
    <img width="250px" src="https://github.com/giovanenunes1990/rede_social_youin/blob/main/screenshots/notifica%C3%A7%C3%B5es.png" />
  </div>
</div>

## Requisitos 

-- <a href="https://www.apachefriends.org/pt_br/index.html">XAMPP</a>
-- <a href="https://getcomposer.org/">Composer</a>

## Instalação
Você pode clonar este repositório OU baixar o .zip

Ao descompactar, é necessário rodar o **composer** pra instalar as dependências e gerar o *autoload*.

Vá até a pasta do projeto, pelo *prompt/terminal* e execute:
> composer install

Depois é só aguardar.

Importar o arquivo > "cyberlife.sql" no phpmyadmin o gerenciador do mysql

## Configuração
Todos os arquivos de **configuração** e aplicação estão dentro da pasta *src*.

As configurações de Banco de Dados e URL estão no arquivo *src/Config.php*

É importante configurar corretamente a constante *BASE_DIR*:
> const BASE_DIR = '/**PastaDoProjeto**/public';

## Uso
Você deve acessar a pasta *public* do projeto.

O ideal é criar um ***alias*** específico no servidor que direcione diretamente para a pasta *public*.

## Modelo de MODEL
```php
<?php
namespace src\models;
use \core\Model;

class Usuario extends Model {

}
```
