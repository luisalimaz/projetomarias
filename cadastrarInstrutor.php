<?php
include_once './config/config.php';
include_once './classes/Instrutor.php';

function calcularIdade($dataNascimento)
{
    $dataAtual = new DateTime();
    $dataNascimento = new DateTime($dataNascimento);
    $idade = $dataAtual->diff($dataNascimento);
    return $idade->y;
}

function validarIdade($idade)
{
    return $idade >= 20;
}


session_start();
$instrutor = new Instrutor($db);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Recebe os dados do formulário
    $nome = htmlspecialchars(trim($_POST['nome']));
    $sexo = $_POST['sexo'];
    $fone = htmlspecialchars(trim($_POST['fone']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];
    $cpf = htmlspecialchars(trim($_POST['cpf']));
    $datanas = $_POST['datanas'];
    $area = $_POST['area'];
    $imagem = '';


    // Calcular idade
    $idade = calcularIdade($datanas);
   
    // Validações
    if (!validarIdade($idade)) {
        $mensagem_erro = "Você precisa ter pelo menos 15 anos para se cadastrar.";
    } elseif (!preg_match("/^\d{3}\.\d{3}\.\d{3}-\d{2}$/", $cpf)) {
        $mensagem_erro = "CPF inválido. Por favor, use o formato XXX.XXX.XXX-XX.";
    } elseif (strtotime($datanas) > time()) {
        $mensagem_erro = "A data de nascimento não pode ser no futuro.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem_erro = "Email inválido.";
    } elseif ($instrutor->verificarEmail($email)) {
        $mensagem_erro = "O email já está cadastrado!";
    } else {

        // Registra o instrutor
        if ($instrutor->cadastrar($nome, $cpf, $email, $senha, $fone, $sexo, $area, $datanas, $imagem)) {

            header('Location: index.php');
            exit();
        } else {
            $mensagem_erro = "Erro ao cadastrar. Tente novamente!";
        }
    }

// Verifica se a imagem foi enviada
if (!empty($_FILES['imagem']['name'])) {
    $target_dir = "img/";  // Diretório onde as imagens serão armazenadas
    $target_file = $target_dir . basename($_FILES["imagem"]["name"]);  // Caminho do arquivo com nome

    // Verifica se o arquivo é uma imagem válida
    if (getimagesize($_FILES["imagem"]["tmp_name"]) !== false) {
        // Tenta mover o arquivo para o diretório de destino
        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
            $imagem = $target_file;  // Caminho completo da imagem
        } else {
            $mensagem_erro = "Erro ao fazer upload da imagem.";
            exit();
        }
    } else {
        $mensagem_erro = "O arquivo não é uma imagem válida.";
        exit();
    }
} else {
    $imagem = '';  // Caso não tenha sido enviada imagem
}

// Agora, chama a função para cadastrar o instrutor, incluindo a imagem
if ($instrutor->cadastrar($nome, $cpf, $email, $senha, $fone, $sexo, $area, $datanas, $imagem)) {
    header('Location: index.php');  // Redireciona após cadastro bem-sucedido
    exit();
} else {
    $mensagem_erro = "Erro ao cadastrar. Tente novamente!";
}


}
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Registrar</title>
    <link rel="stylesheet" href="styles/cadI.css">
</head>

<body>
    <h1>Registrar</h1>
    <div class="right-align">

    </div>
    <form method="POST" enctype="multipart/form-data">
    <a href="login.php">Voltar</a>
    <label for="nome">Nome completo:</label>
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
    <input type="date" id="datanas" name="datanas" required>

    <label for="area">Área:</label>
    <label><input type="radio" name="area" value="G" required> Ginástica</label>
    <label><input type="radio" name="area" value="P" required> Personal Trainer</label>
    <label><input type="radio" name="area" value="F" required> Fisioterapia</label>
    <label><input type="radio" name="area" value="E" required> Especial</label>

    <label>Sexo:</label>
    <label><input type="radio" name="sexo" value="M" required> Masculino</label>
    <label><input type="radio" name="sexo" value="F" required> Feminino</label>

    <label for="imagem">Por favor deixe abaixo foto de seus documentos junto a seu certificado:</label>
    <input type="file" id="imagem" name="imagem">

    <input type="submit" value="Cadastrar">
</form>

    </form>
    <p>Já tem conta? <br> <a href="./loginI.php">Clique Aqui</a></p>
    <p>Esqueceu a senha? <br> <a href="./solicitar_recuperacao.php">Clique Aqui</a></p>

    <?php if (isset($mensagem_erro)): ?>
        <p class="error-message"><?php echo $mensagem_erro; ?></p>
    <?php endif; ?>
</body>

</html>