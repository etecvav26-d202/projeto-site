<?php

require_once 'config/conexao.php';

$tituloPagina = 'Eventos';

$eventos = $pdo->query("
    SELECT *
    FROM eventos
    WHERE ativo = 1
    AND data_evento >= CURDATE()
    ORDER BY data_evento ASC, horario ASC
")->fetchAll();

require 'includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Café Lumière</span>
        <h1>Eventos</h1>
        <p>Encontros, leituras e experiências para quem acredita que histórias também podem ser compartilhadas.</p>
    </div>
</section>

<section class="section">
    <div class="container">

        <div class="event-grid">

            <?php if (empty($eventos)): ?>

                <div class="empty-message">
                    <h2>Nenhum evento disponível</h2>
                    <p>Em breve teremos novas experiências no Café Lumière.</p>
                </div>

            <?php endif; ?>

            <?php foreach ($eventos as $evento): ?>

                <article class="event-card reveal">

                    <div class="event-image">

                        <img
                            src="<?= htmlspecialchars($evento['imagem']) ?>"
                            alt="<?= htmlspecialchars($evento['titulo']) ?>"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
                        >

                        <div class="image-placeholder" style="display: none;">
                            IMAGEM DO EVENTO
                        </div>

                    </div>

                    <div class="event-info">

                        <span class="product-category">
                            <?= date('d/m/Y', strtotime($evento['data_evento'])) ?>
                        </span>

                        <h2>
                            <?= htmlspecialchars($evento['titulo']) ?>
                        </h2>

                        <p>
                            <?= htmlspecialchars($evento['descricao']) ?>
                        </p>

                        <div class="event-meta">
                            <span>
                                <?= date('H:i', strtotime($evento['horario'])) ?>
                            </span>

                            <span>
                                <?= htmlspecialchars($evento['local_evento']) ?>
                            </span>
                        </div>

                        <div class="product-footer">

                            <span class="price">
                                <?php if ($evento['preco'] > 0): ?>
                                    R$ <?= number_format($evento['preco'], 2, ',', '.') ?>
                                <?php else: ?>
                                    Gratuito
                                <?php endif; ?>
                            </span>

                            <a
                                href="evento.php?id=<?= $evento['id'] ?>"
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