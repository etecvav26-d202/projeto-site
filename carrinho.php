<?php

session_start();

require_once 'config/conexao.php';

$tituloPagina = 'Carrinho';

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

$carrinho = $_SESSION['carrinho'];

$produtosCarrinho = [];

$total = 0;

if (!empty($carrinho)) {

    $ids = array_keys($carrinho);

    $placeholders =
        implode(',', array_fill(0, count($ids), '?'));

    $stmt = $pdo->prepare("
        SELECT *
        FROM produtos
        WHERE id IN ($placeholders)
        AND ativo = 1
    ");

    $stmt->execute($ids);

    $produtos = $stmt->fetchAll();

    foreach ($produtos as $produto) {

        $quantidade =
            $carrinho[$produto['id']] ?? 0;

        $subtotal =
            $produto['preco'] * $quantidade;

        $produto['quantidade'] = $quantidade;

        $produto['subtotal'] = $subtotal;

        $produtosCarrinho[] = $produto;

        $total += $subtotal;
    }
}

require 'includes/header.php';

?>

<section class="page-hero">

    <div class="container">

        <span class="eyebrow">
            Seu pedido
        </span>

        <h1>
            Carrinho
        </h1>

        <p>
            Revise os produtos escolhidos antes de finalizar.
        </p>

    </div>

</section>

<section class="section">

    <div class="container">

        <?php if (empty($produtosCarrinho)): ?>

            <div class="empty-message">

                <h2>
                    Seu carrinho está vazio.
                </h2>

                <p>
                    Escolha algo delicioso no nosso cardápio.
                </p>

                <br>

                <a
                    href="cardapio.php"
                    class="btn btn-primary"
                >
                    Ver cardápio
                </a>

            </div>

        <?php else: ?>

            <div class="cart-list">

                <?php foreach ($produtosCarrinho as $produto): ?>

                    <article class="cart-item">

                        <div class="cart-item-image">

                            <img
                                src="<?= htmlspecialchars($produto['imagem']) ?>"
                                alt="<?= htmlspecialchars($produto['nome']) ?>"
                            >

                        </div>

                        <div class="cart-item-info">

                            <h2>
                                <?= htmlspecialchars($produto['nome']) ?>
                            </h2>

                            <p>
                                <?= htmlspecialchars($produto['categoria']) ?>
                            </p>

                            <strong>
                                R$
                                <?= number_format(
                                    $produto['preco'],
                                    2,
                                    ',',
                                    '.'
                                ) ?>
                            </strong>

                        </div>

                        <div class="cart-quantity">

                            <span>
                                Quantidade:
                                <?= $produto['quantidade'] ?>
                            </span>

                        </div>

                        <div class="cart-subtotal">

                            <strong>
                                R$
                                <?= number_format(
                                    $produto['subtotal'],
                                    2,
                                    ',',
                                    '.'
                                ) ?>
                            </strong>

                            <a
                                href="adicionar_carrinho.php?remover=<?= $produto['id'] ?>"
                                class="remove-link"
                            >
                                Remover
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>


            <div class="cart-summary">

                <span>
                    Total
                </span>

                <strong>
                    R$
                    <?= number_format(
                        $total,
                        2,
                        ',',
                        '.'
                    ) ?>
                </strong>
                <a href="finalizar_pedido.php" class="btn btn-primary"> Finalizar pedido </a>
            </div>

        <?php endif; ?>

    </div>

</section>

<?php

require 'includes/footer.php';

?>