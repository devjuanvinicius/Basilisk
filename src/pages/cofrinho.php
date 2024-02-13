<?php
include "conn.php";
include "function.php";
session_start();
voltarLogin();
logout();

if (isset($_GET['id'])) {
  $idCofrinho = $_GET['id'];
  $userCofrinho = $conn->prepare('SELECT * FROM `cofrinho` WHERE `id_meta`=:pid');
  $userCofrinho->bindValue(':pid', $idCofrinho);
  $userCofrinho->execute();
  $rowCofrinho = $userCofrinho->fetch();

  $outrasMetas = $conn->prepare('SELECT * FROM `cofrinho` WHERE `id_meta`!=:pidOutras');
  $outrasMetas->bindValue(':pidOutras', $idCofrinho);
  $outrasMetas->execute();
} else {
  $userCofrinho = $conn->prepare('SELECT * FROM `cofrinho` WHERE `id_user`=:pid');
  $userCofrinho->bindValue(':pid', $_SESSION['login']);
  $userCofrinho->execute();
  $rowCofrinho = $userCofrinho->fetch();
}


$userCad = $conn->prepare('SELECT * FROM `cadastro` WHERE `id_cad`=:pidCad');
$userCad->bindValue(':pidCad', $_SESSION['login']);
$userCad->execute();
$rowNome = $userCad->fetch();

if ($userCofrinho->rowCount() > 1) {
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
      <h1><?php echo $rowCofrinho['nome_meta'] ?></h1>
      <a href="./perfil.php" class="perfil perfil-cofre">
        <?php echo "<img src=\"../assets/ilustracoes/fotos-perfil/" . $rowNome['url_cad'] . "\" alt=\"\">" ?>
        <p>
          <?php
          echo $rowNome['nome_cad'];
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
            echo number_format($rowCofrinho['valor_meta'], 2, ',', '.');
            ?>
          </p>
        </div>
        <div class="segundo-card">
          <h2>Durante:</h2>
          <p><span><?php echo str_pad($rowCofrinho['tempo_meta'], 2, '0', STR_PAD_LEFT) ?></span> meses</p>
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
              if (isset($_GET['id'])) {
                while ($rowOutras = $outrasMetas->fetch()) {
                  echo "
                    <div class=\"outros\">
                      <p>" . $rowOutras['nome_meta'] . "</p>
                      <a href=\"./cofrinho.php?id=" . $rowOutras['id_meta'] . "\">
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
            <p><span>R$</span><?php echo number_format(($rowCofrinho['valor_meta'] / $rowCofrinho['tempo_meta']), 2, ',', '.') ?><span>/mês</span></p>
          </div>
          <div class="card-dois">
            <h2>Progresso meses:</h2>
            <p>01<span>/</span><?php echo str_pad($rowCofrinho['tempo_meta'], 2, '0', STR_PAD_LEFT) ?></p>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>