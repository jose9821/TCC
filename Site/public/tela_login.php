<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <!-- CSS PARA TER UMA BASE E PRA FICAR BONITO POR ENQUANTO-->
    <style>
        /* Configurações Globais / Identidade Cartoon Network */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Impact', 'Arial Black', sans-serif; /* Fonte robusta estilo letreiro */
            background-color: #000000;
            /* Fundo baseado na identidade visual clássica quadriculada do CN */
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
            border-bottom: 5px solid #ffffff; /* Borda grossa marcante */
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

        /* AJUSTADO: Alinhamento flexbox da imagem + texto */
        .logo {
            display: flex;
            align-items: center;
            gap: 10px; /* Espaço entre o quadrado da imagem e o texto */
            font-size: 28px; /* Ajuste suave para acompanhar a altura da imagem */
            font-weight: 900;
            color: #000000;
            background: #ffffff;
            padding: 4px 16px;
            border: 4px solid #000000;
            box-shadow: 5px 5px 0px #ff4655; /* Sombra sólida sem desfoque */
            text-transform: uppercase;
            transform: rotate(-3deg);
            letter-spacing: -1px;
        }

        /* NOVO: Estilização dedicada para a imagem dentro da logo do cabeçalho */
        .logo img {
            height: 35px; /* Altura controlada proporcional ao cabeçalho */
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

        /* Conteúdo Principal */
        main {
            margin-top: 80px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
            padding: 40px 20px;
        }

        /* Formulário em Bloco de Quadrinhos */
        form {
            background: #ffffff;
            border: 5px solid #000000;
            padding: 40px 35px;
            width: 100%;
            max-width: 420px;
            box-shadow: 12px 12px 0px #00aaff; /* Sombra pop-art sólida */
            position: relative;
            text-align: center;
        }

        /* Título estilizado estilo Pop-up */
        h2 {
            font-family: 'Impact', sans-serif;
            font-size: 36px;
            color: #000000;
            background: #ffffff;
            border: 4px solid #000000;
            padding: 5px 20px;
            display: inline-block;
            text-transform: uppercase;
            transform: rotate(-2deg);
            box-shadow: 4px 4px 0px #ff4655;
            margin-bottom: 35px;
            letter-spacing: 1px;
        }

        /* Inputs estilizados com traços grossos */
        input {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 20px;
            border: 4px solid #000000;
            background: #f0f0f0;
            color: #000000;
            font-family: Arial, sans-serif;
            font-weight: bold;
            font-size: 15px;
            outline: none;
            transition: transform 0.1s ease, background-color 0.1s ease;
        }

        input::placeholder {
            color: #777777;
            text-transform: uppercase;
            font-size: 13px;
        }

        input:focus {
            background: #ffffff;
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0px #000000;
        }

        /* Botão Sólido Impactante */
        button {
            width: 100%;
            padding: 16px;
            background: #ff4655;
            color: #ffffff;
            border: 4px solid #000000;
            font-family: 'Impact', sans-serif;
            font-size: 20px;
            letter-spacing: 1px;
            cursor: pointer;
            margin-top: 10px;
            text-transform: uppercase;
            box-shadow: 5px 5px 0px #000000;
            transition: transform 0.1s ease, box-shadow 0.1s ease;
        }

        button:hover {
            background: #000000;
            color: #ffffff;
            box-shadow: 5px 5px 0px #00aaff;
            transform: translate(-2px, -2px);
        }

        button:active {
            transform: translate(2px, 2px);
            box-shadow: 1px 1px 0px #000000;
        }

        /* Caixa de Erro Estilo Alerta de Vilão */
        .msg-erro {
            background: #ff4655;
            color: #ffffff;
            border: 3px solid #000000;
            padding: 12px;
            font-family: Arial, sans-serif;
            font-weight: bold;
            font-size: 13px;
            text-transform: uppercase;
            margin-bottom: 25px;
            box-shadow: 4px 4px 0px #000000;
            transform: rotate(1deg);
        }
                                   
        footer {
            background-color: #ffffff; /* Fundo branco contrastando com o header preto */
            color: #000000;
            padding: 40px 20px;
            text-align: center;
            font-family: 'Impact', 'Arial Black', sans-serif;
            border-top: 5px solid #000000; /* Borda grossa preta */
            margin-top: 60px;
            box-shadow: 0px -10px 0px #00aaff; /* Faixa de sombra azul sólida acima do rodapé */
            width: 100%;
        }

        #logoRodape {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            cursor: pointer;
            background: #000000; /* Caixa preta para a logo */
            padding: 10px 20px;
            border: 4px solid #000000;
            box-shadow: 6px 6px 0px #ff4655; /* Sombra sólida vermelha estilo CN */
            transform: rotate(-1.5deg); /* Leve inclinação cartoon */
            transition: transform 0.1s ease, box-shadow 0.1s ease;
        }

        #logoRodape:hover {
            transform: scale(1.03) rotate(1deg);
            box-shadow: 6px 6px 0px #00aaff; /* Muda a cor da sombra no hover */
        }

        #logoRodape img {
            height: 40px;
            border: 2px solid #ffffff;
            border-radius: 0px; /* Quadrado seco clássico */
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
            text-transform: uppercase; /* Textos em caixa alta casam melhor com a proposta */
            letter-spacing: 0.5px;
        }
    </style>
</head>

<body>
    <a href="index.php"> <?php echo htmlspecialchars ("Deseja voltar? Clique aqui?")?> </a> <!--MUDAR A URL DO LINK!!!-->
    <main>
        <form action="tela_login.php" method="post">
            <h2>Use seu Login</h2>
            <input type="text" name="usuario" placeholder="Usuário">
            <input type="password" name="senha" placeholder="Senha">
            <input type="submit" value="Login">
            <?php /*   //VARIÁVEIS CASO DÊ ERRO QUE VAI APARECER QUANDO O BD ESTIVER PRONTO!!!
            if (isset($mensagem)) {
                ?>
                <p> <?php echo $mensagem ?> </p>
                <?php
            }
            */?> 
        </form>
    </main>
</body>

</html>
