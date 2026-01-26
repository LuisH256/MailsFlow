<?php 
include 'includes/config.php'; 
verificarLogin(); 

// Busca dados do usuário e da empresa vinculada
$stmt = $pdo->prepare("SELECT u.*, e.nome_fantasia, e.logo FROM usuarios u LEFT JOIN empresas e ON u.empresa_id = e.id WHERE u.id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Verifica se é o Administrador (CEO/Dono)
$is_admin = (in_array($user['cargo'], ['Dono', 'CEO', 'Admin']));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Minha Conta | MailFlow</title>
    <style>
        body { font-family: 'Inter', sans-serif; overflow-x: hidden !important; }
        html { overflow-x: hidden !important; }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden">
    <?php include 'includes/sidebar.php'; ?>
    
    <main class="flex-1 overflow-y-auto p-8">
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-bold text-slate-800">Minha Conta</h2>
                <?php renderGoogleTranslate(); ?>
            </div>
            
            <div class="bg-white rounded-3xl shadow-sm border p-8">
                <form action="atualizar_perfil" method="POST" enctype="multipart/form-data" class="space-y-8">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Seu Nome</label>
                            <input type="text" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" class="w-full p-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">E-mail de Acesso</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full p-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <?php if($is_admin): ?>
                    <div class="pt-6 border-t border-slate-100 space-y-6">
                        <h3 class="text-sm font-bold text-blue-600 uppercase tracking-widest">Gestão da Empresa</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Nome da Empresa</label>
                                <input type="text" name="nome_empresa" value="<?php echo htmlspecialchars($user['nome_fantasia']); ?>" class="w-full p-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Logo da Empresa</label>
                                <div class="flex items-center gap-4 bg-slate-50 p-2 border border-slate-100 rounded-xl">
                                    <?php if($user['logo']): ?>
                                        <img src="uploads/<?php echo $user['logo']; ?>" class="w-10 h-10 object-contain bg-white rounded border">
                                    <?php endif; ?>
                                    <input type="file" name="logo" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="pt-6 border-t border-slate-100">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Nova Senha (deixe em branco para não alterar)</label>
                        <input type="password" name="nova_senha" class="w-full p-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200 active:scale-95">
                        Salvar Todas as Alterações
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>