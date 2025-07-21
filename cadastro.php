<?php
session_start();
include('includes/conexao.php');
include('templates/header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    if($result->num_rows > 0) {
        echo '<p class="msg-erro">Email já cadastrado!</p>';
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senhaHash);
        if ($stmt->execute()) {
            echo '<p class="msg-sucesso">Cadastro realizado com sucesso! <a href="login.php">Faça login</a></p>';
        } else {
            echo '<p class="msg-erro">Erro no cadastro. Tente novamente.</p>';
        }
        $stmt->close();
    }
    $sql->close();
}
?>

<h2>Cadastro</h2>
<form id="form-cadastro" method="post" action="">
    <label>Nome:</label><br>
    <input type="text" name="nome" required><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br>

    <label>Senha:</label><br>
    <input type="password" name="senha" required><br>

    <button type="submit">Cadastrar</button>
</form>

<p>Já tem conta? <a href="login.php">Login</a></p>

<?php include('templates/footer.php'); ?>
