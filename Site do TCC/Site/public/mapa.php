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

  <!-- SEÇÃO PRINCIPAL (FUNDO AZUL CONTINUO) -->
  <main class="map-hero-container">
    <h1>Mapa de nossa cidade</h1>
    <p>Venha ver mais sobre Rio Grande!</p>

    <!-- EXIBIÇÃO DO MAPA -->
    <div class="map-box">
      <img src="../Imagens/mapa_rio_grande.png" alt="Mapa de Rio Grande da Serra"> <!-- COLOCAR A API DO GOOGLE MAPS COM JS -->
    </div>
  </main>


<?php require_once("rodape.php") ?>

</body>
</html>