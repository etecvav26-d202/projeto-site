<?php

require_once '../../config/conexao.php';

$tituloPagina = 'Mensagens';

$mensagens = $pdo->query("
    SELECT *
    FROM mensagens
    ORDER BY id DESC
")->fetchAll();

require '../../includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Administração</span>
        <h1>Mensagens recebidas</h1>
        <p>Visualize as mensagens enviadas pelos visitantes.</p>
    </div>
</section>

<section class="section">
    <div class="container">

        <div class="admin-table">

            <?php if (!$mensagens): ?>

                <div class="account-box">
                    <p>Nenhuma mensagem recebida.</p>
                </div>

            <?php else: ?>

                <?php foreach ($mensagens as $mensagem): ?>

                    <div class="account-box">

                        <h2>
                            <?= htmlspecialchars($mensagem['assunto']) ?>
                        </h2>

                        <p>
                            <strong>Nome:</strong>
                            <?= htmlspecialchars($mensagem['nome']) ?>
                        </p>

                        <p>
                            <strong>E-mail:</strong>
                            <?= htmlspecialchars($mensagem['email']) ?>
                        </p>

                        <p>
                            <strong>Mensagem:</strong><br>
                            <?= nl2br(htmlspecialchars($mensagem['mensagem'])) ?>
                        </p>

                        <a
                            href="excluir.php?id=<?= $mensagem['id'] ?>"
                            class="btn btn-light"
                            onclick="return confirm('Deseja excluir esta mensagem?')"
                        >
                            Excluir
                        </a>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </div>
</section>

<?php require '../../includes/footer.php'; ?>