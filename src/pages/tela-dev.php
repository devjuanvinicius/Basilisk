<?php
include "conn.php";
include "function.php";
session_start();
// voltarLogin();
logout();

$verificarAdmin = $conn->prepare('SELECT * FROM `cadastro` WHERE `id_cad` = :pid AND `type_user` = 1');
$verificarAdmin->bindValue(':pid', $_SESSION['login']);
$verificarAdmin->execute();
$userAdmin = $verificarAdmin->fetch();

$verificarCofrinho = $conn->prepare('SELECT * FROM `cofrinho`');
$verificarAdmin->execute();

$verificarInvestimento = $conn->prepare('SELECT * FROM `infos_investimento`');
$verificarInvestimento->execute();

$verificarUsuarios = $conn->prepare('SELECT * FROM `cadastro`');
$verificarUsuarios->execute();

if ($userAdmin['type_user'] != 1) {
  header('location:dashboard.php');
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>Dev - Basilisk</title>
  <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawStuff);

    function drawStuff() {
      var data = new google.visualization.arrayToDataTable([
        ['', ''],
        ["Cofrinho", <?php echo $verificarAdmin->rowCount() ?>],
        ["Investimento", <?php echo $verificarInvestimento->rowCount() ?>],
        ["Utilizam os dois", <?php echo $verificarAdmin->rowCount() + $verificarAdmin->rowCount() ?>],
        ["Não utilizam nenhum", <?php echo $verificarUsuarios->rowCount() - ($verificarAdmin->rowCount() + $verificarAdmin->rowCount()) ?>]
      ]);

      var options = {
        width: 900,
        animation: {
          duration: 2,
          easing: 'inAndOut',
        },
        backgroundColor: 'transparent',
        chartArea: {
          backgroundColor: 'transparent',
        },
        legend: {
          position: 'none'
        },
        chart: {
          title: 'Detalhes usuarios',
          subtitle: 'Funções que os usuarios utilizam'
        },
        bar: {
          groupWidth: "90%"
        },
        colors: ['#FFCB74'],
        titleTextStyle: {
          color: '#F6F6F6',
          fontSize: '24',
          fontName: 'Roboto Slab',
        },
      };

      var chart = new google.charts.Bar(document.getElementById('top_x_div'));
      // Convert the Classic options to Material options.
      chart.draw(data, google.charts.Bar.convertOptions(options));
    };
  </script>

</head>

<body>
  <header class="header-postagem">
    <img src="../assets/logo-dev.svg" alt="logo basilisk">
    <div class="usuario-log">
      <p>
        <?php
        echo $userAdmin['nome_cad'];
        ?>
      </p>
      <?php echo "<img src=\"../assets/ilustracoes/fotos-perfil/" . $userAdmin['url_cad'] . "\" alt=\"\">" ?>
    </div>
  </header>
  <main class="main-dev">
    <div class="column-infos-dev">
      <div class="primeira-linha-dev">
        <div class="card-dev">
          <h1>Usuarios cadastrados:</h1>
          <p><span><?php echo $verificarUsuarios->rowCount() ?></span> usuários</p>
        </div>
        <div class="card-dev">
          <h1>Administradores cadastrados:</h1>
          <p><span><?php echo str_pad($verificarAdmin->rowCount(), 2, '0', STR_PAD_LEFT) ?></span> administradores</p>
        </div>
      </div>
      <div class="segunda-linha-dev">
        <div id="top_x_div" class="grafico-dev"></div>
      </div>
    </div>
    <div class="column-btn-dev">
      <h1>Ações:</h1>
      <div class="btns-dev">
        <a href="./editor.php">
          <button class="btn-md">
            Escrever um post
          </button>
        </a>
        <a href="">
          <button class="btn-md">
            Cadastrar novo usuário
          </button>
        </a>
        <a href="https://titan.hostgator.com.br/mail/" target="_blank">
          <button class="btn-md">
            Verificar caixa de e-mail suporte
          </button>
        </a>
        <a href="./dashboard.php">
          <button class="btn-md">
            Entrar no dahsboard
          </button>
        </a>
        <a href="">
          <button class="btn-md">
            Área de investimento
          </button>
        </a>
        <a href="">
          <button class="btn-md">
            Área do cofrinho
          </button>
        </a>
      </div>
    </div>
  </main>
</body>

</html>