<?php

require_once '../../config/conexao.php';

$tituloPagina = 'Gerenciar Eventos';

$eventos = $pdo->query("
    SELECT *
    FROM eventos
    ORDER BY data_evento DESC, horario DESC
")->fetchAll();

require '../../includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Administração</span>
        <h1>Eventos</h1>
        <p>Gerencie os eventos cadastrados no Café Lumière.</p>
    </div>
</section>

<section class="section">

    <div class="container">

        <div class="admin-header">

            <div>
                <span class="eyebrow">Catálogo</span>
                <h2>Eventos cadastrados</h2>
            </div>

            <a href="criar.php" class="btn btn-primary">
                Novo evento
            </a>

        </div>

        <div class="admin-table-wrapper">

            <table class="admin-table">

                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Local</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($eventos as $evento): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($evento['titulo']) ?>
                            </td>

                            <td>
                                <?= date('d/m/Y', strtotime($evento['data_evento'])) ?>
                            </td>

                            <td>
                                <?= date('H:i', strtotime($evento['horario'])) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($evento['local_evento']) ?>
                            </td>

                            <td>
                                <?php if ($evento['preco'] > 0): ?>
                                    R$ <?= number_format($evento['preco'], 2, ',', '.') ?>
                                <?php else: ?>
                                    Gratuito
                                <?php endif; ?>
                            </td>

                            <td>

                                <?php if ($evento['ativo']): ?>

                                    <span class="status-active">
                                        Ativo
                                    </span>

                                <?php else: ?>

                                    <span class="status-inactive">
                                        Inativo
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <div class="admin-actions">

                                    <a
                                        href="editar.php?id=<?= $evento['id'] ?>"
                                        class="btn btn-light"
                                    >
                                        Editar
                                    </a>

                                    <a
                                        href="excluir.php?id=<?= $evento['id'] ?>"
                                        class="btn-danger"
                                        onclick="return confirm('Tem certeza que deseja excluir este evento?')"
                                    >
                                        Excluir
                                    </a>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</section>

<?php require '../../includes/footer.php'; ?>