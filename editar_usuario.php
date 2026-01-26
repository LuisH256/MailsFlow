<?php
include 'includes/config.php';
verificarLogin();

if (!isset($_SESSION['is_superadmin']) || (int)$_SESSION['is_superadmin'] !== 1) {
    header("Location: index?erro=acesso_negado");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) { 
    die("Usuário não encontrado ou ID ausente."); 
}

// Busca dados atuais do usuário
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$u = $stmt->fetch();

if (!$u) { die("Usuário inexistente no banco."); }

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cargo = $_POST['cargo'];
    $is_admin = $_POST['is_superadmin'];

    try {
        $update = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, cargo = ?, is_superadmin = ? WHERE id = ?");
        $update->execute([$nome, $email, $cargo, $is_admin, $id]);
        $mensagem = "Alterações salvas com sucesso!";
        
        // Atualiza os dados na tela
        $u['nome'] = $nome;
        $u['email'] = $email;
        $u['cargo'] = $cargo;
        $u['is_superadmin'] = $is_admin;
    } catch (Exception $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Editar Usuário | Master</title>
</head>
<body class="bg-slate-900 flex h-screen overflow-hidden">
    <?php include 'includes/sidebar.php'; ?>
    
    <main class="flex-1 overflow-y-auto p-8 bg-slate-50 rounded-l-[40px]">
        <div class="max-w-2xl mx-auto">
            <a href="admin_geral" class="text-indigo-600 font-bold text-sm mb-4 inline-block italic">← Voltar ao Painel Master</a>
            
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <h2 class="text-2xl font-black text-slate-800 mb-2">Editar Usuário</h2>
                <p class="text-slate-400 text-xs mb-8 uppercase font-bold tracking-widest">ID: #<?php echo $u['id']; ?></p>

                <?php if($mensagem): ?>
                    <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-2xl font-bold text-xs border border-emerald-100">
                        <?php echo $mensagem; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-5">
                    <div class="grid grid-cols-1 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Nome Completo</label>
                            <input type="text" name="nome" value="<?php echo htmlspecialchars($u['nome']); ?>" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500 font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">E-mail de Acesso</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($u['email']); ?>" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500 font-semibold">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Cargo</label>
                                <input type="text" name="cargo" value="<?php echo htmlspecialchars($u['cargo']); ?>" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500 font-semibold text-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Nível de Acesso</label>
                                <select name="is_superadmin" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none cursor-pointer focus:ring-2 focus:ring-indigo-500 font-bold text-sm">
                                    <option value="0" <?php echo $u['is_superadmin'] == 0 ? 'selected' : ''; ?>>Usuário Comum</option>
                                    <option value="1" <?php echo $u['is_superadmin'] == 1 ? 'selected' : ''; ?>>MASTER ADMIN</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-5 rounded-2xl hover:bg-black transition-all shadow-xl active:scale-95 mt-4">
                        Salvar Alterações
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>