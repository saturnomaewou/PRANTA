<?php
// Pasta de destino (relativa ao script)
$destino = __DIR__ . '/uploads/';

// Cria a pasta se não existir
if (!is_dir($destino)) {
    mkdir($destino, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['arquivo'])) {
    $file = $_FILES['arquivo'];

    // Valida tipo e erros
    if ($file['type'] === 'application/pdf' && $file['error'] === UPLOAD_ERR_OK) {

        // Limite de 10 MB como exemplo
        if ($file['size'] <= 10 * 1024 * 1024) {
            // Gera nome único para evitar conflitos
            $nomeSeguro = uniqid('pdf_') . '_' . basename($file['name']);
            $caminhoFinal = $destino . $nomeSeguro;

            if (move_uploaded_file($file['tmp_name'], $caminhoFinal)) {
                echo "<p class='message'>Upload bem-sucedido! Arquivo salvo em uploads/{$nomeSeguro}</p>";
            } else {
                echo "<p class='error'>Falha ao mover o arquivo para a pasta.</p>";
            }
        } else {
            echo "<p class='error'>Arquivo muito grande. Máximo permitido: 10 MB.</p>";
        }

    } else {
        echo "<p class='error'>Envio inválido ou tipo de arquivo não permitido.</p>";
    }

} else {
    echo "<p class='error'>Nenhum arquivo foi enviado.</p>";
}
?>
