<?php
// Incluindo os arquivos necessários
include_once './config/config.php';
include_once './classes/Treino.php';
include_once './classes/Usuario.php';
include_once './classes/Instrutor.php';

try {
    // Conexão com o banco de dados
    $database = new Database();
    $db = $database->getConnection();

    // Inicializando a classe de Treino
    $treino = new Treino($db);

    // Inicializando a classe de Usuario para obter a lista de alunos
    $usuario = new Usuario($db);
    $alunos = $usuario->ler(); // Obtém os alunos do banco

    // Inicializando a classe de Instrutor para obter a lista de instrutores
    $instrutorObj = new Instrutor($db);
    $instrutores = $instrutorObj->ler(); // Obtém os instrutores do banco
} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}

// Processando o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegando os dados do formulário
    $tipo = $_POST['tipo'] ?? '';
    $exercicio = $_POST['exercicio'] ?? '';
    $instrutor = $_POST['instrutor'] ?? '';
    $aluno = $_POST['aluno'] ?? ''; // Incluindo o campo aluno
    $data = $_POST['data'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    // Validando os campos
    if (!empty($tipo) && !empty($exercicio) && !empty($instrutor) && !empty($aluno) && !empty($data) && !empty($descricao) ) {
        // Cadastrando o treino
        if ($treino->cadastrar($tipo, $exercicio, $instrutor, $aluno, $data, $descricao)) {
            echo "<script>alert('Treino cadastrado com sucesso!'); window.location.href = 'portal.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar treino.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Preencha todos os campos!'); window.history.back();</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Treino</title>
    <link rel="stylesheet" href="styles/cadastro.css">
</head>
<body>
    <form action="cadastrarTreino.php" method="POST">
        <h1>Cadastrar novo treino</h1>
        <a href="portal.php">Voltar</a>

   
        <!-- Campo de Instrutor -->
        <label for="instrutor">Instrutor:</label>
        <select name="instrutor" id="instrutor" required>
            <option value="">Selecione o instrutor</option>
            <?php while ($instrutor = $instrutores->fetch(PDO::FETCH_ASSOC)) : ?>
                <option value="<?php echo $instrutor['id']; ?>">
                    <?php echo htmlspecialchars($instrutor['nome']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="tipo">Tipo:</label>
        <input type="text" id="tipo" name="tipo" placeholder="Digite o tipo de treino" required>

        <label for="exercicio">Exercício:</label>
        <input type="text" id="exercicio" name="exercicio" placeholder="Qual exercício será feito?" required>

        
        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" placeholder="Descrição" required>
        
    <input type="submit" value="Cadastrar">
</form>

</body>
</html>
