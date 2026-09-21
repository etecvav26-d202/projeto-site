<?php

require_once '../../config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT *
    FROM eventos
    WHERE id = ?
");

$stmt->execute([$id]);

$evento = $stmt->fetch();

if (!$evento) {
    header('Location: index.php');
    exit;
}

$tituloPagina = 'Editar Evento';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $data_evento = $_POST['data_evento'] ?? '';
    $horario = $_POST['horario'] ?? '';
    $local_evento = trim($_POST['local_evento'] ?? '');
    $vagas = trim($_POST['vagas'] ?? '0');
    $preco = str_replace(',', '.', trim($_POST['preco'] ?? '0'));
    $imagem = trim($_POST['imagem'] ?? '');
    $destaque = isset($_POST['destaque']) ? 1 : 0;
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    if (
        $titulo === '' ||
        $descricao === '' ||
        $data_evento === '' ||
        $horario === '' ||
        $local_evento === ''
    ) {

        $erro = 'Preencha todos os campos obrigatórios.';

    } elseif (!is_numeric($vagas) || $vagas < 0) {

        $erro = 'Digite uma quantidade válida de vagas.';

    } elseif (!is_numeric($preco) || $preco < 0) {

        $erro = 'Digite um preço válido.';

    } else {

        try {

            $stmt = $pdo->prepare("
                UPDATE eventos
                SET
                    titulo = ?,
                    descricao = ?,
                    data_evento = ?,
                    horario = ?,
                    local_evento = ?,
                    vagas = ?,
                    preco = ?,
                    imagem = ?,
                    destaque = ?,
                    ativo = ?
                WHERE id = ?
            ");

            $stmt->execute([
                $titulo,
                $descricao,
                $data_evento,
                $horario,
                $local_evento,
                $vagas,
                $preco,
                $imagem,
                $destaque,
                $ativo,
                $id
            ]);

            header('Location: index.php');
            exit;

        } catch (PDOException $e) {

            $erro = 'Erro ao editar o evento: ' . $e->getMessage();

        }
    }
}

require '../../includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Administração</span>
        <h1>Editar evento</h1>
        <p>Atualize as informações do evento.</p>
    </div>
</section>

<section class="section">

    <div class="container">

        <div class="admin-form">

            <?php if ($erro): ?>

                <div class="form-error">
                    <?= htmlspecialchars($erro) ?>
                </div>

            <?php endif; ?>

            <form method="POST">

                <div class="form-grid">

                    <div class="form-group">
                        <label for="titulo">Título *</label>
                        <input
                            type="text"
                            id="titulo"
                            name="titulo"
                            value="<?= htmlspecialchars($evento['titulo']) ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="local_evento">Local *</label>
                        <input
                            type="text"
                            id="local_evento"
                            name="local_evento"
                            value="<?= htmlspecialchars($evento['local_evento']) ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="data_evento">Data *</label>
                        <input
                            type="date"
                            id="data_evento"
                            name="data_evento"
                            value="<?= htmlspecialchars($evento['data_evento']) ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="horario">Horário *</label>
                        <input
                            type="time"
                            id="horario"
                            name="horario"
                            value="<?= htmlspecialchars($evento['horario']) ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="vagas">Vagas</label>
                        <input
                            type="number"
                            id="vagas"
                            name="vagas"
                            min="0"
                            value="<?= htmlspecialchars($evento['vagas']) ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="preco">Preço</label>
                        <input
                            type="number"
                            id="preco"
                            name="preco"
                            min="0"
                            step="0.01"
                            value="<?= htmlspecialchars($evento['preco']) ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="imagem">Imagem</label>
                        <input
                            type="text"
                            id="imagem"
                            name="imagem"
                            value="<?= htmlspecialchars($evento['imagem'] ?? '') ?>"
                        >
                    </div>

                </div>

                <div class="form-group">

                    <label for="descricao">
                        Descrição *
                    </label>

                    <textarea
                        id="descricao"
                        name="descricao"
                        rows="6"
                        required
                    ><?= htmlspecialchars($evento['descricao']) ?></textarea>

                </div>

                <div class="form-options">

                    <label>
                        <input
                            type="checkbox"
                            name="destaque"
                            value="1"
                            <?= $evento['destaque'] ? 'checked' : '' ?>
                        >
                        Destacar evento
                    </label>

                    <label>
                        <input
                            type="checkbox"
                            name="ativo"
                            value="1"
                            <?= $evento['ativo'] ? 'checked' : '' ?>
                        >
                        Evento ativo
                    </label>

                </div>

                <div class="detail-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Salvar alterações
                    </button>

                    <a
                        href="index.php"
                        class="btn btn-light"
                    >
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>

</section>

<?php require '../../includes/footer.php'; ?>