<?php
// ============================================================
// RG Eats - Estoque e Doações
// Qualquer visitante VÊ o estoque. Só usuários 'admin' EDITAM.
// ============================================================
if (session_id() == '') {
    session_start();
}
require_once("../conexao/conexao.php");
mysqli_report(MYSQLI_REPORT_OFF);

$eh_admin = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin';

if (empty($_SESSION['csrf_estoque'])) {
    $_SESSION['csrf_estoque'] = bin2hex(openssl_random_pseudo_bytes(16));
}

$unidades = array('kg', 'g', 'L', 'un', 'cx');

// ---------- Processa ações do administrador (antes de qualquer HTML) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ok  = false;
    $msg = 'Não foi possível concluir a ação.';

    $token = isset($_POST['csrf']) ? $_POST['csrf'] : '';
    if (!$eh_admin) {
        $msg = 'Apenas administradores podem alterar o estoque.';
    } elseif (!hash_equals($_SESSION['csrf_estoque'], $token)) {
        $msg = 'Sessão expirada. Recarregue a página e tente de novo.';
    } else {
        $acao = isset($_POST['acao']) ? $_POST['acao'] : '';

        if ($acao === 'adicionar') {
            $nome = trim(isset($_POST['nome']) ? $_POST['nome'] : '');
            $cat  = (isset($_POST['categoria']) && $_POST['categoria'] === 'perecivel') ? 'perecivel' : 'nao_perecivel';
            $uni  = isset($_POST['unidade']) ? $_POST['unidade'] : '';
            $qtd  = str_replace(',', '.', isset($_POST['quantidade']) ? $_POST['quantidade'] : '');
            $val  = trim(isset($_POST['validade']) ? $_POST['validade'] : '');
            $loc  = trim(isset($_POST['local']) ? $_POST['local'] : '');

            $val_ok = true;
            if ($val !== '') {
                $p = explode('-', $val);
                $val_ok = (count($p) === 3 && checkdate((int)$p[1], (int)$p[2], (int)$p[0]));
            } else {
                $val = null;
            }

            if ($nome === '' || strlen($nome) > 100) {
                $msg = 'Informe o nome do alimento (até 100 caracteres).';
            } elseif (!in_array($uni, $unidades, true)) {
                $msg = 'Unidade inválida.';
            } elseif (!is_numeric($qtd) || $qtd < 0) {
                $msg = 'Quantidade inválida.';
            } elseif (!$val_ok) {
                $msg = 'Data de validade inválida.';
            } else {
                $loc = ($loc === '') ? null : substr($loc, 0, 120);
                $qtd = (float)$qtd;
                $st = mysqli_prepare($conecta, "INSERT INTO estoque_alimentos (nome_produto, categoria, unidade, quantidade, data_validade, local_armazenamento) VALUES (?, ?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($st, "sssdss", $nome, $cat, $uni, $qtd, $val, $loc);
                $ok = mysqli_stmt_execute($st);
                mysqli_stmt_close($st);
                $msg = $ok ? 'Alimento adicionado ao estoque.' : 'Erro ao salvar o alimento.';
            }

        } elseif ($acao === 'atualizar') {
            $id  = (int)(isset($_POST['id']) ? $_POST['id'] : 0);
            $qtd = str_replace(',', '.', isset($_POST['quantidade']) ? $_POST['quantidade'] : '');
            if ($id < 1 || !is_numeric($qtd) || $qtd < 0) {
                $msg = 'Quantidade inválida.';
            } else {
                $qtd = (float)$qtd;
                $st = mysqli_prepare($conecta, "UPDATE estoque_alimentos SET quantidade = ? WHERE id = ?");
                mysqli_stmt_bind_param($st, "di", $qtd, $id);
                $ok = mysqli_stmt_execute($st);
                mysqli_stmt_close($st);
                $msg = $ok ? 'Quantidade atualizada.' : 'Erro ao atualizar.';
            }

        } elseif ($acao === 'remover') {
            $id = (int)(isset($_POST['id']) ? $_POST['id'] : 0);
            if ($id < 1) {
                $msg = 'Item inválido.';
            } else {
                $st = mysqli_prepare($conecta, "DELETE FROM estoque_alimentos WHERE id = ?");
                mysqli_stmt_bind_param($st, "i", $id);
                $ok = mysqli_stmt_execute($st);
                mysqli_stmt_close($st);
                $msg = $ok ? 'Item removido.' : 'Erro ao remover.';
            }

        } elseif ($acao === 'total') {
            $kg = str_replace(',', '.', isset($_POST['total_kg']) ? $_POST['total_kg'] : '');
            if (!is_numeric($kg) || $kg < 0) {
                $msg = 'Valor de quilos inválido.';
            } else {
                $kg = (float)$kg;
                $st = mysqli_prepare($conecta, "INSERT INTO doacoes_total (id, total_kg) VALUES (1, ?) ON DUPLICATE KEY UPDATE total_kg = VALUES(total_kg)");
                mysqli_stmt_bind_param($st, "d", $kg);
                $ok = mysqli_stmt_execute($st);
                mysqli_stmt_close($st);
                $msg = $ok ? 'Total de quilos doados atualizado.' : 'Erro ao atualizar o total.';
            }
        }
    }

    $_SESSION['flash_estoque'] = array('ok' => $ok, 'msg' => $msg);
    header("Location: estoque.php#conteudo");
    exit;
}

