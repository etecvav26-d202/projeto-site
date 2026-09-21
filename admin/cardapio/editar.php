<?php
require_once '../../config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT *
    FROM produtos
    WHERE id = ?
");

$stmt->execute([$id]);

$produto = $stmt->fetch();

if (!$produto) {
    header('Location: index.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = (float) ($_POST['preco'] ?? 0);
    $categoria = trim($_POST['categoria'] ?? '');
    $destaque = isset($_POST['destaque']) ? 1 : 0;
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    $imagem = $produto['imagem'];

    if (
        isset($_FILES['imagem']) &&
        $_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE
    ) {

        if ($_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {

            $erro = 'Erro ao enviar a imagem.';

        } else {

            $tiposPermitidos = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            $tipo = mime_content_type($_FILES['imagem']['tmp_name']);

            if (!in_array($tipo, $tiposPermitidos)) {

                $erro = 'Formato de imagem inválido.';

            } else {

                $extensao = strtolower(
                    pathinfo(
                        $_FILES['imagem']['name'],
                        PATHINFO_EXTENSION
                    )
                );

                $nomeArquivo = uniqid('produto_', true) . '.' . $extensao;

                $pasta = '../../assets/img/produtos/';

                if (!is_dir($pasta)) {
                    mkdir($pasta, 0755, true);
                }

                $destino = $pasta . $nomeArquivo;

                if (
                    move_uploaded_file(
                        $_FILES['imagem']['tmp_name'],
                        $destino
                    )
                ) {

                    if (!empty($produto['imagem'])) {

                        $imagemAntiga = '../../' . $produto['imagem'];

                        if (file_exists($imagemAntiga)) {
                            unlink($imagemAntiga);
                        }
                    }

                    $imagem = 'assets/img/produtos/' . $nomeArquivo;

                } else {

                    $erro = 'Não foi possível salvar a nova imagem.';
                }
            }
        }
    }

    if ($erro === '') {

        $stmt = $pdo->prepare("
            UPDATE produtos
            SET
                nome = ?,
                descricao = ?,
                preco = ?,
                categoria = ?,
                imagem = ?,
                destaque = ?,
                ativo = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $nome,
            $descricao,
            $preco,
            $categoria,
            $imagem,
            $destaque,
            $ativo,
            $id
        ]);

        header('Location: index.php');
        exit;
    }
}

require_once '../header.php';
?>

<div class="admin-container">

    <div class="admin-header">

        <div>

            <span class="eyebrow">Cardápio</span>

            <h1>Editar produto</h1>

            <p>
                Atualize as informações do produto.
            </p>

        </div>

        <a
            href="index.php"
            class="btn btn-light"
        >
            Voltar
        </a>

    </div>

    <?php if ($erro): ?>

        <div class="admin-error">
            <?= htmlspecialchars($erro) ?>
        </div>

    <?php endif; ?>

    <form
        method="POST"
        enctype="multipart/form-data"
        class="admin-form"
    >

        <div class="form-group">

            <label for="nome">
                Nome do produto
            </label>

            <input
                type="text"
                id="nome"
                name="nome"
                value="<?= htmlspecialchars($produto['nome']) ?>"
                required
            >

        </div>

        <div class="form-group">

            <label for="descricao">
                Descrição
            </label>

            <textarea
                id="descricao"
                name="descricao"
                rows="5"
                required
            ><?= htmlspecialchars($produto['descricao']) ?></textarea>

        </div>

        <div class="form-row">

            <div class="form-group">

                <label for="preco">
                    Preço
                </label>

                <input
                    type="number"
                    id="preco"
                    name="preco"
                    step="0.01"
                    min="0"
                    value="<?= htmlspecialchars($produto['preco']) ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label for="categoria">
                    Categoria
                </label>

                <select
                    id="categoria"
                    name="categoria"
                    required
                >

                    <option value="Cafés" <?= $produto['categoria'] === 'Cafés' ? 'selected' : '' ?>>
                        Cafés
                    </option>

                    <option value="Bebidas" <?= $produto['categoria'] === 'Bebidas' ? 'selected' : '' ?>>
                        Bebidas
                    </option>

                    <option value="Sobremesas" <?= $produto['categoria'] === 'Sobremesas' ? 'selected' : '' ?>>
                        Sobremesas
                    </option>

                    <option value="Combos" <?= $produto['categoria'] === 'Combos' ? 'selected' : '' ?>>
                        Combos
                    </option>

                </select>

            </div>

        </div>

        <div class="form-group">

            <label>
                Imagem atual
            </label>

            <?php if (!empty($produto['imagem'])): ?>

                <img
                    src="../../<?= htmlspecialchars($produto['imagem']) ?>"
                    alt="<?= htmlspecialchars($produto['nome']) ?>"
                    class="admin-current-image"
                >

            <?php else: ?>

                <p>
                    Nenhuma imagem cadastrada.
                </p>

            <?php endif; ?>

        </div>

        <div class="form-group">

            <label for="imagem">
                Alterar imagem
            </label>

            <input
                type="file"
                id="imagem"
                name="imagem"
                accept="image/jpeg,image/png,image/webp"
            >

            <small>
                Deixe vazio para manter a imagem atual.
            </small>

        </div>

        <div class="form-check">

            <label>

                <input
                    type="checkbox"
                    name="destaque"
                    value="1"
                    <?= $produto['destaque'] ? 'checked' : '' ?>
                >

                Mostrar como destaque

            </label>

        </div>

        <div class="form-check">

            <label>

                <input
                    type="checkbox"
                    name="ativo"
                    value="1"
                    <?= $produto['ativo'] ? 'checked' : '' ?>
                >

                Produto ativo

            </label>

        </div>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Salvar alterações
        </button>

    </form>

</div>

<?php require_once '../footer.php'; ?>