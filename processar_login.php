<?php
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Buscamos o usuário e incluímos a nova coluna is_superadmin
    $stmt = $pdo->prepare("SELECT u.*, e.nome_fantasia, e.logo 
                           FROM usuarios u 
                           LEFT JOIN empresas e ON u.empresa_id = e.id 
                           WHERE u.email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificação de senha
    if ($user && password_verify($senha, $user['senha'])) {
        // Dados básicos de sessão
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nome'] = $user['nome'];
        $_SESSION['user_tipo'] = $user['tipo'];
        $_SESSION['user_cargo'] = $user['cargo'];
        
        // Dados de empresa
        $_SESSION['empresa_id'] = $user['empresa_id'];
        $_SESSION['empresa_nome'] = $user['nome_fantasia'];
        $_SESSION['logo'] = $user['logo'];

        // PODER MASTER: Define se o usuário logado é o Super Admin do site
        $_SESSION['is_superadmin'] = (isset($user['is_superadmin']) && $user['is_superadmin'] == 1) ? 1 : 0;
        
        // Redireciona para a Dashboard
        header("Location: home");
        exit;
    } else {
        // Caso erre a senha ou e-mail
        header("Location: login?erro=1");
        exit;
    }
} else {
    // Se tentarem acessar o arquivo diretamente sem POST
    header("Location: login");
    exit;
}
?>