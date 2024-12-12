<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: consultarUsuario.php');
    exit();
}
include_once './config/config.php';
include_once './classes/Usuario.php';


$usuario = new Usuario($db);
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $usuario->deletar($id);
    header('Location: consultarUsuario.php');
    exit();
}
?>
