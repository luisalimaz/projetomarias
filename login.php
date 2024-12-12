<?php
session_start();
include_once './config/config.php';
include_once './classes/usuario.php';

$usuario = new Usuario($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    if ($dados_usuario = $usuario->login($email, $senha)) {
        
        $_SESSION['usuario_id'] = $dados_usuario['id'];
        $_SESSION['usuario_nome'] = $dados_usuario['nome'];

        header('Location: portal.php');
        exit();
    } else {
        $mensagem_erro = "Email ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles/login.css">

       
</head>

<body>
    <div id="container">
        <div class="container">
            <h1 id="titulo">Login</h1>
            <form method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" required>
                <input type="submit" value="Entrar">
            </form>

            <p>Não tem uma conta? <br> <a href="./registrar.php">Registre-se aqui</a></p>
            <p>Conta para instrutores <br> <a href="./cadastrarInstrutor.php">Clique aqui</a></p>
            <p>Esqueceu a senha?  <br> <a href="./solicitar_recuperacao.php">Clique Aqui</a></p>

            <?php if (isset($mensagem_erro)): ?>
                <div class="error-message">
                    <?php echo $mensagem_erro; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
