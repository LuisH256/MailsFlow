<?php
include 'includes/config.php';
verificarLogin();

if (!isset($_SESSION['is_superadmin']) || (int)$_SESSION['is_superadmin'] !== 1) {
    header("Location: index.php?erro=acesso_negado");
    exit;
}

// Lógica de Remoção
if (isset($_GET['remover'])) {
    $stmt = $pdo->prepare("DELETE FROM codigos_acesso WHERE id = ? AND usado = 0");
    $stmt->execute([$_GET['remover']]);
    header("Location: gerenciar_codigos.php?sucesso=removido");
}

// Lógica de Geração
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['gerar'])) {
    $quantidade = (int)$_POST['quantidade'];
    $tipo = $_POST['tipo'];
    $lote_id = ($quantidade > 1) ? "LOT-" . strtoupper(substr(md5(uniqid()), 0, 6)) : null;

    for ($i = 0; $i < $quantidade; $i++) {
        $novo_codigo = strtoupper(substr(md5(uniqid()), 0, 8));
        $stmt = $pdo->prepare("INSERT INTO codigos_acesso (codigo, tipo, usado, lote_id) VALUES (?, ?, 0, ?)");
        $stmt->execute([$novo_codigo, $tipo, $lote_id]);
    }
    header("Location: gerenciar_codigos.php?sucesso=gerado&lote=" . $lote_id);
}

// Busca códigos não usados
$codigos = $pdo->query("SELECT * FROM codigos_acesso WHERE usado = 0 ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Master Codes | MailFlow</title>
</head>
<body class="bg-slate-900 flex h-screen overflow-hidden">
    <?php include 'includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto p-8 bg-slate-50 rounded-l-[40px]">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-3xl font-black text-slate-800 mb-8">Gerenciador de Convites</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-400 text-xs uppercase mb-4">Gerar Único</h3>
                    <form method="POST" class="flex gap-2">
                        <input type="hidden" name="gerar" value="1">
                        <input type="hidden" name="quantidade" value="1">
                        <select name="tipo" class="flex-1 p-3 bg-slate-50 border rounded-xl text-sm">
                            <option value="pessoal">Pessoal</option>
                            <option value="empresarial">Empresarial</option>
                        </select>
                        <button class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold text-sm">Gerar</button>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-400 text-xs uppercase mb-4">Gerar Pack (Lote)</h3>
                    <form method="POST" class="flex gap-2">
                        <input type="hidden" name="gerar" value="1">
                        <input type="number" name="quantidade" placeholder="Qtd" class="w-20 p-3 bg-slate-50 border rounded-xl text-sm">
                        <select name="tipo" class="flex-1 p-3 bg-slate-50 border rounded-xl text-sm">
                            <option value="pessoal">Pessoal</option>
                            <option value="empresarial">Empresarial</option>
                        </select>
                        <button class="bg-slate-900 text-white px-6 py-3 rounded-xl font-bold text-sm">Gerar Pack</button>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b">
                        <tr>
                            <th class="p-4 text-[10px] font-bold text-slate-400 uppercase">Código / Lote</th>
                            <th class="p-4 text-[10px] font-bold text-slate-400 uppercase">Categoria</th>
                            <th class="p-4 text-[10px] font-bold text-slate-400 uppercase text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach($codigos as $c): ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono font-bold text-slate-700"><?php echo $c['codigo']; ?></span>
                                    <?php if($c['lote_id']): ?>
                                        <span class="text-[9px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full font-bold"><?php echo $c['lote_id']; ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="text-[10px] font-black uppercase <?php echo $c['tipo'] == 'empresarial' ? 'text-amber-500' : 'text-blue-500'; ?>">
                                    <?php echo $c['tipo']; ?>
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button onclick="copiarTexto('<?php echo $c['codigo']; ?>')" class="p-2 hover:bg-indigo-50 text-indigo-600 rounded-lg transition" title="Copiar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </button>

                                    <?php if($c['lote_id']): ?>
                                    <a href="exportar_codigos.php?lote=<?php echo $c['lote_id']; ?>" class="p-2 hover:bg-emerald-50 text-emerald-600 rounded-lg transition" title="Baixar Lote">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>
                                    <?php endif; ?>

                                    <a href="?remover=<?php echo $c['id']; ?>" onclick="return confirm('Excluir código?')" class="p-2 hover:bg-red-50 text-red-500 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
    function copiarTexto(texto) {
        navigator.clipboard.writeText(texto);
        alert('Código copiado: ' + texto);
    }
    </script>
</body>
</html>