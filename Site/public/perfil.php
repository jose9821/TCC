<?php
session_start();
if (!isset($_SESSION["usuario_Logado"])) {
    header("Location: tela_login.php");
    exit;
}

require_once("../conexao/conexao.php");

$user_id = $_SESSION["usuario_Logado"];
$msg = '';
$erro = '';

// Processamento de Ações do Perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = isset($_POST['acao']) ? $_POST['acao'] : '';

    // 1. Atualizar Foto de Perfil
    if ($acao === 'atualizar_foto') {
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['foto']['tmp_name'];
            $fileName = $_FILES['foto']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = 'user_' . $user_id . '_' . time() . '.' . $fileExtension;
                $uploadFileDir = '../Imagens/Perfis/';
                
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0755, true);
                }
                
                $dest_path = $uploadFileDir . $newFileName;
                
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $stmt = mysqli_prepare($conecta, "UPDATE usuarios SET foto_perfil = ? WHERE id = ?");
                    $db_path = 'Imagens/Perfis/' . $newFileName;
                    mysqli_stmt_bind_param($stmt, "si", $db_path, $user_id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    $msg = "Foto de perfil atualizada com sucesso!";
                } else {
                    $erro = "Erro ao mover o arquivo enviado.";
                }
            } else {
                $erro = "Formato de imagem inválido. Use JPG, JPEG, PNG ou WEBP.";
            }
        } else {
            $erro = "Nenhuma imagem válida selecionada.";
        }
    }

    // 2. Trocar Senha
    elseif ($acao === 'trocar_senha') {
        $senha_atual = isset($_POST['senha_atual']) ? $_POST['senha_atual'] : '';
        $nova_senha = isset($_POST['nova_senha']) ? $_POST['nova_senha'] : '';
        $confirmar_senha = isset($_POST['confirmar_senha']) ? $_POST['confirmar_senha'] : '';

        $stmt = mysqli_prepare($conecta, "SELECT senha FROM usuarios WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $dados_user = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);

        if ($dados_user && password_verify($senha_atual, $dados_user['senha'])) {
            if (strlen($nova_senha) < 6) {
                $erro = "A nova senha deve ter pelo menos 6 caracteres.";
            } elseif ($nova_senha !== $confirmar_senha) {
                $erro = "A nova senha e a confirmação não coincidem.";
            } else {
                $novo_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                $up = mysqli_prepare($conecta, "UPDATE usuarios SET senha = ? WHERE id = ?");
                mysqli_stmt_bind_param($up, "si", $novo_hash, $user_id);
                if (mysqli_stmt_execute($up)) {
                    $msg = "Senha alterada com sucesso!";
                } else {
                    $erro = "Erro ao atualizar a senha no banco de dados.";
                }
                mysqli_stmt_close($up);
            }
        } else {
            $erro = "A senha atual está incorreta.";
        }
    }

    // 3. Excluir Conta
    elseif ($acao === 'excluir_conta') {
        $del = mysqli_prepare($conecta, "DELETE FROM usuarios WHERE id = ?");
        mysqli_stmt_bind_param($del, "i", $user_id);
        mysqli_stmt_execute($del);
        mysqli_stmt_close($del);

        session_destroy();
        header("Location: index.php");
        exit;
    }
}

