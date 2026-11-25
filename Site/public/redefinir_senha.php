<?php
require_once("../conexao/conexao.php");

$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
$erro = '';
$sucesso = false;
$registro = null;

if (preg_match('/^[a-f0-9]{64}$/', $token)) {
    $token_hash = hash('sha256', $token);
    $stmt = mysqli_prepare($conecta, "SELECT id, usuario_id FROM redefinicoes_senha WHERE token_hash = ? AND expira_em > NOW()");
    mysqli_stmt_bind_param($stmt, "s", $token_hash);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $registro = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);
}

if ($registro && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
    $confirmar = isset($_POST['confirmar_senha']) ? $_POST['confirmar_senha'] : '';

    if (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres.";
    } elseif ($senha !== $confirmar) {
        $erro = "As senhas não coincidem.";
    } else {
        $novo_hash = password_hash($senha, PASSWORD_DEFAULT);
        $uid = (int)$registro['usuario_id'];

        $up = mysqli_prepare($conecta, "UPDATE usuarios SET senha = ? WHERE id = ?");
        mysqli_stmt_bind_param($up, "si", $novo_hash, $uid);
        $ok = mysqli_stmt_execute($up);
        mysqli_stmt_close($up);

        if ($ok) {
            $del = mysqli_prepare($conecta, "DELETE FROM redefinicoes_senha WHERE usuario_id = ?");
            mysqli_stmt_bind_param($del, "i", $uid);
            mysqli_stmt_execute($del);
            mysqli_stmt_close($del);
            $sucesso = true;
        } else {
            $erro = "Não foi possível atualizar a senha. Tente novamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS%20(Ryan)/style.css">
    <link rel="stylesheet" href="CSS%20(Ryan)/acessibilidade.css">
    <title>Redefinir senha - RG Eats</title>
    <link rel="icon" type="image/png" href="../Imagens/Logo/favicon.ico">
</head>
<body class="login-page">
<div class="bubbles" id="bubblesContainer"></div>

<div class="login-wrapper">
    <a href="tela_login.php" class="back-link">← Voltar para o login</a>

    <div class="login-card">
        <div class="login-header">
            <h2>Nova senha</h2>
            <p>Escolha uma nova senha para sua conta</p>
        </div>

        <?php if ($sucesso): ?>
            <div class="login-error-message" style="background:#f0fff4;border-color:#9ae6b4;">
                <p style="color:#276749;">Senha alterada com sucesso!</p>
            </div>
            <a href="tela_login.php" class="btn-submit" style="text-align:center;text-decoration:none;display:block;">Ir para o login</a>

        <?php elseif (!$registro): ?>
            <div class="login-error-message">
                <p>Link inválido ou expirado. Peça um novo link.</p>
            </div>
            <a href="esqueci_senha.php" class="btn-submit" style="text-align:center;text-decoration:none;display:block;">Pedir novo link</a>

        <?php else: ?>
            <?php if ($erro !== ''): ?>
                <div class="login-error-message"><p><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></p></div>
            <?php endif; ?>

            <<form action="redefinir_senha.php?token=<?php echo htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>" method="post">
                <div class="form-group">
                    <label for="senha">Nova senha</label>
                    <div class="password-container">
                        <input type="password" id="senha" name="senha" placeholder="Mínimo 6 caracteres" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('senha', this)">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1B2D6B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirmar_senha">Confirmar nova senha</label>
                    <div class="password-container">
                        <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Repita a senha" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('confirmar_senha', this)">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1B2D6B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn-submit">Salvar nova senha</button>
            </form>
        <?php endif; ?>
    </div>
</div>
<script>
    function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);
    
    const svgOlhoAberto = `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1B2D6B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;

    const svgOlhoFechado = `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1B2D6B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`;

    if (input.type === "password") {
        input.type = "text";
        btn.innerHTML = svgOlhoFechado;
    } else {
        input.type = "password";
        btn.innerHTML = svgOlhoAberto;
    }
}
</script>
<script src="JS%20(Gustavo)/animacao_bolha.js"></script>
<script src="JS%20(Gustavo)/acessibilidade.js" defer></script>
</body>
</html>