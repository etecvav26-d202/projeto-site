<?php

session_start();

require_once 'config/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['carrinho'])) {
    header('Location: carrinho.php');
    exit;
}

$carrinho = $_SESSION['carrinho'];

$ids = array_keys($carrinho);

$placeholders = implode(
    ',',
    array_fill(0, count($ids), '?')
);

$stmt = $pdo->prepare("
    SELECT *
    FROM produtos
    WHERE id IN ($placeholders)
    AND ativo = 1
");

$stmt->execute($ids);

$produtos = $stmt->fetchAll();

$total = 0;

foreach ($produtos as $produto) {

    $quantidade = $carrinho[$produto['id']] ?? 0;

    $total += $produto['preco'] * $quantidade;
}

if ($total <= 0) {
    header('Location: carrinho.php');
    exit;
}

try {

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO pedidos
        (usuario_id, total, status)
        VALUES (?, ?, 'confirmado')
    ");

    $stmt->execute([
        $_SESSION['usuario_id'],
        $total
    ]);

    $pedidoId = $pdo->lastInsertId();

    $stmtItem = $pdo->prepare("
        INSERT INTO pedido_itens
        (pedido_id, produto_id, quantidade, preco)
        VALUES (?, ?, ?, ?)
    ");

    foreach ($produtos as $produto) {

        $quantidade = $carrinho[$produto['id']] ?? 0;

        $stmtItem->execute([
            $pedidoId,
            $produto['id'],
            $quantidade,
            $produto['preco']
        ]);
    }

    $pdo->commit();

    $_SESSION['carrinho'] = [];

    header("Location: pedido_confirmado.php?id=$pedidoId");
    exit;

} catch (PDOException $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    die('Não foi possível finalizar o pedido.');
}