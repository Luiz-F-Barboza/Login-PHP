<?php
session_start();
include('includes/conexao.php');
include('templates/header.php');

echo '
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM7 10.414l4.707-4.707-1.414-1.414L7 7.586 5.707 6.293 4.293 7.707 7 10.414z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 
    1.767.98 1.767h13.71c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 
    5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 
    5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>
';

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
        echo '
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:" width="24" height="24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <use xlink:href="#exclamation-triangle-fill"/>
          </svg>
          <div>
            Email já cadastrado!
          </div>
        </div>';
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senhaHash);
        if ($stmt->execute()) {
            echo '
            <div class="alert alert-success d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:" width="24" height="24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <use xlink:href="#check-circle-fill"/>
              </svg>
              <div>
                Cadastro realizado com sucesso! <a href="login.php" class="alert-link">Faça login</a>
              </div>
            </div>';
        } else {
            echo '
            <div class="alert alert-danger d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:" width="24" height="24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <use xlink:href="#exclamation-triangle-fill"/>
              </svg>
              <div>
                Erro no cadastro. Tente novamente.
              </div>
            </div>';
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
