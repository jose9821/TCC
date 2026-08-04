<?php require_once("Navbar.php") ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mapa - RG Eats</title>
<link rel="stylesheet" href="CSS%20(Ryan)/style.css">
</head>
<body>

  <main class="map-hero-container">
    <h1>Mapa de nossa cidade</h1>
    <p>Venha ver mais sobre Rio Grande!</p>
    
    <div class="bubbles" id="bubblesContainer"></div>

    <div class="map-box">
      <img src="../Imagens/mapa_rio_grande.png" alt="Mapa de Rio Grande da Serra">
    </div>
  </main>

  <?php require_once("rodape.php") ?>

  <script src="JS%20(Gustavo)/animacao_bolha.js"></script>

</body>
</html>