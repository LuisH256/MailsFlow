<?php
include 'includes/config.php';
verificarLogin();

$user_id = $_SESSION['user_id'];
$empresa_id = $_SESSION['empresa_id'];
$nome = $_POST['nome'];
$email = $_POST['email'];

// 1. Atualiza dados do usuário
$stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
$stmt->execute([$nome, $email, $user_id]);
$_SESSION['user_nome'] = $nome;

// 2. Atualiza senha se preenchida
if (!empty($_POST['nova_senha'])) {
    $hash = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);
    $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?")->execute([$hash, $user_id]);
}

// 3. Atualiza Empresa (Se for Admin)
$is_admin = (in_array($_SESSION['user_cargo'], ['Dono', 'CEO', 'Admin']));

if ($is_admin) {
    $nome_empresa = $_POST['nome_empresa'];
    
    // Atualiza o nome da empresa
    $stmtEmp = $pdo->prepare("UPDATE empresas SET nome_fantasia = ? WHERE id = ?");
    $stmtEmp->execute([$nome_empresa, $empresa_id]);

    // Processa a Logo
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $diretorio = "uploads/";
        if (!is_dir($diretorio)) mkdir($diretorio, 0777, true);

        $extensao = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $novo_nome_logo = "logo_" . $empresa_id . "_" . time() . "." . $extensao;

        if (move_uploaded_file($_FILES['logo']['tmp_name'], $diretorio . $novo_nome_logo)) {
            $updateLogo = $pdo->prepare("UPDATE empresas SET logo = ? WHERE id = ?");
            $updateLogo->execute([$novo_nome_logo, $empresa_id]);
        }
    }
}

header("Location: perfil.php?sucesso=1");
exit;