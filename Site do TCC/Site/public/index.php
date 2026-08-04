<?php require_once("Navbar.php");
require_once ("../conexao/conexao.php"); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RG Eats</title>
    <link rel="stylesheet" href="CSS%20(Ryan)/style.css">
</head>
<body>
    <section class="hero">
     <div class="hero-title-box">
      <h1>RG Eats</h1>
    </div>
    <p class="subtitle"><?php echo htmlspecialchars ("Redistribuição de Alimentos em Rio Grande da Serra"); ?></p>
  </section>
    
    <div class="photo-wrapper">
    <img class="hero-photo" src="../Imagens/cachoira rio grande.JPG" alt="Cachoeira em Rio Grande da Serra">
  </div>
 
  <!-- FOTOS NOSSAS -->
  <section class="team-section">
    <h2><?php echo htmlspecialchars ("Equipe de Desenvolvimento");?></h2>
    <p class="team-subtitle"><?php echo htmlspecialchars ("Membros e papel de cada um");?></p>
 
    <div class="team-grid">
     <div class="team-card">
  <h3><?php echo htmlspecialchars ("Thiago Siqueira Russo");?></h3>
  <div class="member-row">
    <div class="avatar">
      <img src="../Imagens/batatadeperfil.jpg" alt="Thiago Siqueira Russo">
    </div>
    
    <div class="member-info">
      <div class="username"><?php echo htmlspecialchars ("Te Rasgo");?></div>
      <div class="role"><?php echo htmlspecialchars ("Prototipagem e Design");?></div>
    </div>
  </div>
</div>
 
      <div class="team-card">
        <h3><?php echo htmlspecialchars ("José Vitor dos Santos Pereira");?></h3>
        <div class="member-row">
          <div class="avatar">
            <img src="../Imagens/batatadeperfil.jpg" alt="José Vitor dos Santos Pereira">
          </div>
          <div class="member-info">
            <div class="username"><?php echo htmlspecialchars ("Gozé");?></div>
            <div class="role"><?php echo htmlspecialchars ("Idealizador do Projeto");?></div>
          </div>
        </div>
      </div>
 
      <div class="team-card">
        <h3><?php echo htmlspecialchars ("Raphael Pierre Lima");?></h3>
        <div class="member-row">
          <div class="avatar">
            <img src="../Imagens/batatadeperfil.jpg" alt="Raphael Pierre Lima da Silva">
          </div>
          <div class="member-info">
            <div class="username"><?php echo htmlspecialchars ("Jesus");?></div>
            <div class="role"><?php echo htmlspecialchars ("Prototipagem e Vídeo");?></div>
          </div>
        </div>
      </div>
 
      <div class="team-card">
        <h3><?php echo htmlspecialchars ("Ryan Rodrigues Goncalves");?></h3>
        <div class="member-row">
          <div class="avatar">
           <img src="../Imagens/batatadeperfil.jpg" alt="Ryan Rodrigues Goncalves">
          </div>
          <div class="member-info">
            <div class="username"><?php echo htmlspecialchars ("Ryanzito");?></div>
            <div class="role"><?php echo htmlspecialchars ("Código e Testes");?></div>
          </div>
        </div>
      </div>
 
      <div class="team-card">
        <h3><?php echo htmlspecialchars ("Gustavo Alves dos Santos");?></h3>
        <div class="member-row">
          <div class="avatar">
        <img src="../Imagens/batatadeperfil.jpg" alt="Gustavo Alves dos Santos">
          </div>
          <div class="member-info">
            <div class="username"><?php echo htmlspecialchars ("Gustavinho");?></div>
            <div class="role"><?php echo htmlspecialchars ("Suporte e Testes");?></div>
          </div>
        </div>
      </div>
    </div>
  </section>
    
   
    
<?php require_once("rodape.php");?>
    
</body>
</html>
