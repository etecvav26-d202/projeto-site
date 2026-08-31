<?php
require '../config/conexao.php';

if (isset($_GET['excluir'])) {
    $stmt = $pdo->prepare("DELETE FROM eventos WHERE id = ?");
    $stmt->execute([$_GET['excluir']]);
    header("Location: eventos.php");
    exit;
}

$editando = null;
if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare("SELECT * FROM eventos WHERE id = ?");
    $stmt->execute([$_GET['editar']]);
    $editando = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome        = $_POST['nome'];
    $descricao   = $_POST['descricao'];
    $data_evento = $_POST['data_evento'];
    $vagas       = $_POST['vagas'];

    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE eventos SET nome=?, descricao=?, data_evento=?, vagas=? WHERE id=?");
        $stmt->execute([$nome, $descricao, $data_evento, $vagas, $_POST['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO eventos (nome, descricao, data_evento, vagas) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $descricao, $data_evento, $vagas]);
    }
    header("Location: eventos.php");
    exit;
}

$eventos = $pdo->query("SELECT * FROM eventos ORDER BY data_evento ASC")->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
?>

<h1>Gerenciar Eventos</h1>

<form method="POST">
    <input type="hidden" name="id" value="<?= $editando['id'] ?? '' ?>">
    <input type="text" name="nome" placeholder="Nome do evento" value="<?= $editando['nome'] ?? '' ?>" required>
    <textarea name="descricao" placeholder="Descrição"><?= $editando['descricao'] ?? '' ?></textarea>
    <input type="date" name="data_evento" value="<?= $editando['data_evento'] ?? '' ?>" required>
    <input type="number" name="vagas" placeholder="Vagas" value="<?= $editando['vagas'] ?? '' ?>" required>
    <button type="submit"><?= $editando ? 'Atualizar' : 'Cadastrar' ?></button>
</form>

<hr>

<table border="1">
    <tr>
        <th>Nome</th><th>Data</th><th>Vagas</th><th>Ações</th>
    </tr>
    <?php foreach ($eventos as $evento): ?>
    <tr>
        <td><?= htmlspecialchars($evento['nome']) ?></td>
        <td><?= date('d/m/Y', strtotime($evento['data_evento'])) ?></td>
        <td><?= $evento['vagas'] ?></td>
        <td>
            <a href="eventos.php?editar=<?= $evento['id'] ?>">Editar</a> |
            <a href="eventos.php?excluir=<?= $evento['id'] ?>" onclick="return confirm('Excluir este evento?')">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>