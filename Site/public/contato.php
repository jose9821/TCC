<?php
require_once("Navbar.php");
require_once("../conexao/conexao.php");

$mensagem_status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $sobrenome = trim($_POST['sobrenome']);
    $email = trim($_POST['email']);
    $mensagem = trim($_POST['mensagem']);

    if (!empty($nome) && !empty($sobrenome) && !empty($email) && !empty($mensagem)) {
        try {
            $sql = "INSERT INTO contatos (nome, sobrenome, email, mensagem) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $sobrenome, $email, $mensagem]);

            $mensagem_status = "<script>alert('Mensagem enviada com sucesso!');</script>";
        } catch (PDOException $e) {
            $mensagem_status = "<script>alert('Erro ao enviar mensagem: " . addslashes($e->getMessage()) . "');</script>";
        }
    } else {
        $mensagem_status = "<script>alert('Por favor, preencha todos os campos.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RG Eats - Contato</title>
<link rel="stylesheet" href="CSS%20(Ryan)/style.css">
</head>
<body>

  

  <?php echo $mensagem_status; ?>

  <main class="contact-section">
    <div class="bubbles" id="bubblesContainer"></div>
    <h1>Deseja nos contatar?</h1>
    <p class="subtitle">Insira seu nome e nos comunique!</p>

    <div class="contact-card">
      <form action="" method="POST">
        
        <div class="form-group">
          <label for="nome">Nome</label>
          <input type="text" id="nome" name="nome" placeholder="Insira seu nome" required>
        </div>

        <div class="form-group">
          <label for="sobrenome">Sobrenome</label>
          <input type="text" id="sobrenome" name="sobrenome" placeholder="Insira seu sobrenome" required>
        </div>

        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" placeholder="Insira seu E-mail" required>
        </div>

        <div class="form-group">
          <label for="mensagem">Mensagem para nós</label>
          <textarea id="mensagem" name="mensagem" placeholder="Fale conosco" required></textarea>
        </div>

        <button type="submit" class="btn-submit">Enviar</button>

      </form>
    </div>
  </main>

  <?php require_once("rodape.php") ?>

  <script src="JS%20(Gustavo)/animacao_bolha.js"></script>
</body>
</html>