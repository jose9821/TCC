<?php require_once("Navbar.php") ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mapa - RG Eats</title>
<link rel="stylesheet" href="CSS%20(Ryan)/style.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body>

  <main class="map-hero-container">
    <h1>Mapa de nossa cidade</h1>
    <p>Venha ver mais sobre Rio Grande!</p>
    
    <div class="bubbles" id="bubblesContainer"></div>

    <div class="map-box" style="min-height: 600px;">
      <div id="mapaCidade" style="height: 600px; width: 100%; min-height: 600px; border-radius: 16px; z-index: 1;"></div>
    </div>
  </main>

  <?php require_once("rodape.php") ?>

  <script src="JS%20(Gustavo)/animacao_bolha.js"></script>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="JS%2520(Gustavo)/mapa_rgs.js"></script>

</body>
</html>