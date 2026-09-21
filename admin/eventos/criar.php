<?php

require_once '../../config/conexao.php';

$tituloPagina = 'Cadastrar Evento';

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
                INSERT INTO eventos
                (
                    titulo,
                    descricao,
                    data_evento,
                    horario,
                    local_evento,
                    vagas,
                    preco,
                    imagem,
                    destaque,
                    ativo
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
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
                $ativo
            ]);

            header('Location: index.php');
            exit;

        } catch (PDOException $e) {

            $erro = 'Erro ao cadastrar o evento: ' . $e->getMessage();

        }
    }
}

require '../../includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Administração</span>
        <h1>Novo evento</h1>
        <p>Cadastre um novo evento no Café Lumière.</p>
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
                        <input type="text" id="titulo" name="titulo" required>
                    </div>

                    <div class="form-group">
                        <label for="local_evento">Local *</label>
                        <input type="text" id="local_evento" name="local_evento" required>
                    </div>

                    <div class="form-group">
                        <label for="data_evento">Data *</label>
                        <input type="date" id="data_evento" name="data_evento" required>
                    </div>

                    <div class="form-group">
                        <label for="horario">Horário *</label>
                        <input type="time" id="horario" name="horario" required>
                    </div>

                    <div class="form-group">
                        <label for="vagas">Vagas</label>
                        <input type="number" id="vagas" name="vagas" min="0" value="0">
                    </div>

                    <div class="form-group">
                        <label for="preco">Preço</label>
                        <input type="number" id="preco" name="preco" min="0" step="0.01" value="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="imagem">Imagem do evento</label>
                        <input type="url" id="imagem" name="imagem" placeholder="https://exemplo.com/imagem.jpg">
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
                    ></textarea>

                </div>

                <div class="form-options">

                    <label>
                        <input
                            type="checkbox"
                            name="destaque"
                            value="1"
                        >
                        Destacar evento
                    </label>

                    <label>
                        <input
                            type="checkbox"
                            name="ativo"
                            value="1"
                            checked
                        >
                        Evento ativo
                    </label>

                </div>

                <div class="detail-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Cadastrar evento
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