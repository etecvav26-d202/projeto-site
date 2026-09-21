<?php

session_start();

require_once 'config/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$eventoId = filter_input(INPUT_GET, 'evento', FILTER_VALIDATE_INT);

if (!$eventoId) {
    header('Location: eventos.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT *
    FROM eventos
    WHERE id = ?
    AND ativo = 1
");

$stmt->execute([$eventoId]);

$evento = $stmt->fetch();

if (!$evento) {
    header('Location: eventos.php');
    exit;
}

$tituloPagina = 'Reservar evento';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $quantidade = (int) ($_POST['quantidade'] ?? 0);

    if ($quantidade < 1) {

        $erro = 'Escolha pelo menos uma vaga.';

    } elseif ($quantidade > $evento['vagas']) {

        $erro = 'A quantidade solicitada é maior que o número de vagas disponíveis.';

    } else {

        $stmt = $pdo->prepare("
            INSERT INTO reservas
            (usuario_id, evento_id, quantidade)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([
            $_SESSION['usuario_id'],
            $eventoId,
            $quantidade
        ]);

        header('Location: minha-conta.php');
        exit;
    }
}

require 'includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Reserva</span>
        <h1>Reservar vaga</h1>
        <p><?= htmlspecialchars($evento['titulo']) ?></p>
    </div>
</section>

<section class="section">

    <div class="container">

        <div class="admin-form account-form">

            <?php if ($erro): ?>

                <div class="form-error">
                    <?= htmlspecialchars($erro) ?>
                </div>

            <?php endif; ?>

            <h2>
                <?= htmlspecialchars($evento['titulo']) ?>
            </h2>

            <p>
                <?= date('d/m/Y', strtotime($evento['data_evento'])) ?>
                às
                <?= date('H:i', strtotime($evento['horario'])) ?>
            </p>

            <p>
                <?= htmlspecialchars($evento['local_evento']) ?>
            </p>

            <p>
                Vagas disponíveis:
                <?= (int) $evento['vagas'] ?>
            </p>

            <form method="POST">

                <div class="form-group">

                    <label for="quantidade">
                        Quantidade de vagas
                    </label>

                    <input
                        type="number"
                        id="quantidade"
                        name="quantidade"
                        min="1"
                        max="<?= (int) $evento['vagas'] ?>"
                        value="1"
                        required
                    >

                </div>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Confirmar reserva
                </button>

                <a
                    href="eventos.php"
                    class="btn btn-light"
                >
                    Voltar
                </a>

            </form>

        </div>

    </div>

</section>

<?php require 'includes/footer.php'; ?>