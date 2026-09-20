<?php

require_once 'config/conexao.php';

$tituloPagina = 'Cardápio';

$produtos = $pdo->query("
    SELECT *
    FROM produtos
    WHERE ativo = 1
    ORDER BY categoria, nome
")->fetchAll();

$categorias = $pdo->query("
    SELECT DISTINCT categoria
    FROM produtos
    WHERE ativo = 1
    ORDER BY categoria
")->fetchAll();

require 'includes/header.php';

?>

<section class="page-hero">

    <div class="container">

        <span class="eyebrow">
            Café Lumière
        </span>

        <h1>
            Nosso cardápio
        </h1>

        <p>
            Sabores preparados para acompanhar seus momentos,
            suas conversas e suas histórias.
        </p>

    </div>

</section>

<section class="section">

    <div class="container">

        <div class="category-filter">

            <a
                href="cardapio.php"
                class="filter-button active"
            >
                Todos
            </a>

            <?php foreach ($categorias as $categoria): ?>

                <a
                    href="cardapio.php?categoria=<?= urlencode($categoria['categoria']) ?>"
                    class="filter-button"
                >
                    <?= htmlspecialchars($categoria['categoria']) ?>
                </a>

            <?php endforeach; ?>

        </div>

        <?php

        $categoriaSelecionada =
            $_GET['categoria'] ?? '';

        if ($categoriaSelecionada !== '') {

            $stmt = $pdo->prepare("
                SELECT *
                FROM produtos
                WHERE ativo = 1
                AND categoria = ?
                ORDER BY nome
            ");

            $stmt->execute([
                $categoriaSelecionada
            ]);

            $produtos = $stmt->fetchAll();
        }

        ?>

        <div class="product-grid">

            <?php if (empty($produtos)): ?>

                <div class="empty-message">

                    <h2>
                        Nenhum produto encontrado
                    </h2>

                    <p>
                        Tente selecionar outra categoria.
                    </p>

                </div>

            <?php endif; ?>


            <?php foreach ($produtos as $produto): ?>

                <article class="product-card reveal">

                    <div class="product-image">

                        <img
                            src="<?= htmlspecialchars($produto['imagem']) ?>"
                            alt="<?= htmlspecialchars($produto['nome']) ?>"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
                        >

                        <div
                            class="image-placeholder"
                            style="display: none;"
                        >
                            IMAGEM DO PRODUTO
                        </div>

                    </div>


                    <div class="product-info">

                        <span class="product-category">
                            <?= htmlspecialchars($produto['categoria']) ?>
                        </span>

                        <h2>
                            <?= htmlspecialchars($produto['nome']) ?>
                        </h2>

                        <p>
                            <?= htmlspecialchars($produto['descricao']) ?>
                        </p>

                        <div class="product-footer">

                            <span class="price">
                                R$
                                <?= number_format(
                                    $produto['preco'],
                                    2,
                                    ',',
                                    '.'
                                ) ?>
                            </span>

                            <a
                                href="produto.php?id=<?= $produto['id'] ?>"
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

<?php

require 'includes/footer.php';

?>