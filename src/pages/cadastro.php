<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastro - Basilisk</title>
    <link rel="shortcut icon" href="../assets/fav-icon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Cadastro</title>
</head>
<body class="body-cadastro">
    <div class="lados">
        <div class="esquerda">
            <div class="cima">
                <div class="pt_cima">
                    <h1 class="refrao">"Quem controla suas finanças, <br>controla seu<span style="color: #FFCB74;"> futuro.</span>"</h1>
                    <img class="imagem" src="../assets/ilustracoes/Financial-data-amico.svg" alt="">
                </div>
            </div>
        </div>
        <div class="direita">
            <div class="content-cad">
                <a href="../../index.php"><img src="../assets/logo.svg" alt="" class="logo-cad"></a>

                <form action="cadastro.php" method="POST" class="form-cad">
                    <div class="nome-cad">
                        <div class="nome-input">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" required>
                        </div>
                        <div class="sobrenome-input">
                            <label for="sobrenome">Sobrenome:</label>
                            <input type="text" name="sobrenome" id="sobrenome" required>
                        </div>
                    </div>

                    <div class="dual-input">
                        <div class="nasc">
                            <label for="nasc">Data de nascimento</label>
                            <input type="date" name="nasc" id="nasc" required>
                        </div>
                        <div class="gender">
                            <label for="genero">Gênero</label>
                            <select name="genero" id="genero" required>
                                <option value="masc">
                                    Masculino
                                </option>
                                <option value="fem">
                                    Feminino
                                </option>
                                <option value="outro">
                                    Outro
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="e-mail-cad">
                        <label for="email">E-mail:</label>
                        <input type="email" name="email" id="email" required>
                    </div>

                    <div class="senha-cad">
                        <label for="senha">Senha:</label>
                        <input type="password" name="senha" id="senha">
                    </div>

                    <div class="termos-cad">
                        <input type="checkbox" name="termo" id="termo">
                        <label for="termo">Li e concordo com os <a href="./termos-de-uso.html">termos de uso</a></label>
                    </div> 

                    <div class="submit-cad">
                        <input type="submit" value="Cadastrar-se" class="btn-cad" name="grava">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<!--para nao colocar data futura-->
<script> 
    const hoje = new Date().toISOString().slice(0, 10);
    document.getElementById("nasc").setAttribute("max", hoje);
</script>
<!--fim para nao colocar data futura-->

<?php
include "conn.php";

if (isset($_POST['grava'])) {
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $nasc = $_POST['nasc'];
    $genero = $_POST['genero'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Criando o nome completo
    $nomeCompleto = $nome . " " . $sobrenome;

    // Verificando se o e-mail já existe
    $verificarEmail = $conn->prepare('SELECT * FROM `cadastro` WHERE `email_cad` = :pemail');
    $verificarEmail->bindValue(':pemail', $email);
    $verificarEmail->execute();

    if ($verificarEmail->rowCount() == 0) {
        // Inserindo novo usuário
        $grava = $conn->prepare('INSERT INTO `cadastro` (`id_cad`, `nome_cad`, `data_cad`, `gen_cad`, `email_cad`, `url_cad`,`senha_cad`) VALUES (NULL, :pnome, :pdata, :pgenero, :pemail, "perfil-6.svg",:psenha);');
        $grava->bindValue(':pnome', $nomeCompleto);
        $grava->bindValue(':pdata', $nasc);
        $grava->bindValue(':pgenero', $genero);
        $grava->bindValue(':pemail', $email);
        $grava->bindValue(':psenha', $senha);
        $grava->execute();

        header('location:./login.php');
        exit();
    } else {
        echo "E-mail já cadastrado";
    }
}
?>
