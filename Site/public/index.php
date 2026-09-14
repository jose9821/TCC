<?php require_once("Navbar.php");
require_once ("../conexao/conexao.php"); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RG Eats</title>
    <link rel="stylesheet" href="CSS%20(Ryan)/style.css">
	<link rel="stylesheet" href="CSS%20(Ryan)/acessibilidade.css">
    <script src="JS%20(Gustavo)/animacao_bolha.js"></script>
    <script src="JS%20(Gustavo)/carrossel.js" defer></script>
</head>
<body>
    <section class="hero">
     <div class="hero-title-box">
      <h1>RG Eats</h1>
    </div>
    <p class="subtitle"><?php echo htmlspecialchars ("Redistribuição de Alimentos em Rio Grande da Serra"); ?></p>
  </section>

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

    
    <div class="photo-wrapper">
    <div class="carrossel" id="carrossel">
      <div class="carrossel-track" id="carrosselTrack">
        <img class="carrossel-img" src="../Imagens/carrossel/comida.jpg" alt="Alimentação escolar">
        <img class="carrossel-img" src="../Imagens/carrossel/letreiro.jpg" alt="Letreiro de boas-vindas a Rio Grande da Serra">
        <img class="carrossel-img" src="../Imagens/carrossel/comida_2.jpg" alt="Alimentação escolar">
      </div>
    </div>
  </div>

  <div class="bubbles" id="bubblesContainer"></div>
  
  <!-- FOTOS NOSSAS -->
  <section class="team-section">
    <h2><?php echo htmlspecialchars ("Equipe de Desenvolvimento");?></h2>
    <p class="team-subtitle"><?php echo htmlspecialchars ("Membros e papel de cada um");?></p>
 
    <div class="team-grid">
     <div class="team-card">
  <h3><?php echo htmlspecialchars ("Thiago Siqueira Russo");?></h3>
  <div class="member-row">
    <div class="avatar">
      <img src="../Imagens/integrantes/thiago.jpg" alt="Thiago Siqueira Russo">
    </div>
    
    <div class="member-info">
      <!-- <div class="username"><?php //echo htmlspecialchars ("Te Rasgo");?></div> -->
      <div class="role"><?php echo htmlspecialchars ("Prototipagem e Design");?></div>
    </div>
  </div>
</div>
 
      <div class="team-card">
        <h3><?php echo htmlspecialchars ("José Vitor dos Santos Pereira");?></h3>
        <div class="member-row">
          <div class="avatar">
            <img src="../Imagens/integrantes/jose.jpg" alt="José Vitor dos Santos Pereira">
          </div>
          <div class="member-info">
        <!--    <div class="username"><?php //echo htmlspecialchars ("Gozé");?></div> -->
            <div class="role"><?php echo htmlspecialchars ("Idealizador do Projeto");?></div>
          </div>
        </div>
      </div>
 
      <div class="team-card">
        <h3><?php echo htmlspecialchars ("Raphael Pierre Lima");?></h3>
        <div class="member-row">
          <div class="avatar">
            <img src="../Imagens/integrantes/raphael.png" alt="Raphael Pierre Lima da Silva">
          </div>
          <div class="member-info">
            <!-- <div class="username"><?php //echo htmlspecialchars ("Jesus");?></div> -->
            <div class="role"><?php echo htmlspecialchars ("Prototipagem e Vídeo");?></div>
          </div>
        </div>
      </div>
 
      <div class="team-card">
        <h3><?php echo htmlspecialchars ("Ryan Rodrigues Goncalves");?></h3>
        <div class="member-row">
          <div class="avatar">
           <img src="../Imagens/integrantes/ryan.png" alt="Ryan Rodrigues Goncalves">
          </div>
          <div class="member-info">
            <!-- <div class="username"><?php// echo htmlspecialchars ("Ryanzito");?></div> -->
            <div class="role"><?php echo htmlspecialchars ("Código e Testes");?></div>
          </div>
        </div>
      </div>
 
      <div class="team-card">
        <h3><?php echo htmlspecialchars ("Gustavo Alves dos Santos");?></h3>
        <div class="member-row">
          <div class="avatar">
        <img src="../Imagens/integrantes/gustavo.jpg" alt="Gustavo Alves dos Santos">
          </div>
          <div class="member-info">
            <!-- <div class="username"><?php// echo htmlspecialchars ("Gustavinho");?></div> -->
            <div class="role"><?php echo htmlspecialchars ("Suporte e Testes");?></div>
          </div>
        </div>
      </div>
    </div>
  </section>
    
   
    
<?php require_once("rodape.php");?>
    
</body>
</html>
