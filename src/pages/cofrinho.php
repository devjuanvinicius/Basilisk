<?php
include "conn.php";
include "function.php";
session_start();
voltarLogin();
logout();

if(isset($_GET['id'])){
  $id_cofrinho = $_GET['id'];
  $user_cofrinho=$conn->prepare('SELECT * FROM `cofrinho` WHERE `id_meta`=:pid');
  $user_cofrinho->bindValue(':pid', $id_cofrinho);
  $user_cofrinho->execute();
  $row_cofrinho=$user_cofrinho->fetch();

  $outras_metas=$conn->prepare('SELECT * FROM `cofrinho` WHERE `id_meta`!=:pidOutras');
  $outras_metas->bindValue(':pidOutras', $id_cofrinho);
  $outras_metas->execute();
} else{
  $user_cofrinho=$conn->prepare('SELECT * FROM `cofrinho` WHERE `id_user`=:pid');
  $user_cofrinho->bindValue(':pid', $_SESSION['login']);
  $user_cofrinho->execute();
  $row_cofrinho=$user_cofrinho->fetch();
}


$user_cad=$conn->prepare('SELECT * FROM `cadastro` WHERE `id_cad`=:pidCad');
$user_cad->bindValue(':pidCad', $_SESSION['login']);
$user_cad->execute();
$row_nome=$user_cad->fetch();

if($user_cofrinho->rowCount()>1){
  header('location:escolha-cofrinho.php');
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cofrinho - Basilisk</title>
  <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../css/style.css">
  <script src="../../vendor/bootstrap/js/bootstrap.js"></script>
</head>
<body class="body-dashboard">
  <nav class="sidebar">
    <div class="content-sidebar">
      <img src="../assets/logo-reduzido.svg" alt="">
      <div class="links-dashboard">
        <a class="home" href="./dashboard.php">
          <img src="../assets/Icones/icones-brancos/home.png" alt="" class="icon">
          <p>Home</p>
        </a>
        <a class="investimento" href="./explicacao.php?pagina=1">
          <img src="../assets/Icones/icones-brancos/profits.png" alt="" class="icon">
          <p>Investimento</p>
        </a>
        <a class="cofrinho atual" href="./explicacao.php?pagina=2">
          <img src="../assets/Icones/icones-dourados/Ellipse 4.svg" alt="">
          <img src="../assets/Icones/icones-dourados/piggy-bank.png" alt="" class="icon">
          <p>Cofrinho</p>
        </a>
        <a class="controle" href="./blog.php">
          <img src="../assets/Icones/icones-brancos/communication.png" alt="" class="icon">
          <p>Blog</p>
        </a>
      </div>
      <hr class="linha-divisoria">
      <div class="footer-sidebar">
        <a href="dashboard.php?logout" class="logout">
          <img src="../assets/Icones/icones-brancos/logout.png" alt="" class="icon">
          <p>Sair</p>
        </a>
        <a href="./perfil.php" class="config">
          <img src="../assets/Icones/icones-brancos/setting.png" alt="" class="icon">
          <p>Configurações</p>
        </a>
      </div>
    </div>
  </nav>
  <main class="main-content">
    <div class="linha-perfil">
      <h1><?php echo $row_cofrinho['nome_meta']?></h1>
      <a href="./perfil.php" class="perfil perfil-cofre">
          <?php echo "<img src=\"../assets/ilustracoes/fotos-perfil/".$row_nome['url_cad']."\" alt=\"\">"?>
          <p>
            <?php
              echo $row_nome['nome_cad'];
            ?>
          </p>
      </a>
    </div>
    
    <div class="cards-cofrinho">
      <div class="primeira-linha-cofre">
        <div class="primeiro-card">
          <h2>Valor que deseja guardar:</h2>
          <p><span>R$</span>
          <?php
            echo number_format($row_cofrinho['valor_meta'], 2, ',','.');
          ?>
          </p>
        </div>
        <div class="segundo-card">
          <h2>Durante:</h2>
          <p><span><?php echo str_pad($row_cofrinho['tempo_meta'], 2,'0', STR_PAD_LEFT)?></span> meses</p>
        </div>
      </div>

      <div class="segunda-linha-cofrinho">
        <div class="card-column-progress">
          <div class="card-progress">
            <h2>Seu progresso:</h2>
            <div class="progress barra-progresso" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar" style="width: 25%">25%</div>
            </div>
          </div>

          <div class="card-outros">
            <h2>Outras metas</h1>
            <?php
              if(isset($_GET['id'])){
                while($row_outras=$outras_metas->fetch()){
                  echo "
                    <div class=\"outros\">
                      <p>".$row_outras['nome_meta']."</p>
                      <a href=\"./cofrinho.php?id=".$row_outras['id_meta']."\">
                        <button class=\"btn-sm\">Acessar</button>
                      </a>
                    </div>
                  ";
                }
              }
            ?>
          </div>
        </div>
        
        <div class="card-column-infos">
          <div class="card-um">
            <h2>Valor por mês:</h2>
            <p><span>R$</span><?php echo number_format(($row_cofrinho['valor_meta']/$row_cofrinho['tempo_meta']), 2, ',','.') ?><span>/mês</span></p>
          </div>
          <div class="card-dois">
            <h2>Progresso meses:</h2>
            <p>01<span>/</span><?php echo str_pad($row_cofrinho['tempo_meta'], 2,'0', STR_PAD_LEFT)?></p>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>