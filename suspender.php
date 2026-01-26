<?php
include 'includes/config.php';
verificarLogin();

// Segurança de Acesso
if (!isset($_SESSION['is_superadmin']) || (int)$_SESSION['is_superadmin'] !== 1) {
    header("Location: index.php?erro=acesso_negado");
    exit;
}

$id = $_GET['id'] ?? null;
$tipo = $_GET['tipo'] ?? null; // 'empresa' ou 'usuario'

if (!$id || !$tipo) {
    header("Location: admin_geral.php?erro=parametros_invalidos");
    exit;
}

try {
    $pdo->beginTransaction();

    if ($tipo === 'empresa') {
        // 1. Suspende a Empresa
        $stmtEmp = $pdo->prepare("UPDATE empresas SET status = 'suspenso' WHERE id = ?");
        $stmtEmp->execute([$id]);

        // 2. Suspende todos os usuários que pertencem a essa empresa
        $stmtUsers = $pdo->prepare("UPDATE usuarios SET status = 'suspenso' WHERE empresa_id = ?");
        $stmtUsers->execute([$id]);
        
    } elseif ($tipo === 'usuario') {
        // Suspende apenas o usuário (Contas Pessoais)
        $stmtUser = $pdo->prepare("UPDATE usuarios SET status = 'suspenso' WHERE id = ?");
        $stmtUser->execute([$id]);
    }

    $pdo->commit();
    header("Location: admin_geral.php?sucesso=suspensao_realizada");
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    die("Erro ao processar suspensão: " . $e->getMessage());
}