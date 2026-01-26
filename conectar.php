<?php
require_once 'includes/config.php';
verificarLogin();

// 1. Configurações do Google
$client_id = '1069571138450-u071u447qd394sausnmn6o460b32o4ko.apps.googleusercontent.com';
$redirect_uri = 'https://mailsflow.store/google-callback.php'; 
$scope = 'https://www.googleapis.com/auth/gmail.send';

$url_google = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'response_type' => 'code',
    'scope' => $scope,
    'access_type' => 'offline', 
    'prompt' => 'consent'       
]);

// 2. Busca dados do usuário para o cabeçalho
$stmt = $pdo->prepare("SELECT nome FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Conectar Integrações | MailsFlow</title>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden">

    <?php include 'includes/sidebar.php'; ?>
    
    <main class="flex-1 overflow-y-auto p-8">
        <div class="max-w-4xl mx-auto space-y-8">
            
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-slate-800">Integrações</h2>
                    <p class="text-slate-500 mt-1">Gerencie as conexões externas do seu painel.</p>
                </div>
                <?php renderGoogleTranslate(); ?>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 md:p-12">
                <div class="max-w-xl mx-auto text-center space-y-8">
                    
                    <div class="flex items-center justify-center gap-6">
                        <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center border border-blue-100 shadow-sm">
                            <img src="img/logo.png" class="w-10 h-10 object-contain" alt="MailsFlow">
                        </div>
                        <div class="text-slate-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center border border-slate-100 shadow-sm">
                            <img src="https://www.gstatic.com/images/branding/product/2x/gmail_48dp.png" class="w-10 h-10" alt="Gmail">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-2xl font-bold text-slate-800">Conectar Google Gmail API</h3>
                        <p class="text-slate-500 leading-relaxed">
                            Ao conectar sua conta, o <strong>MailsFlow</strong> poderá disparar e-mails automáticos através da sua conta oficial, aumentando a taxa de entrega e confiança dos seus clientes.
                        </p>
                    </div>

                    <div class="pt-4">
                        <a href="<?php echo $url_google; ?>" class="inline-flex items-center justify-center gap-3 bg-white border-2 border-slate-100 text-slate-700 px-10 py-5 rounded-3xl font-bold text-lg hover:bg-slate-50 hover:border-blue-200 transition-all shadow-xl shadow-slate-200/50 active:scale-95 group">
                            <svg class="w-6 h-6 transition-transform group-hover:scale-110" viewBox="0 0 24 24">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.66l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            </svg>
                            Conectar via Google
                        </a>
                    </div>

                    <div class="pt-8 border-t border-slate-50 flex items-center justify-center gap-8 opacity-60">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-[10px] font-bold uppercase tracking-widest">Criptografia SSL</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <span class="text-[10px] font-bold uppercase tracking-widest">OAuth 2.0 Seguro</span>
                        </div>
                    </div>

                </div>
            </div>

            <p class="text-center text-xs text-slate-400 max-w-lg mx-auto leading-relaxed">
                Nós não armazenamos sua senha. O acesso é feito através de tokens de segurança revogáveis a qualquer momento através do seu painel Google.
            </p>

        </div>
    </main>
</body>
</html>