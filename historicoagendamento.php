<?php
// Incluindo os arquivos necessários
include_once './config/config.php';
include_once './classes/Treino.php';
include_once './classes/Usuario.php';
include_once './classes/Instrutor.php';
include_once './classes/Agendamento.php';

try {
    // Conexão com o banco de dados
    $database = new Database();
    $db = $database->getConnection();

    // Inicializando a classe de Agendamento
    $agendamento = new Agendamento($db);

    // Inicializando a classe de Usuario para obter a lista de instrutores
    $usuario = new Usuario($db);
    $instrutores = $usuario->ler(); // Obtém os instrutores do banco
} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}

// Processando o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegando os dados do formulário
    $data = $_POST['data'] ?? '';
    $horario = $_POST['horario'] ?? '';
    $aluno = $_POST['aluno'] ?? '';
    $treino = $_POST['treino'] ?? '';
    $instrutor = $_POST['instrutor'] ?? '';

    // Validando os campos
    if (!empty($data) && !empty($horario) && !empty($aluno) && !empty($treino) && !empty($instrutor)) {
        // Cadastrando o agendamento
        if ($agendamento->cadastrar($data, $horario, $aluno, $treino, $instrutor)) {
            echo "<script>alert('Agendamento cadastrado com sucesso!'); window.location.href = 'portal.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar agendamento.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Preencha todos os campos!'); window.history.back();</script>";
    }
}

// Recupera os agendamentos do banco de dados
$stmt = $db->query("SELECT * FROM agendamento ORDER BY data DESC, horario DESC");
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Organiza os agendamentos por data
$agendamentosPorData = [];
foreach ($agendamentos as $agendamento) {
    $agendamentosPorData[$agendamento['data']][] = $agendamento;
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Agendamentos</title>
    <link rel="stylesheet" href="styles/agendamento.css">
</head>
<body>
    <div class="container">
        <h1>Calendário de Agendamentos</h1>
        
        <?php
        // Definindo o mês e o ano atual
        $mesAtual = date('m');
        $anoAtual = date('Y');

        // Data de início e fim do mês
        $primeiroDiaDoMes = "$anoAtual-$mesAtual-01";
        $ultimoDiaDoMes = date('Y-m-t', strtotime($primeiroDiaDoMes));

        // Obtém o primeiro e o último dia da semana do mês
        $primeiroDiaDaSemana = date('w', strtotime($primeiroDiaDoMes));
        $totalDiasNoMes = date('t', strtotime($primeiroDiaDoMes));
        ?>

        <!-- Calendário -->
        <div class="calendario">
        <br><div class="mes"><br>
                <h2><?php echo strftime('%B %Y', strtotime($primeiroDiaDoMes)); ?></h2>
            </div>

            <div class="dias">
                <?php
                // Dias da semana
                $diasSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
                foreach ($diasSemana as $dia): ?>
                    <div class="dia semana"><?php echo $dia; ?></div>
                <?php endforeach; ?>

                <?php
                // Preenche os dias vazios antes do primeiro dia do mês
                for ($i = 0; $i < $primeiroDiaDaSemana; $i++) {
                    echo '<div class="dia vazio"></div>';
                }

                // Preenche os dias do mês
                for ($dia = 1; $dia <= $totalDiasNoMes; $dia++) {
                    $dataAtual = "$anoAtual-$mesAtual-" . str_pad($dia, 2, '0', STR_PAD_LEFT);
                    $temAgendamento = isset($agendamentosPorData[$dataAtual]) ? true : false;
                    ?>

                    <div class="dia <?php echo $temAgendamento ? 'agendado' : ''; ?>">
                        <span class="numero"><?php echo $dia; ?></span>
                        <?php if ($temAgendamento): ?>
                            <span class="bolinha"></span>
                        <?php endif; ?>
                    </div>

                <?php } ?>
            </div>
        </div>

        <h2>Agendamentos do Mês</h2>
        <?php if (count($agendamentos) > 0): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Aluno</th>
                        <th>Treino</th>
                        <th>Instrutor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agendamentos as $agendamento): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($agendamento['data']); ?></td>
                            <td><?php echo htmlspecialchars($agendamento['horario']); ?></td>
                            <td><?php echo htmlspecialchars($agendamento['aluno']); ?></td>
                            <td><?php echo htmlspecialchars($agendamento['treino']); ?></td>
                            <td><?php echo htmlspecialchars($agendamento['instrutor']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum agendamento registrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
