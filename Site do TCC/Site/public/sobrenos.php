<?php require_once("Navbar.php") ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sobre Nós - RG Eats</title>
<link rel="stylesheet" href="CSS%20(Ryan)/style.css">
</head>
<body>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-title-box">
      <h1>Quem somos nós?</h1>
    </div>
    <p class="subtitle">Venha descobrir sobre nossa equipe</p>
  </section>

  <!-- CONTEÚDO PRINCIPAL -->
  <main class="main-container">
    
    <!-- GALERIA ETEC -->
    <div class="etec-gallery">
      <img src="../Imagens/Etecrio.jpg" alt="Fachada da Etec Rio Grande da Serra" class="etec-img">
      <img src="../Imagens/logoetec.jpg" alt="Logo Etec Rio Grande da Serra" class="etec-img">
    </div>

    <!-- SOBRE A RG EATS -->
    <section class="about-text-section">
      <div class="about-card">
        <h2>Sobre a RG Eats</h2>
        <p>
          Somos uma equipe que trabalha com o aproveitamento de alimentos que seriam descartados, mas que ainda se encontram em condições de consumo, propondo um sistema de coleta, triagem, reaproveitamento e redistribuição desses itens para pessoas em situação de vulnerabilidade social no município de Rio Grande da Serra, estado de São Paulo. A pesquisa busca articular políticas de doação de alimentos, redução do desperdício e segurança alimentar por meio da oferta de refeições nutritivas a partir de alimentos reaproveitados. Trabalhamos para que contribuam com a construção de uma política pública local de combate ao desperdício e à fome.
        </p>
      </div>
    </section>

    <!-- IMAGEM DA SALADA/ALIMENTOS -->
    <div class="food-banner">
      <img src="../Imagens/circulo alimentar.png" alt="Círculo de Alimentos Nutritivos">
    </div>

    <!-- MISSÃO, VISÃO E VALORES -->
    <section class="mvv-section">
      <h2>Missão, Visão e Valores</h2>

      <div class="mvv-grid">
        <!-- CARD MISSÃO -->
        <div class="mvv-card">
          <svg class="mvv-icon" viewBox="0 0 24 24" fill="none" stroke="#19b956" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <circle cx="12" cy="12" r="6"/>
            <circle cx="12" cy="12" r="2"/>
          </svg>
          <h3>Missão</h3>
          <p>Reciclagem de alimentos para doação e redistribuição dos recursos por meio de um website acessível.</p>
        </div>

        <!-- CARD VISÃO -->
        <div class="mvv-card">
          <svg class="mvv-icon" viewBox="0 0 24 24" fill="none" stroke="#19b956" stroke-width="2">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>
          </svg>
          <h3>Visão</h3>
          <p>Ser referência sobre reciclagem e doação de alimentos para pessoas carentes em Rio Grande da Serra.</p>
        </div>

        <!-- CARD VALORES -->
        <div class="mvv-card">
          <svg class="mvv-icon" viewBox="0 0 24 24" fill="none" stroke="#19b956" stroke-width="2">
            <path d="M6 3h12l4 6-10 12L2 9z"/>
            <path d="M11 3v18M2 9h20"/>
          </svg>
          <h3>Valores</h3>
          <ul class="mvv-list">
            <li><strong>Transparência:</strong> Clareza nas informações</li>
            <li><strong>Inovação:</strong> Soluções criativas e rápidas</li>
            <li><strong>Compromisso Social:</strong> Bem da comunidade</li>
            <li><strong>Colaboração:</strong> Participação ativa</li>
          </ul>
        </div>
      </div>
    </section>

  </main>

  <?php require_once("rodape.php");?>

</body>
</html>