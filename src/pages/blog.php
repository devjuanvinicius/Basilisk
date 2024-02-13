<?php
include "conn.php";
session_start();

$verificarPostagem = $conn->prepare('SELECT * FROM `postagem_blog`');
$verificarPostagem->execute();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog - Basilisk</title>
  <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body class="body-blog">
  <nav class="nav-blog">
    <div class="logo-blog">
      <img src="../assets/logo.svg" alt="">
    </div>
    <div class="links-nav-blog">
      <a href="../../index.php">Home</a>
      <a href="" class="select-home">Blog</a>
      <a href="./contato.php">Contato</a>
    </div>
    <div class="login-cad-blog">
      <a href="login.php">Login</a>
      <a href="cadastro.php">
        <button>Cadastre-se</button>
      </a>
    </div>
  </nav>
  <main class="main-blog">
    <article>
      <div class="post-principal">
        <img src="../assets/ilustracoes/pix.jpg" alt="" class="bg-post">
        <div class="txt-article">
          <h2>Curiosidade</h2>
          <h1>
            Impacto do pix na economia brasileira.
          </h1>
          <p>O Banco Central concluiu que 49 milhões de pessoas passaram a fazer transferências eletrônicas após a criação do PIX. Esse contingente não fazia esse tipo de operação anteriormente. O maior porcentual de inclusão financeira foi alcançado na região Norte do país. Os dados fazem parte do boxe publicado no Relatório de Economia Bancária (REB) de 2021.</p>
        </div>
        <hr>
        <div class="infos-post">
          <div class="data-post">
            <img src="../assets/Icones/icones-dourados/calendar.png" alt="">
            <p>21/11/2023</p>
          </div>
          <div class="autor-post">
            <img src="../assets/Icones/icones-dourados/user.png" alt="">
            <p>Juan Vinicius De Souza</p>
          </div>
        </div>
      </div>
    </article>
    <aside class="aside-blog">
      <div class="primeira-linha-blog">
        <?php
        while ($rowPostagem = $verificarPostagem->fetch()) {
          $verificarEscritor = $conn->prepare('SELECT * FROM `cadastro` WHERE `id_cad`=:pidEscritor');
          $verificarEscritor->bindValue(':pidEscritor', $rowPostagem['id_escritor']);
          $verificarEscritor->execute();
          $nomeEscritor = $verificarEscritor->fetch();
          $dataPostagem = date('d/m/Y', strtotime($rowPostagem['data_post']));

          echo "
              <a href=\"pagina-blog.php?id=" . $rowPostagem['id_post'] . "\" class=\"postagem-blog\">
                <img src=\"" . $rowPostagem['img_post'] . "\" alt=\"\" class=\"bg-aside\">
      
                <div class=\"txt-postagem\">
                  <h2>" . $rowPostagem['catego_post'] . "</h2>
                  <h1>" . $rowPostagem['title_post'] . "</h1>
                </div>
                <hr>
                <div class=\"infos-post\">
                  <div class=\"data-post alteracao-data\">
                    <img src=\"../assets/Icones/icones-dourados/calendar.png\" alt=\"\">
                    <p>" . $dataPostagem . "</p>
                  </div>
                  <div class=\"autor-post alteracao-autor\">
                    <img src=\"../assets/Icones/icones-dourados/user.png\" alt=\"\">
                    <p>" . $nomeEscritor['nome_cad'] . "</p>
                  </div>
                </div>
              </a>
            ";
        }
        ?>
      </div>
    </aside>
  </main>
</body>

</html>