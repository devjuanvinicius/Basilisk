<?php
include "conn.php";
include "function.php";
session_start();
voltarLogin();
logout();


if(isset(($_GET['aceitar']))){
  $nome_da_meta = $_GET['nome'];
  $valor = $_GET['valor'];
  $tempo = $_GET['tempo'];

  $aceitar = $conn->prepare('INSERT INTO `cofrinho` (`id_meta`, `nome_meta`,`valor_meta`, `tempo_meta`, `id_user`) VALUES (NULL, :pnome_meta, :pvalor, :ptempo, :pidUser);');
  $aceitar->bindValue(':pnome_meta', $nome_da_meta);
  $aceitar->bindValue(':pvalor', $valor);
  $aceitar->bindValue(':ptempo', $tempo);
  $aceitar->bindValue(':pidUser', $_SESSION['login']);
  $aceitar->execute();

  $row_cofrinho=$aceitar->fetch();
  $id_row_cofrinho=$row_cofrinho['id_user'];
  $_SESSION['cad_info_cofrinho']=$id_row_cofrinho;
  header('location:cofrinho.php');
  exit();
}

$nome_meta = $_POST['nome_meta'];
$valor = $_POST['guardar'];
$tempo = $_POST['tempo'];

$primeiraProposta = $valor / $tempo;

if($tempo < 2){
  $segundaProposta = $valor / $tempoSegundaProposta = ($tempo - 2);
} else{
  $segundaProposta = $valor / $tempoSegundaProposta = ($tempo + 2);
}

$terceiraProposta = $valor / $tempoTerceiraProposta = ($tempo + 4);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proposta - Basilisk</title>
  <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <header class="header-load">
    <a href="./dashboard.php"><img src="../assets/logo.svg" alt=""></a>
  </header>
  <main class="main-proposta">
    <div class="proposta-row">
      <div class="card-proposta">
        <h1>Segunda sugestão</h1>
  
        <div class="content-card">
          <h2>Você irá guardar</h2>
          <p class="valor"><span>R$</span><?php echo number_format($segundaProposta, 2, ',', '.') ?><span>/mês</span></p>
          <p class="meses">Por <span><?php echo str_pad($tempoSegundaProposta, 2, '0', STR_PAD_LEFT)?></span> meses</p>
        </div>
  
       <?php
        echo "
            <a href=\"proposta-cofrinho.php?aceitar&nome=".$nome_meta."&valor=".$segundaProposta."&tempo=".$tempoSegundaProposta."\" class=\"\">
                <button class=\"btn-md\">Aceitar</button>
            </a>"
       ?>
      </div>
      <div class="card-proposta principal">
        <h1>Sugesão ideal</h1>
  
        <div class="content-card content-card-principal">
          <h2>Você irá guardar</h2>
          <p class="valor valor-principal"><span>R$</span><?php echo number_format($primeiraProposta, 2, ',', '.') ?><span>/mês</span></p>
          <p class="meses meses-principal">Por <span><?php echo str_pad($tempo, 2, '0', STR_PAD_LEFT)?></span> meses</p>
        </div>
  
        <?php
          echo "
            <a href=\"proposta-cofrinho.php?aceitar&nome=".$nome_meta."&valor=".$primeiraProposta."&tempo=".$tempo."\" class=\"\">
              <button class=\"btn-md\">Aceitar</button>
            </a>
          "
        ?>
      </div>
      <div class="card-proposta">
        <h1>Terceira sugestão</h1>
  
        <div class="content-card">
          <h2>Você irá guardar</h2>
          <p class="valor"><span>R$</span><?php echo number_format($terceiraProposta, 2, ',', '.') ?><span>/mês</span></p>
          <p class="meses">Por <span><?php echo str_pad($tempoTerceiraProposta, 2, '0', STR_PAD_LEFT)?></span> meses</p>
        </div>
  
        <?php
          echo "
            <a href=\"proposta-cofrinho.php?aceitar&nome=".$nome_meta."&valor=".$terceiraProposta."&tempo=".$tempoTerceiraProposta."\" class=\"\">
              <button class=\"btn-md\">Aceitar</button>
            </a>
          "
        ?>
      </div>
    </div>
  </main>
</body>
</html>