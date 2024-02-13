<?php
include "conn.php";
include "function.php";
session_start();
voltarLogin();

$userId = $conn->prepare('SELECT * FROM `cadastro` WHERE `id_cad`=:pid AND `type_user` = 1');
$userId->bindValue(':pid', $_SESSION['login']);
$userId->execute();
$rowName = $userId->fetch();


if ($rowName['type_user'] != 1) {
  header('location:dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editor - Basilisk</title>
  <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>

  <header class="header-postagem">
    <img src="../assets/logo-dev.svg" alt="logo basilisk">
    <div class="usuario-log">
      <p>
        <?php
        echo $rowName['nome_cad'];
        ?>
      </p>
      <?php echo "<img src=\"../assets/ilustracoes/fotos-perfil/" . $rowName['url_cad'] . "\" alt=\"\">" ?>
    </div>
  </header>

  <main class="main-postagem">
    <form action="editor.php" method="post" enctype="multipart/form-data">
      <input name="titulo" id="titulo" type="text" placeholder="Título" class="input-post" required>

      <input name="subtitulo" id="subtitulo" type="text" placeholder="Subtítulo" class="input-post input-2" required>

      <textarea name="content" id="content" cols="30" rows="10" placeholder="Conteúdo aqui"></textarea required>

      <div class="file-categoria">
        <div class="input-foto btn-md">
          <label for="foto">Escolha o background do post</label>
          <input name="foto" id="foto" type="file" class="file-input" required>
        </div>
        <div class="select-post">
          <select name="categoria" id="categoria" required>
            <option selected disabled>Escolha a categoria</option>
            <option value="Curiosidade">Curiosidade</option>
            <option value="Investimento">Investimento</option>
            <option value="Finanças">Finanças pessoais</option>
            <option value="Educacao">Educação financeira</option>
            <option value="Empreendedorismo">Negócios e empreendedorismo</option>
          </select>
        </div>
      </div>
      <input name="envia" id="envia" type="submit" value="Postar" class="btn-md btn-post">
    </form>
  </main>  
</body>
</html>

<?php
include "conn.php";

if (isset($_POST['envia'])) {
  $titulo = $_POST['titulo'];
  $subtitulo = $_POST['subtitulo'];
  $texto = $_POST['content'];
  $categoria = $_POST['categoria'];
  $foto = $_FILES['foto'];

  $_UP['pasta'] = "../assets/imagens-blog/";
  $_UP['tamanho'] = 1024 * 1024 * 1;
  $_UP['extensao'] = array('jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp');
  $_UP['renomear'] = true;

  $separaExtensao = explode('.', $_FILES['foto']['name']);
  $apontaExtensao = end($separaExtensao);
  $padraoExtensao = strtolower($apontaExtensao); //se a extensão estiver maiúscula, transforma em minúscula

  //mensagem de extensão não aceita
  if (array_search($padraoExtensao, $_UP['extensao']) === false) {
    echo "Extensão de arquivo não aceita, o arquivo deve ser uma imagem.";
  }

  //mensagem de tamanho não aceito
  if ($_UP['tamanho'] < $_FILES['foto']['size']) {
    echo "Tamanho de arquivo não aceito, o arquivo deve ter até 1MB.";
  }

  //renomeando arquivo
  if ($_UP['renomear'] === true) {
    $arquivoRenomeado = md5(time()) . ".$padraoExtensao";
  } else {
    $arquivoRenomeado = $_FILES['foto']['name'];
  }

  //salvando arquivo na pasta e no banco
  if (move_uploaded_file($_FILES['foto']['tmp_name'], $_UP['pasta'] . $arquivoRenomeado)) {
    $url = $_UP['pasta'] . $arquivoRenomeado;
    $envia = $conn->prepare('INSERT INTO `postagem_blog` (`id_post`, `title_post`, `subt_post`, `text_post`, `data_post`, `img_post`, `catego_post`, `id_escritor`) VALUES (NULL, :ptitulo, :psubtitulo, :ptexto, NOW(), :pfoto, :pcategoria, :pidescritor)');
    $envia->bindValue(':ptitulo', $titulo);
    $envia->bindValue(':psubtitulo', $subtitulo);
    $envia->bindValue(':ptexto', $texto);
    $envia->bindValue(':pfoto', $url);
    $envia->bindValue(':pcategoria', $categoria);
    $envia->bindValue('pidescritor', $_SESSION['login']);
    $envia->execute();
  }
}
?>