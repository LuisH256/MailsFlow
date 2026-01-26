<?php
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $tipo = $_POST['tipo']; // 'pessoal' ou 'empresarial'
    $codigo_convite = $_POST['codigo_convite'];

    // 1. VALIDAR O CÓDIGO E A CATEGORIA (Tipo de conta)
    $stmtCod = $pdo->prepare("SELECT id, tipo FROM codigos_acesso WHERE codigo = ? AND usado = 0");
    $stmtCod->execute([$codigo_convite]);
    $codigoInfo = $stmtCod->fetch();

    if (!$codigoInfo) {
        header("Location: registro.php?erro=codigo_invalido");
        exit;
    }

    // VERIFICAÇÃO DE CATEGORIA: O código gerado deve ser igual ao tipo de conta escolhido
    if ($codigoInfo['tipo'] !== $tipo) {
        header("Location: registro.php?erro=codigo_tipo_errado");
        exit;
    }

    // 2. VERIFICAR SE O E-MAIL JÁ EXISTE
    $stmtEmail = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmtEmail->execute([$email]);
    if ($stmtEmail->fetch()) {
        header("Location: registro.php?erro=duplicado");
        exit;
    }

    // 3. CRIAÇÃO DA CONTA
    try {
        $pdo->beginTransaction();

        $empresa_id = null;
        if ($tipo == 'empresarial') {
            $stmtEmp = $pdo->prepare("INSERT INTO empresas (nome_fantasia, status) VALUES (?, 'ativo')");
            $stmtEmp->execute([$nome . " Enterprise"]);
            $empresa_id = $pdo->lastInsertId();
        }

        $cargo = ($tipo == 'empresarial') ? 'Dono' : 'Usuário Pessoal';
        
        $stmtUser = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo, empresa_id, cargo, is_superadmin, status) VALUES (?, ?, ?, ?, ?, ?, 0, 'ativo')");
        $stmtUser->execute([$nome, $email, $senha, $tipo, $empresa_id, $cargo]);

        // 4. MARCAR CÓDIGO COMO USADO
        $stmtUpdateCodigo = $pdo->prepare("UPDATE codigos_acesso SET usado = 1 WHERE codigo = ?");
        $stmtUpdateCodigo->execute([$codigo_convite]);

        $pdo->commit();
        header("Location: login.php?sucesso=cadastrado");

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Erro crítico: " . $e->getMessage());
    }
} else {
    header("Location: registro.php");
    exit;
}