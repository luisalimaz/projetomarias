<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="styles/index.css">
    <title>Academia Fit</title>
    <style>

        
</style>
</head>

<body>
    <!-- Cabeçalho -->
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="img/haltere.png" alt="Logo" class="logo-img">
            </div>
            <div class="header-content">
                <h1>Academia Fit</h1>
                <p>Juntos com você nessa jornada fitness!</p>
                <a href="login.php" class="btn-login">Login</a>
            </div>
        </div>
    </header>

    <?php
    include_once './config/config.php';
    include_once './classes/Treino.php';

    try {
        $database = new Database();
        $db = $database->getConnection();
        $treinos = new Treino($db);
        $dados = $treinos->ler();
    } catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }
    ?>

    <!-- Treinos -->
    <main>
        <section class="treinos-container">
            <h2>Treinos Disponíveis</h2>

            <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
                <article class="treino-card">
                    <div class="treino-content">
                        <h3><?php echo htmlspecialchars($row['tipo']); ?></h3>
                        <p><strong>Exercício:</strong> <?php echo htmlspecialchars($row['exercicio']); ?></p>
                    </div>
                </article>
            <?php endwhile; ?>
        </section>
    </main>

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2024 Academia Fit | Todos os direitos reservados Marias.</p>
    </footer>
</body>

</html>