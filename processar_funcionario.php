<?php
include 'includes/config.php';
verificarLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['user_tipo'] == 'empresarial') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $cargo = $_POST['cargo'];
    $empresa_id = $_SESSION['empresa_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo, empresa_id, cargo) VALUES (?, ?, ?, 'empresarial', ?, ?)");
        $stmt->execute([$nome, $email, $senha, $empresa_id, $cargo]);
        header("Location: gestao_funcionarios.php?sucesso=1");
    } catch (PDOException $e) {
        die("Erro: Este e-mail já está cadastrado no sistema.");
    }
} else {
    header("Location: home.php");
}
?>