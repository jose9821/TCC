<?php
// session_status() não existe no PHP antigo (< 5.4). 
// Usamos session_id() para verificar se a sessão já foi iniciada.
if (session_id() == '') {
    session_start();
}

// basename e $_SERVER funcionam normalmente no PHP antigo
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
   
    <li><a href="index.php"     <?php echo nav_active('index.php',     $pagina_atual); ?>>Início</a></li>
    <li><a href="sobrenos.php"  <?php echo nav_active('sobrenos.php',  $pagina_atual); ?>>Sobre nós</a></li>
    <li><a href="parceiros.php" <?php echo nav_active('parceiros.php', $pagina_atual); ?>>Parceiros</a></li>
    <li><a href="contato.php"   <?php echo nav_active('contato.php',   $pagina_atual); ?>>Contato</a></li>
  </ul>
  
  <div class="nav-actions">
    <?php if (isset($_SESSION["usuario_Logado"])): ?>
      <?php  
        // Substituído o operador ?? por operador ternário clássico
        // Substituído mb_substr por substr (assume UTF-8 básico ou ambiente sem mbstring)
        $nome_usuario = isset($_SESSION["nome_usuario"]) ? $_SESSION["nome_usuario"] : 'U';
        $inicial = strtoupper(substr($nome_usuario, 0, 1));
      ?>
      <div class="user-menu-container">
        <button class="user-avatar-btn" title="<?php echo htmlspecialchars($nome_usuario, ENT_QUOTES, 'UTF-8'); ?>">
          <?php echo $inicial; ?>
        </button>
        <div class="user-dropdown">
          <div class="dropdown-header">
            <strong><?php echo htmlspecialchars($nome_usuario, ENT_QUOTES, 'UTF-8'); ?></strong>
          </div>
          <a href="perfil.php">Meu Perfil</a>
          <a href="../conexao/logout.php" class="logout-link">Sair</a>
        </div>
      </div>
    <?php else: ?>
      <a href="tela_login.php" class="btn-entrar">Entrar</a>
      <a href="registrar.php" class="btn-registrar">Registrar-se</a>
    <?php endif; ?>
  </div>
</header>