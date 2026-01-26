<?php 
include 'includes/config.php'; 
verificarLogin(); 

if (!isset($_SESSION['is_superadmin']) || (int)$_SESSION['is_superadmin'] !== 1) {
    header("Location: index.php?erro=acesso_negado");
    exit;
}

// Listagem com informações de Usuário e Empresa
$usuarios = $pdo->query("SELECT u.id as user_id, u.nome, u.email, u.status as user_status, 
                         e.nome_fantasia, e.id as empresa_id, e.status as empresa_status
                         FROM usuarios u 
                         LEFT JOIN empresas e ON u.empresa_id = e.id 
                         ORDER BY u.id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Master Panel | MailFlow</title>
</head>
<body class="bg-slate-900 flex h-screen overflow-hidden">
    <?php include 'includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto p-8 bg-slate-50 rounded-l-[40px]">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-black text-slate-800 mb-10">Gestão de Contas</h2>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b">
                        <tr>
                            <th class="p-4 text-[10px] font-bold text-slate-400 uppercase">Entidade</th>
                            <th class="p-4 text-[10px] font-bold text-slate-400 uppercase">Status</th>
                            <th class="p-4 text-[10px] font-bold text-slate-400 uppercase text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach($usuarios as $user): 
                            $is_empresa = !empty($user['empresa_id']);
                            $id_acao = $is_empresa ? $user['empresa_id'] : $user['user_id'];
                            $tipo_acao = $is_empresa ? 'empresa' : 'usuario';
                            $status_atual = $is_empresa ? $user['empresa_status'] : $user['user_status'];
                        ?>
                        <tr class="hover:bg-slate-50 transition <?php echo ($status_atual == 'suspenso') ? 'opacity-60 bg-red-50/30' : ''; ?>">
                            <td class="p-4">
                                <p class="font-bold text-slate-700"><?php echo htmlspecialchars($is_empresa ? $user['nome_fantasia'] : $user['nome']); ?></p>
                                <p class="text-xs text-slate-400"><?php echo $is_empresa ? "Empresa (Resp: {$user['nome']})" : "Conta Pessoal"; ?></p>
                            </td>
                            <td class="p-4">
                                <span class="text-[10px] px-2 py-1 rounded-full font-black uppercase <?php echo ($status_atual == 'suspenso') ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'; ?>">
                                    <?php echo $status_atual ?? 'ativo'; ?>
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex justify-center gap-3 text-[10px] font-black uppercase">
                                    <a href="Editar-Usuario?id=<?php echo $user['user_id']; ?>">Editar</a>

                                    <?php if($status_atual == 'suspenso'): ?>
                                        <a href="ativar.php?tipo=<?php echo $tipo_acao; ?>&id=<?php echo $id_acao; ?>" class="text-emerald-500 hover:text-emerald-700">Ativar</a>
                                    <?php else: ?>
                                        <a href="suspender.php?tipo=<?php echo $tipo_acao; ?>&id=<?php echo $id_acao; ?>" onclick="return confirm('Suspender?')" class="text-orange-500 hover:text-orange-700">Suspender</a>
                                    <?php endif; ?>

                                    <a href="remover.php?tipo=<?php echo $tipo_acao; ?>&id=<?php echo $id_acao; ?>" 
                                       onclick="return confirm('PERIGO: Esta ação é irreversível. Apagar tudo?')" 
                                       class="text-red-500 hover:text-red-700">Remover</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>