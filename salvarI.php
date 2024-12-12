

<?php

include_once './config/config.php';
include_once './classes/Instrutor.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Inicializar conexão com o banco de dados
        $instrutor = new Instrutor($db);

        // Capturar os dados enviados pelo formulário
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $fone = $_POST['fone'];
        $sexo = $_POST['sexo'];
        $area = $_POST['area'];
        $datanas = $_POST['datanas'];
        $imagem = null;

        // Upload da imagem
        if (!empty($_FILES['imagem']['name'])) {
            $uploadDir = 'img/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = basename($_FILES['imagem']['name']);
            $filePath = $uploadDir . uniqid() . '_' . $fileName;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $filePath)) {
                $imagem = $filePath;
            } else {
                throw new Exception('Erro ao fazer upload da imagem.');
            }
        }

        // Cadastrar o instrutor no banco
        $resultado = $instrutor->cadastrar($nome, $cpf, $email, $senha, $fone, $sexo, $area, $datanas, $imagem);

        if ($resultado) {
            echo "Instrutor cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar instrutor.";
        }
    } catch (Exception $e) {
        die('Erro: ' . $e->getMessage());
    }
}
?>