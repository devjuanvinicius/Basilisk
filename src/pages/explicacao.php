<?php
include "conn.php";
include "function.php";
session_start();
voltarLogin();

$url = $_GET['pagina'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Basilisk</title>
  <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../css/style.css">
  <script src="../../vendor/bootstrap/js/bootstrap.js"></script>
</head>

<body>
  <header class="header-load">
    <img src="../assets/logo.svg" alt="">
  </header>
  <main class="main-load">
    <div id="carouselExampleIndicators" class="carousel slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <?php

          switch ($url) {
            case 1:
              echo "
                  <div class=\"d-flex img-explicacao\">
                    <img src=\"../assets/ilustracoes/Finance-cuate.svg\" alt=\"\">
                  </div>
                  <div class=\"txt-carousel\">
                    <h1>Para que serve a área de investimento?</h1>
                    <br>
                    <p>Aqui você conseguirá organizar toda sua vida de investimentos. Poderá verificar via gráficos como sua carteira está divida, o quanto você já investiu e quando pretende ter o retorno.</p>
                  </div> 
                ";
              break;

            case 2:
              echo "
                  <div class=\"d-flex img-explicacao\">
                    <img src=\"../assets/ilustracoes/Money income-pana.svg\" alt=\"\">
                  </div>
                  <div class=\"txt-carousel\">
                    <h1>Como utilizar a função de cofrinho.</h1>
                    <br>
                    <p>Bem-vindo à nossa Cofrinho Digital, um espaço dedicado para tornar seus sonhos financeiros realidade. Aqui, você consegue estabelecer uma meta desejada, como \"comprar uma TV\" por exemplo, e ajudaremos você a realizar isso!</p>
                  </div> 
                ";
              break;
          }
          ?>
        </div>
        <div class="carousel-item">
          <?php
          switch ($url) {
            case 1:
              echo "
                  <div class=\"d-flex img-explicacao\">
                    <img src=\"../assets/ilustracoes/Investment data-cuate.svg\" alt=\"\">
                  </div>
                  <div class=\"txt-carousel\">
                    <h1>Tenha uma visão mais abragente de seus investimentos</h1>
                    <br>
                    <p>Maximize seu potencial de crescimento financeiro com a nossa Área de Investimento. Explore estratégias de investimento inteligentes, desde portfólios diversificados até abordagens inovadoras. Nosso objetivo é capacitar você com as informações e ferramentas necessárias para tomar decisões bem fundamentadas e otimizar o desempenho do seu patrimônio ao longo do tempo.</p>
                  </div>
                ";
              break;

            case 2:
              echo "
                  <div class=\"d-flex img-explicacao\">
                    <img src=\"../assets/ilustracoes/Done-pana.svg\" alt=\"\">
                  </div>
                  <div class=\"txt-carousel\">
                    <h1>Vamos lá!</h1>
                    <br>
                    <p>Utilize o botão abaixo para inserir o montante que pretende economizar e o período desejado. Apresentaremos três propostas parecidas sobre como gerir seus fundos. Inicie sua jornada de economia de maneira estratégica e acompanhe visualmente o progresso em direção aos seus objetivos financeiros</p>
                  </div>
                ";
              break;
          }
          ?>
        </div>
        <div class="carousel-item">
          <?php
          switch ($url) {
            case 1:
              echo "
                  <div class=\"d-flex img-explicacao\">
                    <img src=\"../assets/ilustracoes/Investor presentation-cuate.svg\" alt=\"\">  
                  </div>
                  <div class=\"txt-carousel\">
                    <h1>Como vou fazer isso?</h1>
                    <br>
                    <p>Clicando no botão na seta, você irá diretamente para o cadastro, nos informe a categorias das ações, o quanto você investe nela, e mostraremos tudo para você.</p>
                    // arrumar o botao, deixar ele com background que nem do cad investimento.
                    <a href=\"./cadastro-investimento.php\">
                      <button>Ir para o formulário</button>
                    </a>
                  </div>
                ";
              break;

            case 2:
              echo "
                  <div class=\"txt-carousel\">
                    <form action=\"proposta-cofrinho.php\" method=\"POST\">
                      <div class=\"input-explicacao\">
                        <label for=\"nome_meta\">Infome o nome que deseja para sua meta :</label>
                        <input type=\"text\" id=\"nome_meta\" name=\"nome_meta\" placeholder=\"Ex: Televisão quarto\"></input>
                      </div>
                      <div class=\"input-explicacao\">
                        <label for=\"guardar\">Infome o montante que deseja guardar:</label>
                        <input type=\"number\" id=\"guardar\" name=\"guardar\" placeholder=\"Informe o valor em BRL(R$)\"></input>
                      </div>
                      <div class=\"input-explicacao\">
                        <label for=\"tempo\">Infome a meta de tempo que deseja economizar:</label>
                        <input type=\"number\" id=\"tempo\" name=\"tempo\" placeholder=\"Informe o tempo em semanas\"></input>
                      </div>
                      <div class=\"btn-explicacao\">
                        <input type=\"submit\" id=\"enviar\" name=\"enviar\" value=\"Enviar\" class=\"btn-md\"></input>
                      </div>
                    </form>
                  </div>
                ";
              break;
          }
          ?>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <img src="../assets/Icones/icones-dourados/seta-esquerda.png" alt="" class="carousel-control-prev-icon" aria-hidden="true">
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <img src="../assets/Icones/icones-dourados/seta-direita.png" alt="" class="carousel-control-next-icon" aria-hidden="true">
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </main>
</body>

</html>