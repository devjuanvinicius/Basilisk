<?php 
  include "conn.php";
  include "function.php";
  session_start();
  voltarLogin();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - Basilisk</title>
  <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="body-cad-info">
  <div class="logo-and-aviso">
    <a href="../../index.php"><img src="../assets/logo-reduzido.svg" alt="logo-basilisk"></a>

    <h1>Para lhe ajudarmos melhor, precisamos de algumas informações sobre sua vida financeira!</h1>

    <hr>
  </div>

  <form action="cadastro-infos-banco.php" method="post">
    <h2>Renda</h2>

    <div class="renda-cad-info">
      <label for="renda">Qual é sua renda mensal?</label>
      <input type="number" name="renda" id="renda" placeholder="Informe somente o valor. Ex: 1200" required>
    </div>

    <div class="outra-renda-dolar">
      <div class="outra-renda">
        <label for="outra-renda">Caso possua outra renda, coloque aqui.</label>
        <input type="number" name="outra-renda" id="outra-renda" placeholder="Informe somente o valor. Ex: 1200">
      </div>
      <div class="moeda-renda">
        <label for="moeda-renda">Informe a moeda em que recebe:</label>
        <select name="moeda-renda" id="moeda-renda">
          <option value="BRL">Real (R$)</option>
          <option value="USD">Dólar (USD)</option>
        </select>
      </div>
    </div>

    <h2 class="h2-gastos">Gastos</h2>

    <div class="linha-moeda-gasto moeda-gasto">
        <label for="moeda-gasto">Informe a moeda na qual faz os pagamentos:</label>
        <select name="moeda-gasto" id="moeda-gasto">
          <option value="BRL">Real (R$)</option>
          <option value="USD">Dólar (USD)</option>
        </select>
    </div>

    <div class="gastos-cad-info">
      <div class="primeira-linha">
        <div class="inputs-gastos">
          <label for="moradia">Gastos com moradia*</label>
          <input type="number" name="moradia" id="moradia" placeholder="Ex: Aluguel, agua, luz, etc." required>
        </div>
        <div class="inputs-gastos">
          <label for="alimentacao">Gastos com alimentação*</label>
          <input type="number" name="alimentacao" id="alimentacao" placeholder="Ex: Supermercado, refeições fora de casa, delivery" required>
        </div>
      </div>
      
      <div class="segunda-linha">
        <div class="inputs-gastos">
          <label for="saude">Gastos pessoais*</label>
          <input type="number" name="pessoais" id="pessoais" placeholder="Ex: Vestuario, seguro de vida, etc." required>
        </div>
        <div class="inputs-gastos">
          <label for="saude">Gastos com saúde</label>
          <input type="number" name="saude" id="saude" placeholder="Ex: Plano de saúde, academia, remédios, etc.">
        </div>
      </div>

      <div class="terceira-linha">
        <div class="inputs-gastos">
          <label for="educacao">Gastos com educação</label>
          <input type="number" name="educacao" id="educacao" placeholder="Ex: Escola, Livros, Cursos online, etc.">
        </div>
        <div class="inputs-gastos">
          <label for="transporte">Gastos com transporte</label>
          <input type="number" name="transporte" id="transporte" placeholder="Ex: Gasolina, transporte público, Apps de carona, etc.">
        </div>
      </div>

      <div class="quarta-linha">
        <div class="inputs-gastos">
          <label for="comunicacao">Gastos com comunicação</label>
          <input type="number" name="comunicacao" id="comunicacao" placeholder="Ex: Internet, Despesas com celular, TV a cabo, etc.">
        </div>
        <div class="inputs-gastos">
          <label for="lazer">Gastos com lazer</label>
          <input type="number" name="lazer" id="lazer" placeholder="Ex: Viagem, cinema, atividades recreativas, etc.">
        </div>
      </div>

      <div class="btn-cad-info">
        <input type="submit" value="Enviar" name="enviar">
      </div>
    </div>
  </form> 
