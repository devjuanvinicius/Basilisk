<?php
include "conn.php";
include "function.php";
require_once "bootstrap.php";
session_start();
voltarLogin();
logout();

$userName = $conn->prepare('SELECT * FROM `cadastro` WHERE `id_cad`=:pid');
$userName->bindValue(':pid', $_SESSION['login']);
$userName->execute();
$rowName = $userName->fetch();

$rendaDashboard = $conn->prepare('SELECT * FROM `infos_bancarias` WHERE `id_user`=:pid_dados AND `status` = 1');
$rendaDashboard->bindValue(':pid_dados', $_SESSION['login']);
$rendaDashboard->execute();
$rowDados = $rendaDashboard->fetch();

if (empty($rowDados)) {
  header('location:cadastro-infos-banco.php');
  exit();
}

// Calcular gastos
$gastosDashboard = $rowDados['gastos_moradia'] + $rowDados['gastos_alimentacao'] + $rowDados['gastos_transporte'] + $rowDados['gastos_saude'] + $rowDados['gastos_educacao'] + $rowDados['gastos_pessoais'] + $rowDados['gastos_comunicacao'] + $rowDados['gastos_lazer'];

// Definindo moeda base de acordo com a moeda da renda
$baseCurrency = $rowDados['moeda-renda'];
$targetCurrency = $rowDados['moeda-gasto'];

$exchangeRateApiUrl = getenv('API_URL').getenv('API_KEY').'&base='.$baseCurrency;
$exchangeRateData = '';

//verificar se a moeda é diferent
if ($rowDados['moeda-renda'] != $rowDados['moeda-gasto']) {
  $exchangeRateResponse = json_decode(file_get_contents($exchangeRateApiUrl), true);
  try {
    switch ($rowDados['moeda-renda']) {
      case 'BRL':
        $usdBRL = $rowDados['renda_mensal'] * $exchangeRateResponse['rates'][$targetCurrency];
        break;
      case 'USD':
        $brlUSD = $rowDados['renda_mensal'] * $exchangeRateResponse['rates'][$targetCurrency];
        break;
    }
  } catch (Error $error) {
    $valorEmDolares = 'Erro ao obter a taxa de câmbio';
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard de controle</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">

  <!-- Pie design with Google Charts -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {
      packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Moradia', <?php echo $rowDados['gastos_moradia'] ?>],
        ['Alimentação', <?php echo $rowDados['gastos_alimentacao'] ?>],
        ['Transporte', <?php echo $rowDados['gastos_transporte'] ?>],
        ['Saúde', <?php echo $rowDados['gastos_saude'] ?>],
        ['Educação', <?php echo $rowDados['gastos_educacao'] ?>],
        ['Pessoais', <?php echo $rowDados['gastos_pessoais'] ?>],
        ['Comunicação', <?php echo $rowDados['gastos_comunicacao'] ?>],
        ['Lazer', <?php echo $rowDados['gastos_lazer'] ?>]
      ]);

      var options = {
        title: 'Total gasto',
        titleSpacing: 10,
        pieHole: 0.4,
        backgroundColor: 'transparent',
        height: '100%',
        legend: {
          position: 'none',
        },

        chartArea: {
          width: '75%',
          height: '75%',
        },

        titleTextStyle: {
          color: '#f6f6f6',
          fontName: 'Roboto Slab',
          fontSize: '28.8',
          bold: true,
          height: '25%',
        },

        slices: [{
          color: '#f94144'
        }, {
          color: '#f3722c'
        }, {
          color: '#f8961e'
        }, {
          color: '#f9c74f'
        }, {
          color: '#90be6d'
        }, {
          color: '#43aa8b'
        }, {
          color: '#4d908e'
        }, {
          color: '#577590'
        }, ],

        pieSliceBorderColor: '#772e25',
        pieSliceTextStyle: {
          bold: true,
          color: '#F6F6F6',
          fontSize: '14'
        },

        tooltip: {
          textStyle: {
            color: '#111111',
            fontName: 'Roboto Slab',
            bold: true,
            fontSize: '16',
          },
        }
      };

      var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
      chart.draw(data, options);
    }
  </script>
</head>

