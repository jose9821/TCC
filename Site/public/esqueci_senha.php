<?php
require_once("../conexao/conexao.php");
 
// Ajuste para um e-mail do SEU domínio (na Hostinger o mail() só envia bem com remetente do próprio domínio)
define('EMAIL_REMETENTE', 'nao-responda@seudominio.com.br');
 
$mensagem = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
 
    if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = mysqli_prepare($conecta, "SELECT id, nome FROM usuarios WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $usuario = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);
 
        if ($usuario) {
            $token = bin2hex(openssl_random_pseudo_bytes(32));
            $token_hash = hash('sha256', $token);
            $uid = (int)$usuario['id'];
 
            // Apaga pedidos antigos desse usuário
            $del = mysqli_prepare($conecta, "DELETE FROM redefinicoes_senha WHERE usuario_id = ?");
            mysqli_stmt_bind_param($del, "i", $uid);
            mysqli_stmt_execute($del);
            mysqli_stmt_close($del);
 
            // Token vale por 1 hora (usa o relógio do MySQL para evitar conflito de fuso)
            $ins = mysqli_prepare($conecta, "INSERT INTO redefinicoes_senha (usuario_id, token_hash, expira_em) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))");
            mysqli_stmt_bind_param($ins, "is", $uid, $token_hash);
            mysqli_stmt_execute($ins);
            mysqli_stmt_close($ins);
 
            $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $pasta = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $link = $protocolo . '://' . $_SERVER['HTTP_HOST'] . $pasta . '/redefinir_senha.php?token=' . $token;
 
            $assunto = '=?UTF-8?B?' . base64_encode('RG Eats - Redefinição de senha') . '?=';
            $corpo = "Olá, " . $usuario['nome'] . "!\n\n"
                   . "Recebemos um pedido para redefinir sua senha no RG Eats.\n"
                   . "Clique no link abaixo (válido por 1 hora):\n\n" . $link . "\n\n"
                   . "Se não foi você, ignore este e-mail.";
            $headers = "From: RG Eats <" . EMAIL_REMETENTE . ">\r\n"
                     . "Content-Type: text/plain; charset=UTF-8\r\n";
            @mail($email, $assunto, $corpo, $headers);
        }
    }
    // Mesma resposta exista o e-mail ou não (evita revelar quais e-mails estão cadastrados)
    $mensagem = "Se este e-mail estiver cadastrado, enviaremos um link para redefinir a senha. Confira também a caixa de spam.";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS%20(Ryan)/style.css">
    <link rel="stylesheet" href="CSS%20(Ryan)/acessibilidade.css">
    <title>Esqueci minha senha - RG Eats</title>
</head>
<body class="login-page">
<div class="bubbles" id="bubblesContainer"></div>
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
    <?php require_once("acessibilidade.php") ?>
 
<div class="login-wrapper">
    <a href="tela_login.php" class="back-link">&larr; Voltar para o login</a>
 
    <main class="login-container">
        <form action="esqueci_senha.php" method="post" class="login-card">
            <div class="login-header">
                <h2>Esqueceu a senha?</h2>
                <p>Informe o e-mail da sua conta para receber o link de redefinição</p>
            </div>
 
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
            </div>
 
            <input type="submit" value="Enviar link" class="btn-submit">
 
            <?php if ($mensagem !== ''): ?>
                <div class="login-error-message" style="background:#f0fff4;border-color:#9ae6b4;">
                    <p style="color:#276749;"><?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            <?php endif; ?>
        </form>
    </main>
</div>
<script src="JS%20(Gustavo)/animacao_bolha.js"></script>
<script src="JS%20(Gustavo)/acessibilidade.js" defer></script>
</body>
</html>