<?php
include "conn.php";
$idPost=$_GET['id'];
echo $idPost;

$verificarId=$conn->prepare('SELECT * FROM `postagem_blog` WHERE `id_post`=:pidPost');
$verificarId->bindValue(':pidPost', $idPost);
$verificarId->execute();
$rowId=$verificarId->fetch();

$verificarPostagem=$conn->prepare('SELECT * FROM `postagem_blog`');
$verificarPostagem->execute();
$rowPostagem=$verificarPostagem->fetch();

$verificarEscritor=$conn->prepare('SELECT * FROM `cadastro` WHERE `id_cad`=:pidEscritor');
$verificarEscritor->bindValue(':pidEscritor', $rowId['id_escritor']);
$verificarEscritor->execute();
$nomeEscritor=$verificarEscritor->fetch();

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
<body class="body-page">
  <nav class="nav-home">
    <img src="../assets/logo.svg" alt="Logo Basilisk" class="logo">
    <div class="links">
      <ul>
        <li><a href="../../index.php" class="home-page">Home</a></li>
        <li><a href="./blog.php" class="select-page">Blog</a></li>
        <li><a href="./contato.php" class="contato">Contato</a></li>
      </ul>
    </div>
    <div class="btn-acess">
      <a href="./login.php">Login</a>
      <button>
        <a href="./cadastro.php">Cadastre-se</a>
      </button>
    </div>
  </nav>
  <div class="content-page">
    <main class="main-page">
    <?php echo "<div class=\"bg-img-page\" style=\"background-image: url(".$rowId['img_post'].");\">" ?>
    </div>
    <div class="texto-blog">
      <div class="title-blog">
        <p>Blog > <?php echo $rowId['catego_post'];?></p>
        <h1>
          <?php
            echo $rowId['title_post'];
          ?>
        </h1>
        <h2>
          <?php 
            echo $rowId['subt_post'];
          ?>
        </h2>
      </div>
      <hr>
      <article class='postagem-blog'>
        <p>
          <?php 
            echo $rowId['text_post'];
          ?>
        </p>
      </article>
          
      <hr>
    
      <footer>
        <div class='autor-blog'>  
          <?php echo "<img src=\"../assets/ilustracoes/fotos-perfil/".$nomeEscritor['url_cad']."\" alt=\"\">"?>
    
          <div class='txt-autor-blog'>
            <h2>Escrito por <?php echo $nomeEscritor['nome_cad'];?></h2>
            <h3>
                <!--essa parte do código está fazendo com que apareça apenas o PRIMEIRO nome 
                do escritor no rodapé do texto, e não seu nome completo-->
              <?php 
                $primeiroNome=explode(' ',$nomeEscritor['nome_cad']);
                if(count($primeiroNome)>=1){
                  echo $primeiroNome[0];
                }
              ?> é desenvolvedor(a) e escritor(a) do Basilisk
            </h3> 
          </div>
    
        </div>
    
        <div class='stats-blog'>
          <div class='like-blog'>
            <img src='../assets/Icones/icones-brancos/gostar.png' alt=''>
    
            <p><span>1.2K</span> Likes</p>
          </div>
          <div class='seguidores-blog'>
            <img src='../assets/Icones/icones-brancos/seguir.png' alt=''>

            <p><span>982</span> Seguidores</p>
          </div>
        </div>
      </footer>
    </div>
    </main>
    <aside class="aside-page">
      <h2>Outras postagens</h2>
      <hr>
    </aside>
  </div>
</body>
</html>