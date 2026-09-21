<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config/conexao.php';

$tituloPagina = 'Minha conta';

$stmt = $pdo->prepare("
    SELECT *
    FROM reservas
    WHERE usuario_id = ?
    ORDER BY criado_em DESC
");

$stmt->execute([$_SESSION['usuario_id']]);

$reservas = $stmt->fetchAll();

require 'includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Minha conta</span>
        <h1>Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?></h1>
        <p>Acompanhe suas reservas no Café Lumière.</p>
    </div>
</section>

<section class="section">

    <div class="container">

        <div class="account-box">

            <h2>Seus dados</h2>

            <p>
                <strong>Nome:</strong>
                <?= htmlspecialchars($_SESSION['usuario_nome']) ?>
            </p>

            <p>
                <strong>E-mail:</strong>
                <?= htmlspecialchars($_SESSION['usuario_email']) ?>
            </p>

            <a href="logout.php" class="btn btn-light">
                Sair da conta
            </a>

        </div>

        <div class="account-box">

            <h2>Minhas reservas</h2>

            <?php if (empty($reservas)): ?>

                <p>Você ainda não possui reservas.</p>

            <?php else: ?>

                <?php foreach ($reservas as $reserva): ?>

                    <?php

                    $stmtEvento = $pdo->prepare("
                        SELECT *
                        FROM eventos
                        WHERE id = ?
                    ");

                    $stmtEvento->execute([
                        $reserva['evento_id']
                    ]);

                    $evento = $stmtEvento->fetch();

                    ?>

                    <?php if ($evento): ?>

                        <div class="reservation-item">

                            <h3>
                                <?= htmlspecialchars($evento['titulo']) ?>
                            </h3>

                            <p>
                                <?= date('d/m/Y', strtotime($evento['data_evento'])) ?>
                                às
                                <?= date('H:i', strtotime($evento['horario'])) ?>
                            </p>

                            <p>
                                Vagas reservadas:
                                <?= $reserva['pessoas'] ?>
                            </p>

                            <span class="status-active">
                                <?= htmlspecialchars($reserva['status']) ?>
                            </span>

                        </div>

                    <?php endif; ?>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </div>

</section>

<?php require 'includes/footer.php'; ?>