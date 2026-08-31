<?php
require 'config/conexao.php';
$livros = $pdo->query("SELECT * FROM livros ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
include 'includes/header.php'
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Café Lumière</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>☕ Café Lumière</h1>
    <h2>Nossos Livros</h2>
    <div class="livros">
        <?php foreach ($livros as $livro): ?>
            <div class="livro-card">
                <h3><?= htmlspecialchars($livro['titulo']) ?></h3>
                <p><?= htmlspecialchars($livro['autor']) ?></p>
                <p>R$ <?= number_format($livro['preco'], 2, ',', '.') ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
