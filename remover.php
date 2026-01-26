<?php
include 'includes/config.php';
verificarLogin();

$id = $_GET['id'] ?? null;
$tipo = $_GET['tipo'] ?? null;

if ($id && $tipo) {
    if ($tipo === 'empresa') {
        // Remove empresa e todos os usuários vinculados
        $pdo->prepare("DELETE FROM usuarios WHERE empresa_id = ?")->execute([$id]);
        $pdo->prepare("DELETE FROM empresas WHERE id = ?")->execute([$id]);
    } else {
        // Remove apenas o usuário individual
        $pdo->prepare("DELETE FROM usuarios WHERE id = ?")->execute([$id]);
    }
}
header("Location: admin_geral.php?sucesso=removido");