$flash = null;
if (isset($_SESSION['flash_estoque'])) {
    $flash = $_SESSION['flash_estoque'];
    unset($_SESSION['flash_estoque']);
}

// ---------- Consultas ----------
$total_kg = 0;
$tabela_ok = true;
$r = mysqli_query($conecta, "SELECT total_kg FROM doacoes_total WHERE id = 1");
if ($r === false) {
    $tabela_ok = false; // tabelas ainda não criadas (rode estoque_setup.sql)
} else {
    $linha = mysqli_fetch_assoc($r);
    $total_kg = $linha ? (float)$linha['total_kg'] : 0;
}

$itens = array();
if ($tabela_ok) {
    $r = mysqli_query($conecta, "SELECT id, nome_produto, categoria, unidade, quantidade, data_validade, local_armazenamento FROM estoque_alimentos ORDER BY (data_validade IS NULL), data_validade ASC, nome_produto ASC");
    if ($r) {
        while ($l = mysqli_fetch_assoc($r)) {
            $itens[] = $l;
        }
    }
}

// Situação da validade: texto + cor (nunca só cor, por acessibilidade)
function situacao_validade($data) {
    if (empty($data)) {
        return array('sem', 'Sem validade informada', '');
    }
    $hoje = strtotime(date('Y-m-d'));
    $dias = (int)floor((strtotime($data) - $hoje) / 86400);
    if ($dias < 0) {
        return array('vencido', 'Vencido', 'há ' . abs($dias) . ($dias === -1 ? ' dia' : ' dias'));
    }
    if ($dias === 0) {
        return array('atencao', 'Vence hoje', '');
    }
    if ($dias <= 7) {
        return array('atencao', 'Vence em breve', 'em ' . $dias . ($dias === 1 ? ' dia' : ' dias'));
    }
    return array('ok', 'Dentro da validade', 'em ' . $dias . ' dias');
}

$qtd_vencidos = 0;
$qtd_atencao  = 0;
foreach ($itens as $i) {
    $s = situacao_validade($i['data_validade']);
    if ($s[0] === 'vencido') { $qtd_vencidos++; }
    if ($s[0] === 'atencao') { $qtd_atencao++; }
}

function fmt_num($n) {
    return number_format((float)$n, 2, ',', '.');
}
function h($t) {
    return htmlspecialchars((string)$t, ENT_QUOTES, 'UTF-8');
}

