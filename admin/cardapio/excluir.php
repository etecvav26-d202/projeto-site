<?php

require_once '../../config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT imagem
    FROM produtos
    WHERE id = ?
");

$stmt->execute([$id]);

$produto = $stmt->fetch();

if ($produto) {

    if (!empty($produto['imagem'])) {

        $arquivo = '../../' . $produto['imagem'];

        if (file_exists($arquivo)) {
            unlink($arquivo);
        }
    }

    $stmt = $pdo->prepare("
        DELETE FROM produtos
        WHERE id = ?
    ");

    $stmt->execute([$id]);
}

header('Location: index.php');
exit;