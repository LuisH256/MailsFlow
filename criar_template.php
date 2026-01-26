<?php 
include 'includes/config.php'; 
verificarLogin(); 

$cargos = [];
if ($_SESSION['user_tipo'] == 'empresarial') {
    $stmt = $pdo->prepare("SELECT DISTINCT cargo FROM usuarios WHERE empresa_id = ? AND cargo IS NOT NULL");
    $stmt->execute([$_SESSION['empresa_id']]);
    $cargos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Novo Template | MailFlow</title>
    <style>
        body { font-family: 'Inter', sans-serif; top: 0 !important; }
        .skiptranslate { display: none !important; }
        #google_translate_element { display: block !important; }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden">

    <?php include 'includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto p-8">
        <div class="max-w-5xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="home" class="p-2 bg-white border rounded-lg hover:bg-slate-100 shadow-sm transition">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                    <h2 class="text-3xl font-extrabold text-slate-800">Criar Novo Template</h2>
                </div>
                <div id="google_translate_wrapper" class="scale-90">
                    <?php renderGoogleTranslate(); ?>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <form action="salvar_template" method="POST" class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Título do Template</label>
                            <input type="text" name="titulo" required placeholder="Ex: Onboarding de TI" 
                                   class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Corpo do E-mail</label>
                            <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100 mb-4">
                                <p class="text-[11px] text-blue-700 leading-relaxed">
                                    <strong>Regra do Menu:</strong> Use <code>[[Rótulo: Opção 1 > Opção 2]]</code> para listas de escolha.<br>
                                    <strong>Variável:</strong> Use <code>{{nome}}</code> para campos de texto manual.
                                </p>
                            </div>
                            <textarea id="templateInput" name="conteudo" rows="12" required 
                                      class="w-full p-5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none font-mono text-sm"
                                      placeholder="Olá {{nome}}, escolha seu kit: [[Kit: MacBook > Dell > Lenovo]]"
                                      oninput="updatePreview()"></textarea>
                        </div>

                        <?php if($_SESSION['user_tipo'] == 'empresarial'): ?>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Quem pode ver este modelo?</label>
                            <select name="visibilidade_cargo" class="w-full p-4 bg-white border border-slate-200 rounded-2xl outline-none">
                                <option value="todos">Toda a Empresa</option>
                                <?php foreach($cargos as $c): ?>
                                    <option value="<?php echo htmlspecialchars($c['cargo']); ?>"><?php echo htmlspecialchars($c['cargo']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg transition-transform active:scale-95">
                            Salvar Template
                        </button>
                    </form>
                </div>

                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest px-2">Visualização em Tempo Real</h3>
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 min-h-[400px]">
                        <div id="previewArea" class="text-slate-700 whitespace-pre-wrap leading-relaxed"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
    function updatePreview() {
        const input = document.getElementById('templateInput').value;
        const preview = document.getElementById('previewArea');
        if(!input.trim()) { 
            preview.innerHTML = '<p class="text-slate-400 italic">Digite algo para ver o preview...</p>'; 
            return; 
        }

        // Processar Menus Dinâmicos
        let processed = input.replace(/\[\[(.*?)\]\]/g, function(match, content) {
            let label = "Escolha";
            let optionsString = content;
            if (content.includes(':')) {
                const parts = content.split(':');
                label = parts[0].trim();
                optionsString = parts[1];
            }
            
            // Aceita ">" ou "/" como separadores de opções no editor
            const options = optionsString.split(/[/>]/); 
            
            let selectHtml = `<div class="inline-flex flex-col border border-blue-100 px-2 py-0.5 rounded bg-blue-50 mx-1 align-middle">
                                <span class="block font-black uppercase text-blue-500 text-[8px] mb-0">${label}</span>
                                <select class="bg-transparent outline-none text-xs border-none p-0 h-auto font-bold text-slate-600">`;
            options.forEach(opt => { 
                const display = opt.trim();
                if(display) selectHtml += `<option>${display}</option>`; 
            });
            return selectHtml + `</select></div>`;
        });

        // Processar Variáveis de Texto
        processed = processed.replace(/{{(.*?)}}/g, `<span class="bg-yellow-100 text-yellow-700 px-1 rounded font-medium">[$1]</span>`);
        
        preview.innerHTML = processed;
    }
    updatePreview();
    </script>
</body>
</html>