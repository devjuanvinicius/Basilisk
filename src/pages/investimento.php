<?php
include "conn.php";
include "function.php";
session_start();
voltarLogin();
logout();

$user_name = $conn->prepare('SELECT * FROM `cadastro` WHERE `id_cad`=:pid');
$user_name->bindValue(':pid', $_SESSION['login']);
$user_name->execute();
$row_nome = $user_name->fetch();

$dadosInvestimento = $conn->prepare('SELECT * FROM `infos_investimento` WHERE `id_user` = :pid AND `status` = 1');
$dadosInvestimento->bindValue(':pid', $_SESSION['login']);
$dadosInvestimento->execute();
$row_investimento = $dadosInvestimento->fetch();

if($dadosInvestimento->rowCount() == 0){
  header('location:explicacao.php?pagina=1');
  exit();
}

$totalInvestimento = $row_investimento['CDB_inv'] + $row_investimento['poupanca_inv'] + $row_investimento['rendavariavel_inv'] + $row_investimento['imoveis_inv'];


// Começa API
$apiKey = '6e71a18ebb384adda69f4e08ba5a638c';
$baseCurrency = 'BRL'; // Real brasileiro
$targetCurrency = 'USD'; // Dólar americano
$exchangeRateApiUrl = "https://open.er-api.com/v6/latest?apikey=$apiKey&base=$baseCurrency";

$exchangeRateData = @file_get_contents($exchangeRateApiUrl);
//caso de erro por causa da api
if ($exchangeRateData === false) {

    die('Erro ao obter a taxa de câmbio.');
}

$exchangeRateData = json_decode($exchangeRateData, true);


if ($exchangeRateData === null || !isset($exchangeRateData['rates'][$targetCurrency])) {
    // Tratamento de erro caso a decodificação falhe ou a moeda alvo não esteja presente
    die('Erro ao processar os dados da taxa de câmbio.');
}

$usdToBrlRate = $exchangeRateData['rates'][$targetCurrency];
// Acaba API 

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <!-- Configs grafico -->
  <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['CDB', <?php echo $row_investimento['CDB_inv'] ?>],
        ['Poupança', <?php echo $row_investimento['poupanca_inv'] ?>],
        ['Renda Variável',  <?php echo $row_investimento['rendavariavel_inv'] ?>],
        ['Imoveis', <?php echo $row_investimento['imoveis_inv']?>],
      ]);

      var options = {
        title: 'Valor divido',
        titleSpacing: 10,
        pieHole: 0.4,
        backgroundColor: 'transparent',
        height: '100%',
        legend:{
          position:'none',
          alignment:'center',
        },

        chartArea:{
          width: '70%',
          height: '70%',
        },

        titleTextStyle:{
          color: '#f6f6f6',
          fontName:'Roboto Slab',
          fontSize: '28.8',
          bold: true,
          height:'25%',
        },

        slices:[
          {color:'#f94144'},{color:'#f3722c'},{color:'#f8961e'},{color:'#f9c74f'},{color:'#90be6d'},{color:'#43aa8b'}, {color:'#4d908e'},{color:'#577590'},
        ],
        
        pieSliceBorderColor:'#772e25',
        pieSliceTextStyle:{bold:true, color: '#F6F6F6', fontSize: '14'},

        tooltip:{
          textStyle:{
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
          <?php echo "<img src=\"../assets/ilustracoes/fotos-perfil/".$row_nome['url_cad']."\" alt=\"\">"?>
          <p>
            <?php
              echo $row_nome['nome_cad'];
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
              echo number_format($totalInvestimento, 2, ',','.');
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
            <p>R$<?php echo $row_investimento['CDB_inv']?></p>
            <a href="cadastro-investimento.php">
              <button class="btn-md btn-invi">Alterar</button>
            </a>
          </div>
          <div class="card-invi-mudanca">
            <h2>Poupança:</h2>
            <p>R$<?php echo $row_investimento['poupanca_inv']?></p>
            <a href="cadastro-investimento.php">
              <button class="btn-md btn-invi">Alterar</button>
            </a>
          </div>
          <div class="card-invi-mudanca">
            <h2>Renda Variavel:</h2>
            <p>R$<?php echo $row_investimento['rendavariavel_inv']?></p>
            <a href="">
              <button class="btn-md btn-invi">Alterar</button>
            </a>
          </div>
          <div class="card-invi-mudanca">
            <h2>Imoveis:</h2>
            <p>R$<?php echo $row_investimento['imoveis_inv']?></p>
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
              <div class="brl-moeda">
                <h3>BRL(R$)</h3>
                <p><span>R$</span><?php echo number_format(1 / $usdToBrlRate, 2, ',', '.'); ?></p>
              </div>
              <div class="usd-moeda">
                <h3>USD($)</h3>
                <p><span>US$</span>1,00</p>
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
