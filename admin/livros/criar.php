<?php

require_once '../../config/conexao.php';
$tituloPagina = 'Gerenciar Livros';
$livros = $pdo->query("
    SELECT *
    FROM livros
    ORDER BY id DESC
")->fetchAll();

require '../../includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Administração</span>
        <h1>Livros</h1>
        <p>Gerencie os livros cadastrados no Café Lumière.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="admin-header">
            <div>
                <span class="eyebrow">Catálogo</span>
                <h2>Livros cadastrados</h2>
            </div>

            <a href="criar.php" class="btn btn-primary">
                Novo livro
            </a>
        </div>

        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Gênero</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($livros as $livro): ?>
                        <tr>
                            <td>
                                <?= $livro['id'] ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($livro['titulo']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($livro['autor']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($livro['genero']) ?>
                            </td>

                            <td>
                                R$ <?= number_format($livro['preco'], 2, ',', '.') ?>
                            </td>

                            <td>
                                <?php if ($livro['ativo']): ?>
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
                                        href="editar.php?id=<?= $livro['id'] ?>"
                                        class="btn btn-light"
                                    >
                                        Editar
                                    </a>

                                    <a
                                        href="excluir.php?id=<?= $livro['id'] ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('Tem certeza que deseja excluir este livro?')"
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