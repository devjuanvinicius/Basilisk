<?php

require_once "bootstrap.php";

$conn=new PDO(
    'mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME'),
    getenv('DB_LOGIN'),
    getenv('DB_PASS'));
?>