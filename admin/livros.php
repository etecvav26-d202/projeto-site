<?php

require_once 'config/conexao.php';

$tituloPagina = 'Livros';

require 'includes/header.php';

$livros = $pdo->query("
    SELECT *
    FROM livros
    WHERE ativo = 1
    ORDER BY destaque DESC, id DESC
")->fetchAll();

?>

<section class="page-hero">

    <div class="container fade-up">

        <span class="eyebrow">
            Estante Lumière
        </span>

        <h1>
            Livros
        </h1>

        <p>
            Escolha uma história para levar para casa
            ou simplesmente descubra algo novo enquanto
            toma seu café.
        </p>

    </div>

</section>


<section class="section">

    <div class="container">

        <div class="book-grid">

            <?php foreach ($livros as $livro): ?>

                <article class="card reveal">

                    <div class="book-cover">

                        <div class="image-placeholder">
                            COLOQUE A CAPA AQUI
                        </div>

                        <img
                            src="<?= htmlspecialchars($livro['imagem']) ?>"
                            alt="Capa de <?= htmlspecialchars($livro['titulo']) ?>"
                        >

                    </div>

                    <div class="book-body">

                        <h3>
                            <?= htmlspecialchars($livro['titulo']) ?>
                        </h3>

                        <div class="book-meta">

                            <?= htmlspecialchars($livro['autor']) ?>

                            ·

                            <?= htmlspecialchars($livro['genero']) ?>

                        </div>

                        <p>
                            <?= htmlspecialchars($livro['sinopse']) ?>
                        </p>

                        <div class="product-footer">

                            <strong class="price">

                                R$
                                <?= number_format(
                                    $livro['preco'],
                                    2,
                                    ',',
                                    '.'
                                ) ?>

                            </strong>

                            <a
                                class="btn btn-primary"
                                href="adicionar_carrinho.php?tipo=livro&id=<?= $livro['id'] ?>"
                            >
                                Adicionar
                            </a>

                        </div>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </div>

</section>


<?php require 'includes/footer.php'; ?>