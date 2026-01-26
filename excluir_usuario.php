<?php
include 'includes/config.php';
verificarLogin();

if (isset($_GET['id']) && $_SESSION['user_tipo'] == 'empresarial') {
    $id_excluir = $_GET['id'];
    $empresa_id = $_SESSION['empresa_id'];

    // Segurança: Só deleta se o usuário pertencer à mesma empresa do dono logado
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ? AND empresa_id = ? AND id != ?");
    $stmt->execute([$id_excluir, $empresa_id, $_SESSION['user_id']]);

    header("Location: gestao_funcionarios.php?excluido=1");
} else {
    header("Location: home.php");
}
?>