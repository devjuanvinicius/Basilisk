<?php
include "conn.php";
include "function.php";
session_start();
voltarLogin();

$user_name = $conn->prepare('SELECT * FROM `cadastro` WHERE `id_cad`=:pid');
$user_name->bindValue(':pid', $_SESSION['login']);
$user_name->execute();
$row_user = $user_name->fetch();

if(isset($_GET['excluir'])){
  $excluirConta = $conn->prepare('DELETE FROM `cadastro` WHERE `cadastro`.`id_cad` = :pidExclusao');
  $excluirConta -> bindValue(':pidExclusao', $_SESSION['login']);
  $excluirConta->execute();
  header('location:../../index.php');
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>Perfil - Basilisk</title>
  <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">
</head>
<body>
  <header class="header-load">
    <a href="./dashboard.php"><img src="../assets/logo.svg" alt=""></a>
  </header>
  <main class="main-perfil">
    <?php echo "<img src=\"../assets/ilustracoes/fotos-perfil/".$row_user['url_cad']."\" alt=\"\">"?>
    <form action="perfil.php" method="post" enctype="multipart/form-data">
      <?php
        if(isset($_POST['alterar'])){
          ?>
            <div class="input-perfil">
              <label for="nome-alterado">Nome:</label>
              <?php echo "<input type=\"text\" id=\"nome-alterado\" name=\"nome-alterado\" value=\"".$row_user['nome_cad']."\">"?>
            </div>
            <div class="input-perfil">
              <label for="email-alterado">E-mail:</label>
              <?php echo "<input type=\"email\" id=\"email-alterado\" name=\"email-alterado\" value=\"".$row_user['email_cad']."\">"?>
            </div>
            <div class="input-perfil">
              <label for="data-alterado">Data de nascimento:</label>
              <?php echo "<input type=\"date\" id=\"data-alterado\" name=\"data-alterado\" value=\"".$row_user['data_cad']."\">"?>
            </div>
            <div class="escolher-foto">
              <h2>Escolha sua foto de perfil</h2>
              <div class="perfil-foto">
               <div class="foto-escolha">
                <input type="radio" name="perfil" id="perfil" value="perfil-1"> 
                <label for="perfil1">
                    <img src="../assets/ilustracoes/fotos-perfil/perfil-1.svg" alt="">
                </label>
               </div>
               <div class="foto-escolha">
                <input type="radio" name="perfil" id="perfil" value="perfil-2">
                <label for="perfil2">
                    <img src="../assets/ilustracoes/fotos-perfil/perfil-2.svg" alt="">
                </label>
               </div>
               <div class="foto-escolha">
                <input type="radio" name="perfil" id="perfil" value="perfil-3">
                <label for="perfil3">
                    <img src="../assets/ilustracoes/fotos-perfil/perfil-3.svg" alt="">
                </label>
               </div>
               <div class="foto-escolha">
                <input type="radio" name="perfil" id="perfil" value="perfil-4">
                <label for="perfil4">
                    <img src="../assets/ilustracoes/fotos-perfil/perfil-4.svg" alt="">
                </label>
               </div>
               <div class="foto-escolha">
                <input type="radio" name="perfil" id="perfil5" value="perfil-5">
                <label for="perfil5">
                    <img src="../assets/ilustracoes/fotos-perfil/perfil-5.svg" alt="">
                </label>
               </div>
               <div class="foto-escolha">
                <input type="radio" name="perfil" id="perfil6" value="perfil-6">
                <label for="perfil6">
                    <img src="../assets/ilustracoes/fotos-perfil/perfil-6.svg" alt="">
                </label>
               </div>
              </div>
            </div>
            <hr>
            <div class="btn-perfil">
              <input type="submit" class="btn-md" value="Salvar" id="salvar" name="salvar">
            </div>
          <?php
        } else{
          ?>
            <div class="input-perfil">
              <label for="nome-perfil">Nome:</label>
              <?php echo "<input type=\"text\" id=\"nome-perfil\" name=\"nome-perfil\" value=\"".$row_user['nome_cad']."\" disabled>"?>
            </div>
            <div class="input-perfil">
              <label for="email">E-mail:</label>
              <?php echo "<input type=\"email\" id=\"email\" name=\"email\" value=\"".$row_user['email_cad']."\" disabled>"?>
              <div class="input-perfil">
              </div>
              <label for="data-nasc">Data de nascimento:</label>
              <?php echo "<input type=\"date\" id=\"data-nasc\" name=\"data-nasc\" value=\"".$row_user['data_cad']."\" disabled>"?>
            </div>
            <div class="btn-perfil">
              <input type="submit" class="btn-md" value="Alterar" id="alterar" name="alterar">
              <a href="./perfil.php?excluir">
                <button class="btn-md btn-exclusao" >Excluir conta</button>
              </a>
            </div>
          <?php
        }
      ?>
    </form>
  </main>
</body>
</html>

<?php
if(isset($_POST['salvar'])){
  $novoNome = $_POST['nome-alterado'];
  $novoEmail = $_POST['email-alterado'];
  $novaData = $_POST['data-alterado'];
  $urlCad = $_POST['perfil'].".svg";
  // echo $urlCad;

  $alteracao = $conn->prepare('UPDATE `cadastro` SET `nome_cad` = :pnovoNome, `data_cad` = :pnovaData, `email_cad` = :pnovoEmail, `url_cad` = :purlCad WHERE `cadastro`.`id_cad` = :pidCad');
  $alteracao->bindValue(':pnovoNome', $novoNome);
  $alteracao->bindValue(':pnovaData', $novaData);
  $alteracao->bindValue(':pnovoEmail', $novoEmail);
  $alteracao->bindValue(':pidCad', $_SESSION['login']);
  $alteracao->bindValue(':purlCad', $urlCad);
  $alteracao->execute();

  header('location:perfil.php');
  exit();
}
?>  