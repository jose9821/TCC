<?php require_once("Navbar.php") ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parceiros - RG Eats</title>
<link rel="stylesheet" href="CSS%20(Ryan)/style.css">

</head>
<body>

  <!-- HERO -->
  <section class="hero">
      <div class="hero-title-box">
    <h1>Nossos apoiadores</h1>
       </div>
    <p>Veja nossas escolas parceiras!</p>
  </section>

  <!-- CONTEÚDO PRINCIPAL -->
  <main class="main-container">
    
    <p class="intro-text">
      A RG Eats conta com o apoio de escolas da região, cada uma contribuindo com sua área de excelência para fortalecer diferentes frentes do projeto.
    </p>

    <!-- LISTA DE PARCEIROS -->
    <section class="partners-section">
      <h2>Nossos Parceiros:</h2>
      
      <ul class="partners-list">
        <li>
          <strong>• ETEC de Rio Grande da Serra (Sede):</strong> Sendo a unidade central, ela atua como o centro de inteligência e coordenação do projeto. O suporte foca na gestão administrativa e na articulação com a prefeitura e órgãos locais, garantindo que a logística de arrecadação esteja em conformidade com as normas municipais.
        </li>
        <li>
          <strong>• Escola Antonio Lucas:</strong> Com um perfil voltado à tecnologia e automação, esta unidade auxilia no desenvolvimento de soluções inteligentes para o controle de estoque dos alimentos doados. Elas ajudam a garantir que nada perca a validade, otimizando a distribuição para as famílias que mais precisam.
        </li>
        <li>
          <strong>• EMEF Cassiano Ricardo:</strong> Esta unidade destaca-se pelo apoio na comunicação e mobilização comunitária. Através de projetos de marketing social, os alunos e professores ajudam a divulgar as campanhas de arrecadação, sensibilizando o comércio local e os moradores sobre a importância do combate à insegurança alimentar.
        </li>
        <li>
          <strong>• E.E Edmundo Luiz de Nobrega Teixeira:</strong> Focada na operação e infraestrutura, a Edmundo Luiz serve como um ponto estratégico de triagem e armazenamento temporário. Sua equipe técnica orienta sobre as melhores práticas de manuseio e segurança alimentar, garantindo que as doações cheguem à mesa com a máxima qualidade.
        </li>
      </ul>
    </section>

    <!-- MAPA -->
    <section class="map-section">
      <h2>Localização no mapa</h2>
      
      <div class="map-wrapper">
        <img src="../Imagens/mapa_parceiros.png" alt="Mapa com a localização das escolas parceiras em Rio Grande da Serra"> <!--COLOCAR API DO GOOGLE MAPS COM JS -->
      </div>
    </section>

  </main>

  <?php require_once("rodape.php") ?>

</body>
</html>