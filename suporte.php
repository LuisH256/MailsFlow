<?php
include 'includes/config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Suporte | MailFlow</title>
    <style>
        body { font-family: 'Inter', sans-serif; top: 0 !important; }
        .goog-te-gadget { font-family: 'Inter', sans-serif !important; }
        .skiptranslate { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 flex min-h-screen">

    <?php include 'includes/sidebar.php'; ?>

    <main class="flex-1 p-8 md:p-12">
        <div class="max-w-5xl mx-auto">
            
            <div class="flex justify-between items-start mb-12">
                <header>
                    <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Central de Ajuda</h1>
                    <p class="text-slate-500 mt-2">Suporte técnico e auxílio operacional.</p>
                </header>
                <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
                    <?php renderGoogleTranslate(); ?>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 mb-12">
                
                <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col justify-between border-b-4 border-b-blue-500">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 mb-4 tracking-tight">Importação de Templates</h3>
                        <p id="msg-import" class="text-slate-500 text-sm leading-relaxed mb-6 font-medium">
                            Olá! Gostaria de suporte para a Importação em Massa. Já possuo templates prontos e quero integrá-los ao MailFlow.
                        </p>
                        <p class="text-slate-400 text-[13px] leading-relaxed mb-8">
                            Se você já utiliza modelos no Gmail, Word ou TXT, nossa equipe pode realizar a migração em massa para o seu painel MailFlow.
                        </p>
                    </div>
                    
                    <button onclick="enviarWhats('msg-import')" class="flex items-center justify-center gap-3 w-full py-4 bg-[#25D366] text-white rounded-2xl font-bold hover:scale-[1.02] transition-all shadow-lg shadow-emerald-100">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" class="w-5 h-5 brightness-0 invert"> Falar sobre Importação
                    </button>
                </div>

                <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col justify-between border-b-4 border-b-indigo-500">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 mb-4 tracking-tight">Dúvidas e Criação</h3>
                        <p id="msg-duvida" class="text-slate-500 text-sm leading-relaxed mb-6 font-medium">
                            Olá! Preciso de ajuda com a criação de templates no MailFlow. Tenho dúvidas sobre as funcionalidades do painel.
                        </p>
                        <p class="text-slate-400 text-[13px] leading-relaxed mb-8">
                            Se você está encontrando dificuldades para configurar seus primeiros templates ou gerenciar sua equipe.
                        </p>
                    </div>

                    <button onclick="enviarWhats('msg-duvida')" class="flex items-center justify-center gap-3 w-full py-4 bg-[#25D366] text-white rounded-2xl font-bold hover:scale-[1.02] transition-all shadow-lg shadow-emerald-100">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" class="w-5 h-5 brightness-0 invert"> Suporte Operacional
                    </button>
                </div>
            </div>

            <div class="bg-slate-900 rounded-[40px] p-10 text-white relative overflow-hidden">
                <div class="relative z-10 grid md:grid-cols-2 gap-10">
                    <div>
                        <span class="bg-blue-500 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Contato via E-mail</span>
                        <h2 class="text-2xl font-bold mt-4 mb-4">Prefere enviar um e-mail?</h2>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Caso sua solicitação inclua anexos ou listas de funcionários, envie diretamente para nosso departamento de suporte técnico.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-white/5 border border-white/10 p-4 rounded-2xl">
                            <span class="text-[10px] font-bold text-slate-500 uppercase block mb-1">Destinatário:</span>
                            <p class="text-blue-400 font-mono font-bold">lhenriqur29@gmail.com</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 p-4 rounded-2xl">
                            <span class="text-[10px] font-bold text-slate-500 uppercase block mb-1">Assunto Sugerido:</span>
                            <p class="text-slate-200 font-medium">Suporte Técnico - ID: #<?php echo $_SESSION['user_id']; ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        function enviarWhats(idElemento) {
            // Pega o texto do elemento (que já foi traduzido visualmente pelo Google Translate)
            const textoTraduzido = document.getElementById(idElemento).innerText;
            const numero = "5573999215400";
            // Codifica para URL e redireciona
            const url = `https://wa.me/${numero}?text=${encodeURIComponent(textoTraduzido)}`;
            window.open(url, '_blank');
        }
    </script>

</body>
</html>