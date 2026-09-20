<?php

require_once 'config/conexao.php';

$tituloPagina = 'Cardápio';

require 'includes/header.php';

$categoria = $_GET['categoria'] ?? 'todos';

$sql = "
    SELECT *
    FROM produtos
    WHERE ativo = 1
";

$params = [];

if ($categoria !== 'todos') {

    $sql .= " AND categoria = ?";

    $params[] = $categoria;
}

$sql .= " ORDER BY categoria, nome";

$stmt = $pdo->prepare($sql);

$stmt->execute($params);

$produtos = $stmt->fetchAll();

?>

<section class="page-hero">

    <div class="container fade-up">

        <span class="eyebrow">
            Sabores Lumière
        </span>

        <h1>
            Cardápio
        </h1>

        <p>
            Cafés especiais, bebidas e sobremesas
            para acompanhar suas melhores histórias.
        </p>

    </div>

</section>


<section class="section">

    <div class="container">

        <div
            class="hero-actions"
            style="justify-content:center;margin-bottom:45px"
        >

            <a
                class="btn <?= $categoria === 'todos' ? 'btn-primary' : 'btn-light' ?>"
                href="cardapio.php"
            >
                Todos
            </a>

            <a
                class="btn <?= $categoria === 'cafe' ? 'btn-primary' : 'btn-light' ?>"
                href="?categoria=cafe"
            >
                Cafés
            </a>

            <a
                class="btn <?= $categoria === 'bebida' ? 'btn-primary' : 'btn-light' ?>"
                href="?categoria=bebida"
            >
                Bebidas
            </a>

            <a
                class="btn <?= $categoria === 'sobremesa' ? 'btn-primary' : 'btn-light' ?>"
                href="?categoria=sobremesa"
            >
                Sobremesas
            </a>

            <a
                class="btn <?= $categoria === 'combo' ? 'btn-primary' : 'btn-light' ?>"
                href="?categoria=combo"
            >
                Combos
            </a>

        </div>


        <div class="product-grid">

            <?php foreach ($produtos as $produto): ?>

                <article class="product-card reveal">

                    <div class="product-image">

                        <div class="image-placeholder">
                            COLOQUE A IMAGEM AQUI
                        </div>

                        <img
                            src="<?= htmlspecialchars($produto['imagem']) ?>"
                            alt="<?= htmlspecialchars($produto['nome']) ?>"
                        >

                    </div>

                    <div class="product-info">

                        <small style="
                            color:var(--brown);
                            text-transform:uppercase;
                            letter-spacing:.1em
                        ">

                            <?= htmlspecialchars($produto['categoria']) ?>

                        </small>

                        <h3>
                            <?= htmlspecialchars($produto['nome']) ?>
                        </h3>

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
                                class="btn btn-primary"
                                href="adicionar_carrinho.php?tipo=produto&id=<?= $produto['id'] ?>"
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