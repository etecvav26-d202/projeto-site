<?php

require 'config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contato.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$assunto = trim($_POST['assunto'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

if ($nome === '' || $email === '' || $assunto === '' || $mensagem === '') {
    header('Location: contato.php?erro=1');
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO mensagens
    (nome, email, assunto, mensagem)
    VALUES (?, ?, ?, ?)
");

$stmt->execute([
    $nome,
    $email,
    $assunto,
    $mensagem
]);

header('Location: contato.php?sucesso=1');
exit;