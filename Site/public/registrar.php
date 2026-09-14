<?php
session_start();
require_once("../conexao/conexao.php");

$erro = '';

// $_SERVER['REQUEST_METHOD'] funciona perfeitamente no PHP antigo
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Substituído o operador ?? por ternário clássico
    $nome = trim(isset($_POST['nome']) ? $_POST['nome'] : '');
    $login = trim(isset($_POST['login']) ? $_POST['login'] : '');
    $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
    $confirmar_senha = isset($_POST['confirmar_senha']) ? $_POST['confirmar_senha'] : '';
    $tipo = 'comum'; // Padrão conforme o banco

    if (empty($nome) || empty($login) || empty($email) || empty($senha)) {
        $erro = "Por favor, preencha todos os campos.";
    } elseif ($senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem.";
    } else {
        // Verifica se o login ou email já existem usando MySQLi orientado a procedimentos (compatível)
        $stmt = mysqli_prepare($conecta, "SELECT id FROM usuarios WHERE login = ? OR email = ?");
        mysqli_stmt_bind_param($stmt, "ss", $login, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $erro = "Este usuário ou e-mail já está cadastrado.";
        } else {
            // ATENÇÃO: password_hash() não existe em versões antigas (< 5.5).
            // Se estiver usando PHP < 5.5, recomenda-se usar sha1 ou md5 (ou a biblioteca password_compat).
            // Aqui estamos usando sha1 como alternativa legada segura de hash:
            $senha_hash = sha1($senha); 

            $insert = mysqli_prepare($conecta, "INSERT INTO usuarios (nome, login, email, senha, tipo) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($insert, "sssss", $nome, $login, $email, $senha_hash, $tipo);
            
            if (mysqli_stmt_execute($insert)) {
                $novo_id = mysqli_insert_id($conecta);
                
                // Realiza o login automático do usuário cadastrado
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
          <input type="password" id="senha" name="senha" placeholder="Insira uma senha" required>
        </div>
 
        <div class="form-group">
          <label for="confirmar_senha">Confirmar a senha</label>
          <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme sua senha" required>
        </div>
 
        <button type="submit" class="btn-submit">Registrar</button>
 
      </form>

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
 
    </div>
  </div>

  <script src="JS%20(Gustavo)/animacao_bolha.js"></script>
  <script src="JS%20(Gustavo)/acessibilidade.js" defer></script>
  <?php require_once("acessibilidade.php"); ?>
</body>
</html>
