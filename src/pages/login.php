<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Basilisk</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-container">
        <div class="login-form">
            <a href="../../index.php"><img src="../assets/logo.svg" alt="" class="logo-cad"></a>
            <form class="form-login" action="login.php" method="post">
                <div class="input-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="input-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required>
                </div>

                <div class="remember-forgot">
                    <div class="input-lembrar">
                        <input type="checkbox" id="lembrara" name="lembrara">
                        <label for="lembrar" class="remember">Lembrar de mim</label>
                    </div>
                    <a href="#" class="forgot-password">Esqueci minha senha</a>
                </div>
                <div class="btn-md">
                    <input type="submit" value="Entrar" name="entrar" class="custom-button">
                </div>
            </form>
        </div>

        <div class="login-side">
            <p class="login-side-text">
                "Quem controla suas finanças, <br>controla seu
                <span class="simples">futuro.</span>"
            </p>
            <img src="../assets/ilustracoes/Site Stats-cuate.svg" alt="Imagem de Apoio" class="login-side-image">
        </div>
        <img src="../assets/ilustracoes/Ellipse 3.svg" alt="" class="eclipse">
    </div>
</body>

</html>

<?php

if (isset($_POST['entrar'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    include "conn.php";

    $consultaEmail = $conn->prepare('SELECT * FROM `cadastro` WHERE `email_cad` = :pemail');
    $consultaEmail->bindValue(':pemail', $email);
    $consultaEmail->execute();
    $verificarLogin = $consultaEmail->fetch();

    if ($consultaEmail->rowCount() == 0) {
        echo "E-mail invalido";
    } else {
        if (password_verify($senha, $verificarLogin['senha_cad'])) {
            session_start();
            $_SESSION['login'] = $verificarLogin['id_cad'];
            if ($verificarLogin['type_user'] != 1) {
                header('location:dashboard.php');
            } else {
                header('location:tela-dev.php');
            }
            exit();
        } else {
            echo "Login ou senha inválido";
        }
    }
}
?>