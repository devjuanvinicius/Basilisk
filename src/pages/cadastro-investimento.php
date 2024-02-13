<?php
include "conn.php";
include "function.php";
session_start();
voltarLogin();
logout();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - Basilisk</title>
  <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <header class="header-load">
    <img src="../assets/logo.svg" alt="">
  </header>
  <main class="main-cad-investimento">
    <form action="cadastro-investimento.php" method="POST">
      <div class="input-invest">
        <label for="">Informe o quanto você investe em renda fixa:</label>
        <input type="number" name="rendafixa" placeholder="Ex: Tesouro direto, CDB, Poupança,etc...">
      </div>

      <div class="input-invest">
        <label for="">Informe o quanto você investe em renda variavel:</label>
        <input type="number" name="rendavariavel" id="" placeholder="Ex: Ações, ETFS, Fundo de investimentos">
      </div>

      <div class="input-invest">
        <label for="">Informe o quanto você investe em fundo imobiliaro:</label>
        <input type="number" name="fundoimobiliaro" placeholder="Ex: Aluguel de terrenos, Compra de imoveis, espaço de eventos">
      </div>

      <div class="input-invest">
        <label for="">Informe o quando você investe em reserva de emergência:</label>
        <input type="number" name="reservadeemergencia" placeholder="Ex: Poupança, Tesouro direto, etc...">
      </div>

      <div class="btn-cad-info btn-cad-invest">
        <input type="submit" name="grava" value="Enviar">
      </div>
    </form>
  </main>
</body>

</html>

<?php

include "conn.php";
if (isset($_POST['grava'])) {
  $verificarExiste = $conn->prepare('SELECT * FROM `infos_investimento` WHERE `id_user` = :pid AND `status` = 1');
  $verificarExiste->bindValue(':pid', $_SESSION['login']);
  $verificarExiste->execute();

  if ($verificarExiste->rowCount() >= 1) {
    $updateStatus = $conn->prepare('UPDATE `infos_investimento` SET `status` = 0 WHERE `id_user` = :pid');
    $updateStatus->bindValue(':pid', $_SESSION['login']);
    $updateStatus->execute();
  }

  $rendafixa = $_POST['rendafixa'];
  $rendavariavel = $_POST['rendavariavel'];
  $fundoimobiliaro = $_POST['fundoimobiliaro'];
  $reservadeemergencia = $_POST['reservadeemergencia'];

  $grava = $conn->prepare('INSERT INTO `infos_investimento` (`id_inv`, `CDB_inv`, `poupanca_inv`, `rendavariavel_inv`, `imoveis_inv`, `id_user`, `status`) VALUES (NULL, :prendafixa, :prendavariavel, :pfundoimobiliaro, :preservadeemergencia, :pidUser, 1);');

  $grava->bindValue(':prendafixa', $rendafixa);
  $grava->bindValue(':prendavariavel', $rendavariavel);
  $grava->bindValue(':pfundoimobiliaro', $fundoimobiliaro);
  $grava->bindValue(':preservadeemergencia', $reservadeemergencia);
  $grava->bindValue(':pidUser', $_SESSION['login']);
  $grava->execute();

  header('location:investimento.php');
  exit();
}

?>