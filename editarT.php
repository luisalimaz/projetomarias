
<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Treino.php';

$treino = new Treino($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $exercicio = $_POST['exercicio'];
    $instrutor = $_POST['instrutor'];
    $descricao = $_POST['descricao'];

    if ($treino->atualizar($id, $tipo, $exercicio, $instrutor, $descricao)) {
        header('Location: consultarTreino.php?sucesso=1');
    } else {
        header('Location: consultarTreino.php?erro=1');
    }
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $treino->lerPorId($id);
}
?>


Código HTML


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Treino</title>
    <link rel="stylesheet" href="style/editarTreino.css">
</head>
<body>
    <div>
        <h1>Editar Treino</h1>
        <form method="POST">
            <a href="consultarTreino.php">Voltar</a>
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="tipo">Tipo:</label>
            <input type="text" id="tipo" name="tipo" value="<?php echo $row['tipo']; ?>" required>
            <label for="exercicio">Exercício:</label>
            <input type="text" id="exercicio" name="exercicio" value="<?php echo $row['exercicio']; ?>" required>
            <label for="instrutor">Instrutor:</label>
            <input type="text" id="instrutor" name="instrutor" value="<?php echo $row['instrutor']; ?>" required>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required><?php echo $row['descricao']; ?></textarea>
            <input type="submit" value="Salvar">
        </form>
    </div>
</body>
</html>