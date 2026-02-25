<?php
session_start();

// --- CONFIGURAÇÕES DE BANCO DE DADOS ---
$host = 'localhost';
$db   = 'XXXXX'; 
$user = 'XXXXX';
$pass = 'XXXXX';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro crítico de conexão.");
}

// --- FUNÇÕES DE SISTEMA ---

function verificarLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}

function renderTemplate($conteudo, $variaveis) {
    foreach ($variaveis as $tag => $valor) {
        $conteudo = str_replace("{{" . $tag . "}}", $valor, $conteudo);
    }
    return $conteudo;
}

// --- COMPONENTE DO GOOGLE TRANSLATE ---
function renderGoogleTranslate() {
    ?>
    <div id="google_translate_element" style="display:none;"></div>
    
    <select id="language-selector" onchange="translatePage(this.value)" class="bg-white border border-slate-200 text-slate-600 text-[11px] font-bold uppercase tracking-wider px-3 py-2 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition-all shadow-sm">
        <option value="en">English</option>
        <option value="pt">Português</option>
        <option value="fr">Français</option>
    </select>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'pt',
                includedLanguages: 'en,fr,pt',
                autoDisplay: false
            }, 'google_translate_element');
        }

        function translatePage(lang) {
            if (!lang) return;
            localStorage.setItem('user_lang', lang);
            var select = document.querySelector("select.goog-te-combo");
            if (select) {
                select.value = lang;
                select.dispatchEvent(new Event('change'));
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            let savedLang = localStorage.getItem('user_lang') || 'en';
            const selector = document.getElementById('language-selector');
            if(selector) selector.value = savedLang;
            
            setTimeout(() => { translatePage(savedLang); }, 1000);
        });
    </script>
    
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <style>
        .goog-te-banner-frame.skiptranslate, .goog-te-gadget-icon, #goog-gt-tt { display: none !important; }
        body { top: 0px !important; position: static !important; }
        .goog-text-highlight { background-color: transparent !important; box-shadow: none !important; }
        iframe.skiptranslate { display: none !important; }
        html, body { overflow-x: hidden !important; }
    </style>
    <?php

}
