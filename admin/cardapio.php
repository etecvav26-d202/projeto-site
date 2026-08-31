<?php
require '../config/conexao.php';


if (isset($_GET['excluir'])) {
    $stmt = $pdo->prepare("DELETE FROM cardapio WHERE id = ?");
    $stmt->execute([$_GET['excluir']]);
    header("Location: cardapio.php");
    exit;
}

$editando = null;
if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare("SELECT * FROM cardapio WHERE id = ?");
    $stmt->execute([$_GET['editar']]);
    $editando = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome      = $_POST['nome'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $preco     = $_POST['preco'];

    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE cardapio SET nome=?, categoria=?, descricao=?, preco=? WHERE id=?");
        $stmt->execute([$nome, $categoria, $descricao, $preco, $_POST['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO cardapio (nome, categoria, descricao, preco) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $categoria, $descricao, $preco]);
    }
    header("Location: cardapio.php");
    exit;
}

$itens = $pdo->query("SELECT * FROM cardapio ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
?>

<h1>Gerenciar Cardápio</h1>

<form method="POST">
    <input type="hidden" name="id" value="<?= $editando['id'] ?? '' ?>">
    <input type="text" name="nome" placeholder="Nome do item" value="<?= $editando['nome'] ?? '' ?>" required>
    <select name="categoria">
        <option value="cafe" <?= (($editando['categoria'] ?? '') == 'cafe') ? 'selected' : '' ?>>Café</option>
        <option value="bebida" <?= (($editando['categoria'] ?? '') == 'bebida') ? 'selected' : '' ?>>Bebida</option>
        <option value="sobremesa" <?= (($editando['categoria'] ?? '') == 'sobremesa') ? 'selected' : '' ?>>Sobremesa</option>
        <option value="combo" <?= (($editando['categoria'] ?? '') == 'combo') ? 'selected' : '' ?>>Combo</option>
    </select>
    <textarea name="descricao" placeholder="Descrição"><?= $editando['descricao'] ?? '' ?></textarea>
    <input type="number" step="0.01" name="preco" placeholder="Preço" value="<?= $editando['preco'] ?? '' ?>" required>
    <button type="submit"><?= $editando ? 'Atualizar' : 'Cadastrar' ?></button>
</form>

<hr>

<table border="1">
    <tr>
        <th>Nome</th><th>Categoria</th><th>Preço</th><th>Ações</th>
    </tr>
    <?php foreach ($itens as $item): ?>
    <tr>
        <td><?= htmlspecialchars($item['nome']) ?></td>
        <td><?= $item['categoria'] ?></td>
        <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
        <td>
            <a href="cardapio.php?editar=<?= $item['id'] ?>">Editar</a> |
            <a href="cardapio.php?excluir=<?= $item['id'] ?>" onclick="return confirm('Excluir este item?')">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>