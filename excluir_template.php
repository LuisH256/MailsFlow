<?php
include 'includes/config.php';
verificarLogin();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Segurança: Só o dono do template ou admin pode excluir
    $stmt = $pdo->prepare("DELETE FROM templates WHERE id = ? AND (criado_por = ? OR ? IN ('Dono', 'CEO', 'Admin'))");
    $stmt->execute([$id, $user_id, $_SESSION['user_cargo']]);
}

header("Location: home.php");
exit;