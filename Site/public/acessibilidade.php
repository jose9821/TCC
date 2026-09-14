<?php
/**
 * Área da Acessibilidade - RG Eats
 * -----------------------------------------------------------------
 * Inclua este arquivo no lugar do widget do VLibras, em todas as páginas:
 *
 *   <?php require_once("acessibilidade.php"); ?>
 *
 * E garanta que, no <head> de cada página, existam:
 *   <link rel="stylesheet" href="CSS%20(Ryan)/acessibilidade.css">
 * E antes do fechamento do </body>:
 *   <script src="JS%20(Gustavo)/acessibilidade.js" defer></script>
 *
 * (ajuste os caminhos conforme a pasta onde você salvar os arquivos)
 */
?>
<!-- ===================== BOTÃO DE ACESSIBILIDADE ===================== -->
<div class="acessibilidade-widget">

  <button
    type="button"
    id="btnAcessibilidade"
    class="acessibilidade-btn"
    aria-haspopup="dialog"
    aria-expanded="false"
    aria-controls="painelAcessibilidade"
  >
    <svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" width="24" height="24"
         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="4" r="2"></circle>
      <path d="M19 7c-2.3 1-4.6 1.5-7 1.5S7.3 8 5 7"></path>
      <path d="M12 8.5V14"></path>
      <path d="M8.5 21l2-6.5h3l2 6.5"></path>
      <path d="M6.5 12.5L12 11l5.5 1.5"></path>
    </svg>
    <span class="acessibilidade-btn-label">Acessibilidade</span>
  </button>

  <!-- ===================== PAINEL ===================== -->
  <div
    id="painelAcessibilidade"
    class="acessibilidade-painel"
    role="dialog"
    aria-modal="true"
    aria-labelledby="tituloAcessibilidade"
    hidden
  >
    <div class="acessibilidade-painel-header">
      <h2 id="tituloAcessibilidade">Área da Acessibilidade</h2>
      <button type="button" id="fecharAcessibilidade" class="acessibilidade-fechar" aria-label="Fechar painel de acessibilidade">
        &times;
      </button>
    </div>

    <div class="acessibilidade-painel-body">

      <section class="acessibilidade-grupo" aria-labelledby="tituloGrupoContraste">
        <h3 id="tituloGrupoContraste">Contraste e cores</h3>
        <div class="acessibilidade-opcoes">
          <button type="button" class="acessibilidade-opcao" data-acao="alto-contraste" aria-pressed="false">
            <span>Alto Contraste</span>
          </button>
          <button type="button" class="acessibilidade-opcao" data-acao="modo-escuro" aria-pressed="false">
            <span>Modo Escuro</span>
          </button>
        </div>
      </section>

      <section class="acessibilidade-grupo" aria-labelledby="tituloGrupoFonte">
        <h3 id="tituloGrupoFonte">Tamanho do texto</h3>
        <div class="acessibilidade-opcoes acessibilidade-fonte-controles">
          <button type="button" id="fonteDiminuir" class="acessibilidade-opcao" aria-label="Diminuir tamanho da fonte">
            A&minus;
          </button>
          <button type="button" id="fonteResetar" class="acessibilidade-opcao" aria-label="Restaurar tamanho de fonte padrão">
            A
          </button>
          <button type="button" id="fonteAumentar" class="acessibilidade-opcao" aria-label="Aumentar tamanho da fonte">
            A&plus;
          </button>
        </div>
      </section>

      <section class="acessibilidade-grupo" aria-labelledby="tituloGrupoLeitura">
        <h3 id="tituloGrupoLeitura">Leitura e navegação</h3>
        <div class="acessibilidade-opcoes">
          <button type="button" class="acessibilidade-opcao" data-acao="destacar-links" aria-pressed="false">
            <span>Sublinhar Links</span>
          </button>
          <button type="button" class="acessibilidade-opcao" data-acao="fonte-legivel" aria-pressed="false">
            <span>Fonte Legível</span>
          </button>
          <button type="button" class="acessibilidade-opcao" data-acao="pausar-animacoes" aria-pressed="false">
            <span>Pausar Animações</span>
          </button>
        </div>
      </section>

      <button type="button" id="resetarAcessibilidade" class="acessibilidade-resetar">
        Restaurar tudo ao padrão
      </button>

      <p class="acessibilidade-nota">
        Suas preferências ficam salvas neste navegador e valem para todas as páginas do RG Eats.
      </p>
    </div>
  </div>
</div>
