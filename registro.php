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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Criar Conta | MailFlow</title>
    <style>
        body { font-family: 'Inter', sans-serif; top: 0 !important; }
        .goog-te-gadget { font-family: 'Inter', sans-serif !important; }
        .skiptranslate { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">

    <div class="fixed top-6 left-6 right-6 flex justify-between items-center z-50">
        <a href="index" class="group flex items-center gap-2 bg-white px-5 py-2.5 rounded-2xl shadow-sm border border-slate-100 text-slate-500 hover:text-blue-600 transition-all hover:shadow-md">
            <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span class="text-xs font-bold uppercase tracking-widest">Início</span>
        </a>
        <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
            <?php renderGoogleTranslate(); ?>
        </div>
    </div>

    <div class="max-w-md w-full bg-white rounded-[40px] shadow-2xl p-10 border border-slate-100 my-8 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

        <h2 class="text-3xl font-extrabold text-slate-800 mb-2 text-center tracking-tight">Comece agora</h2>
        <p class="text-slate-400 text-center mb-10 text-sm font-medium">Crie seu acesso exclusivo ao MailFlow.</p>

        <?php if (isset($_GET['erro'])): ?>
            <div class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-500 rounded-r-2xl text-[11px] text-amber-800 font-bold">
                <?php 
                    if($_GET['erro'] == 'duplicado') echo "Este e-mail já possui uma conta registrada.";
                    if($_GET['erro'] == 'codigo_invalido') echo "Código de convite inválido ou já utilizado.";
                    if($_GET['erro'] == 'codigo_tipo_errado') echo "Este código é para uma categoria diferente.";
                ?>
            </div>
        <?php endif; ?>

        <form action="processar_registro" method="POST" class="space-y-5">
            <div class="bg-blue-50/50 p-5 rounded-3xl border border-blue-100">
                <label class="block text-[10px] font-black text-blue-600 uppercase mb-2 ml-1 tracking-widest">Código de Convite</label>
                <input type="text" name="codigo_convite" required placeholder="DIGITE SEU CÓDIGO" 
                       class="w-full p-4 bg-white border border-blue-200 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 transition-all font-mono font-bold text-center uppercase text-blue-700">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Nome Completo</label>
                <input type="text" name="nome" required placeholder="Ex: João Silva" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="grid md:grid-cols-1 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">E-mail</label>
                    <input type="email" name="email" required placeholder="email@gmail.com" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Senha</label>
                    <input type="password" name="senha" required placeholder="••••••••" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Tipo de Plano</label>
                <select name="tipo" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none cursor-pointer focus:ring-2 focus:ring-blue-500 font-medium text-slate-600 appearance-none">
                    <option value="pessoal">Plano Pessoal (Individual)</option>
                    <option value="empresarial" selected>Plano Empresarial (Equipes)</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white font-extrabold py-5 rounded-[24px] hover:bg-blue-600 transition-all shadow-xl active:scale-[0.97] uppercase text-sm tracking-widest mt-4">
                Finalizar Cadastro
            </button>
        </form>

        <p class="text-center mt-8 text-sm text-slate-400 font-medium">
            Já tem conta? <a href="login" class="text-blue-600 font-extrabold hover:underline">Fazer Login</a>
        </p>
    </div>
</body>
</html>