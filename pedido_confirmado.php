<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: minha-conta.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT *
    FROM pedidos
    WHERE id = ?
    AND usuario_id = ?
");

$stmt->execute([
    $id,
    $_SESSION['usuario_id']
]);

$pedido = $stmt->fetch();

if (!$pedido) {
    header('Location: minha-conta.php');
    exit;
}

$tituloPagina = 'Pedido confirmado';

require 'includes/header.php';

?>

<section class="section">

    <div class="container">

        <div class="empty-message">

            <span class="eyebrow">
                Café Lumière
            </span>

            <h1>Pedido confirmado</h1>

            <p>
                Seu pedido foi registrado com sucesso.
            </p>

            <p>
                Número do pedido:
                <strong>#<?= $pedido['id'] ?></strong>
            </p>

            <p>
                Total:
                <strong>
                    R$ <?= number_format($pedido['total'], 2, ',', '.') ?>
                </strong>
            </p>

            <br>

            <a
                href="index.php"
                class="btn btn-primary"
            >
                Voltar ao início
            </a>

        </div>

    </div>

</section>

<?php require 'includes/footer.php'; ?>