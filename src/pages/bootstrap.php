<?php

use Dotenv\Dotenv;

require "../../vendor/autoload.php";

$dotenv = Dotenv::createUnsafeImmutable("../../");
$dotenv->safeLoad();