<?php 
require_once("../conexao/conexao.php");
session_start();

$mensagem = '';
if (isset($_POST["usuario"])) {
    $_usuario = $_POST["usuario"];
    $_senha = $_POST["senha"];

    $stmt = mysqli_prepare($conecta, "SELECT id, nome, senha, tipo FROM usuarios WHERE login = ?");
    mysqli_stmt_bind_param($stmt, "s", $_usuario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $informacao = mysqli_fetch_assoc($result);

    if ($informacao && password_verify($_senha, $informacao["senha"])) {
        $_SESSION["usuario_Logado"] = $informacao["id"];
        $_SESSION["nome_usuario"] = $informacao["nome"];
        $_SESSION["tipo_usuario"] = $informacao["tipo"];
        
        // Redirecionamento baseado no perfil (opcional)
        header("location:index.php");
        exit;
    } else {
        $mensagem = "Usuário ou senha incorretos.";
    }
    mysqli_stmt_close($stmt);
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

<div vw class="enabled">
  <div vw-access-button class="active"></div>
  <div vw-plugin-wrapper>
    <div class="vw-plugin-top-wrapper"></div>
  </div>
</div>
<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
<script>
  new window.VLibras.Widget('https://vlibras.gov.br/app');
</script>

    <?php require_once("acessibilidade.php"); ?>

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
