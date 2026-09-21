<?php
require_once '../../config/conexao.php';

$produtos = $pdo->query("
    SELECT *
    FROM produtos
    ORDER BY id DESC
")->fetchAll();

$tituloPagina = 'Gerenciar Cardápio';

require_once '../header.php';
?>

<div class="admin-container">

    <div class="admin-header">
        <div>
            <span class="eyebrow">Administração</span>
            <h1>Cardápio</h1>
            <p>Gerencie os produtos exibidos no Café Lumière.</p>
        </div>

        <a href="criar.php" class="btn btn-primary">
            + Novo produto
        </a>
    </div>

    <div class="admin-table-wrapper">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Produto</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Destaque</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

            <?php if (count($produtos) > 0): ?>

                <?php foreach ($produtos as $produto): ?>

                    <tr>

                        <td>

                            <?php if (!empty($produto['imagem'])): ?>

                                <img
                                    src="../../<?= htmlspecialchars($produto['imagem']) ?>"
                                    alt="<?= htmlspecialchars($produto['nome']) ?>"
                                    class="admin-product-image"
                                >

                            <?php else: ?>

                                <div class="admin-no-image">
                                    Sem imagem
                                </div>

                            <?php endif; ?>

                        </td>

                        <td>
                            <strong>
                                <?= htmlspecialchars($produto['nome']) ?>
                            </strong>

                            <small>
                                <?= htmlspecialchars($produto['descricao']) ?>
                            </small>
                        </td>

                        <td>
                            <?= htmlspecialchars($produto['categoria']) ?>
                        </td>

                        <td>
                            R$ <?= number_format(
                                $produto['preco'],
                                2,
                                ',',
                                '.'
                            ) ?>
                        </td>

                        <td>

                            <?php if ($produto['destaque']): ?>

                                <span class="status status-highlight">
                                    Sim
                                </span>

                            <?php else: ?>

                                <span class="status">
                                    Não
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <?php if ($produto['ativo']): ?>

                                <span class="status status-active">
                                    Ativo
                                </span>

                            <?php else: ?>

                                <span class="status status-inactive">
                                    Inativo
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <div class="admin-actions">

                                <a
                                    href="editar.php?id=<?= $produto['id'] ?>"
                                    class="btn btn-small"
                                >
                                    Editar
                                </a>

                                <a
                                    href="excluir.php?id=<?= $produto['id'] ?>"
                                    class="btn btn-small btn-danger"
                                    onclick="return confirm('Tem certeza que deseja excluir este produto?')"
                                >
                                    Excluir
                                </a>

                            </div>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="7" class="empty-message">
                        Nenhum produto cadastrado.
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require_once '../footer.php'; ?>