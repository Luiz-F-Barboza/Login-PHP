<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
include('templates/header.php');
?>

<h2>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h2>
<p>Você está logado no sistema.</p>
<p><a href="logout.php">Sair</a></p>

<?php include('templates/footer.php'); ?>
