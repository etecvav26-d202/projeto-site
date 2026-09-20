<?php

require_once 'config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: eventos.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT *
    FROM eventos
    WHERE id = ?
    AND ativo = 1
");

$stmt->execute([$id]);

$evento = $stmt->fetch();

if (!$evento) {
    header('Location: eventos.php');
    exit;
}

$tituloPagina = $evento['titulo'];

require 'includes/header.php';

?>

<section class="section">

    <div class="container event-detail">

        <div class="event-detail-image">

            <img
                src="<?= htmlspecialchars($evento['imagem']) ?>"
                alt="<?= htmlspecialchars($evento['titulo']) ?>"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
            >

            <div class="image-placeholder" style="display: none;">
                IMAGEM DO EVENTO
            </div>

        </div>

        <div class="event-detail-content">

            <span class="eyebrow">
                <?= date('d/m/Y', strtotime($evento['data_evento'])) ?>
            </span>

            <h1>
                <?= htmlspecialchars($evento['titulo']) ?>
            </h1>

            <p class="event-detail-description">
                <?= nl2br(htmlspecialchars($evento['descricao'])) ?>
            </p>

            <div class="event-detail-info">

                <div>
                    <strong>Data</strong>
                    <span>
                        <?= date('d/m/Y', strtotime($evento['data_evento'])) ?>
                    </span>
                </div>

                <div>
                    <strong>Horário</strong>
                    <span>
                        <?= date('H:i', strtotime($evento['horario'])) ?>
                    </span>
                </div>

                <div>
                    <strong>Local</strong>
                    <span>
                        <?= htmlspecialchars($evento['local_evento']) ?>
                    </span>
                </div>

                <div>
                    <strong>Vagas</strong>
                    <span>
                        <?= (int) $evento['vagas'] ?>
                    </span>
                </div>

            </div>

            <div class="event-detail-price">

                <?php if ($evento['preco'] > 0): ?>

                    R$ <?= number_format($evento['preco'], 2, ',', '.') ?>

                <?php else: ?>

                    Gratuito

                <?php endif; ?>

            </div>

            <div class="detail-actions">

                <a href="reservas.php?evento=<?= $evento['id'] ?>" class="btn btn-primary">
                    Reservar vaga
                </a>

                <a href="eventos.php" class="btn btn-light">
                    Voltar aos eventos
                </a>

            </div>

        </div>

    </div>

</section>

<?php require 'includes/footer.php'; ?>