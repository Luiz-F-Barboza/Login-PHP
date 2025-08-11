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
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.71c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $endereco = trim($_POST['endereco'] ?? '');

    echo '<div class="container mt-4">';

    if (empty($nome) || empty($email) || empty($senha) || empty($endereco)) {
        echo '
        <div class="alert alert-danger d-flex align-items-center justify-content-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:" width="24" height="24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <use xlink:href="#exclamation-triangle-fill"/>
          </svg>
          <div>
            Todos os campos são obrigatórios!
          </div>
        </div>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '
        <div class="alert alert-danger d-flex align-items-center justify-content-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:" width="24" height="24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <use xlink:href="#exclamation-triangle-fill"/>
          </svg>
          <div>
            Email inválido!
          </div>
        </div>';
    } else {
        $sql = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            echo '
            <div class="alert alert-danger d-flex align-items-center justify-content-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:" width="24" height="24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <use xlink:href="#exclamation-triangle-fill"/>
              </svg>
              <div>
                Email já cadastrado!
              </div>
            </div>';
        } else {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, endereco) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nome, $email, $senhaHash, $endereco);

            if ($stmt->execute()) {
                echo '
                <div class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
                  <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:" width="24" height="24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <use xlink:href="#check-circle-fill"/>
                  </svg>
                  <div>
                    Cadastro realizado com sucesso! <a href="login.php" class="alert-link">Faça login</a>
                  </div>
                </div>';
            } else {
                echo '
                <div class="alert alert-danger d-flex align-items-center justify-content-center" role="alert">
                  <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:" width="24" height="24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <use xlink:href="#exclamation-triangle-fill"/>
                  </svg>
                  <div>
                    Erro no cadastro. Tente novamente mais tarde ou entre em contato com o suporte.
                  </div>
                </div>';
            }
            $stmt->close();
        }
        $sql->close();
    }
    echo '</div>';
}
?>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
        <h2 class="card-title text-center mb-4">Cadastro</h2>
        <form id="form-cadastro" method="post" action="">
            <div class="mb-3">
                <label for="nomeInput" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nomeInput" name="nome" required>
            </div>

            <div class="mb-3">
                <label for="emailInput" class="form-label">Email:</label>
                <input type="email" class="form-control" id="emailInput" name="email" required>
            </div>

            <div class="mb-3">
                <label for="senhaInput" class="form-label">Senha:</label>
                <input type="password" class="form-control" id="senhaInput" name="senha" required>
            </div>

            <div class="mb-3">
                <label for="enderecoInput" class="form-label">Endereço:</label>
                <input type="text" class="form-control" id="enderecoInput" name="endereco" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Cadastrar</button>
        </form>

        <p class="text-center mt-4 classDoPdeJaTemConta">Já tem conta? <a href="login.php" class="text-decoration-none">Login</a></p>
    </div>
</div>

<?php include('templates/footer.php'); ?>