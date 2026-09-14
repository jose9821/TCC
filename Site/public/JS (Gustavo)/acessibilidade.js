/**
 * Área da Acessibilidade - RG Eats
 * -----------------------------------------------------------------
 * Controla o botão flutuante e o painel de acessibilidade.
 * As preferências ficam salvas em localStorage e são reaplicadas
 * automaticamente em qualquer página do site que carregue este script.
 */
(function () {
  "use strict";

  const CHAVE_STORAGE = "rgeats_acessibilidade";

  const PADRAO = {
    altoContraste: false,
    modoEscuro: false,
    linksSublinhados: false,
    fonteLegivel: false,
    semAnimacao: false,
    fonteNivel: 0 // -2 a +3 (passos de 10%)
  };

  const NIVEIS_FONTE = {
    "-2": "acess-fonte-m2",
    "-1": "acess-fonte-m1",
    "0": null,
    "1": "acess-fonte-p1",
    "2": "acess-fonte-p2",
    "3": "acess-fonte-p3"
  };

  function carregarPreferencias() {
    try {
      const salvo = localStorage.getItem(CHAVE_STORAGE);
      if (!salvo) return Object.assign({}, PADRAO);
      return Object.assign({}, PADRAO, JSON.parse(salvo));
    } catch (e) {
      return Object.assign({}, PADRAO);
    }
  }

  function salvarPreferencias(prefs) {
    try {
      localStorage.setItem(CHAVE_STORAGE, JSON.stringify(prefs));
    } catch (e) {
      /* localStorage indisponível: as opções continuam funcionando
         na página atual, só não são lembradas entre páginas. */
    }
  }

  // Detecta se o navegador suporta "zoom" em CSS (Chrome, Edge, Safari).
  // Se não suportar (Firefox), usamos transform:scale como alternativa.
  const SUPORTA_ZOOM = (function () {
    const teste = document.createElement("div");
    teste.style.zoom = "1.1";
    return teste.style.zoom === "1.1";
  })();

  function aplicarFonte(nivel) {
    const html = document.documentElement;

    // Remove classes de zoom anteriores
    Object.values(NIVEIS_FONTE).forEach(function (classe) {
      if (classe) html.classList.remove(classe);
    });
    html.style.transform = "";
    html.style.transformOrigin = "";
    html.style.width = "";

    const classe = NIVEIS_FONTE[String(nivel)];
    if (!classe) return;

    if (SUPORTA_ZOOM) {
      html.classList.add(classe);
    } else {
      // Fallback para Firefox: escala visual sem cortar a página
      const escala = parseFloat(getComputedStyle(html).zoom) || 1;
      const fatorMap = { "-2": 0.8, "-1": 0.9, "1": 1.1, "2": 1.2, "3": 1.3 };
      const fator = fatorMap[String(nivel)] || 1;
      html.style.transformOrigin = "top left";
      html.style.transform = "scale(" + fator + ")";
      html.style.width = (100 / fator) + "%";
    }
  }

  function aplicarPreferencias(prefs) {
    const body = document.body;
    body.classList.toggle("acess-alto-contraste", !!prefs.altoContraste);
    body.classList.toggle("acess-modo-escuro", !!prefs.modoEscuro);
    body.classList.toggle("acess-links-sublinhados", !!prefs.linksSublinhados);
    body.classList.toggle("acess-fonte-legivel", !!prefs.fonteLegivel);
    body.classList.toggle("acess-sem-animacao", !!prefs.semAnimacao);
    aplicarFonte(prefs.fonteNivel || 0);

    // Sincroniza os botões visuais (aria-pressed) com o estado atual
    document.querySelectorAll(".acessibilidade-opcao[data-acao]").forEach(function (btn) {
      const acao = btn.getAttribute("data-acao");
      const mapa = {
        "alto-contraste": prefs.altoContraste,
        "modo-escuro": prefs.modoEscuro,
        "destacar-links": prefs.linksSublinhados,
        "fonte-legivel": prefs.fonteLegivel,
        "pausar-animacoes": prefs.semAnimacao
      };
      if (acao in mapa) {
        btn.setAttribute("aria-pressed", mapa[acao] ? "true" : "false");
      }
    });
  }

  function iniciar() {
    let prefs = carregarPreferencias();
    aplicarPreferencias(prefs);

    const btnAbrir = document.getElementById("btnAcessibilidade");
    const painel = document.getElementById("painelAcessibilidade");
    const btnFechar = document.getElementById("fecharAcessibilidade");

    if (!btnAbrir || !painel) return; // widget não presente nesta página

    let ultimoFoco = null;

    function abrirPainel() {
      ultimoFoco = document.activeElement;
      painel.hidden = false;
      btnAbrir.setAttribute("aria-expanded", "true");
      const primeiroFocavel = painel.querySelector(
        "button, [href], input, select, textarea, [tabindex]:not([tabindex='-1'])"
      );
      if (primeiroFocavel) primeiroFocavel.focus();
      document.addEventListener("keydown", aoTeclarNoPainel, true);
      document.addEventListener("click", aoClicarFora, true);
    }

    function fecharPainel() {
      painel.hidden = true;
      btnAbrir.setAttribute("aria-expanded", "false");
      document.removeEventListener("keydown", aoTeclarNoPainel, true);
      document.removeEventListener("click", aoClicarFora, true);
      if (ultimoFoco) ultimoFoco.focus();
    }

    function aoClicarFora(evento) {
      if (!painel.contains(evento.target) && evento.target !== btnAbrir) {
        fecharPainel();
      }
    }

    // Fecha com Esc e mantém o foco preso dentro do painel (Tab / Shift+Tab)
    function aoTeclarNoPainel(evento) {
      if (evento.key === "Escape") {
        fecharPainel();
        return;
      }
      if (evento.key === "Tab") {
        const focaveis = Array.prototype.slice.call(
          painel.querySelectorAll(
            "button, [href], input, select, textarea, [tabindex]:not([tabindex='-1'])"
          )
        ).filter(function (el) { return !el.disabled && el.offsetParent !== null; });

        if (focaveis.length === 0) return;

        const primeiro = focaveis[0];
        const ultimo = focaveis[focaveis.length - 1];

        if (evento.shiftKey && document.activeElement === primeiro) {
          evento.preventDefault();
          ultimo.focus();
        } else if (!evento.shiftKey && document.activeElement === ultimo) {
          evento.preventDefault();
          primeiro.focus();
        }
      }
    }

    btnAbrir.addEventListener("click", function () {
      if (painel.hidden) abrirPainel();
      else fecharPainel();
    });

    if (btnFechar) btnFechar.addEventListener("click", fecharPainel);

    // Botões liga/desliga (alto contraste, modo escuro, etc.)
    painel.querySelectorAll(".acessibilidade-opcao[data-acao]").forEach(function (btn) {
      btn.addEventListener("click", function () {
        const acao = btn.getAttribute("data-acao");
        const mapaChave = {
          "alto-contraste": "altoContraste",
          "modo-escuro": "modoEscuro",
          "destacar-links": "linksSublinhados",
          "fonte-legivel": "fonteLegivel",
          "pausar-animacoes": "semAnimacao"
        };
        const chave = mapaChave[acao];
        if (!chave) return;

        // Alto contraste e modo escuro são mutuamente exclusivos
        if (chave === "altoContraste" && !prefs.altoContraste) prefs.modoEscuro = false;
        if (chave === "modoEscuro" && !prefs.modoEscuro) prefs.altoContraste = false;

        prefs[chave] = !prefs[chave];
        salvarPreferencias(prefs);
        aplicarPreferencias(prefs);
      });
    });

    // Fonte: aumentar / diminuir / resetar
    const btnMais = document.getElementById("fonteAumentar");
    const btnMenos = document.getElementById("fonteDiminuir");
    const btnResetFonte = document.getElementById("fonteResetar");

    if (btnMais) btnMais.addEventListener("click", function () {
      prefs.fonteNivel = Math.min(3, (prefs.fonteNivel || 0) + 1);
      salvarPreferencias(prefs);
      aplicarPreferencias(prefs);
    });

    if (btnMenos) btnMenos.addEventListener("click", function () {
      prefs.fonteNivel = Math.max(-2, (prefs.fonteNivel || 0) - 1);
      salvarPreferencias(prefs);
      aplicarPreferencias(prefs);
    });

    if (btnResetFonte) btnResetFonte.addEventListener("click", function () {
      prefs.fonteNivel = 0;
      salvarPreferencias(prefs);
      aplicarPreferencias(prefs);
    });

    // Restaurar tudo
    const btnResetarTudo = document.getElementById("resetarAcessibilidade");
    if (btnResetarTudo) btnResetarTudo.addEventListener("click", function () {
      prefs = Object.assign({}, PADRAO);
      salvarPreferencias(prefs);
      aplicarPreferencias(prefs);
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", iniciar);
  } else {
    iniciar();
  }
})();
