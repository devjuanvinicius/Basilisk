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

$dadosInvestimento = $conn->prepare('SELECT * FROM `infos_investimento` WHERE `id_user` = :pid AND `status` = 1');
$dadosInvestimento->bindValue(':pid', $_SESSION['login']);
$dadosInvestimento->execute();
$rowInvestimento = $dadosInvestimento->fetch();

if ($dadosInvestimento->rowCount() == 0) {
  header('location:explicacao.php?pagina=1');
  exit();
}

$totalInvestimento = $rowInvestimento['CDB_inv'] + $rowInvestimento['poupanca_inv'] + $rowInvestimento['rendavariavel_inv'] + $rowInvestimento['imoveis_inv'];


// Começa API
$apiKey = getenv('API_KEY');
$baseCurrency = 'BRL';
$targetCurrency = 'USD';
$exchangeRateApiUrl = getenv('API_URL');
$exchangeRateData = @file_get_contents($exchangeRateApiUrl);
if ($exchangeRateData === false) {
  die('Erro ao obter a taxa de câmbio.');
}

$exchangeRateData = json_decode($exchangeRateData, true);

if ($exchangeRateData === null || !isset($exchangeRateData['rates'][$targetCurrency])) {
  die('Erro ao processar os dados da taxa de câmbio.');
}

$usdToBrlRate = $exchangeRateData['rates'][$targetCurrency];


$baseCurrency = 'EUR';
$targetCurrency = 'BRL';
$exchangeRateApiUrl = "https://open.er-api.com/v6/latest?apikey=$apiKey&base=$baseCurrency&symbols=$targetCurrency";

$exchangeRateData = @file_get_contents($exchangeRateApiUrl);
if ($exchangeRateData === false) {
  die('Erro ao obter a taxa de câmbio.');
}

$exchangeRateData = json_decode($exchangeRateData, true);

if ($exchangeRateData === null || !isset($exchangeRateData['rates'][$targetCurrency])) {
  die('Erro ao processar os dados da taxa de câmbio.');
}

$eurToBrlRate = $exchangeRateData['rates'][$targetCurrency];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <!-- Made with Google Chart -->
  <script type="text/javascript">
    google.charts.load("current", {
      packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['CDB', <?php echo $rowInvestimento['CDB_inv'] ?>],
        ['Poupança', <?php echo $rowInvestimento['poupanca_inv'] ?>],
        ['Renda Variável', <?php echo $rowInvestimento['rendavariavel_inv'] ?>],
        ['Imoveis', <?php echo $rowInvestimento['imoveis_inv'] ?>],
      ]);

      var options = {
        title: 'Valor divido',
        titleSpacing: 10,
        pieHole: 0.4,
        backgroundColor: 'transparent',
        height: '100%',
        legend: {
          position: 'none',
          alignment: 'center',
        },

        chartArea: {
          width: '70%',
          height: '70%',
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
  <title>Investimento - Basilisk</title>
  <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">
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
        <a class="investimento atual" href="explicacao.php?pagina=1">
          <img src="../assets/Icones/icones-dourados/Ellipse 4.svg" alt="">
          <img src="../assets/Icones/icones-dourados/profits.png" alt="" class="icon">
          <p>Investimento</p>
        </a>
        <a class="cofrinho" href="explicacao.php?pagina=2">
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
        <a href="#" class="config">
          <img src="../assets/Icones/icones-brancos/setting.png" alt="" class="icon">
          <p>Configurações</p>
        </a>
      </div>
    </div>
  </nav>
  <main class="main-content">
    <div class="linha-perfil">
      <h1>Investimentos</h1>
      <div class="perfil perfil-cofre">
        <?php echo "<img src=\"../assets/ilustracoes/fotos-perfil/" . $rowName['url_cad'] . "\" alt=\"\">" ?>
        <p>
          <?php
          echo $rowName['nome_cad'];
          ?>
        </p>
      </div>
    </div>
    <!-- Depois refatorar para primeira-linha e deixar todos os dashs com essa configuração -->
    <div class="cards-cofrinho">
      <div class="primeira-linha-cofre primeira-linha-invi">
        <div class="primeiro-card card-total">
          <h2>Total investido:</h2>
          <p><span>R$</span>
            <?php
            echo number_format($totalInvestimento, 2, ',', '.');
            ?>
          </p>
        </div>
        <!-- Juan vai fazer -->
        <!-- grafico -->
        <div class="segundo-card card-invi">
          <div id="donutchart" class="chart-container"></div>
        </div>
      </div>
      <!-- cards para mudança -->
      <div class="segunda-linha-cofrinho segunda-linha-invi">
        <div class="card-infos-invi">
          <div class="card-invi-mudanca">
            <h2>CDB:</h2>
            <p>R$<?php echo $rowInvestimento['CDB_inv'] ?></p>
            <a href="cadastro-investimento.php">
              <button class="btn-md btn-invi">Alterar</button>
            </a>
          </div>
          <div class="card-invi-mudanca">
            <h2>Poupança:</h2>
            <p>R$<?php echo $rowInvestimento['poupanca_inv'] ?></p>
            <a href="cadastro-investimento.php">
              <button class="btn-md btn-invi">Alterar</button>
            </a>
          </div>
          <div class="card-invi-mudanca">
            <h2>Renda Variavel:</h2>
            <p>R$<?php echo $rowInvestimento['rendavariavel_inv'] ?></p>
            <a href="">
              <button class="btn-md btn-invi">Alterar</button>
            </a>
          </div>
          <div class="card-invi-mudanca">
            <h2>Imoveis:</h2>
            <p>R$<?php echo $rowInvestimento['imoveis_inv'] ?></p>
            <a href="">
              <button class="btn-md btn-invi">Alterar</button>
            </a>
          </div>
        </div>
        <div class="card-moeda">
          <div class="title-moeda">
            <h2>Cotação atual do dólar</h2>
            <hr>
          </div>

          <div class="txt-moeda">
            <div class="moedas">
              <div class="brl_to_usd">
                <div class="usd-moeda">
                  <h3>USD($)</h3>
                  <p><span>US$</span>1,00</p>
                </div>

                <div class="brl-moeda">
                  <h3>BRL(R$)</h3>
                  <p><span>R$</span><?php echo number_format(1 / $usdToBrlRate, 2, ',', '.'); ?></p>
                </div>
              </div>
              <div class="brl_to_eur">
                <div class="eur-moeda">
                  <h3>EUR(&euro;)</h3>
                  <p><span>&euro;</span>1,00</p>
                </div>
                
                <div div class="brl-moeda">
                  <h3>BRL(R$)</h3>
                  <p><span>R$</span><?php echo number_format($eurToBrlRate, 2, ',', '.');; ?></p>
                </div>
              </div>
            </div>

            <a href="https://www.bcb.gov.br/conversao" target="_blank">
              <button class="btn-md">Fazer conversão</button>
            </a>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
  </main>
</body>

</html>