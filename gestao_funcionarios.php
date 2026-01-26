<?php 
include 'includes/config.php'; 
verificarLogin(); 

// Apenas contas empresariais acessam aqui
if ($_SESSION['user_tipo'] !== 'empresarial') {
    header("Location: index.php");
    exit;
}

$empresa_id = $_SESSION['empresa_id'];

// Buscar funcionários da empresa (exceto o próprio dono logado)
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE empresa_id = ? AND id != ?");
$stmt->execute([$empresa_id, $_SESSION['user_id']]);
$funcionarios = $stmt->fetchAll();

// Buscar lista de cargos cadastrados para o Select
$stmtC = $pdo->prepare("SELECT * FROM cargos WHERE empresa_id = ?");
$stmtC->execute([$empresa_id]);
$cargos = $stmtC->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Equipe | MailFlow</title>
    <style>
        /* Proteção para tradução automática e layout */
        html, body { overflow-x: hidden !important; }
        .goog-te-banner-frame.skiptranslate { display: none !important; }
        body { top: 0px !important; }
        /* Garante que o modal fique por cima de tudo */
        #modal_add { z-index: 9999; }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden">

    <?php include 'includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto p-8">
        <div class="max-w-5xl mx-auto">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-slate-800">Gerenciar Funcionários</h2>
                    <p class="text-slate-500 text-sm">Controle quem tem acesso aos templates da sua empresa.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <?php renderGoogleTranslate(); ?>
                    <button onclick="document.getElementById('modal_add').classList.remove('hidden')" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center gap-2 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>Novo Funcionário</span>
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="p-4 font-bold text-slate-600 text-xs uppercase tracking-wider">Nome</th>
                            <th class="p-4 font-bold text-slate-600 text-xs uppercase tracking-wider">E-mail (Gmail)</th>
                            <th class="p-4 font-bold text-slate-600 text-xs uppercase tracking-wider">Cargo</th>
                            <th class="p-4 font-bold text-slate-600 text-xs uppercase tracking-wider text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($funcionarios)): ?>
                            <tr>
                                <td colspan="4" class="p-12 text-center text-slate-400 italic">Nenhum colaborador cadastrado ainda.</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach($funcionarios as $f): ?>
                        <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition">
                            <td class="p-4 text-slate-800 font-semibold"><?php echo htmlspecialchars($f['nome']); ?></td>
                            <td class="p-4 text-slate-500 text-sm"><?php echo htmlspecialchars($f['email']); ?></td>
                            <td class="p-4">
                                <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-[10px] font-black uppercase border border-blue-100">
                                    <?php echo htmlspecialchars($f['cargo']); ?>
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <a href="excluir_usuario.php?id=<?php echo $f['id']; ?>" 
                                   onclick="return confirm('Tem certeza que deseja remover o acesso deste usuário?')" 
                                   class="text-red-400 hover:text-red-600 font-bold text-xs uppercase tracking-tighter transition">
                                    Remover
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="modal_add" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-slate-800">Cadastrar Colaborador</h3>
                <button onclick="document.getElementById('modal_add').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="processar_funcionario.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1 ml-1">Nome Completo</label>
                    <input type="text" name="nome" required placeholder="Ex: Jane Doe" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1 ml-1">Gmail / E-mail</label>
                    <input type="email" name="email" required placeholder="usuario@gmail.com" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1 ml-1">Senha de Acesso</label>
                    <input type="password" name="senha" required placeholder="••••••••" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1 ml-1">Atribuir Cargo</label>
                    <select name="cargo" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                        <?php foreach($cargos as $c): ?>
                            <option value="<?php echo htmlspecialchars($c['nome_cargo']); ?>"><?php echo htmlspecialchars($c['nome_cargo']); ?></option>
                        <?php endforeach; ?>
                        <option value="Colaborador">Outro / Geral</option>
                    </select>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition shadow-lg active:scale-95">Criar Acesso</button>
                    <button type="button" onclick="document.getElementById('modal_add').classList.add('hidden')" class="px-6 py-3 text-slate-500 font-bold hover:bg-slate-100 rounded-xl transition">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>