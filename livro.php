<?php

require_once 'config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: livros.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT *
    FROM livros
    WHERE id = ?
    AND ativo = 1
");

$stmt->execute([$id]);

$livro = $stmt->fetch();

if (!$livro) {
    header('Location: livros.php');
    exit;
}

$tituloPagina = $livro['titulo'];

require 'includes/header.php';

?>

<section class="section">

    <div class="container book-detail">

        <div class="book-detail-image">

            <img
                src="<?= htmlspecialchars($livro['imagem']) ?>"
                alt="<?= htmlspecialchars($livro['titulo']) ?>"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
            >

            <div class="image-placeholder" style="display: none;">
                CAPA DO LIVRO
            </div>

        </div>

        <div class="book-detail-content">

            <span class="eyebrow">
                <?= htmlspecialchars($livro['genero']) ?>
            </span>

            <h1>
                <?= htmlspecialchars($livro['titulo']) ?>
            </h1>

            <h2>
                <?= htmlspecialchars($livro['autor']) ?>
            </h2>

            <p class="book-detail-description">
                <?= nl2br(htmlspecialchars($livro['sinopse'])) ?>
            </p>

            <strong class="detail-price">
                R$ <?= number_format($livro['preco'], 2, ',', '.') ?>
            </strong>

            <p class="book-type">
                Disponível para:
                <?= htmlspecialchars($livro['tipo']) ?>
            </p>

            <div class="detail-actions">

                <a
                    href="adicionar_carrinho.php?tipo=livro&id=<?= $livro['id'] ?>"
                    class="btn btn-primary"
                >
                    Adicionar ao carrinho
                </a>

                <a
                    href="livros.php"
                    class="btn btn-light"
                >
                    Voltar aos livros
                </a>

            </div>

        </div>

    </div>

</section>

<?php require 'includes/footer.php'; ?>