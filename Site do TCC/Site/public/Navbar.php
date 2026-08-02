<?php
// Detecta automaticamente qual página está ativa
$pagina_atual = basename($_SERVER['PHP_SELF']);

function nav_active($pagina, $atual) {
    return $pagina === $atual ? 'class="active"' : '';
}
?>

<!-- BARRA DE MENU PARA OS LINKS -->
<header class="navbar">
  <div class="logo">
    <a href="index.php">
      <img src="../Imagens/Logo1(Sem%20Fundo).png" alt="Logo RG Eats">
    </a>
    <span>RG Eats</span>
  </div>
  <ul class="nav-links">
    <li><a href="index.php"     <?= nav_active('index.php',     $pagina_atual) ?>>Início</a></li>
    <li><a href="sobrenos.php"  <?= nav_active('sobrenos.php',  $pagina_atual) ?>>Sobre nós</a></li>
    <li><a href="parceiros.php" <?= nav_active('parceiros.php', $pagina_atual) ?>>Parceiros</a></li>
    <li><a href="mapa.php"      <?= nav_active('mapa.php',      $pagina_atual) ?>>Mapa</a></li>
    <li><a href="contato.php"   <?= nav_active('contato.php',   $pagina_atual) ?>>Contato</a></li>
  </ul>
  <div class="nav-actions">
    <a href="tela_login.php" class="btn-entrar">Entrar</a>
    <a href="registro.php" class="btn-registrar">Registrar-se</a>
  </div>
</header>