<?php
require 'config/conexao.php';
include 'includes/header.php';


if (isset($_GET['excluir'])) {
    $stmt = $pdo->prepare("DELETE FROM livros WHERE id = ?");
    $stmt->execute([$_GET['excluir']]);
    header("Location: livros.php");
    exit;
}

$editando = null;
if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare("SELECT * FROM livros WHERE id = ?");
    $stmt->execute([$_GET['editar']]);
    $editando = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo  = $_POST['titulo'];
    $autor   = $_POST['autor'];
    $genero  = $_POST['genero'];
    $sinopse = $_POST['sinopse'];
    $preco   = $_POST['preco'];
    $tipo    = $_POST['tipo'];

    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE livros SET titulo=?, autor=?, genero=?, sinopse=?, preco=?, tipo=? WHERE id=?");
        $stmt->execute([$titulo, $autor, $genero, $sinopse, $preco, $tipo, $_POST['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO livros (titulo, autor, genero, sinopse, preco, tipo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $autor, $genero, $sinopse, $preco, $tipo]);
    }
    header("Location: livros.php");
    exit;
}

$livros = $pdo->query("SELECT * FROM livros ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Admin - Livros | Café Lumière</title>
</head>
<body>
    <h1>Gerenciar Livros</h1>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $editando['id'] ?? '' ?>">
        <input type="text" name="titulo" placeholder="Título" value="<?= $editando['titulo'] ?? '' ?>" required>
        <input type="text" name="autor" placeholder="Autor" value="<?= $editando['autor'] ?? '' ?>" required>
        <input type="text" name="genero" placeholder="Gênero" value="<?= $editando['genero'] ?? '' ?>">
        <textarea name="sinopse" placeholder="Sinopse"><?= $editando['sinopse'] ?? '' ?></textarea>
        <input type="number" step="0.01" name="preco" placeholder="Preço" value="<?= $editando['preco'] ?? '' ?>" required>
        <select name="tipo">
            <option value="compra" <?= (($editando['tipo'] ?? '') == 'compra') ? 'selected' : '' ?>>Compra</option>
            <option value="aluguel" <?= (($editando['tipo'] ?? '') == 'aluguel') ? 'selected' : '' ?>>Aluguel</option>
            <option value="ambos" <?= (($editando['tipo'] ?? '') == 'ambos') ? 'selected' : '' ?>>Ambos</option>
        </select>
        <button type="submit"><?= $editando ? 'Atualizar' : 'Cadastrar' ?></button>
    </form>

    <hr>

    <table border="1">
        <tr>
            <th>Título</th><th>Autor</th><th>Gênero</th><th>Preço</th><th>Tipo</th><th>Ações</th>
        </tr>
        <?php foreach ($livros as $livro): ?>
        <tr>
            <td><?= htmlspecialchars($livro['titulo']) ?></td>
            <td><?= htmlspecialchars($livro['autor']) ?></td>
            <td><?= htmlspecialchars($livro['genero']) ?></td>
            <td>R$ <?= number_format($livro['preco'], 2, ',', '.') ?></td>
            <td><?= $livro['tipo'] ?></td>
            <td>
                <a href="livros.php?editar=<?= $livro['id'] ?>">Editar</a> |
                <a href="livros.php?excluir=<?= $livro['id'] ?>" onclick="return confirm('Excluir este livro?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>