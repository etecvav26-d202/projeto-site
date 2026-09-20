<?php

session_start();

require_once 'config/conexao.php';

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_GET['remover'])) {

    $id = filter_input(
        INPUT_GET,
        'remover',
        FILTER_VALIDATE_INT
    );

    if ($id && isset($_SESSION['carrinho'][$id])) {

        unset($_SESSION['carrinho'][$id]);

    }

    header('Location: carrinho.php');

    exit;
}


$id = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT
);

if (!$id) {

    header('Location: cardapio.php');

    exit;
}


$stmt = $pdo->prepare("
    SELECT id
    FROM produtos
    WHERE id = ?
    AND ativo = 1
");

$stmt->execute([$id]);

$produto = $stmt->fetch();


if (!$produto) {

    header('Location: cardapio.php');

    exit;
}


if (isset($_SESSION['carrinho'][$id])) {

    $_SESSION['carrinho'][$id]++;

} else {

    $_SESSION['carrinho'][$id] = 1;

}


header('Location: carrinho.php');

exit;