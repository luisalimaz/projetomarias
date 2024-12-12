<?php
include_once './config/config.php';
include_once './classes/Usuario.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $usuario = new Usuario($db);
    $codigo = $usuario->gerarCodigoVerificacao($email);

    if ($codigo) {
        $mensagem = "Seu código de verificação é: $codigo. Por favor, anote o código e <a href='redefinir_senha.php'>clique aqui</a> para redefinir sua senha.";
    } else {
        $mensagem = 'E-mail não encontrado.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <style>
       /* General Body Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f0f6; /* Soft pink background */
    margin: 0;
    padding: 0;
    color: #333; /* Text color remains consistent */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;  /* Ensure the page takes full viewport height */
    text-align: center;
}

/* Container Div */
div {
    display: flex;
    flex-direction: column;  /* Align items vertically */
    align-items: center;     /* Center horizontally */
    justify-content: center; /* Center vertically */
    width: 100%;
    max-width: 450px; /* Set a max-width to prevent it from getting too wide */
    padding: 20px;
    box-sizing: border-box;
}

/* Form Container */
form {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    border: 1px solid #ddd;
    box-sizing: border-box;
}

/* Form Title */
h1 {
    color: #e91e63; /* Pink color */
    margin-bottom: 20px;
    font-size: 24px;
}

/* Label Styles */
label {
    font-weight: bold;
    color: #555;
    margin-bottom: 8px;
    display: block;
}

/* Input Styles */
input[type="email"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    box-sizing: border-box;
}

/* Submit Button */
input[type="submit"] {
    background-color: #ec407a; /* Lighter pink */
    color: #fff;
    border: none;
    padding: 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #d81b60; /* Darker pink on hover */
}

/* Message Section */
p {
    font-size: 16px;
    color: #333;
    margin-top: 20px;
}

/* Links */
a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

a:hover {
    text-decoration: underline;
}

/* Footer Styling */
footer {
    background-color: #e91e63; /* Matching pink footer */
    color: #fff;
    padding: 20px;
    text-align: center;
    font-size: 14px;
    letter-spacing: 1px;
    margin-top: 40px;
}

footer a {
    color: #fff;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div>
    <form method="POST">
        <h1>Recuperar Senha</h1>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <input type="submit" value="Enviar">
    </form>

    <p><?php echo $mensagem; ?></p>

    <a href="logout.php">Voltar</a>

    <footer>
        <p>&copy; 2024 Recuperação de Senha | Todos os direitos reservados.</p>
    </footer></div>
</body>
</html>
