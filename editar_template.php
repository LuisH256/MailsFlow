<?php 
include 'includes/config.php'; 
verificarLogin(); 

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: home"); exit; }

$stmt = $pdo->prepare("SELECT * FROM templates WHERE id = ?");
$stmt->execute([$id]);
$template = $stmt->fetch();

// Se não for o dono e não for empresarial, bloqueia
if (!$template || ($template['criado_por'] != $_SESSION['user_id'] && $_SESSION['user_tipo'] == 'pessoal')) {
    header("Location: index"); exit;
}

$stmtC = $pdo->prepare("SELECT * FROM cargos WHERE empresa_id = ?");
$stmtC->execute([$_SESSION['empresa_id']]);
$cargos = $stmtC->fetchAll();

// Lógica de Atualização
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $visibilidade = $_POST['visibilidade_cargo'] ?? 'todos';

    $up = $pdo->prepare("UPDATE templates SET titulo = ?, conteudo = ?, visibilidade_cargo = ? WHERE id = ?");
    $up->execute([$titulo, $conteudo, $visibilidade, $id]);
    header("Location: home?editado=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Editar Template | MailFlow</title>
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
        <div class="max-w-3xl mx-auto">
            
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-slate-800">Editar Modelo</h2>
                <?php renderGoogleTranslate(); ?>
            </div>

            <form method="POST" class="bg-white p-8 rounded-3xl border shadow-sm space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700">Título do Template</label>
                    <input type="text" name="titulo" value="<?php echo htmlspecialchars($template['titulo']); ?>" class="w-full mt-2 p-4 bg-slate-50 border rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700">Conteúdo (Use {{tag}})</label>
                    <textarea name="conteudo" rows="10" class="w-full mt-2 p-4 bg-slate-50 border rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 font-mono text-sm leading-relaxed"><?php echo htmlspecialchars($template['conteudo']); ?></textarea>
                </div>

                <?php if($_SESSION['user_tipo'] == 'empresarial'): ?>
                <div>
                    <label class="block text-sm font-bold text-slate-700">Visibilidade por Cargo</label>
                    <select name="visibilidade_cargo" class="w-full mt-2 p-4 border bg-white rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                        <option value="todos" <?php echo $template['visibilidade_cargo'] == 'todos' ? 'selected' : ''; ?>>Toda a Empresa</option>
                        <?php foreach($cargos as $c): ?>
                            <option value="<?php echo htmlspecialchars($c['nome_cargo']); ?>" <?php echo $template['visibilidade_cargo'] == $c['nome_cargo'] ? 'selected' : ''; ?>>
                                Apenas <?php echo htmlspecialchars($c['nome_cargo']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>

                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-4 rounded-2xl hover:bg-blue-700 transition shadow-lg active:scale-95">
                        Salvar Alterações
                    </button>
                    <a href="home" class="px-8 py-4 text-slate-500 font-bold hover:bg-slate-100 rounded-2xl transition flex items-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>