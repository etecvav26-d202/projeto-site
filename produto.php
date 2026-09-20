<?php

require_once 'config/conexao.php';

$id = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT
);

if (!$id) {
    header('Location: cardapio.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT *
    FROM produtos
    WHERE id = ?
    AND ativo = 1
");

$stmt->execute([$id]);

$produto = $stmt->fetch();

if (!$produto) {
    header('Location: cardapio.php');
    exit;
}

$tituloPagina = $produto['nome'];

require 'includes/header.php';

?>

<section class="section">

    <div class="container product-detail">

        <div class="product-detail-image">

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


        <div class="product-detail-content">

            <span class="eyebrow">
                <?= htmlspecialchars($produto['categoria']) ?>
            </span>

            <h1>
                <?= htmlspecialchars($produto['nome']) ?>
            </h1>

            <p class="product-description">
                <?= htmlspecialchars($produto['descricao']) ?>
            </p>

            <strong class="detail-price">
                R$
                <?= number_format(
                    $produto['preco'],
                    2,
                    ',',
                    '.'
                ) ?>
            </strong>

            <div class="detail-actions">

                <a
                    href="adicionar_carrinho.php?id=<?= $produto['id'] ?>"
                    class="btn btn-primary"
                >
                    Adicionar ao carrinho
                </a>

                <a
                    href="cardapio.php"
                    class="btn btn-light"
                >
                    Voltar ao cardápio
                </a>

            </div>

        </div>

    </div>

</section>

<?php

require 'includes/footer.php';

?>