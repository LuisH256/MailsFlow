<?php
include 'includes/config.php';

$metodo = $_GET['metodo'] ?? '';
$lang = $_GET['lang'] ?? 'pt';
$plano = $_GET['plano'] ?? 'Pessoal'; // Captura o plano vindo da URL

$short_lang = substr(strtolower($lang), 0, 2);

// Mensagens para WhatsApp
$mensagens_wa = [
    'pt' => "Olá! Gostaria de saber mais sobre o plano $plano do MailFlow.",
    'en' => "Hello! I would like to know more about the MailFlow $plano plan.",
    'es' => "¡Hola! Me gustaría saber más sobre el plan $plano de MailFlow.",
    'fr' => "Bonjour! Je voudrais en savoir plus sur le forfait $plano de MailFlow."
];

$texto_wa = urlencode($mensagens_wa[$short_lang] ?? $mensagens_wa['pt']);

if ($metodo === 'whatsapp') {
    header("Location: https://wa.me/5573999215400?text=$texto_wa");
} else {
    // Agora redireciona para a página de instruções de e-mail passando o plano
    header("Location: instrucoes_email.php?plano=$plano");
}
exit;