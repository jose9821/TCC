   <!-- BARRA DE MENU PARA OS LINKS -->
    <header>
        <div class="logo">
            <img src="../Imagens/Logo1(Sem%20Fundo).png" alt="Logo RG Eats">
           RG Eats
        </div>
        
        <!-- CSS PARA TER UMA BASE E PRA FICAR BONITO POR ENQUANTO-->
    <style>
        /* Configurações Globais / Identidade Cartoon Network */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Impact', 'Arial Black', sans-serif;
            background-color: #000000;
            /* Fundo clássico quadriculado estilo CN de blocos */
            background-image: 
                linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)),
                radial-gradient(#ff4655 20%, transparent 20%),
                radial-gradient(#00aaff 20%, transparent 20%);
            background-size: 100% 100%, 40px 40px, 40px 40px;
            background-position: 0 0, 0 0, 20px 20px;
            background-attachment: fixed;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Menu em Bloco Sólido */
        header {
            background: #000000;
            border-bottom: 5px solid #ffffff;
            padding: 0 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 80px;
            z-index: 1000;
        }

        /* AJUSTADO: Agora suporta a imagem e o texto alinhados lado a lado */
        .logo {
            display: flex;
            align-items: center;
            gap: 10px; /* Espaço entre a imagem e o texto */
            font-size: 28px; /* Reduzido levemente para caber melhor com a imagem */
            font-weight: 900;
            color: #000000;
            background: #ffffff;
            padding: 4px 16px;
            border: 4px solid #000000;
            box-shadow: 5px 5px 0px #ff4655;
            text-transform: uppercase;
            transform: rotate(-3deg);
            letter-spacing: -1px;
            text-decoration: none; /* Caso você queira transformar a logo num link depois */
        }

        /* NOVO: Controla o tamanho da imagem da logo no cabeçalho */
        .logo img {
            height: 35px; /* Altura ideal para a barra de 80px */
            width: auto;
            border: 2px solid #000000;
            background-color: #ffffff;
        }

        .menu a {
            color: #ffffff;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
            margin-left: 15px;
            padding: 10px 20px;
            border: 3px solid #ffffff;
            background: #000000;
            box-shadow: 4px 4px 0px #00aaff;
            transition: transform 0.1s ease, box-shadow 0.1s ease;
            display: inline-block;
        }

        .menu a:hover {
            background: #ff4655;
            color: #000000;
            border-color: #000000;
            box-shadow: 4px 4px 0px #ffffff;
            transform: translate(-2px, -2px);
        }

        /* Container Principal */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 140px auto 40px auto;
            flex-grow: 1;
        }

        /* Box de Bem-Vindo Estilo Banner CN */
        .bem-vindo {
            background: #00aaff;
            border: 5px solid #000000;
            color: #000000;
            padding: 20px 30px;
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 8px 8px 0px #ffffff;
        }

        .bem-vindo h2 {
            font-size: 26px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .bem-vindo h2 span {
            color: #ffffff;
            background: #000000;
            padding: 2px 12px;
            display: inline-block;
            transform: rotate(-1deg);
        }

        .bem-vindo p {
            font-family: Arial, sans-serif;
            font-weight: 900;
            font-size: 14px;
            color: #ffffff;
            background: #000000;
            padding: 8px 16px;
            border: 3px solid #000000;
            box-shadow: 4px 4px 0px #ff4655;
        }

        /* Grid de Exibição */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }

        /* Card Individual em formato de Bloco HQ */
        .card {
            background: #ffffff;
            border: 5px solid #000000;
            border-radius: 0px;
            box-shadow: 10px 10px 0px #ff4655;
            transition: all 0.15s ease;
            display: flex;
            flex-direction: column;
        }

        .card:hover {
            transform: translate(-4px, -4px);
            box-shadow: 14px 14px 0px #00aaff;
        }

        /* Wrapper de Imagem */
        .card-img-wrapper {
            width: 100%;
            height: 230px;
            overflow: hidden;
            border-bottom: 5px solid #000000;
            background-color: #1a1a2e;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* Conteúdo Interno do Card / Estilização Textual */
        .card-content {
            font-family: Arial, sans-serif;
            padding: 24px;
            color: #000000;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card h2 {
            font-family: 'Impact', sans-serif;
            font-size: 28px;
            color: #000000;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.1;
        }

        .card p.sinopse {
            font-size: 14px;
            color: #222222;
            line-height: 1.5;
            margin-bottom: 20px;
            flex-grow: 1;
            font-weight: bold;
        }

        .card .info-meta {
            font-size: 14px;
            color: #000000;
            margin-bottom: 6px;
            font-weight: 800;
        }

        .card .info-meta strong {
            color: #ff4655;
            text-transform: uppercase;
        }

        /* Badge de Gênero Colado como Adesivo */
        .genero {
            align-self: flex-start;
            margin-top: 16px;
            background: #000000;
            color: #ffffff;
            border: 3px solid #000000;
            padding: 6px 16px;
            font-family: 'Impact', sans-serif;
            font-size: 14px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transform: rotate(3deg);
            box-shadow: 4px 4px 0px rgba(0,0,0,0.2);
        }

        .no-data {
            text-align: center;
            grid-column: 1 / -1;
            padding: 40px;
            color: #ffffff;
            font-size: 22px;
            text-transform: uppercase;
            text-shadow: 3px 3px 0px #ff4655;
        }
        
        footer {
            background-color: #ffffff;
            color: #000000;
            padding: 40px 20px;
            text-align: center;
            font-family: 'Impact', 'Arial Black', sans-serif;
            border-top: 5px solid #000000;
            margin-top: 60px;
            box-shadow: 0px -10px 0px #00aaff;
            width: 100%;
        }

        #logoRodape {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            cursor: pointer;
            background: #000000;
            padding: 10px 20px;
            border: 4px solid #000000;
            box-shadow: 6px 6px 0px #ff4655;
            transform: rotate(-1.5deg);
            transition: transform 0.1s ease, box-shadow 0.1s ease;
        }

        #logoRodape:hover {
            transform: scale(1.03) rotate(1deg);
            box-shadow: 6px 6px 0px #00aaff;
        }

        #logoRodape img {
            height: 40px;
            border: 2px solid #ffffff;
            border-radius: 0px;
            background-color: #ffffff;
        }

        #logoRodape h3 {
            font-size: 24px;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }

        .Texto {
            font-family: Arial, sans-serif;
            font-size: 13px;
            font-weight: bold;
            line-height: 1.6;
            color: #333333;
            max-width: 600px;
            margin: 15px auto 0 auto;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
        <div class="menu">
            <a href="index.php">Home</a>
            <a href="tela_login.php">Login</a>
            <a href="">Sobre nós</a>
        </div>
    </header> 
