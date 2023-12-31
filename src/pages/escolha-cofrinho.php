<?php
include "conn.php";
include "function.php";
session_start();
voltarLogin();

$user = $conn->prepare('SELECT * FROM `cadastro` WHERE `id_cad`=:pid');
$user->bindValue(':pid', $_SESSION['login']);
$user->execute();
$row_nome = $user->fetch();

$ver_cofrinho = $conn->prepare('SELECT * FROM `cofrinho` WHERE `id_user`=:pid_user');
$ver_cofrinho->bindValue(':pid_user', $_SESSION['login']);
$ver_cofrinho->execute();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>Escolha - Basilisk</title>
  <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">
</head>
<body>
  <header class="header-load">
    <a href="./dashboard.php"><img src="../assets/logo.svg" alt=""></a>
  </header>
  <main class="main-escolha">
    <h1>Deseja ver qual meta?</h1>
    <div class="bloco-escolha">
      <?php
        while($row_cofrinho = $ver_cofrinho->fetch()){
          
          $valorMes = $row_cofrinho['valor_meta'] / $row_cofrinho['tempo_meta'];
          echo "
              <a href=\"./cofrinho.php?id=".$row_cofrinho['id_meta']."\" class=\"escolha\">
                <div class=\"title-escolha\">
                  <h2>".$row_cofrinho['nome_meta']."</h2>
                  <hr>  
                </div>
                <div class=\"txt-escolha\">
                  <div class=\"valores\">
                    <div class=\"valor\">
                      <h3>Valor total da meta:</h3>
                      <p><span>R$</span>".number_format($row_cofrinho['valor_meta'], 2, ',', '.')."</p>
                    </div>
                    <div class=\"valor-mes\">
                      <h3>Valor por mês:</h3>
                      <p><span>R$</span>".number_format($valorMes, 2, ',','.')."<span>/mês</span></p>
                    </div>
                  </div>
                  <div class=\"tempo-escolha\">
                    <h3>Tempo:</h3>
                    <p><span>".$row_cofrinho['tempo_meta']."</span> meses</p>
                  </div>
                </div>
              </a>
          ";
        }
      ?>
      <a href="./explicacao.php?pagina=2" class="adicionar">
        <img src="../assets/Icones/icones-brancos/plus.png" alt="">
      </a>
    </div>
  </main>
</body>
</html>