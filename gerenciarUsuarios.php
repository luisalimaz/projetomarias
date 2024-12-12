<?php
session_start();
include_once './config/config.php';
include_once './classes/usuario.php';

date_default_timezone_set('America/Sao_Paulo'); // Ajustar fuso horário

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario = new Usuario($db);

// Processar exclusão de usuário
if (isset($_GET['deletar'])) {
    try {
        $id = $_GET['deletar'];
        $usuario->deletar($id);
        header('Location: portal.php');
        exit();
    } catch (Exception $e) {
        echo '<p style="color: red;">Erro ao excluir usuário: ' . $e->getMessage() . '</p>';
    }
}

$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];
$dados = $usuario->ler();

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
    <title>Portal</title>
</head>
<body>
    <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
    <h1>Gerenciar Usuários</h1>
    <a href="registrar.php">Adicionar Usuário</a>
    <a href="logout.php">Logout</a>
<br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sexo</th>
            <th>Fone</th>
            <th>Email</th>
            <th>cpf</th>
            <th>data Nascimento</th>
            <th>peso</th> 
            <th>altura</th>
           
            
        </tr>
        <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
            <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo ($row['sexo'] === 'M') ? 'Masculino' : 'Feminino'; ?></td>
                <td><?php echo $row['fone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['cpf']; ?></td>
                <td><?php echo $row['dataN']; ?></td>
                <td><?php echo $row['peso']; ?></td>
                <td><?php echo $row['altura']; ?></td>
                <td>
                    <a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="portal.php?deletar=<?php echo $row['id']; ?>">Deletar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <h2>Gerenciar Notícias</h2>
    <a href="adicionar_noticia.php">Adicionar </a>
    <a href="listar_noticias.php">Listar Notícias</a>
</body>
</html>
