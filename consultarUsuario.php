<?php
include_once './config/config.php';
include_once './classes/usuario.php';

session_start();

if (!isset($_SESSION['usuario_nome'])) {
    // Redirecionar para a página de login se o usuário não estiver logado
    header('Location: login.php');
    exit();
}

$usuario = new Usuario($db);
$nome_usuario =  $_SESSION['usuario_nome'];

$dados = $usuario->ler();

function saudacao()
{
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
<link rel="stylesheet" href="style/consultarU.css">
<link rel="stylesheet" href="style/editarU.css">
<title>Portal</title>
    
</head>
<body>
    <div>
        <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
        <a href="registrar.php">Adicionar Usuário</a>
        <a href="logout.php">Logout</a>
        <a href="portal.php">Voltar</a>
        <br>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Sexo</th>
                <th>Fone</th>
                <th>Email</th>
                <th>CPF</th>
                <th>Data de Nascimento</th>
                <th>Peso</th>
                <th>Altura</th>
                <th>Ações</th>
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
                        <a href="deletar.php?id=<?php echo $row['id']; ?>">Deletar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
