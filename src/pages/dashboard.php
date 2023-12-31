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

  $renda_dashboard = $conn->prepare('SELECT * FROM `infos_bancarias` WHERE `id_user`=:pid_dados AND `status` = 1');
  $renda_dashboard->bindValue(':pid_dados', $_SESSION['login']);
  $renda_dashboard->execute();
  $row_dados = $renda_dashboard->fetch();

  //kaique: caso o usuarionao tenha cadastrado as info!
  if (empty($row_dados)){
    header('location:cadastro-infos-banco.php');
    exit();
  }

// Calcular gastos
$gastos_dashboard = $row_dados['gastos_moradia'] + $row_dados['gastos_alimentacao'] + $row_dados['gastos_transporte'] + $row_dados['gastos_saude'] + $row_dados['gastos_educacao'] + $row_dados['gastos_pessoais'] + $row_dados['gastos_comunicacao'] + $row_dados['gastos_lazer'];

// Definindo moeda base de acordo com a moeda da renda
$baseCurrency = $row_dados['moeda-renda'];
$targetCurrency = $row_dados['moeda-gasto'];

// Obter taxa de câmbio para o dólar americano
$apiKey = '6e71a18ebb384adda69f4e08ba5a638c';
#$baseCurrency = 'BRL'; // Real brasileiro
#$targetCurrency = 'USD'; // Dólar americano
$exchangeRateApiUrl = "https://open.er-api.com/v6/latest?apikey=$apiKey&base=$baseCurrency";
$exchangeRateData = '';

/*
 * Só vamos fazer a conversão de moeda caso a moeda de gasto e de renda sejam diferentes.
 *
 */
if ($row_dados['moeda-renda'] != $row_dados['moeda-gasto']) {
    $exchangeRateResponse = json_decode(file_get_contents($exchangeRateApiUrl), true);
    try {
        switch ($row_dados['moeda-renda']) {
            case 'BRL':
                $usdBRL = $row_dados['renda_mensal'] * $exchangeRateResponse['rates'][$targetCurrency];
                break;
            case 'USD':
                $brlUSD = $row_dados['renda_mensal'] * $exchangeRateResponse['rates'][$targetCurrency];
                break;
        }
    } catch (Error $error) {
        $valorEmDolares = 'Erro ao obter a taxa de câmbio';
    }
}

#$exchangeRateData = json_decode(file_get_contents($exchangeRateApiUrl), true);

//if ($exchangeRateData && isset($exchangeRateData['rates'][$targetCurrency])) {
//  // Calcular o valor em dólares
//  $valorEmDolares = $row_dados['renda_mensal'] / $exchangeRateData['rates'][$targetCurrency];
//} else {
//  // Se houver um problema com a API, defina um valor padrão
//  $valorEmDolares = 'Erro ao obter a taxa de câmbio';
//}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard de controle</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Moradia', <?php echo $row_dados['gastos_moradia'] ?>],
        ['Alimentação',      <?php echo $row_dados['gastos_alimentacao'] ?>],
        ['Transporte',  <?php echo $row_dados['gastos_transporte'] ?>],
        ['Saúde', <?php echo $row_dados['gastos_saude']?>],
        ['Educação', <?php echo $row_dados['gastos_educacao'] ?>],
        ['Pessoais', <?php echo $row_dados['gastos_pessoais'] ?>],
        ['Comunicação', <?php echo $row_dados['gastos_comunicacao'] ?>],
        ['Lazer', <?php echo $row_dados['gastos_lazer'] ?>]
      ]);

      var options = {
        title: 'Total gasto',
        titleSpacing: 10,
        pieHole: 0.4,
        backgroundColor: 'transparent',
        height: '100%',
        legend:{
          position:'none',
        },

        chartArea:{
          width: '75%',
          height: '75%',
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
    <?php echo "<img src=\"../assets/ilustracoes/fotos-perfil/".$row_nome['url_cad']."\" alt=\"\">"?>
      <p>
        <?php
        echo $row_nome['nome_cad'];
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
        <?php if ($row_dados['moeda-renda'] == 'USD' && $row_dados['moeda-renda'] != $row_dados['moeda-gasto']) {
            echo "<span>USD$</span>" . number_format($row_dados['renda_mensal'], 2, ',', '.');
            echo "<hr>";
        } elseif ($row_dados['moeda-gasto'] == 'USD' && $row_dados['moeda-renda'] != $row_dados['moeda-gasto']) {
            echo "<span>USD$ </span>" . number_format($usdBRL, 2, ',', '.');
            echo "<hr>";
        } elseif ($row_dados['moeda-renda'] && $row_dados['moeda-gasto'] == 'USD') {
            echo "<span>USD$</span>" . number_format($row_dados['renda_mensal'], 2, ',', '.');
            echo "<hr>";
        }?>
    </p>
    <p class="real">
      <?php if ($row_dados['moeda-renda'] == 'BRL' && $row_dados['moeda-renda'] != $row_dados['moeda-gasto']) {
          echo "<span>R$</span>" . number_format($row_dados['renda_mensal'], 2, ',', '.');
      } elseif($row_dados['moeda-renda'] == 'USD' && $row_dados['moeda-renda'] != $row_dados['moeda-gasto']) {
          echo "<span>R$</span>" . number_format($brlUSD, 2, ',', '.');
      } elseif ($row_dados['moeda-renda'] && $row_dados['moeda-gasto'] == 'BRL'){
          echo "<span>R$</span>" . number_format($row_dados['renda_mensal'], 2, ',', '.');
      }?>

  </div>
  <p class="aumento">0,00% de aumento - mês passado</p>
</div>
        <div class="despesas">
          <h2>Despesas</h2>
          <p class="valor">
            <?php
              echo "<span>R$</span>" . number_format($gastos_dashboard, 2, ',', '.');
            ?>
          </p>
          <p class="aumento">2,87% de aumento - mês passado</p>
        </div>
        <div class="saldo">
    <h2>Saldo</h2>
    <p class="valor">
        <?php
            $saldoEmReais = $row_dados['renda_mensal'] - $gastos_dashboard;
            echo "<span>R$</span>" . number_format($saldoEmReais, 2, ',', '.');
            // Verificar se a moeda de gasto é diferente de BRL
            if ($row_dados['moeda-gasto'] != 'BRL') {
                echo "<br>";
                echo "<span>USD$</span>" . number_format($saldoEmReais * $exchangeRateResponse['rates'][$row_dados['moeda-gasto']], 2, ',', '.');
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
        <!-- <div class="bancos-cliente"></div> -->
      </div>
    </div>
  </main>
</body>
</html>