<?php
include 'includes/config.php';
verificarLogin();

if (isset($_GET['id']) && $_SESSION['user_tipo'] == 'empresarial') {
    $id_cargo = $_GET['id'];
    $empresa_id = $_SESSION['empresa_id'];

    // Deleta o cargo apenas se pertencer à empresa do usuário logado
    $stmt = $pdo->prepare("DELETE FROM cargos WHERE id = ? AND empresa_id = ?");
    $stmt->execute([$id_cargo, $empresa_id]);

    header("Location: gestao_cargos.php?excluido=1");
} else {
    header("Location: home.php");
}
?>