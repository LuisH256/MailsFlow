<?php
include 'includes/config.php';
verificarLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $criado_por = $_SESSION['user_id'];
    
    // Se não for empresarial, a visibilidade padrão é 'todos'
    $visibilidade = isset($_POST['visibilidade_cargo']) ? $_POST['visibilidade_cargo'] : 'todos';

    $stmt = $pdo->prepare("INSERT INTO templates (titulo, conteudo, criado_por, visibilidade_cargo) VALUES (?, ?, ?, ?)");
    $stmt->execute([$titulo, $conteudo, $criado_por, $visibilidade]);

    header("Location: home.php?sucesso=1");
}