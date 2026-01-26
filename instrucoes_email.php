<?php
include 'includes/config.php';
$plano = $_GET['plano'] ?? 'Não especificado';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Instruções de Contato | MailFlow</title>
    <style>
        body { font-family: 'Inter', sans-serif; top: 0 !important; }
        .goog-te-gadget { font-family: 'Inter', sans-serif !important; }
        .skiptranslate { display: none !important; }
        .copy-success { color: #10b981 !important; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">

    <div class="max-w-xl w-full bg-white rounded-[45px] shadow-2xl p-10 border border-slate-100 text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

        <div class="flex justify-between items-start mb-8">
            <a href="home" class="p-3 bg-slate-50 hover:bg-slate-100 rounded-2xl text-slate-400 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div id="google_translate_element">
                <?php renderGoogleTranslate(); ?>
            </div>
        </div>

        <div class="w-24 h-24 bg-blue-50 text-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-6 text-4xl shadow-inner">
            📧
        </div>

        <h2 class="text-3xl font-extrabold text-slate-800 mb-3 tracking-tight">Quase lá!</h2>
        <p class="text-slate-500 mb-10 leading-relaxed">Siga as instruções abaixo para ativar o seu plano <span class="font-bold text-blue-600"><?php echo ucfirst($plano); ?></span>.</p>

        <div class="space-y-4 text-left">
            <div class="group bg-slate-50 p-5 rounded-3xl border border-slate-100 hover:border-blue-200 transition-all relative">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1 ml-1">Enviar para:</span>
                <div class="flex items-center justify-between">
                    <p id="target-email" class="font-bold text-slate-700">lhenriqur29@gmail.com</p>
                    <button onclick="copyToClipboard('target-email', this)" class="text-blue-600 p-2 hover:bg-blue-50 rounded-xl transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                        <span class="text-xs font-bold uppercase">Copiar</span>
                    </button>
                </div>
            </div>

            <div class="group bg-slate-50 p-5 rounded-3xl border border-slate-100 hover:border-blue-200 transition-all relative">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1 ml-1">Assunto:</span>
                <div class="flex items-center justify-between">
                    <p id="target-subject" class="font-bold text-slate-700">Solicitação de plano - <?php echo ucfirst($plano); ?></p>
                    <button onclick="copyToClipboard('target-subject', this)" class="text-blue-600 p-2 hover:bg-blue-50 rounded-xl transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                        <span class="text-xs font-bold uppercase">Copiar</span>
                    </button>
                </div>
            </div>

            <div class="bg-indigo-600 p-7 rounded-[32px] shadow-lg shadow-indigo-100 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-white/10 text-6xl rotate-12">📄</div>
                <span class="text-[10px] font-bold text-indigo-200 uppercase tracking-widest block mb-3">Corpo do E-mail (Copie e Preencha):</span>
                <div id="target-body" class="text-white text-sm leading-loose font-medium">
                    Nome Completo: <br>
                    Outro meio de contato (WhatsApp/Tel): <br>
                    Dúvidas ou Observações: 
                </div>
                <button onclick="copyToClipboard('target-body', this, true)" class="mt-4 w-full bg-white/10 hover:bg-white/20 text-white py-3 rounded-2xl text-xs font-bold uppercase transition border border-white/20 backdrop-blur-sm">
                    Copiar texto do corpo
                </button>
            </div>
        </div>

        <p class="mt-10 text-slate-400 text-[11px] leading-relaxed">
            * Após o envio, nossa equipe entrará em contato em até 24 horas úteis para finalizar sua ativação.
        </p>
    </div>

    <script>
    function copyToClipboard(elementId, btn, isBody = false) {
        const text = document.getElementById(elementId).innerText;
        const originalBtnHTML = btn.innerHTML;

        navigator.clipboard.writeText(text).then(() => {
            btn.innerHTML = `
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="text-xs font-bold uppercase text-emerald-400 italic">Copiado!</span>
            `;
            btn.classList.add('copy-success');
            
            setTimeout(() => {
                btn.innerHTML = originalBtnHTML;
                btn.classList.remove('copy-success');
            }, 2000);
        });
    }
    </script>

</body>
</html>