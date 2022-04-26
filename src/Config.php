<?php
namespace src;
date_default_timezone_set('America/Sao_Paulo');

class Config {
    const BASE_DIR = '/devsbook/public';
   

    const DB_DRIVER = 'mysql';
    const DB_HOST = 'localhost';
    const DB_DATABASE = 'cyberlife';
    CONST DB_USER = 'root';
    const DB_PASS = '';

    const ERROR_CONTROLLER = 'ErrorController';
    const DEFAULT_ACTION = 'index';
}