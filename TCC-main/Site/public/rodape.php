<!-- CSS PARA TER UMA BASE E PRA FICAR BONITO POR ENQUANTO-->
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
  
  body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #ffffff;
    color: #1a1a1a;
    line-height: 1.5;
  }
 
  /* ===== NAVBAR (VERDE) ===== */
  .menu {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #6de866;
    padding: 12px 5%;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  }
  
  .menu .logo {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 800;
    font-size: 20px;
    color: #1a1a1a;
  }
  
  /* TAMANHO DA LOGO NA NAVBAR */
  .menu .logo img { 
    height: 40px; 
    width: auto; 
    object-fit: contain;
  }
  
  .menu .menu-links {
    display: flex;
    gap: 24px;
    list-style: none;
  }
  
  .menu .menu-links li a {
    text-decoration: none;
    color: #1a1a1a;
    font-size: 14px;
    font-weight: 600;
    transition: opacity 0.2s;
  }
  .menu .menu-links li a:hover { opacity: 0.7; }
  
  .menu .menu-actions {
    display: flex;
    gap: 10px;
    align-items: center;
  }
  
  .btn-entrar {
    background: #e9e9e9;
    color: #1a1a1a;
    border: none;
    padding: 8px 18px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
  }
  .btn-entrar:hover { background: #dcdcdc; }
  
  .btn-registrar {
    background: #2b2b2b;
    color: #fff;
    border: none;
    padding: 8px 18px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
  }
  .btn-registrar:hover { background: #1a1a1a; }
 
  /* ===== HERO (AZUL ROYAL + ROXO) - quadrado grande azul ===== */
  .hero {
    background: #0096ff;
    padding: 60px 20px 70px;
    text-align: center;
  }
  
  .hero-title-box {
    display: inline-block;
    border: 3px solid #8f4bff;
    background: rgba(255, 255, 255, 0.1);
    padding: 12px 36px;
    border-radius: 8px;
    margin-bottom: 16px;
    backdrop-filter: blur(4px);
  }
  
  .hero-title-box h1 {
    font-size: 36px;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: 0.5px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.15);
  }
  
  .hero p.subtitle {
    color: #f3ecff;
    font-size: 16px;
    font-weight: 500;
  }
 
  /* ===== PHOTO ===== */
  .photo-wrapper {
    max-width: 1000px;
    margin: -30px auto 40px;
    padding: 0 20px;
  }

  .hero-photo {
    width: 100%;
    max-height: 420px;
    display: block;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  }
 
  /* ===== EQUIPE ===== */
  .team-section {
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px 24px 60px;
    text-align: center;
  }
  
  .team-section h2 {
    font-size: 26px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 4px;
  }
  
  .team-section .team-subtitle {
    color: #71717a;
    font-size: 14px;
    margin-bottom: 32px;
  }
  
  .team-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
  }
  
  .team-card {
    background: #ffffff;
    border: 1px solid #e2e2e2;
    border-radius: 10px;
    padding: 16px;
    width: 230px;
    text-align: left;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    transition: transform 0.2s, box-shadow 0.2s;
  }
  
  .team-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.08);
  }

  .team-card h3 {
    font-size: 14px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 12px;
    min-height: 38px;
    display: flex;
    align-items: center;
  }
  
  .team-card .member-row {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  
  .avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #2b2b2b;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  
  .avatar img {
  width: 100%;
  height: 100%;
  border-radius: 50%; 
  object-fit: cover;  
}
  
  .member-info .username {
    font-size: 13px;
    font-weight: 700;
    color: #0096ff;
  }
  
  .member-info .role {
    font-size: 11px;
    color: #666666;
    line-height: 1.3;
  }
 
  /* ===== rodape ===== */
  footer {
    background: #00c0e8;
    color: #ffffff;
    padding: 40px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    text-align: center;
  }

  #logoRodape {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    cursor: pointer;
  }

  /* O TAMANHO DA LOGO NO RODAPÉ */
  #logoRodape img {
    height: 48px;
    width: auto;
    object-fit: contain;
  }

  #logoRodape h3 {
    font-size: 24px;
    font-weight: 800;
    color: #ffffff;
  }

  footer .Texto {
    font-size: 14px;
    line-height: 1.6;
    color: #f0f9ff;
    max-width: 600px;
  }
 
  /* ===== RESPONSIVO ===== */
  @media (max-width: 768px) {
    .menu .menu-links { display: none; }
    .hero-title-box h1 { font-size: 26px; }
    .hero-photo { max-height: 250px; }
    .photo-wrapper { margin-top: -15px; }
  }
    </style>


<!-- Rodape -->
<footer>
        <div id="logoRodape" onclick="window.location=''">
            <img src="../Imagens/Logo1(Sem%20Fundo).png" alt="Logo RG Eats">
            <h3>RG Eats</h3>
        </div>
        <div class="Texto">
            Conteúdo desenvolvido pelo Professor José Victor para ser utilizado durante as aulas.<br>
            Etec RGS<br>
            Feito Por Raphael Pierre, Thiago Russo, Jose Vitor, Gustavo e Ryan Gonçalves <br>
        </div>
    </footer>
