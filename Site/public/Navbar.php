<?php
if (session_id() == '') {
    session_start();
}

require_once("../conexao/conexao.php");

$pagina_atual = basename($_SERVER['PHP_SELF']);

function nav_active($pagina, $atual) {
    return $pagina === $atual ? 'class="active"' : '';
}

// Busca a foto de perfil atualizada do usuário logado, se houver
$foto_navbar = '';
if (isset($_SESSION["usuario_Logado"])) {
    $uid_nav = (int)$_SESSION["usuario_Logado"];
    $stmt_nav = mysqli_prepare($conecta, "SELECT foto_perfil FROM usuarios WHERE id = ?");
    mysqli_stmt_bind_param($stmt_nav, "i", $uid_nav);
    mysqli_stmt_execute($stmt_nav);
    $res_nav = mysqli_stmt_get_result($stmt_nav);
    if ($row_nav = mysqli_fetch_assoc($res_nav)) {
        $foto_navbar = $row_nav['foto_perfil'];
    }
    mysqli_stmt_close($stmt_nav);
}
?>

<!-- BARRA DE MENU PARA OS LINKS -->
<header class="navbar">
  <div class="logo">
    <a href="index.php">
      <img src="../Imagens/favicon.png" alt="Logo RG Eats">
    </a>
    <span>RG Eats</span>
  </div>
  <ul class="nav-links">
    <li><a href="index.php"     <?php echo nav_active('index.php',     $pagina_atual); ?>>Início</a></li>
    <li><a href="estoque.php"   <?php echo nav_active('estoque.php',   $pagina_atual); ?>>Estoque</a></li>
    <li><a href="sobrenos.php"  <?php echo nav_active('sobrenos.php',  $pagina_atual); ?>>Sobre nós</a></li>
    <li><a href="parceiros.php" <?php echo nav_active('parceiros.php', $pagina_atual); ?>>Parceiros</a></li>
    <li><a href="contato.php"   <?php echo nav_active('contato.php',   $pagina_atual); ?>>Contato</a></li>
  </ul>
  
  <div class="nav-actions">
    <?php if (isset($_SESSION["usuario_Logado"])): ?>
      <?php  
        $nome_usuario = isset($_SESSION["nome_usuario"]) ? $_SESSION["nome_usuario"] : 'U';
        $inicial = strtoupper(substr($nome_usuario, 0, 1));
      ?>
      <div class="user-menu-container">
        <a href="perfil.php" class="user-avatar-btn" title="<?php echo htmlspecialchars($nome_usuario, ENT_QUOTES, 'UTF-8'); ?>" style="<?php echo !empty($foto_navbar) ? 'padding: 0; overflow: hidden;' : ''; ?>">
          <?php if (!empty($foto_navbar)): ?>
            <img src="../<?php echo htmlspecialchars($foto_navbar, ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
          <?php else: ?>
            <?php echo $inicial; ?>
          <?php endif; ?>
        </a>
      </div>
    <?php else: ?>
      <a href="tela_login.php" class="btn-entrar">Entrar</a>
      <a href="registrar.php" class="btn-registrar">Registrar-se</a>
    <?php endif; ?>
  </div>
</header>