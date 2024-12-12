<?php
include_once './config/config.php';
include_once './classes/Usuario.php';


$mensagem = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];
    $nova_senha = $_POST['nova_senha'];
    $usuario = new Usuario($db);


    if ($usuario->redefinirSenha($codigo, $nova_senha)) {
        $mensagem = 'Senha redefinida com sucesso. Você pode <a href="index.php">entrar</a> agora.';
    } else {
        $mensagem = 'Código de verificação inválido.';
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <style>

/* Estilos gerais */
body {
    font-family: Arial, sans-serif;
    background-color: #fce4ec; /* Cor de fundo em tom suave de rosa */
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

h1 {
    color: #333;
    text-align: center;
}

/* Container do formulário */
form {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 400px;
    width: 100%;
    box-sizing: border-box;
    border: 1px solid #f06292; /* Tom de rosa claro para borda */
}

/* Estilização dos rótulos */
form label {
    font-weight: bold;
    display: block;
    margin-bottom: 8px;
    color: #880e4f; /* Rosa escuro para os rótulos */
}

/* Campos de entrada */
form input[type="text"],
form input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #f06292; /* Borda rosa clara nos campos */
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 14px;
    color: #333;
}

/* Botão de envio */
form input[type="submit"] {
    background-color: #ec407a; /* Rosa médio para o botão */
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    width: 100%;
}

form input[type="submit"]:hover {
    background-color: #ad1457; /* Rosa mais escuro para o efeito hover */
}

/* Mensagem */
p {
    text-align: center;
    color: #ec407a; /* Cor rosa do texto da mensagem */
    font-weight: bold;
    margin-top: 20px;
}

p a {
    text-decoration: none;
    color: #d81b60; /* Rosa mais escuro para o link */
}

p a:hover {
    text-decoration: underline;
}



    </style>
</head>

<body>
    <form method="POST">
        <h1>Redefinir Senha</h1>

        <label for="codigo">Código de Verificação:</label>
        <input type="text" name="codigo" required placeholder="insira seu codigo de verificação"><br><br>
        <label for="nova_senha">Nova Senha:</label>
        <input type="password" name="nova_senha" required><br><br>
        <input type="submit" value="Redefinir Senha">
    </form>
    <p><?php echo $mensagem; ?></p>
</body>

</html>