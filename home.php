<?php 
include 'includes/config.php';
verificarLogin();

$user_id = $_SESSION['user_id'];
$empresa_id = $_SESSION['empresa_id'];
$user_cargo = $_SESSION['user_cargo'] ?? 'Colaborador';

$is_admin = (in_array($user_cargo, ['Dono', 'CEO', 'Admin']) || (isset($_SESSION['is_superadmin']) && $_SESSION['is_superadmin'] == 1));

$stmtEmp = $pdo->prepare("SELECT e.logo, e.nome_fantasia FROM empresas e JOIN usuarios u ON u.empresa_id = e.id WHERE u.id = ?");
$stmtEmp->execute([$user_id]);
$dadosEmpresa = $stmtEmp->fetch();

if ($_SESSION['user_tipo'] == 'pessoal') {
    $stmt = $pdo->prepare("SELECT * FROM templates WHERE criado_por = ? ORDER BY titulo ASC");
    $stmt->execute([$user_id]);
} else {
    if ($is_admin) {
        $stmt = $pdo->prepare("SELECT t.*, u.nome as autor FROM templates t JOIN usuarios u ON t.criado_por = u.id WHERE u.empresa_id = ? ORDER BY t.titulo ASC");
        $stmt->execute([$empresa_id]);
    } else {
        $stmt = $pdo->prepare("SELECT t.*, u.nome as autor FROM templates t JOIN usuarios u ON t.criado_por = u.id WHERE u.empresa_id = ? AND (t.visibilidade_cargo = 'todos' OR t.visibilidade_cargo = ? OR t.criado_por = ?) ORDER BY t.titulo ASC");
        $stmt->execute([$empresa_id, $user_cargo, $user_id]);
    }
}
$templates = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Dashboard | MailFlow</title>
    <style>
        body { font-family: 'Inter', sans-serif; top: 0 !important; }
        html, body { overflow-x: hidden !important; position: relative; }
        .skiptranslate { display: none !important; }
        #google_translate_element { display: block !important; }
        select { text-overflow: ellipsis; white-space: nowrap; overflow: hidden; }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden">

    <?php include 'includes/sidebar.php'; ?>

    <main class="flex-1 flex flex-col overflow-hidden">
        <header class="h-20 bg-white border-b flex items-center justify-between px-8 shrink-0 shadow-sm z-10">
            <div class="flex items-center gap-4">
                <?php if(!empty($dadosEmpresa['logo'])): ?>
                    <img src="uploads/<?php echo $dadosEmpresa['logo']; ?>" class="h-10 w-10 object-contain rounded-lg border shadow-sm bg-white">
                <?php endif; ?>
                <div>
                    <h1 class="text-lg font-bold text-slate-800 leading-tight"><?php echo $dadosEmpresa['nome_fantasia'] ?? 'MailFlow'; ?></h1>
                    <p class="text-[10px] text-blue-600 font-bold uppercase tracking-widest"><?php echo $user_cargo; ?></p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div id="google_translate_wrapper" class="scale-90">
                    <?php renderGoogleTranslate(); ?>
                </div>
                <div class="relative w-64">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" id="inputPesquisa" onkeyup="filtrarTemplates()" placeholder="Pesquisar..." 
                           class="w-full pl-9 pr-4 py-2 bg-slate-100 border-none rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>
        </header>

        <div class="flex-1 flex overflow-hidden">
            <section class="w-1/3 border-r bg-white overflow-y-auto p-6 space-y-4" id="listaTemplates">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Seus Modelos</span>
                    <span class="bg-blue-50 text-blue-600 text-[10px] px-2 py-1 rounded-full font-bold"><?php echo count($templates); ?></span>
                </div>

                <?php foreach($templates as $t): ?>
                <div class="template-card group bg-white p-4 rounded-2xl border border-slate-100 hover:border-blue-500 hover:shadow-md transition-all cursor-pointer relative"
                     onclick="carregarTemplate(this)"
                     data-titulo="<?php echo htmlspecialchars($t['titulo']); ?>">
                    
                    <textarea class="hidden-content" style="display:none;"><?php echo htmlspecialchars($t['conteudo']); ?></textarea>
                    
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-700 group-hover:text-blue-600 transition-colors"><?php echo htmlspecialchars($t['titulo']); ?></h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[9px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded uppercase font-bold">Cargo: <?php echo htmlspecialchars($t['visibilidade_cargo']); ?></span>
                                <span class="text-[9px] text-slate-400">Por: <?php echo htmlspecialchars($t['autor'] ?? 'Você'); ?></span>
                            </div>
                        </div>
                        
                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity ml-2">
                            <?php if($t['criado_por'] == $user_id || $is_admin): ?>
                                <a href="editar_template?id=<?php echo $t['id']; ?>" class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-blue-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.25 2.25 0 113.182 3.182L11.75 20.25a.75.75 0 01-.53.22H8.25a.75.75 0 01-.75-.75v-2.97a.75.75 0 01.22-.53l10.5-10.5z"></path></svg>
                                </a>
                                <a href="excluir_template?id=<?php echo $t['id']; ?>" 
                                   onclick="event.stopPropagation(); return confirm('Tem certeza que deseja excluir?')" 
                                   class="p-1.5 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>

            <section class="flex-1 bg-slate-50 overflow-y-auto p-10">
                <div id="instrucao_vazia" class="h-full flex flex-col justify-center items-center text-center">
                    <div class="w-20 h-20 bg-white rounded-3xl mb-4 flex items-center justify-center text-slate-300 shadow-sm border border-slate-100">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-400">Selecione um modelo lateral</h2>
                </div>

                <div id="editor_real" class="hidden max-w-3xl mx-auto space-y-6">
                    <div class="flex justify-between items-center">
                        <h2 id="view_titulo" class="text-2xl font-bold text-slate-800"></h2>
                        <button onclick="copiarTexto()" class="bg-blue-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all active:scale-95">Copiar Texto Final</button>
                    </div>

                    <div id="dynamic_inputs" class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm"></div>

                    <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
                        <div class="bg-slate-50 px-6 py-3 border-b">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Visualização do Resultado</span>
                        </div>
                        <div id="preview" class="p-8 text-slate-700 whitespace-pre-wrap leading-relaxed min-h-[200px]"></div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script>
    let templateBase = "";

    function filtrarTemplates() {
        let busca = document.getElementById('inputPesquisa').value.toLowerCase();
        document.querySelectorAll('.template-card').forEach(card => {
            let titulo = card.getAttribute('data-titulo').toLowerCase();
            card.style.display = titulo.includes(busca) ? "block" : "none";
        });
    }

    function carregarTemplate(elemento) {
        const titulo = elemento.getAttribute('data-titulo');
        const conteudo = elemento.querySelector('.hidden-content').value;

        templateBase = conteudo;
        document.getElementById('instrucao_vazia').classList.add('hidden');
        document.getElementById('editor_real').classList.remove('hidden');
        document.getElementById('view_titulo').innerText = titulo;
        
        const container = document.getElementById('dynamic_inputs');
        container.innerHTML = "";

        // Processar Dropdowns [[Rótulo: Opção 1 > Opção 2]]
        const selects = [...conteudo.matchAll(/\[\[(.*?)\]\]/g)];
        selects.forEach((match, index) => {
            let rawContent = match[1];
            let labelText = `Opção ${index + 1}`;
            let optionsPart = rawContent;

            if(rawContent.includes(':')) {
                const parts = rawContent.split(':');
                labelText = parts[0].trim().replace(/_/g, ' ');
                optionsPart = parts[1];
            }

            // Suporta "/" ou ">" como separadores
            const opcoes = optionsPart.split(/[/>]/);
            let selectHtml = `<div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">${labelText}</label>
                <select data-raw-tag="${match[0].replace(/"/g, '&quot;')}" onchange="render()" 
                        class="w-full border border-slate-200 rounded-xl bg-slate-50 p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Selecione...</option>`;
            
            opcoes.forEach(opt => {
                const display = opt.trim();
                if(display) {
                    selectHtml += `<option value="${display.replace(/"/g, '&quot;')}">${display}</option>`;
                }
            });
            
            selectHtml += `</select></div>`;
            container.innerHTML += selectHtml;
        });

        // Processar Inputs {{campo}}
        const tags = [...new Set([...conteudo.matchAll(/{{(.*?)}}/g)].map(m => m[1]))];
        tags.forEach(tag => {
            container.innerHTML += `<div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">${tag.replace(/_/g, ' ')}</label>
                <input type="text" data-tag="${tag}" oninput="render()" placeholder="Preencher ${tag}..." 
                       class="w-full border border-slate-200 rounded-xl bg-slate-50 p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>`;
        });

        if(selects.length === 0 && tags.length === 0) {
            container.innerHTML = "<p class='col-span-2 text-slate-400 italic text-sm text-center py-4'>Este modelo não possui variáveis.</p>";
        }
        
        render();
    }

    function render() {
        let text = templateBase;
        
        // CORREÇÃO AQUI: Se o valor for vazio, substitui por vazio ou um placeholder discreto
        document.querySelectorAll('#dynamic_inputs select').forEach(s => {
            const rawTag = s.getAttribute('data-raw-tag');
            const val = s.value || ""; // Antes era s.value || rawTag
            text = text.replace(rawTag, val);
        });

        document.querySelectorAll('#dynamic_inputs input').forEach(i => {
            const val = i.value || `[${i.dataset.tag.toUpperCase()}]`;
            text = text.replaceAll(`{{${i.dataset.tag}}}`, val);
        });
        
        document.getElementById('preview').innerText = text;
    }

    function copiarTexto() {
        const text = document.getElementById('preview').innerText;
        navigator.clipboard.writeText(text).then(() => alert("Texto copiado!"));
    }
    </script>
</body>
</html>