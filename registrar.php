<?php
include_once './config/config.php';
include_once './classes/Usuario.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($db);

    // Recebe os dados do formulário
    $nome = htmlspecialchars(trim($_POST['nome']));
    $sexo = $_POST['sexo'];
    $fone = htmlspecialchars(trim($_POST['fone']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];
    $cpf = htmlspecialchars(trim($_POST['cpf']));
    $dataN = $_POST['dataN'];
    $peso = (float) htmlspecialchars(trim($_POST['peso']));
    $altura = (float) htmlspecialchars(trim($_POST['altura']));

    
    // Calcular idade
    $idade = calcularIdade($dataN);

    // Validações
    if (!validarIdade($idade)) {
        $mensagem_erro = "Você precisa ter pelo menos 15 anos para se cadastrar.";
    } elseif (!preg_match("/^\d{3}\.\d{3}\.\d{3}-\d{2}$/", $cpf)) {
        $mensagem_erro = "CPF inválido. Por favor, use o formato XXX.XXX.XXX-XX.";
    } elseif (strtotime($dataN) > time()) {
        $mensagem_erro = "A data de nascimento não pode ser no futuro.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem_erro = "Email inválido.";
    } elseif ($usuario->verificarEmail($email)) {
        $mensagem_erro = "O email já está cadastrado!";
    } else {
        
        // Registra o usuário
        if ($usuario->registrar($nome, $email, $senha, $fone, $sexo, $cpf, $dataN, $peso, $altura)) {
            
            header('Location: login.php');
            exit();
        } else {
            $mensagem_erro = "Erro ao cadastrar. Tente novamente!";
        }
    }
}

// Funções auxiliares
function calcularIdade($dataNascimento)
{
    $dataAtual = new DateTime();
    $dataNascimento = new DateTime($dataNascimento);
    $idade = $dataAtual->diff($dataNascimento);
    return $idade->y;
}

function validarIdade($idade)
{
    return $idade >= 15;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Registrar</title>
    <link rel="stylesheet" href="styles/registrar.css">
</head>

<body>
    <h1>Registrar</h1>
    <div class="right-align">
        
    </div>
    <form method="POST">
        <a href="login.php">Voltar</a>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="fone">Telefone:</label>
        <input type="text" id="fone" name="fone" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" placeholder="XXX.XXX.XXX-XX" required>

        <label for="dataN">Data Nascimento:</label>
        <input type="date" id="dataN" name="dataN" required>

        <label for="peso">Peso (kg):</label>
        <input type="text" id="peso" name="peso" required>

        <label for="altura">Altura (cm):</label>
        <input type="text" id="altura" name="altura" required>

        <label>Sexo:</label>
        <label><input type="radio" name="sexo" value="M" required> Masculino</label>
        <label><input type="radio" name="sexo" value="F" required> Feminino</label>
        <input type="submit" value="Cadastrar">
    </form>
    <p>Já tem conta?  <br> <a href="./login.php">Clique Aqui</a></p>
    <?php if (isset($mensagem_erro)): ?>
        <p class="error-message"><?php echo $mensagem_erro; ?></p>
    <?php endif; ?>
</body>

</html>