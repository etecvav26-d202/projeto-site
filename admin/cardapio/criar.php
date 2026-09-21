<?php
require_once '../../config/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = (float) ($_POST['preco'] ?? 0);
    $categoria = trim($_POST['categoria'] ?? '');
    $destaque = isset($_POST['destaque']) ? 1 : 0;
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    $imagem = '';

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

                $erro = 'Formato de imagem inválido. Use JPG, PNG ou WEBP.';

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

                    $imagem = 'assets/img/produtos/' . $nomeArquivo;

                } else {

                    $erro = 'Não foi possível salvar a imagem.';
                }
            }
        }
    }

    if ($erro === '') {

        $stmt = $pdo->prepare("
            INSERT INTO produtos
            (nome, descricao, preco, categoria, imagem, destaque, ativo)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $nome,
            $descricao,
            $preco,
            $categoria,
            $imagem,
            $destaque,
            $ativo
        ]);

        header('Location: index.php');
        exit;
    }
}

require_once '../../includes/header.php';
?>

<div class="admin-container">

    <div class="admin-header">
        <div>
            <span class="eyebrow">Cardápio</span>
            <h1>Novo produto</h1>
            <p>Adicione um novo item ao cardápio.</p>
        </div>

        <a href="index.php" class="btn btn-light">
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
            ></textarea>

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

                    <option value="">
                        Selecione
                    </option>

                    <option value="Cafés">
                        Cafés
                    </option>

                    <option value="Bebidas">
                        Bebidas
                    </option>

                    <option value="Sobremesas">
                        Sobremesas
                    </option>

                    <option value="Combos">
                        Combos
                    </option>

                </select>

            </div>

        </div>

        <div class="form-group">

            <label for="imagem">
                Imagem do produto
            </label>

            <input
                type="file"
                id="imagem"
                name="imagem"
                accept="image/jpeg,image/png,image/webp"
            >

            <small>
                JPG, PNG ou WEBP.
            </small>

        </div>

        <div class="form-check">

            <label>

                <input
                    type="checkbox"
                    name="destaque"
                    value="1"
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
                    checked
                >

                Produto ativo

            </label>

        </div>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Cadastrar produto
        </button>

    </form>

</div>

<?php require_once '../../includes/footer.php'; ?>