</body>
</html>

<?php
  include "conn.php";
  if(isset($_POST['enviar'])){
    $rendaMensal = $_POST['renda'];
    $outraRenda = $_POST['outra-renda'];
    $rendaFinal = "";

    if($outraRenda > 0){
      $rendaFinal = $rendaMensal + $outraRenda;
    }

    $gastosMoradia = $_POST['moradia'];
    $gastosAlimentacao = $_POST['alimentacao'];
    $gastosTransporte = $_POST['transporte'];
    $gastosSaude = $_POST['saude'];
    $gastosEducacao = $_POST['educacao'];
    $gastosPessoais = $_POST['pessoais'];
    $gastosComunicacao = $_POST['comunicacao'];
    $gastosLazer = $_POST['lazer'];
    $moedaRenda = $_POST['moeda-renda'];
    $moedaGasto = $_POST['moeda-gasto'];
    
    $verificarSeExisteInfo=$conn->prepare('SELECT * FROM `infos_bancarias` WHERE `id_user` = :pid AND `status` = 1');
    $verificarSeExisteInfo->bindValue(':pid', $_SESSION['login']);
    $verificarSeExisteInfo->execute();

    if($verificarSeExisteInfo->rowCount() >= 1){
      $updateStatus = $conn->prepare('UPDATE `infos_bancarias` SET `status` = 0 WHERE `id_user` = :pid');
      $updateStatus->bindValue(':pid', $_SESSION['login']);
      $updateStatus->execute();
    }

    $enviarInfosBancarias=$conn->prepare('INSERT INTO `infos_bancarias`(`id_dados`, `renda_mensal`, `outra_renda`, `renda_final`, `gastos_moradia`, `gastos_alimentacao`, `gastos_transporte`, `gastos_saude`, `gastos_educacao`, `gastos_pessoais`, `gastos_comunicacao`, `gastos_lazer`, `moeda-renda`,`moeda-gasto`, `id_user`, `status`) VALUES (NULL, :prendaMensal, :poutraRenda, :prendaFinal, :pgastosMoradia, :pgastosAlimentacao, :pgastosTransporte, :pgastosSaude, :pgastosEducacao, :pgastosPessoais, :pgastosComunicacao, :pgastosLazer, :pmoedaRenda, :pmoedaGasto, :pidUser, 1)');

    $enviarInfosBancarias->bindValue(':prendaMensal', $rendaMensal);
    $enviarInfosBancarias->bindValue(':poutraRenda', $outraRenda);
    $enviarInfosBancarias->bindValue(':prendaFinal', $rendaFinal);
    $enviarInfosBancarias->bindValue(':pgastosMoradia', $gastosMoradia);
    $enviarInfosBancarias->bindValue(':pgastosAlimentacao', $gastosAlimentacao);
    $enviarInfosBancarias->bindValue(':pgastosTransporte', $gastosTransporte);
    $enviarInfosBancarias->bindValue(':pgastosSaude', $gastosSaude);
    $enviarInfosBancarias->bindValue(':pgastosEducacao', $gastosEducacao);
    $enviarInfosBancarias->bindValue(':pgastosPessoais', $gastosPessoais);
    $enviarInfosBancarias->bindValue(':pgastosComunicacao', $gastosComunicacao);
    $enviarInfosBancarias->bindValue(':pgastosLazer', $gastosLazer);
    $enviarInfosBancarias->bindValue(':pmoedaRenda', $moedaRenda);
    $enviarInfosBancarias->bindValue(':pmoedaGasto', $moedaGasto);
    $enviarInfosBancarias->bindValue(':pidUser', $_SESSION['login']);
    $enviarInfosBancarias->execute();
    
    
    $rowInfoDados=$enviarInfosBancarias->fetch();
    $idInfoDados=$rowInfoDados['id_user'];
    $_SESSION['cad_info_dados']=$idInfoDados;
    echo "<script> window.location.href='dashboard.php';</script>";
    exit();
  }
?>