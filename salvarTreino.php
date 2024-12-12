<?php

include_once './config/config.php';
include_once './classes/Treino.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Inicializar a classe Treino com a conexão ao banco
        $treino = new Treino($db);

        // Capturar os dados enviados pelo formulário
        $tipo = $_POST['tipo'];
        $exercicio = $_POST['exercicio'];
        $instrutor = $_POST['instrutor'];
        $data = $_POST['data'];
        $descricao = $_POST['descricao'];
        // Cadastrar o treino no banco de dados
        $resultado = $treino->cadastrar( $tipo, $exercicio, $instrutor, $data, $descricao);

        if ($resultado) {
            echo "Treino cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar o treino.";
        }
    } catch (Exception $e) {
        die('Erro: ' . $e->getMessage());
    }
} ?>