require_once("Navbar.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque e Doações - RG Eats</title>
    <link rel="stylesheet" href="CSS%20(Ryan)/style.css">
    <link rel="stylesheet" href="CSS%20(Ryan)/acessibilidade.css">
    <link rel="stylesheet" href="CSS%20(Ryan)/estoque.css">
    <link rel="icon" type="image/png" href="../Imagens/Logo/favicon.ico">
    <script src="JS%20(Gustavo)/animacao_bolha.js"></script>
</head>
<body>
    <a class="skip-link" href="#conteudo">Pular para o conteúdo</a>

    <section class="hero">
        <div class="hero-title-box">
            <h1>Estoque e Doações</h1>
        </div>
        <p class="subtitle">Acompanhe os alimentos armazenados, suas validades e o total já doado</p>
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

    <div class="bubbles" id="bubblesContainer"></div>

    <main class="main-container" id="conteudo" tabindex="-1">

        <?php if ($flash): ?>
            <div class="estoque-aviso <?php echo $flash['ok'] ? 'estoque-aviso-ok' : 'estoque-aviso-erro'; ?>" role="status">
                <?php echo h($flash['msg']); ?>
            </div>
        <?php endif; ?>

        <?php if (!$tabela_ok): ?>
            <div class="estoque-aviso estoque-aviso-erro" role="alert">
                As tabelas do estoque ainda não foram criadas. Execute o arquivo <strong>estoque_setup.sql</strong> no banco de dados.
            </div>
        <?php endif; ?>

        <!-- RESUMO -->
        <section class="estoque-resumo" aria-labelledby="titulo-resumo">
            <h2 id="titulo-resumo" class="visually-hidden-estoque">Resumo</h2>
            <div class="estoque-card estoque-destaque">
                <p class="estoque-card-rotulo">Total já doado</p>
                <p class="estoque-card-valor"><?php echo fmt_num($total_kg); ?> kg</p>
                <p class="estoque-card-nota">Alimentos entregues a pessoas em situação de vulnerabilidade em Rio Grande da Serra</p>
            </div>
            <div class="estoque-card">
                <p class="estoque-card-rotulo">Itens em estoque</p>
                <p class="estoque-card-valor"><?php echo count($itens); ?></p>
            </div>
            <div class="estoque-card">
                <p class="estoque-card-rotulo">Vencendo em até 7 dias</p>
                <p class="estoque-card-valor"><?php echo $qtd_atencao; ?></p>
            </div>
            <div class="estoque-card">
                <p class="estoque-card-rotulo">Vencidos</p>
                <p class="estoque-card-valor"><?php echo $qtd_vencidos; ?></p>
            </div>
        </section>

        <!-- TABELA -->
        <section class="estoque-secao" aria-labelledby="titulo-tabela">
            <h2 id="titulo-tabela">Controle de estoque e validade</h2>
            <p class="estoque-legenda-texto">Ordenado pela validade: o que vence primeiro aparece no topo, para ser distribuído antes.</p>

            <?php if (count($itens) === 0): ?>
                <p class="estoque-vazio">Nenhum alimento cadastrado no estoque no momento.</p>
            <?php else: ?>
            <div class="estoque-tabela-wrap" role="region" aria-label="Tabela de estoque (rolável)" tabindex="0">
                <table class="estoque-tabela">
                    <caption class="visually-hidden-estoque">Alimentos em estoque, com quantidade, validade e local de armazenamento</caption>
                    <thead>
                        <tr>
                            <th scope="col">Alimento</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Validade</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Local</th>
                            <?php if ($eh_admin): ?><th scope="col">Ações</th><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($itens as $i):
                        $s = situacao_validade($i['data_validade']); ?>
                        <tr>
                            <th scope="row"><?php echo h($i['nome_produto']); ?></th>
                            <td><?php echo $i['categoria'] === 'perecivel' ? 'Perecível' : 'Não perecível'; ?></td>
                            <td><?php echo fmt_num($i['quantidade']) . ' ' . h($i['unidade']); ?></td>
                            <td><?php echo $i['data_validade'] ? date('d/m/Y', strtotime($i['data_validade'])) : '—'; ?></td>
                            <td>
                                <span class="estoque-selo estoque-selo-<?php echo $s[0]; ?>"><?php echo h($s[1]); ?></span>
                                <?php if ($s[2] !== ''): ?><span class="estoque-selo-extra"><?php echo h($s[2]); ?></span><?php endif; ?>
                            </td>
                            <td><?php echo $i['local_armazenamento'] ? h($i['local_armazenamento']) : '—'; ?></td>
                            <?php if ($eh_admin): ?>
                            <td class="estoque-acoes">
                                <form method="post" action="estoque.php" class="estoque-form-inline">
                                    <input type="hidden" name="csrf" value="<?php echo h($_SESSION['csrf_estoque']); ?>">
                                    <input type="hidden" name="acao" value="atualizar">
                                    <input type="hidden" name="id" value="<?php echo (int)$i['id']; ?>">
                                    <label for="qtd-<?php echo (int)$i['id']; ?>" class="visually-hidden-estoque">Nova quantidade de <?php echo h($i['nome_produto']); ?></label>
                                    <input type="text" inputmode="decimal" id="qtd-<?php echo (int)$i['id']; ?>" name="quantidade" value="<?php echo h(number_format((float)$i['quantidade'], 2, ',', '')); ?>" required>
                                    <button type="submit" class="estoque-btn estoque-btn-sec">Salvar</button>
                                </form>
                                <form method="post" action="estoque.php" class="estoque-form-inline" onsubmit="return confirm('Remover este item do estoque?');">
                                    <input type="hidden" name="csrf" value="<?php echo h($_SESSION['csrf_estoque']); ?>">
                                    <input type="hidden" name="acao" value="remover">
                                    <input type="hidden" name="id" value="<?php echo (int)$i['id']; ?>">
                                    <button type="submit" class="estoque-btn estoque-btn-perigo" aria-label="Remover <?php echo h($i['nome_produto']); ?>">Remover</button>
                                </form>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </section>

        <?php if ($eh_admin): ?>
        <!-- PAINEL DO ADMINISTRADOR -->
        <section class="estoque-secao" aria-labelledby="titulo-admin">
            <h2 id="titulo-admin">Painel do administrador</h2>

            <div class="estoque-admin-grid">
                <form method="post" action="estoque.php" class="estoque-admin-form">
                    <h3>Atualizar total doado (kg)</h3>
                    <input type="hidden" name="csrf" value="<?php echo h($_SESSION['csrf_estoque']); ?>">
                    <input type="hidden" name="acao" value="total">
                    <div class="form-group">
                        <label for="total_kg">Total de quilos doados</label>
                        <input type="text" inputmode="decimal" id="total_kg" name="total_kg" value="<?php echo h(number_format($total_kg, 2, ',', '')); ?>" required>
                    </div>
                    <button type="submit" class="btn-submit">Salvar total</button>
                </form>

                <form method="post" action="estoque.php" class="estoque-admin-form">
                    <h3>Adicionar alimento</h3>
                    <input type="hidden" name="csrf" value="<?php echo h($_SESSION['csrf_estoque']); ?>">
                    <input type="hidden" name="acao" value="adicionar">

                    <div class="form-group">
                        <label for="nome">Nome do alimento</label>
                        <input type="text" id="nome" name="nome" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Tipo</label>
                        <select id="categoria" name="categoria">
                            <option value="nao_perecivel">Não perecível</option>
                            <option value="perecivel">Perecível</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantidade">Quantidade</label>
                        <input type="text" inputmode="decimal" id="quantidade" name="quantidade" required>
                    </div>
                    <div class="form-group">
                        <label for="unidade">Unidade</label>
                        <select id="unidade" name="unidade">
                            <option value="kg">Quilos (kg)</option>
                            <option value="g">Gramas (g)</option>
                            <option value="L">Litros (L)</option>
                            <option value="un">Unidades</option>
                            <option value="cx">Caixas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="validade">Validade (opcional)</label>
                        <input type="date" id="validade" name="validade">
                    </div>
                    <div class="form-group">
                        <label for="local">Local de armazenamento (opcional)</label>
                        <input type="text" id="local" name="local" maxlength="120" placeholder="Ex.: E.E Edmundo Luiz de Nobrega Teixeira">
                    </div>
                    <button type="submit" class="btn-submit">Adicionar ao estoque</button>
                </form>
            </div>
        </section>
        <?php endif; ?>

    </main>

    <?php require_once("rodape.php"); ?>
    <?php require_once("acessibilidade.php"); ?>
    <script src="JS%20(Gustavo)/acessibilidade.js" defer></script>
</body>
</html>