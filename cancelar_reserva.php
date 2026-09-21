<?php

session_start();

require_once 'config/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {

    $stmt = $pdo->prepare("
        UPDATE reservas
        SET status = 'cancelada'
        WHERE id = ?
        AND usuario_id = ?
    ");

    $stmt->execute([
        $id,
        $_SESSION['usuario_id']
    ]);
}

header('Location: minha-conta.php');
exit;