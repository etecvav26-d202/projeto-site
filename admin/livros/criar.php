<?php

require_once '../../config/conexao.php';
$tituloPagina = 'Cadastrar Livro';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $titulo = trim($_POST['titulo'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $sinopse = trim($_POST['sinopse'] ?? '');
    $preco = str_replace(',', '.', trim($_POST['preco'] ?? ''));
    $tipo = $_POST['tipo'] ?? 'compra';
    $imagem = trim($_POST['imagem'] ?? '');
    $destaque = isset($_POST['destaque']) ? 1 : 0;
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    if(
        $titulo === '' ||
        $autor === '' ||
        $genero === '' ||
        $sinopse === '' ||
        $preco === ''
    ){

        $erro = 'Preencha todos os campos obrigatórios.';

    }elseif (!is_numeric($preco)){

        $erro = 'Digite um preço válido.';

    }else{
        try{
            $stmt = $pdo->prepare("
                INSERT INTO livros
                (titulo, autor, genero, sinopse, preco, tipo, imagem, destaque, ativo)
                VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $titulo,
                $autor,
                $genero,
                $sinopse,
                $preco,
                $tipo,
                $imagem,
                $destaque,
                $ativo
            ]);

            header('Location: index.php');
            exit;

        }catch (PDOException $e){

            $erro = 'Erro ao cadastrar o livro: ' . $e->getMessage();

        }
    }
}

require '../../includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Administração</span>
        <h1>Novo livro</h1>
        <p>
            Cadastre uma nova obra no catálogo do Café Lumière.
        </p>
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
                        <label for="titulo">
                            Título *
                        </label>

                        <input
                            type="text"
                            id="titulo"
                            name="titulo"
                            required
                        >

                    </div>

                    <div class="form-group">
                        <label for="autor">
                            Autor *
                        </label>

                        <input
                            type="text"
                            id="autor"
                            name="autor"
                            required
                        >

                    </div>
                    <div class="form-group">
                        <label for="genero">
                            Gênero *
                        </label>

                        <input
                            type="text"
                            id="genero"
                            name="genero"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="preco">
                            Preço *
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
                        <label for="tipo">
                            Disponibilidade
                        </label>

                        <select id="tipo" name="tipo">

                            <option value="compra">
                                Compra
                            </option>

                            <option value="aluguel">
                                Aluguel
                            </option>

                            <option value="ambos">
                                Compra e aluguel
                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label for="imagem">
                            Imagem
                        </label>
                        
                        <input
                        type="url"
                        id="imagem"
                        name="imagem"
                        placeholder="https://exemplo.com/imagem.jpg"
                        >

                    </div>
                </div>

                <div class="form-group">
                    <label for="sinopse">
                        Sinopse *
                    </label>

                    <textarea
                        id="sinopse"
                        name="sinopse"
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

                        Destacar livro

                    </label>

                    <label>
                        <input
                            type="checkbox"
                            name="ativo"
                            value="1"
                            checked
                        >

                        Livro ativo

                    </label>
                </div>
                <div class="detail-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Cadastrar livro
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