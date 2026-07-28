<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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