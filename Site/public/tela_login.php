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
        
        $ok = false;
        if ($informacao) {
            $guardada = $informacao["senha"];
            if (password_verify($_senha, $guardada)) {
                $ok = true;
            } elseif ($guardada === sha1($_senha) || $guardada === $_senha) {
                $ok = true;
                $novo = password_hash($_senha, PASSWORD_DEFAULT);
                $up = mysqli_prepare($conecta, "UPDATE usuarios SET senha = ? WHERE id = ?");
                mysqli_stmt_bind_param($up, "si", $novo, $informacao["id"]);
                mysqli_stmt_execute($up);
                mysqli_stmt_close($up);
            }
        }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS%20(Ryan)/style.css">
    <link rel="stylesheet" href="CSS%20(Ryan)/acessibilidade.css">
    <title>Tela de Login - RG Eats</title>
    <link rel="icon" type="image/png" href="../Imagens/Logo/favicon.ico">
</head>
<body class="login-page">
    <?php require_once("acessibilidade.php"); ?>
    <div class="bubbles" id="bubblesContainer"></div>

    <div class="login-wrapper">
        <a href="index.php" class="back-link">← Deseja voltar? Clique aqui</a>

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
                    <div class="password-container">
                        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('senha', this)" aria-label="Mostrar/ocultar senha">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1B2D6B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                    </div>
                </div>

                <input type="submit" value="Entrar" class="btn-submit">

                <p style="text-align:center;margin-top:16px;">
                    <a href="esqueci_senha.php" style="color:#2196C4;font-size:14px;">Esqueci minha senha</a>
                </p>

                <?php if (isset($mensagem) && $mensagem !== ''): ?>
                    <div class="login-error-message">
                        <p><?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                <?php endif; ?> 
            </form>
        </main>
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