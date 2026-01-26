<?php 
include 'includes/config.php'; 
if (isset($_SESSION['user_id'])) { header("Location: home"); exit; }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Login | MailFlow</title>
    <style>
        body { font-family: 'Inter', sans-serif; top: 0 !important; }
        .goog-te-gadget { font-family: 'Inter', sans-serif !important; }
        .skiptranslate { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">

    <div class="fixed top-6 left-6 right-6 flex justify-between items-center z-50">
        <a href="index.php" class="group flex items-center gap-2 bg-white px-5 py-2.5 rounded-2xl shadow-sm border border-slate-100 text-slate-500 hover:text-blue-600 transition-all hover:shadow-md">
            <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span class="text-xs font-bold uppercase tracking-widest">Início</span>
        </a>
        <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
            <?php renderGoogleTranslate(); ?>
        </div>
    </div>

    <div class="max-w-md w-full bg-white rounded-[40px] shadow-2xl p-10 border border-slate-100 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-slate-800 to-slate-900"></div>

        <div class="flex justify-center mb-8">
            <div class="w-16 h-16 bg-blue-600 rounded-3xl flex items-center justify-center shadow-xl shadow-blue-200">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
        </div>
        
        <h2 class="text-3xl font-extrabold text-slate-800 text-center mb-2 tracking-tight">Bem-vindo</h2>
        <p class="text-slate-400 text-center mb-10 text-sm font-medium">Acesse sua conta MailFlow.</p>

        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 'senha_alterada'): ?>
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-xs font-bold rounded-r-2xl">
                Senha atualizada com sucesso!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['erro']) && $_GET['erro'] == 'login_invalido'): ?>
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-xs font-bold rounded-r-2xl">
                E-mail ou senha incorretos.
            </div>
        <?php endif; ?>

        <form action="processar_login.php" method="POST" class="space-y-6">
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">E-mail</label>
                <input type="email" name="email" required placeholder="exemplo@gmail.com" 
                    class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>
            
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Senha</label>
                <input type="password" name="senha" required placeholder="••••••••" 
                    class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white font-extrabold py-5 rounded-[24px] hover:bg-blue-600 transition-all shadow-xl shadow-slate-200 active:scale-[0.97] text-sm uppercase tracking-widest">
                Entrar no Painel
            </button>
        </form>

        <div class="mt-10 pt-8 border-t border-slate-50 text-center">
            <p class="text-sm text-slate-400 font-medium">
                Ainda não tem uma conta? <br>
                <a href="registro.php" class="text-blue-600 font-extrabold hover:text-blue-700 transition-colors inline-block mt-2">Cadastre-se agora</a>
            </p>
        </div>
    </div>
</body>
</html>