<?php
session_start();
require_once("../conexao/conexao.php");

$erro = '';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim(isset($_POST['nome']) ? $_POST['nome'] : '');
    $login = trim(isset($_POST['login']) ? $_POST['login'] : '');
    $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
    $confirmar_senha = isset($_POST['confirmar_senha']) ? $_POST['confirmar_senha'] : '';
    $tipo = 'comum';

    if (empty($nome) || empty($login) || empty($email) || empty($senha)) {
        $erro = "Por favor, preencha todos os campos.";
    } elseif ($senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem.";
    } else {
        $stmt = mysqli_prepare($conecta, "SELECT id FROM usuarios WHERE login = ? OR email = ?");
        mysqli_stmt_bind_param($stmt, "ss", $login, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $erro = "Este usuário ou e-mail já está cadastrado.";
        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT); 

            $insert = mysqli_prepare($conecta, "INSERT INTO usuarios (nome, login, email, senha, tipo) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($insert, "sssss", $nome, $login, $email, $senha_hash, $tipo);
            
            if (mysqli_stmt_execute($insert)) {
                $novo_id = mysqli_insert_id($conecta);
                
                $_SESSION["usuario_Logado"] = $novo_id;
                $_SESSION["nome_usuario"] = $nome;
                $_SESSION["tipo_usuario"] = $tipo;

                header("Location: index.php");
                exit;
            } else {
                $erro = "Erro ao cadastrar usuário. Tente novamente.";
            }
            mysqli_stmt_close($insert);
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RG Eats - Registre-se</title>
<link rel="stylesheet" href="CSS%20(Ryan)/style.css">
<link rel="stylesheet" href="CSS%20(Ryan)/acessibilidade.css">
<link rel="icon" type="image/png" href="../Imagens/Logo/favicon.ico">
</head>
<body class="login-page">

<div class="bubbles" id="bubblesContainer"></div>
 
  <div class="login-wrapper">
    <a href="index.php" class="back-link">← Voltar para o início</a>
 
    <div class="login-card">
      <div class="login-header">
        <h2>Registre-se</h2>
        <p>Crie sua conta para começar a usar o RG Eats</p>
      </div>
 
      <?php if (!empty($erro)): ?>
        <div class="login-error-message">
          <p><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
      <?php endif; ?>
 
      <form action="registrar.php" method="POST">

        <div class="form-group">
          <label for="nome">Nome Completo</label>
          <input type="text" id="nome" name="nome" placeholder="Insira seu nome" required>
        </div>

        <div class="form-group">
          <label for="login">Nome de Usuário (Login)</label>
          <input type="text" id="login" name="login" placeholder="Ex: joaosilva" required>
        </div>
 
        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" placeholder="Insira seu E-mail" required>
        </div>
 
        <div class="form-group">
          <label for="senha">Senha</label>
          <div class="password-container">
            <input type="password" id="senha" name="senha" placeholder="Insira uma senha" required>
            <button type="button" class="toggle-password" onclick="togglePassword('senha', this)">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1B2D6B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </button>
          </div>
        </div>
 
        <div class="form-group">
          <label for="confirmar_senha">Confirmar a senha</label>
          <div class="password-container">
            <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme sua senha" required>
            <button type="button" class="toggle-password" onclick="togglePassword('confirmar_senha', this)">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1B2D6B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </button>
          </div>
        </div>
 
        <button type="submit" class="btn-submit">Registrar</button>
 
      </form>
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
  <?php require_once("acessibilidade.php"); ?>
</body>
</html>