// Buscar dados atuais do usuário
$stmt = mysqli_prepare($conecta, "SELECT nome, email, login, tipo, criado_em, foto_perfil FROM usuarios WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

require_once("Navbar.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - RG Eats</title>
    <link rel="icon" type="image/png" href="../Imagens/Logo/favicon.ico">
    <link rel="stylesheet" href="CSS%20(Ryan)/style.css">
    <link rel="stylesheet" href="CSS%20(Ryan)/acessibilidade.css">
    <style>
        .profile-card-container { display: flex; flex-direction: column; gap: 20px; }
        .profile-avatar-box { text-align: center; margin-bottom: 5px; }
        .profile-avatar { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #2196C4; margin-bottom: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
        .section-box { background: #f8fafc; padding: 20px; border-radius: 16px; border: 1px solid #e2e8f0; }
        .section-box h3 { font-size: 16px; color: #1B2D6B; margin-bottom: 15px; font-weight: 700; }
    </style>
</head>
<body class="login-page profile-page">
    <div class="bubbles" id="bubblesContainer"></div>

    <div class="login-wrapper">
        <a href="index.php" class="back-link">← Voltar para o início</a>

        <div class="login-card profile-card-container">
            <div class="login-header" style="margin-bottom: 0;">
                <h2>Meu Perfil</h2>
                <p>Gerencie suas informações e segurança</p>
            </div>

            <?php if (!empty($msg)): ?>
                <div class="login-error-message" style="background:#f0fff4;border-color:#9ae6b4;">
                    <p style="color:#276749;"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($erro)): ?>
                <div class="login-error-message">
                    <p><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            <?php endif; ?>

            <!-- Avatar e Formulário de Foto Customizado -->
            <div class="profile-avatar-box">
                <?php if (!empty($usuario['foto_perfil'])): ?>
                    <img src="../<?php echo htmlspecialchars($usuario['foto_perfil'], ENT_QUOTES, 'UTF-8'); ?>" alt="Foto de perfil" class="profile-avatar">
                <?php else: ?>
                    <img src="https://via.placeholder.com/100?text=Perfil" alt="Foto padrão" class="profile-avatar">
                <?php endif; ?>
                
                <form action="perfil.php" method="POST" enctype="multipart/form-data" class="profile-upload-form">
                    <input type="hidden" name="acao" value="atualizar_foto">
                    
                    <div class="file-upload-wrapper">
                        <input type="file" name="foto" id="file-upload" accept="image/*" required onchange="document.getElementById('file-chosen').textContent = this.files[0].name">
                        <label for="file-upload" class="file-upload-btn-custom">Escolher imagem de perfil</label>
                        <span id="file-chosen">Nenhum arquivo escolhido</span>
                    </div>

                    <button type="submit" class="btn-submit" style="margin-top: 0; padding: 12px; font-size: 14px;">Atualizar Foto de Perfil</button>
                </form>
            </div>

            <!-- Informações Pessoais -->
            <div class="profile-details section-box">
                <h3>Informações Pessoais</h3>
                <p><strong>Nome:</strong> <?= htmlspecialchars($usuario['nome']); ?></p>
                <p><strong>Login:</strong> <?= htmlspecialchars($usuario['login']); ?></p>
                <p><strong>E-mail:</strong> <?= htmlspecialchars($usuario['email']); ?></p>
                <p><strong>Tipo de Conta:</strong> <?= ucfirst(htmlspecialchars($usuario['tipo'])); ?></p>
                <p><strong>Membro desde:</strong> <?= date('d/m/Y', strtotime($usuario['criado_em'])); ?></p>
            </div>

            <!-- Alterar Senha -->
            <div class="section-box">
                <h3>Alterar Senha</h3>
                <form action="perfil.php" method="POST">
                    <input type="hidden" name="acao" value="trocar_senha">
                    <div class="form-group">
                        <label for="senha_atual">Senha Atual</label>
                        <div class="password-container">
                            <input type="password" id="senha_atual" name="senha_atual" placeholder="Digite sua senha atual" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('senha_atual', this)" aria-label="Mostrar ou ocultar senha">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1B2D6B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nova_senha">Nova Senha</label>
                        <div class="password-container">
                            <input type="password" id="nova_senha" name="nova_senha" placeholder="Mínimo 6 caracteres" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('nova_senha', this)" aria-label="Mostrar ou ocultar senha">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1B2D6B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirmar_senha">Confirmar Nova Senha</label>
                        <div class="password-container">
                            <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Repita a nova senha" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('confirmar_senha', this)" aria-label="Mostrar ou ocultar senha">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1B2D6B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Salvar Nova Senha</button>
                </form>
            </div>

            <!-- Ações de Conta -->
            <div style="display: flex; gap: 10px;">
                <a href="logout.php" class="btn-submit" style="text-align: center; text-decoration: none; flex: 1; background: #1B2D6B; color: #fff; margin: 0; display: flex; align-items: center; justify-content: center;">Sair da Conta</a>
                
                <form action="perfil.php" method="POST" onsubmit="return confirm('Tem certeza que deseja EXCLUIR permanentemente a sua conta? Esta ação não pode ser desfeita!');" style="flex: 1; margin: 0;">
                    <input type="hidden" name="acao" value="excluir_conta">
                    <button type="submit" class="btn-submit" style="width: 100%; background: #e53e3e; color: #fff; margin: 0; border: none;">Excluir Conta</button>
                </form>
            </div>

        </div>
    </div>

    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            
            const svgOlhoAberto = `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1B2D6B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
            
            const svgOlhoFechado = `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1B2D6B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`;

            if (input.type === "password") {
                input.type = "text";
                btn.innerHTML = svgOlhoFechado;
            } else {
                input.type = "password";
                btn.innerHTML = svgOlhoAberto;
            }
        }
    </script>
    <script src="JS%20(Gustavo)/animacao_bolha.js"></script>
    <script src="JS%20(Gustavo)/acessibilidade.js" defer></script>
<?php require_once("acessibilidade.php"); ?>
</body>
</html>