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
            echo '<div class="alert alert-danger text-center mt-3" role="alert">Senha incorreta!</div>';
        }
    } else {
        echo '<div class="alert alert-danger text-center mt-3" role="alert">Usuário não encontrado!</div>';
    }
    $stmt->close();
}
?>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
        <h2 class="card-title text-center mb-4">Login</h2>
        <form id="form-login" method="post" action="">
            <div class="mb-3">
                <label for="emailInput" class="form-label">Email:</label>
                <input type="email" class="form-control" id="emailInput" name="email" required>
            </div>

            <div class="mb-3">
                <label for="senhaInput" class="form-label">Senha:</label>
                <input type="password" class="form-control" id="senhaInput" name="senha" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Entrar</button>
        </form>

        <p class="text-center mt-4 classDoNaoTemConta">Não tem conta? <a href="cadastro.php" class="text-decoration-none">Cadastre-se</a></p>
    </div>
</div>

<?php include('templates/footer.php'); ?>