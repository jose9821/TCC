<?php
require_once("../conexao/conexao.php");
 
// Página de registro - RG Eats
// Processamento do formulário (ajuste conforme sua lógica de back-end)
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
 
    if ($senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem.";
    } else {
        // TODO: inserir lógica de cadastro (banco de dados, hash de senha, etc.)
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
</head>
<body class="login-page">
<div class="bubbles" id="bubblesContainer"></div>
 
  <div class="login-wrapper">
 
    <a href="index.php" class="back-link">&larr; Voltar para o início</a>
 
    <div class="login-card">
 
      <div class="login-header">
        <h2>Registre-se</h2>
        <p>Crie sua conta para começar a usar o RG Eats</p>
      </div>
 
      <?php if (!empty($erro)): ?>
        <div class="login-error-message">
          <p><?php echo htmlspecialchars($erro); ?></p>
        </div>
      <?php endif; ?>
 
      <form action="registrar.php" method="POST">
 
        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" placeholder="Insira seu E-mail" required>
        </div>
 
        <div class="form-group">
          <label for="senha">Senha</label>
          <input type="password" id="senha" name="senha" placeholder="Insira uma senha" required>
        </div>
 
        <div class="form-group">
          <label for="confirmar_senha">Confirmar a senha</label>
          <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme sua senha" required>
        </div>
 
        <button type="submit" class="btn-submit">Registrar</button>
 
      </form>
 
    </div>
 
  </div>

  <script src="JS%20(Gustavo)/animacao_bolha.js"></script>
</body>
</html>

