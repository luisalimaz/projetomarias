<?php 
include_once './config/config.php'; 
include_once './classes/treino.php'; 
session_start(); 

if (!isset($_SESSION['usuario_nome'])) { 
    header('Location: login.php'); 
    exit(); 
}

$treino = new Treino($db); 
$nome_usuario = $_SESSION['usuario_nome'];

if(isset($_GET['ler'])) {
    $id = $_GET['ler'];
    $dados = $treino->lerPorId($id);
} else {
    $dados = $treino->ler();
}

function saudacao() { 
    $hora = date('H'); 
    if ($hora >= 6 && $hora < 12) { 
        return "Bom dia"; 
    } else if ($hora >= 12 && $hora < 18) { 
        return "Boa tarde"; 
    } else { 
        return "Boa noite"; 
    } 
} 
?>

<!DOCTYPE html> 
<html lang="pt-br"> 
<head> 
    <meta charset="UTF-8"> 
    <link rel="stylesheet" href="style/consultarT.css"> 
    <title>Portal de Treinos</title> 
</head> 
<body> 
    <div> 
        <form method="GET" action="consultarTreino.php"> 
            <input type="number" name="ler" placeholder="Buscar Treino por ID" /> 
            <button type="submit">Buscar</button> 
        </form> 
        <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1> 
        <a href="cadastrarTreino.php">Adicionar Treino</a> 
        <a href="logout.php">Logout</a> 
        <a href="portal.php">Voltar</a> 
        <br> 
        <table border="1"> 
            <tr> 
                <th>ID</th> 
                <th>Tipo</th> 
                <th>Exercício</th> 
                <th>Instrutor</th> 
                <th>Descrição</th> 
                <th>Ações</th> 
            </tr> 
            <?php foreach ($dados as $treino) : ?> 
                <tr> 
                    <td><?php echo $treino['id']; ?></td> 
                    <td><?php echo $treino['tipo']; ?></td> 
                    <td><?php echo $treino['exercicio']; ?></td> 
                    <td><?php echo $treino['instrutor']; ?></td> 
                    <td><?php echo $treino['descricao']; ?></td> 
                    <td> 
                        <a href="editarTphp?id=<?php echo $treino['id']; ?>">Editar</a> 
                        <a href="deletarT.php?id=<?php echo $treino['id']; ?>">Deletar</a> 
                    </td> 
                </tr> 
            <?php endforeach; ?> 
        </table> 
    </div> 
</body> 
</html>
