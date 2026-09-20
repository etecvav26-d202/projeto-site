<?php

require_once 'config/conexao.php';

$tituloPagina = 'Recomendações';

$livros = $pdo->query("
    SELECT *
    FROM livros
    WHERE ativo = 1
    AND destaque = 1
    ORDER BY titulo
")->fetchAll();

require 'includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">
            Curadoria Lumière
        </span>

        <h1>
            Nossas recomendações
        </h1>

        <p>
            Livros selecionados para acompanhar diferentes momentos,
            interesses e experiências de leitura.
        </p>

    </div>

</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">
                Seleção da casa
            </span>

            <h2>
                Para sua próxima leitura
            </h2>

        </div>
        <div class="book-grid">
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

                        <a
                            href="livro.php?id=<?= $livro['id'] ?>"
                            class="btn btn-light"
                        >
                            Conhecer livro
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>