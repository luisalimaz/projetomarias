<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';
include_once 'classes/Instrutor.php';


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles/portal.css">
    <title>Document</title>
    
</head>

<body>
    <header>
        <div><img src="img/haltere.png" alt="Logo"></div>
        <div>
            <a href="index.php">Voltar</a>
            <h2>AcademiaFit</h2>
        </div>
    </header>

    <main>
        <h3 class="sub-titulo">O que deseja fazer?</h3>
        <div>
            <a href="./registrar.php">Cadastrar usuário</a>
            <a href="./consultarUsuario.php">Consultar usuário</a>
            <a href="./consultarTreino.php">Consultar  treinos</a>
            <a href="./cadastrartreino.php">Criar meu treino</a>
            <a href="./historicoagendamento.php">Consultar Agenda</a>
            <a href="./consultarUsuario.php">Consultar instrutor</a>
        </div>
    </main>
</body>

</html>
