<?php
require_once 'includes/config.php';
verificarLogin();

$user_id = $_SESSION['user_id'];

try {
    // Limpamos o token no banco de dados
    $sql = "UPDATE usuarios SET gmail_refresh_token = NULL WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $user_id]);

    header("Location: minha-conta.php?status=desconectado");
} catch (PDOException $e) {
    die("Erro ao desconectar: " . $e->getMessage());
}