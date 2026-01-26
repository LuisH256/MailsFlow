<?php
include 'includes/config.php';
verificarLogin();

$id = $_GET['id'] ?? null;
$tipo = $_GET['tipo'] ?? null;

if ($id && $tipo) {
    if ($tipo === 'empresa') {
        $pdo->prepare("UPDATE empresas SET status = 'ativo' WHERE id = ?")->execute([$id]);
        $pdo->prepare("UPDATE usuarios SET status = 'ativo' WHERE empresa_id = ?")->execute([$id]);
    } else {
        $pdo->prepare("UPDATE usuarios SET status = 'ativo' WHERE id = ?")->execute([$id]);
    }
}
header("Location: admin_geral.php?sucesso=ativado");