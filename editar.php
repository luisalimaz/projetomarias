<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: consultarUsuario.php');
    exit();
}
include_once './config/config.php';
include_once './classes/Usuario.php';


$usuario = new Usuario($db);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $fone = $_POST['fone'];
    $sexo = $_POST['email'];
    $cpf = $_POST['cpf'];
    $dataN = $_POST['dataN'];
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $usuario->atualizar($id,$nome, $email,$fone, $sexo, $cpf, $dataN, $peso, $altura);
    header('Location: consultarUsuario.php');
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $usuario->lerPorId($id);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
   <link rel="stylesheet" href="style/editarU.css">
</head>
<body>
    <div>
    <h1>Editar Usuário</h1>
    <form method="POST">
        <a href="consultarUsuario.php">Voltar</a>
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
</div>
</body>
</html>
