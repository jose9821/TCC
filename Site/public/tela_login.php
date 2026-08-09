<?php require_once("../conexao/conexao.php"); ?>
<?php
session_start();
if (isset($_POST["usuario"])) {

    $_usuario = $_POST["usuario"];
    $_senha = $_POST["senha"];
    $login = "SELECT login.id_usuario, login.id_tipo, dados_usuario.nome 
              FROM login 
              INNER JOIN dados_usuario ON login.id_usuario = dados_usuario.id_usuario 
              WHERE login.usuario = '{$_usuario}' AND login.senha = '{$_senha}'";

    $acesso = mysqli_query($conecta, $login);
    if (!$acesso) {
        die("Falhou ao fazer seu Login, tente novamente.");
    }

    $informacao = mysqli_fetch_assoc($acesso);
    if (empty($informacao)) {
        $mensagem = "Login sem Sucesso";
    } else {
        $_SESSION["usuario_Logado"] = $informacao["id_usuario"];
        $_SESSION["nome_usuario"] = $informacao["nome"];
        $_SESSION['id_tipo'] = $informacao['id_tipo'];
        header("location:index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS%20(Ryan)/style.css">
    <title>Tela de Login - RG Eats</title>
</head>

<body class="login-page">
<div class="bubbles" id="bubblesContainer"></div>

    <div class="login-wrapper">
        <a href="index.php" class="back-link">
            ← <?php echo htmlspecialchars("Deseja voltar? Clique aqui") ?>
        </a>

        <main class="login-container">
            <form action="tela_login.php" method="post" class="login-card">
                <div class="login-header">
                    <h2>Bem-vindo de volta!</h2>
                    <p>Use seu login para acessar o RG Eats</p>
                </div>

                <div class="form-group">
                    <label for="usuario">Usuário</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Digite seu usuário" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                </div>

                <input type="submit" value="Entrar" class="btn-submit">

                <?php
                if (isset($mensagem)) {
                    ?>
                    <div class="login-error-message">
                        <p><?php echo $mensagem ?></p>
                    </div>
                    <?php
                }
                ?> 
            </form>
        </main>
    </div>

    <script src="JS%20(Gustavo)/animacao_bolha.js"></script>
</body>
</html>