<?php
session_start();
if (!isset($_SESSION["usuario_Logado"])) {
    header("Location: tela_login.php");
    exit;
}

require_once("../conexao/conexao.php");

$user_id = $_SESSION["usuario_Logado"];
$stmt = mysqli_prepare($conecta, "SELECT nome, email, login, tipo, criado_em FROM usuarios WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

require_once("Navbar.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - RG Eats</title>
    <link rel="stylesheet" href="CSS%20(Ryan)/style.css">
    <link rel="stylesheet" href="CSS%20(Ryan)/acessibilidade.css">
</head>
<body class="login-page">
    <div class="bubbles" id="bubblesContainer"></div>

    <div class="login-wrapper" style="max-width: 500px;">
        <a href="index.php" class="back-link">&larr; Voltar para o início</a>

        <div class="login-card">
            <div class="login-header">
                <h2>Meu Perfil</h2>
                <p>Informações do seu usuário</p>
            </div>

            <div class="profile-details">
                <p><strong>Nome:</strong> <?= htmlspecialchars($usuario['nome']); ?></p>
                <p><strong>Login:</strong> <?= htmlspecialchars($usuario['login']); ?></p>
                <p><strong>E-mail:</strong> <?= htmlspecialchars($usuario['email']); ?></p>
                <p><strong>Tipo de Conta:</strong> <?= ucfirst(htmlspecialchars($usuario['tipo'])); ?></p>
                <p><strong>Membro desde:</strong> <?= date('d/m/Y', strtotime($usuario['criado_em'])); ?></p>
            </div>

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

            <a href="../conexao/logout.php" class="btn-submit" style="text-align: center; text-decoration: none; display: block; background: #e53e3e; color: #fff; margin-top: 20px;">Sair da Conta</a>
        </div>
    </div>

    <script src="JS%20(Gustavo)/animacao_bolha.js"></script>
    <script src="JS%20(Gustavo)/acessibilidade.js" defer></script>
</body>
</html>