<body class="body-dashboard">
  <nav class="sidebar">
    <div class="content-sidebar">
      <img src="../assets/logo-reduzido.svg" alt="">
      <div class="links-dashboard">
        <a class="atual home" href="#">
          <img src="../assets/Icones/icones-dourados/Ellipse 4.svg" alt="">
          <img src="../assets/Icones/icones-dourados/home.png" alt="" class="icon">
          <p>Home</p>
        </a>
        <a class="investimento" href="./explicacao.php?pagina=1">
          <img src="../assets/Icones/icones-brancos/profits.png" alt="" class="icon">
          <p>Investimento</p>
        </a>
        <a class="cofrinho" href="./explicacao.php?pagina=2">
          <img src="../assets/Icones/icones-brancos/pig.png" alt="" class="icon">
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
    <div class="perfil">
      <?php echo "<img src=\"../assets/ilustracoes/fotos-perfil/" . $rowName['url_cad'] . "\" alt=\"\">" ?>
      <p>
        <?php
        echo $rowName['nome_cad'];
        ?>
      </p>
    </div>
    <div class="graphics">
      <h1>Dashboard de controle</h1>
      <div class="superior">
        <div class="renda">
          <h2>Renda</h2>
          <div class="valor">
            <p class="dolar">
              <?php if ($rowDados['moeda-renda'] == 'USD' && $rowDados['moeda-renda'] != $rowDados['moeda-gasto']) {
                echo "<span>USD$</span>" . number_format($rowDados['renda_mensal'], 2, ',', '.');
                echo "<hr>";
              } elseif ($rowDados['moeda-gasto'] == 'USD' && $rowDados['moeda-renda'] != $rowDados['moeda-gasto']) {
                echo "<span>USD$ </span>" . number_format($usdBRL, 2, ',', '.');
                echo "<hr>";
              } elseif ($rowDados['moeda-renda'] && $rowDados['moeda-gasto'] == 'USD') {
                echo "<span>USD$</span>" . number_format($rowDados['renda_mensal'], 2, ',', '.');
                echo "<hr>";
              } ?>
            </p>
            <p class="real">
              <?php if ($rowDados['moeda-renda'] == 'BRL' && $rowDados['moeda-renda'] != $rowDados['moeda-gasto']) {
                echo "<span>R$</span>" . number_format($rowDados['renda_mensal'], 2, ',', '.');
              } elseif ($rowDados['moeda-renda'] == 'USD' && $rowDados['moeda-renda'] != $rowDados['moeda-gasto']) {
                echo "<span>R$</span>" . number_format($brlUSD, 2, ',', '.');
              } elseif ($rowDados['moeda-renda'] && $rowDados['moeda-gasto'] == 'BRL') {
                echo "<span>R$</span>" . number_format($rowDados['renda_mensal'], 2, ',', '.');
              } ?>

          </div>
          <p class="aumento">0,00% de aumento - mês passado</p>
        </div>
        <div class="despesas">
          <h2>Despesas</h2>
          <p class="valor">
            <?php
            echo "<span>R$</span>" . number_format($gastosDashboard, 2, ',', '.');
            ?>
          </p>
          <p class="aumento">2,87% de aumento - mês passado</p>
        </div>
        <div class="saldo">
          <h2>Saldo</h2>
          <p class="valor">
            <?php
            $saldoEmReais = $rowDados['renda_mensal'] - $gastosDashboard;
            echo "<span>R$</span>" . number_format($saldoEmReais, 2, ',', '.');
            // Verificar se a moeda de gasto é diferente de BRL
            if ($rowDados['moeda-gasto'] != 'BRL') {
              echo "<br>";
              echo "<span>USD$</span>" . number_format($saldoEmReais * $exchangeRateResponse['rates'][$rowDados['moeda-gasto']], 2, ',', '.');
            }
            ?>
          </p>
          <p class="aumento">5,68% de aumento - mês passado</p>
        </div>
      </div>
      <div class="inferior">
        <div class="atv-recentes">
          <h2>Atividades recentes</h2>
          <div class="gastos">
            <div class="salario">
              <div class="txt-gastos">
                <h3>Salário</h3>
                <p>Hoje</p>
              </div>
              <p><span>+R$</span>3.000,00</p>
            </div>
            <div class="cinema">
              <div class="txt-gastos">
                <h3>Cinema</h3>
                <p>Ontem</p>
              </div>
              <p><span>-R$</span>50,00</p>
            </div>
            <div class="gasolina">
              <div class="txt-gastos">
                <h3>Gasolina</h3>
                <p>Ontem</p>
              </div>
              <p><span>-R$</span>100,00</p>
            </div>
            <div class="supermercado">
              <div class="txt-gastos">
                <h3>Supermercado</h3>
                <p>Ontem</p>
              </div>
              <p><span>-R$</span>350,00</p>
            </div>
          </div>
        </div>
        <div class="total-gasto">
          <div id="donutchart" class="chart-container"></div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>