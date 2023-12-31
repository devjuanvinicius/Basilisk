<?php

function voltarLogin(){
  if(!isset($_SESSION['login'])){
    header('location:login.php');
  }
}

function logout(){
  if(isset($_GET['logout'])){
    session_destroy();
    header('location:login.php');
  }
}

?>