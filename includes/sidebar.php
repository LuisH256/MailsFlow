<?php
// Define quem é o Administrador da conta (Dono da empresa)
$is_admin = (isset($_SESSION['user_cargo']) && ($_SESSION['user_cargo'] === 'Dono' || $_SESSION['user_cargo'] === 'CEO' || $_SESSION['user_cargo'] === 'Admin'));

// Define se é o Super Admin (Você, dono do site)
$is_superadmin = (isset($_SESSION['is_superadmin']) && $_SESSION['is_superadmin'] == 1);
?>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<aside class="w-64 bg-slate-900 text-white flex flex-col h-screen sticky top-0 shrink-0">
    <div class="p-6 text-2xl font-bold border-b border-slate-800 flex items-center gap-3">
        <img src="img/logo.png" alt="MailFlow Logo" class="w-8 h-8 object-contain"> 
        <span>MailFlow</span>
    </div>
    
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto scrollbar-hide">
        <div class="pb-2 text-[10px] font-bold text-slate-500 uppercase px-3 tracking-widest">Navegação</div>
        <a href="home" class="block p-3 hover:bg-slate-800 rounded-xl transition font-medium text-sm text-slate-300 hover:text-white">
            Dashboard
        </a>
        <a href="criar_template" class="block p-3 hover:bg-slate-800 rounded-xl transition font-medium text-sm text-slate-300 hover:text-white">
            Novo Template
        </a>
        
        <?php if(isset($_SESSION['user_tipo']) && $_SESSION['user_tipo'] == 'empresarial' && $is_admin): ?>
            <div class="pt-6 pb-2 text-[10px] font-bold text-slate-500 uppercase px-3 tracking-widest">Gestão Business</div>
            <a href="gestao_funcionarios" class="block p-3 hover:bg-slate-800 rounded-xl transition font-medium text-sm text-slate-300 hover:text-white">
                Funcionários
            </a>
            <a href="gestao_cargos" class="block p-3 hover:bg-slate-800 rounded-xl transition font-medium text-sm text-slate-300 hover:text-white">
                Cargos
            </a>
        <?php endif; ?>

        <?php if ($is_superadmin): ?>
            <div class="pt-6 pb-2 text-[10px] font-bold text-amber-500 uppercase px-3 tracking-widest text-opacity-70">Sistema Master</div>
            <a href="admin_geral" class="block p-3 mb-1 hover:bg-amber-500/10 text-amber-500 rounded-xl transition font-bold border border-amber-500/10 text-sm">
                Gestão de Contas
            </a>
            <a href="gerenciar_codigos" class="block p-3 hover:bg-amber-500/10 text-amber-500 rounded-xl transition font-bold border border-amber-500/10 text-sm">
                Gerar Convites
            </a>
        <?php endif; ?>
        
        <div class="pt-6 pb-2 text-[10px] font-bold text-slate-500 uppercase px-3 tracking-widest">Ajuda & Conta</div>
        
        <a href="google-callback.php" class="block p-3 hover:bg-slate-800 rounded-xl transition font-medium text-sm text-slate-300 hover:text-white flex items-center gap-2">
            <img src="https://www.gstatic.com/images/branding/product/2x/gmail_48dp.png" class="w-4 h-4" alt="Gmail">
            Conexão Gmail
        </a>

        <a href="perfil" class="block p-3 hover:bg-slate-800 rounded-xl transition font-medium text-sm text-slate-300 hover:text-white">
            Minha Conta
        </a>
        <a href="suporte" class="block p-3 bg-blue-600/10 text-blue-400 hover:bg-blue-600/20 rounded-xl transition font-bold text-sm border border-blue-500/20">
            Suporte Técnico
        </a>

        <div class="pt-8 px-3">
            <a href="index" class="group flex items-center gap-2 text-slate-500 hover:text-white transition-all text-[10px] font-black uppercase tracking-tighter">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Sair para Site Inicial
            </a>
        </div>
    </nav>

    <div class="p-4 border-t border-slate-800/50">
        <a href="logout.php" class="flex items-center gap-2 text-slate-500 hover:text-red-400 text-xs p-3 transition font-bold uppercase tracking-widest">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Deslogar
        </a>
    </div>
</aside>