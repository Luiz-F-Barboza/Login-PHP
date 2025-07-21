<?php
session_start();
include('includes/conexao.php');
include('templates/header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nome'] = $user['nome'];
            header("Location: painel.php");
            exit;
        } else {
            echo '<p class="msg-erro">Senha incorreta!</p>';
        }
    } else {
        echo '<p class="msg-erro">Usuário não encontrado!</p>';
    }
    $stmt->close();
}
?>

<h2>Login</h2>
<form id="form-login" method="post" action="">
    <label>Email:</label><br>
    <input type="email" name="email" required><br>

    <label>Senha:</label><br>
    <input type="password" name="senha" required><br>

    <button type="submit">Entrar</button>
</form>

<p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>

<?php include('templates/footer.php'); ?>
