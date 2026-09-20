<?php

require_once '../../config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id){
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT *
    FROM livros
    WHERE id = ?
");

$stmt->execute([$id]);
$livro = $stmt->fetch();

if (!$livro){
    header('Location: index.php');
    exit;
}

$tituloPagina = 'Editar Livro';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $titulo = trim($_POST['titulo'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $sinopse = trim($_POST['sinopse'] ?? '');
    $preco = str_replace(',', '.', $_POST['preco'] ?? '0');
    $tipo = $_POST['tipo'] ?? 'compra';
    $imagem = trim($_POST['imagem'] ?? '');
    $destaque = isset($_POST['destaque']) ? 1 : 0;
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    if ($titulo === '' || $autor === '' || $genero === '' || $sinopse === '' || $preco === '') {
        $erro = 'Preencha todos os campos obrigatórios.';
    }else{
        $stmt = $pdo->prepare("
            UPDATE livros
            SET
                titulo = ?,
                autor = ?,
                genero = ?,
                sinopse = ?,
                preco = ?,
                tipo = ?,
                imagem = ?,
                destaque = ?,
                ativo = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $titulo,
            $autor,
            $genero,
            $sinopse,
            $preco,
            $tipo,
            $imagem,
            $destaque,
            $ativo,
            $id
        ]);
        header('Location: index.php');
        exit;
    }
}

require '../../includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">
            Administração
        </span>

        <h1>
            Editar livro
        </h1>

        <p>
            Atualize as informações da obra.
        </p>

    </div>

</section>
<section class="section">
    <div class="container">
        <div class="admin-form">
            <?php if ($erro): ?>
                <div class="form-error">
                    <?= htmlspecialchars($erro) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="titulo">
                            Título *
                        </label>

                        <input
                            type="text"
                            id="titulo"
                            name="titulo"
                            value="<?= htmlspecialchars($livro['titulo']) ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="autor">
                            Autor *
                        </label>

                        <input
                            type="text"
                            id="autor"
                            name="autor"
                            value="<?= htmlspecialchars($livro['autor']) ?>"
                            required
                        >

                    </div>
                    <div class="form-group">
                        <label for="genero">
                            Gênero *
                        </label>

                        <input
                            type="text"
                            id="genero"
                            name="genero"
                            value="<?= htmlspecialchars($livro['genero']) ?>"
                            required
                        >

                    </div>
                    <div class="form-group">
                        <label for="preco">
                            Preço *
                        </label>

                        <input
                            type="number"
                            id="preco"
                            name="preco"
                            step="0.01"
                            min="0"
                            value="<?= htmlspecialchars($livro['preco']) ?>"
                            required
                        >

                    </div>

                    <div class="form-group">
                        <label for="tipo">
                            Disponibilidade
                        </label>

                        <select id="tipo" name="tipo">

                            <option
                                value="compra"
                                <?= $livro['tipo'] === 'compra' ? 'selected' : '' ?>
                            >
                                Compra
                            </option>

                            <option
                                value="aluguel"
                                <?= $livro['tipo'] === 'aluguel' ? 'selected' : '' ?>
                            >
                                Aluguel
                            </option>

                            <option
                                value="ambos"
                                <?= $livro['tipo'] === 'ambos' ? 'selected' : '' ?>
                            >
                                Compra e aluguel
                            </option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="imagem">
                            Imagem
                        </label>

                        <input
                            type="text"
                            id="imagem"
                            name="imagem"
                            value="<?= htmlspecialchars($livro['imagem'] ?? '') ?>"
                        >
                    </div>
                </div>
                <div class="form-group">
                    <label for="sinopse">
                        Sinopse *
                    </label>

                    <textarea
                        id="sinopse"
                        name="sinopse"
                        rows="6"
                        required
                    ><?= htmlspecialchars($livro['sinopse']) ?></textarea>

                </div>

                <div class="form-options">
                    <label>
                        <input
                            type="checkbox"
                            name="destaque"
                            value="1"
                            <?= $livro['destaque'] ? 'checked' : '' ?>
                        >

                        Destacar livro

                    </label>

                    <label>

                        <input
                            type="checkbox"
                            name="ativo"
                            value="1"
                            <?= $livro['ativo'] ? 'checked' : '' ?>
                        >

                        Livro ativo

                    </label>

                </div>

                <div class="detail-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Salvar alterações
                    </button>

                    <a
                        href="index.php"
                        class="btn btn-light"
                    >
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require '../../includes/footer.php'; ?>