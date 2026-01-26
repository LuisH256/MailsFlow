<?php
// 1. O config.php já inicia a sessão e define $pdo
require_once 'includes/config.php'; 
verificarLogin();

// 2. Lógica de Processamento (Conexão ou Desconexão)
$mensagem_feedback = "";
$tipo_feedback = ""; // success ou error

// --- CASO 1: RECEBENDO RETORNO DO GOOGLE ---
if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $ch = curl_init('https://oauth2.googleapis.com/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'code'          => $code,
        'client_id'     => '1069571138450-u071u447qd394sausnmn6o460b32o4ko.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect_uri'  => 'https://mailsflow.store/google-callback.php',
        'grant_type'    => 'authorization_code'
    ]);

    $response = json_decode(curl_exec($ch), true);

    if (isset($response['refresh_token'])) {
        try {
            $sql = "UPDATE usuarios SET gmail_refresh_token = :token WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':token' => $response['refresh_token'], ':id' => $_SESSION['user_id']]);
            $mensagem_feedback = "Gmail conectado com sucesso!";
            $tipo_feedback = "success";
        } catch (PDOException $e) {
            $mensagem_feedback = "Erro ao salvar: " . $e->getMessage();
            $tipo_feedback = "error";
        }
    } else {
        $mensagem_feedback = "Erro na conexão com Google.";
        $tipo_feedback = "error";
    }
}

// --- CASO 2: LÓGICA DE DESCONEXÃO ---
if (isset($_GET['action']) && $_GET['action'] === 'disconnect') {
    $sql = "UPDATE usuarios SET gmail_refresh_token = NULL WHERE id = :id";
    $pdo->prepare($sql)->execute([':id' => $_SESSION['user_id']]);
    $mensagem_feedback = "Integração removida.";
    $tipo_feedback = "success";
}

// 3. Busca dados atualizados do usuário para exibir na tela
$stmt = $pdo->prepare("SELECT u.*, e.nome_fantasia FROM usuarios u LEFT JOIN empresas e ON u.empresa_id = e.id WHERE u.id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$ja_conectado = !empty($user['gmail_refresh_token']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Meu Perfil | MailsFlow</title>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden font-['Inter']">

    <?php include 'includes/sidebar.php'; ?>
    
    <main class="flex-1 overflow-y-auto p-8">
        <div class="max-w-4xl mx-auto space-y-6">
            
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-bold text-slate-800">Meu Perfil</h2>
                <?php renderGoogleTranslate(); ?>
            </div>

            <?php if($mensagem_feedback): ?>
                <div class="p-4 rounded-2xl flex items-center gap-3 font-bold text-sm <?php echo $tipo_feedback === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                    <span class="w-2 h-2 rounded-full <?php echo $tipo_feedback === 'success' ? 'bg-green-500' : 'bg-red-500'; ?>"></span>
                    <?php echo $mensagem_feedback; ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white rounded-3xl shadow-sm border p-8">
                        <h3 class="text-sm font-bold text-blue-600 uppercase tracking-widest mb-6 text-center md:text-left">Informações Pessoais</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Nome Completo</label>
                                <div class="w-full p-3 bg-slate-50 border border-slate-100 rounded-xl text-slate-700 font-medium">
                                    <?php echo htmlspecialchars($user['nome']); ?>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">E-mail de Login</label>
                                <div class="w-full p-3 bg-slate-50 border border-slate-100 rounded-xl text-slate-700 font-medium italic">
                                    <?php echo htmlspecialchars($user['email']); ?>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Sua Empresa</label>
                                <div class="w-full p-3 bg-slate-50 border border-slate-100 rounded-xl text-slate-700 font-medium">
                                    <?php echo htmlspecialchars($user['nome_fantasia'] ?? 'Não vinculada'); ?>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Cargo / Nível</label>
                                <div class="w-full p-3 bg-slate-50 border border-slate-100 rounded-xl text-slate-700 font-medium">
                                    <?php echo htmlspecialchars($user['cargo'] ?? 'Usuário'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1">
                    <div class="bg-white rounded-3xl shadow-sm border p-8 h-full flex flex-col items-center justify-center text-center space-y-6">
                        <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center border border-slate-100 shadow-sm">
                            <img src="https://www.gstatic.com/images/branding/product/2x/gmail_48dp.png" class="w-10 h-10" alt="Gmail">
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-slate-800">Integração Gmail</h4>
                            <p class="text-xs text-slate-500 mt-1">Envio automático via API</p>
                        </div>

                        <?php if($ja_conectado): ?>
                            <div class="px-4 py-2 bg-green-50 text-green-600 rounded-full text-[10px] font-bold tracking-widest border border-green-100 flex items-center gap-2">
                                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> ATIVO
                            </div>
                            <a href="google-callback.php?action=disconnect" 
                               onclick="return confirm('Desconectar sua conta Gmail?')"
                               class="text-xs font-bold text-red-400 uppercase hover:text-red-600 transition underline underline-offset-4">
                                Desconectar conta
                            </a>
                        <?php else: ?>
                            <div class="px-4 py-2 bg-slate-100 text-slate-400 rounded-full text-[10px] font-bold tracking-widest">
                                DESCONECTADO
                            </div>
                            <a href="conectar.php" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold text-xs hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                                Conectar Agora
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <div class="text-center pt-4">
                <a href="perfil" class="text-sm font-semibold text-slate-400 hover:text-blue-600 transition">
                    ← Voltar para configurações de conta
                </a>
            </div>

        </div>
    </main>
</body>
</html>