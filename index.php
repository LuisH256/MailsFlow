<?php
include 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>MailFlow | Gestão de Templates Profissionais</title>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .goog-te-gadget { font-family: 'Inter', sans-serif !important; }
        /* Esconde a barra superior do Google Translate para manter o design limpo */
        body { top: 0 !important; }
        .skiptranslate { display: none !important; }
        #google_translate_element { display: block !important; }
    </style>
</head>
<body class="bg-white text-slate-900">

    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="img/MFullBlack.png" alt="Logo" class="w-10 h-10">
                <span class="text-xl font-bold tracking-tight">MailFlow</span>
            </div>
            
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                <a href="#como-funciona" class="hover:text-blue-600 transition">Como funciona</a>
                <a href="#planos" class="hover:text-blue-600 transition">Planos</a>
                <a href="#contato" class="hover:text-blue-600 transition">Contato</a>
            </div>

            <div class="flex items-center gap-4">
                <div id="google_translate_wrapper" class="scale-90">
                    <?php renderGoogleTranslate(); ?>
                </div>
                <a href="login" class="text-sm font-semibold text-slate-700 hover:text-blue-600 transition">Entrar</a>
                <a href="registro" class="bg-slate-900 text-white px-5 py-2.5 rounded-full text-sm font-bold hover:bg-blue-600 transition shadow-lg">
                    Começar
                </a>
            </div>
        </div>
    </nav>

    <section class="pt-40 pb-20 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 mb-8 tracking-tight">
                Sua comunicação padronizada <br> <span class="text-blue-600">em um só lugar.</span>
            </h1>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                Crie, gerencie e compartilhe templates de e-mail dinâmicos com sua equipe. Aumente a produtividade e mantenha a identidade visual da sua empresa.
            </p>
            <div class="flex flex-col md:flex-row items-center justify-center gap-4">
                <a href="registro" class="w-full md:w-auto bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-blue-700 transition shadow-xl shadow-blue-200">
                    Registrar com Código
                </a>
                <a href="#planos" class="w-full md:w-auto px-8 py-4 rounded-2xl font-bold text-lg text-slate-600 hover:bg-slate-50 transition border border-slate-200">
                    Ver Planos
                </a>
            </div>
        </div>
    </section>

    <section id="como-funciona" class="py-24 bg-slate-50 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-16 italic text-slate-800">"A padronização é o primeiro passo para a perfeição."</h2>
            <div class="grid md:grid-cols-3 gap-12">
                <div class="p-8">
                    <div class="text-4xl mb-4">✍️</div>
                    <h3 class="font-bold text-xl mb-3">Crie Templates</h3>
                    <p class="text-slate-500 text-sm">Crie modelos flexíveis com variáveis {{campo}} que se adaptam a cada atendimento.</p>
                </div>
                <div class="p-8">
                    <div class="text-4xl mb-4">👥</div>
                    <h3 class="font-bold text-xl mb-3">Gerencie Níveis</h3>
                    <p class="text-slate-500 text-sm">Controle quem pode ver ou editar cada modelo com base nos cargos da sua empresa.</p>
                </div>
                <div class="p-8">
                    <div class="text-4xl mb-4">⚡</div>
                    <h3 class="font-bold text-xl mb-3">Ganhe Velocidade</h3>
                    <p class="text-slate-500 text-sm">Preencha os dados, clique e copie. Sem erros de digitação, sem perda de tempo.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="planos" class="py-24">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black mb-4">Escolha o seu nível de controle</h2>
                <p class="text-slate-500">Soluções para profissionais independentes e empresas estruturadas.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white p-10 rounded-[40px] border border-slate-200 shadow-sm flex flex-col justify-between hover:border-blue-400 transition-all">
                    <div class="mb-8">
                        <span class="text-blue-600 font-bold uppercase tracking-widest text-[10px] bg-blue-50 px-3 py-1 rounded-full">Uso Individual</span>
                        <h3 class="text-2xl font-bold mt-4 text-slate-800">Plano Pessoal</h3>
                        <p class="text-slate-500 mt-4 text-sm leading-relaxed">
                            Apenas você faz o gerenciamento dos seus templates. Ideal para profissionais autônomos que buscam agilidade e organização pessoal no dia a dia.
                        </p>
                    </div>
                    <div>
                        <ul class="space-y-4 mb-10 text-slate-600 text-sm font-medium">
                            <li class="flex items-center gap-3">✅ Painel de templates ilimitado</li>
                            <li class="flex items-center gap-3">✅ Variáveis personalizadas dinâmicas</li>
                            <li class="flex items-center gap-3">✅ Acesso exclusivo ao seu usuário</li>
                        </ul>
                        <button onclick="solicitar('whatsapp', 'Pessoal')" class="w-full py-4 border-2 border-slate-900 rounded-2xl font-bold hover:bg-slate-900 hover:text-white transition">Adquirir Plano Pessoal</button>
                    </div>
                </div>

                <div class="bg-slate-900 p-10 rounded-[40px] text-white shadow-2xl relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute top-8 right-8 bg-blue-500 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-tighter">Foco em Equipe</div>
                    <div class="mb-8">
                        <span class="text-blue-400 font-bold uppercase tracking-widest text-[10px]">Gestão Administrativa</span>
                        <h3 class="text-2xl font-bold mt-4">Plano Empresarial</h3>
                        <p class="text-slate-400 mt-4 text-sm leading-relaxed">
                            Você gestor faz o gerenciamento total. Crie cargos, adicione funcionários e defina quais templates cada cargo pode visualizar. Controle total da comunicação.
                        </p>
                    </div>
                    <div>
                        <ul class="space-y-4 mb-10 text-slate-400 text-sm">
                            <li class="flex items-center gap-3 text-white">✅ Gestão de Funcionários e Contas</li>
                            <li class="flex items-center gap-3 text-white">✅ Criação e Hierarquia de Cargos</li>
                            <li class="flex items-center gap-3 text-white">✅ Controle de visibilidade por setor</li>
                            <li class="flex items-center gap-3 text-white">✅ Dashboard Administrativo Geral</li>
                        </ul>
                        <button onclick="solicitar('whatsapp', 'Empresarial')" class="w-full py-4 bg-blue-600 rounded-2xl font-bold hover:bg-blue-500 transition shadow-lg shadow-blue-500/20">Adquirir Plano Empresarial</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contato" class="py-24 bg-slate-50">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6 text-slate-800">Pronto para transformar seu fluxo?</h2>
            <p class="text-slate-500 mb-12">Escolha como prefere falar conosco para ativar sua licença:</p>
            
            <div class="flex flex-col md:flex-row justify-center gap-6">
                <button onclick="solicitar('whatsapp', 'Geral')" class="flex items-center justify-center gap-4 bg-[#25D366] text-white px-10 py-6 rounded-3xl font-bold text-xl hover:bg-[#20ba5a] transition shadow-lg shadow-emerald-100">
                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" class="w-8 h-8">
                    WhatsApp Direto
                </button>
                
                <button onclick="solicitar('email', 'Geral')" class="flex items-center justify-center gap-4 bg-white text-slate-700 px-10 py-6 rounded-3xl font-bold text-xl hover:bg-slate-100 transition border border-slate-200 shadow-sm">
                    <span class="text-2xl">📧</span>
                    Solicitar via E-mail
                </button>
            </div>
        </div>
    </section>

    <footer class="py-12 border-t text-center text-slate-400 text-sm">
        <p>© 2026 MailFlow. Desenvolvido para produtividade máxima.</p>
    </footer>

    <script>
    function solicitar(metodo, plano = 'Geral') {
        let lang = 'pt';
        
        // Tenta ler o cookie do Google Translate de forma mais precisa
        const name = "googtrans=";
        const decodedCookie = decodeURIComponent(document.cookie);
        const ca = decodedCookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) {
                const value = c.substring(name.length, c.length);
                lang = value.split('/').pop();
            }
        }

        // Caso o cookie falhe, tenta pegar o valor do seletor visual
        if(lang === 'pt') {
            const combo = document.querySelector('.goog-te-combo');
            if (combo && combo.value) lang = combo.value;
        }

        // Redireciona para o processador passando o método, idioma e plano
        window.location.href = `contato_redirecionar.php?metodo=${metodo}&lang=${lang}&plano=${plano}`;
    }
    </script>

</body>
</html>