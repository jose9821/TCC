<?php require_once("Navbar.php"); ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contato - RG Eats</title>
<link rel="stylesheet" href="CSS%20(Ryan)/style.css">
</head>
<body>

  <!-- SEÇÃO PRINCIPAL (CONTATO) -->
  <main class="contact-section">
    <h1>Deseja nos contatar?</h1>
    <p class="subtitle">Insira seu nome e nos comunique!</p>

    <!-- CARD DO FORMULÁRIO -->
    <div class="contact-card">
      <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Mensagem enviada com sucesso!');">
        
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

</body>
</html>