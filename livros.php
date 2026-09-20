<?php

require_once 'config/conexao.php';

$tituloPagina = 'Livros';

$livros = $pdo->query("
    SELECT *
    FROM livros
    WHERE ativo = 1
    ORDER BY destaque DESC, titulo ASC
")->fetchAll();

$generos = $pdo->query("
    SELECT DISTINCT genero
    FROM livros
    WHERE ativo = 1
    ORDER BY genero
")->fetchAll();

$generoSelecionado = $_GET['genero'] ?? '';

if ($generoSelecionado !== '') {
    $stmt = $pdo->prepare("
        SELECT *
        FROM livros
        WHERE ativo = 1
        AND genero = ?
        ORDER BY destaque DESC, titulo ASC
    ");

    $stmt->execute([$generoSelecionado]);
    $livros = $stmt->fetchAll();
}

require 'includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Café Lumière</span>
        <h1>Livros</h1>
        <p>
            Uma seleção de obras para acompanhar seu café,
            seus estudos e seus momentos de leitura.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">

        <div class="category-filter">
            <a
                href="livros.php"
                class="filter-button <?= $generoSelecionado === '' ? 'active' : '' ?>"
            >
                Todos
            </a>

            <?php foreach ($generos as $genero): ?>

                <a
                    href="livros.php?genero=<?= urlencode($genero['genero']) ?>"
                    class="filter-button <?= $generoSelecionado === $genero['genero'] ? 'active' : '' ?>"
                >
                    <?= htmlspecialchars($genero['genero']) ?>
                </a>

            <?php endforeach; ?>
        </div>

        <div class="book-grid">

            <?php if (empty($livros)): ?>

                <div class="empty-message">
                    <h2>Nenhum livro encontrado</h2>
                    <p>Não encontramos livros nessa categoria.</p>
                </div>

            <?php endif; ?>

            <?php foreach ($livros as $livro): ?>

                <article class="book-card reveal">

                    <div class="book-image">

                        <img
                            src="<?= htmlspecialchars($livro['imagem']) ?>"
                            alt="<?= htmlspecialchars($livro['titulo']) ?>"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
                        >

                        <div class="image-placeholder" style="display: none;">
                            CAPA DO LIVRO
                        </div>

                    </div>

                    <div class="book-info">

                        <span class="product-category">
                            <?= htmlspecialchars($livro['genero']) ?>
                        </span>

                        <h2>
                            <?= htmlspecialchars($livro['titulo']) ?>
                        </h2>

                        <p class="book-author">
                            <?= htmlspecialchars($livro['autor']) ?>
                        </p>

                        <p>
                            <?= htmlspecialchars($livro['sinopse']) ?>
                        </p>

                        <div class="product-footer">

                            <span class="price">
                                R$ <?= number_format($livro['preco'], 2, ',', '.') ?>
                            </span>

                            <a
                                href="livro.php?id=<?= $livro['id'] ?>"
                                class="btn btn-light"
                            >
                                Ver detalhes
                            </a>

                        </div>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </div>
</section>

<?php require 'includes/footer.php'; ?>