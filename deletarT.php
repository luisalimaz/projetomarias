

<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Treino.php';

$treino = new Treino($db);

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    if ($treino->deletar($id)) {
        header('Location: consultarTreino.php?sucesso=1');
    } else {
        header('Location: consultarTreino.php?erro=1');
    }
    exit();
}
?>