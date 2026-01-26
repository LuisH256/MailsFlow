<?php
include 'includes/config.php';
verificarLogin();

if (!isset($_SESSION['is_superadmin'])) exit;

$lote = $_GET['lote'] ?? null;

if ($lote) {
    $stmt = $pdo->prepare("SELECT codigo, tipo FROM codigos_acesso WHERE lote_id = ? AND usado = 0");
    $stmt->execute([$lote]);
    $resultados = $stmt->fetchAll();

    if ($resultados) {
        $filename = "Pack_" . $lote . "_" . date('d-m-Y') . ".txt";
        
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        echo "CONVITES MAILFLOW - LOTE: $lote\r\n";
        echo "TIPO: " . strtoupper($resultados[0]['tipo']) . "\r\n";
        echo "----------------------------------\r\n\r\n";

        foreach ($resultados as $row) {
            echo $row['codigo'] . "\r\n";
        }
        exit;
    }
}
header("Location: gerenciar_codigos.php");