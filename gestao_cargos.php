<?php 
include 'includes/config.php'; 
verificarLogin(); 

if ($_SESSION['user_tipo'] !== 'empresarial') { header("Location: index"); exit; }

// LÓGICA PARA CRIAR O CARGO
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['novo_cargo'])) {
    $nome_cargo = $_POST['nome_cargo'];
    $empresa_id = $_SESSION['empresa_id'];

    if (!empty($nome_cargo)) {
        $stmt = $pdo->prepare("INSERT INTO cargos (nome_cargo, empresa_id) VALUES (?, ?)");
        $stmt->execute([$nome_cargo, $empresa_id]);
        header("Location: gestao_cargos?sucesso=1");
        exit;
    }
}

// BUSCAR CARGOS DA EMPRESA
$stmt = $pdo->prepare("SELECT * FROM cargos WHERE empresa_id = ?");
$stmt->execute([$_SESSION['empresa_id']]);
$cargos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Cargos | MailFlow</title>
    <style>
        /* Proteção para tradução automática */
        html, body { overflow-x: hidden !important; }
        .goog-te-banner-frame.skiptranslate { display: none !important; }
        body { top: 0px !important; }
    </style>
</head>

<body class="bg-slate-50 flex h-screen overflow-hidden">
    <?php include 'includes/sidebar.php'; ?>
    
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="max-w-5xl mx-auto">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-slate-800">Gestão de Cargos</h2>
                    <p class="text-slate-500 text-sm">Defina as permissões de visibilidade da sua empresa.</p>
                </div>
                <?php renderGoogleTranslate(); ?>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 h-fit">
                    <form method="POST" class="space-y-4">
                        <label class="block text-sm font-bold text-slate-700 ml-1">Criar Novo Cargo</label>
                        <div class="flex flex-col gap-3">
                            <input type="text" name="nome_cargo" required 
                                   class="w-full border border-slate-200 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50 transition-all" 
                                   placeholder="Ex: Vendedor Sênior">
                            <button type="submit" name="novo_cargo" 
                                    class="w-full bg-blue-600 text-white px-6 py-4 rounded-2xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100 active:scale-[0.98]">
                                Adicionar Cargo
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                    <h4 class="text-xs font-bold text-slate-400 uppercase mb-4 tracking-widest ml-1">Cargos Ativos</h4>
                    <div class="space-y-3">
                        <?php if(empty($cargos)): ?>
                            <div class="text-center py-8 text-slate-400 italic text-sm">Nenhum cargo cadastrado.</div>
                        <?php endif; ?>

                        <?php foreach($cargos as $c): ?>
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex justify-between items-center group hover:border-blue-200 hover:bg-white transition-all">
                                <span class="font-semibold text-slate-700"><?php echo htmlspecialchars($c['nome_cargo']); ?></span>
                                <a href="excluir_cargo?id=<?php echo $c['id']; ?>" 
                                   onclick="return confirm('Excluir este cargo? Isso pode afetar o acesso de funcionários vinculados.')"
                                   class="text-red-400 opacity-0 group-hover:opacity-100 transition hover:text-red-600 text-xs font-bold uppercase tracking-tighter">
                                    Excluir
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>