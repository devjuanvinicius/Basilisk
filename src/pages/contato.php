<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - Basilisk</title>
    <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="mascote" href="imgs/ilustracoes/mascote">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@600&display=swap" rel="stylesheet">
</head>
<body class="body-contato">
    <nav class="navbarbs">
        <img src="../assets/logo.svg" alt="">

        <div class="navbar">
            <a href="../../index.php">HOME</a>
            <a href="./blog.php">BLOG</a>
            <a href="./contato.php">CONTATO</a>
        </div>
        <div class="login-cadastro">
            <a href="./login.php">LOGIN</a>
            <a href="./cadastro.php" class="cadastrobs">CADASTRE-SE</a>
        </div>
    </nav>
    <div class="faleconosco">
        <h2>Fale conosco</h2>
        <form class="formulariocontato" action="https://formsubmit.co/admin@basiliskfs.com" method="post">
            <div class="campo">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="name" class="campo-input" required>
            </div>
        
            <div class="campo">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" class="campo-input" required>
            </div>
        
            <div class="campo">
                <label for="mensagem">Sua mensagem:</label>
                <textarea id="mensagem" name="message" class="campo-textarea" required></textarea>
            </div>
        
            <input type="submit" value="Enviar" class="submit-contato">
            <input type="hidden" name="_subject" value="Novo Contato!">
            <input type="text" name="_honey" style="display: none">
            <input type="hidden" name="_captcha" value="false">
        </form>
    </div>
    
    <footer class="footer-contato">
        <div class="redes-sociais">
            <a href="#"><img src="../assets/Icones/rede-sociais/facebook.png" alt="Facebook"></a>
            <a href="#"><img src="../assets/Icones/rede-sociais/instagram.png" alt="Twitter"></a>
            <a href="#"><img src="../assets/Icones/rede-sociais/linkedin.png" alt="LinkedIn"></a>
            <a href="#"><img src="../assets/Icones/rede-sociais/twitter.png" alt="LinkedIn"></a>
        </div>
    </footer>
    
</body>
</html>
