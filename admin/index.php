<?php

session_start();

require_once '../config/conexao.php';

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$tituloPagina = 'Painel Administrativo';

require '../includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Café Lumière</span>

        <h1>
            Painel Administrativo
        </h1>

        <p>
            Bem-vindo, <?= htmlspecialchars($_SESSION['admin_nome']) ?>!
            Gerencie o conteúdo do Café Lumière.
        </p>
    </div>
</section>

<section class="section">

    <div class="container">

        <div class="admin-header">
            <div>
                <span class="eyebrow">Administração</span>

                <h2>
                    Área administrativa
                </h2>

                <p>
                    Escolha uma opção para gerenciar o site.
                </p>
            </div>
        </div>

        <div class="admin-grid">

            <!-- Livros -->
            <div class="account-box">

                <h2>Livros</h2>

                <p>
                    Cadastre, edite e exclua livros do catálogo.
                </p>

                <a
                    href="livros/index.php"
                    class="btn btn-primary"
                >
                    Gerenciar livros
                </a>

            </div>

            <!-- Mensagens -->
            <div class="account-box">

                <h2>Mensagens</h2>

                <p>
                    Veja as mensagens enviadas pelos visitantes.
                </p>

                <a
                    href="mensagens/index.php"
                    class="btn btn-primary"
                >
                    Ver mensagens
                </a>

            </div>

            <!-- Eventos -->
            <div class="account-box">

                <h2>Eventos</h2>

                <p>
                    Gerencie os eventos disponíveis no Café Lumière.
                </p>

                <a
                    href="eventos/index.php"
                    class="btn btn-primary"
                >
                    Gerenciar eventos
                </a>

            </div>

            <!-- Produtos -->
            <div class="account-box">

                <h2>Produtos</h2>

                <p>
                    Gerencie os produtos e itens do cardápio.
                </p>

                <a
                    href="produtos/index.php"
                    class="btn btn-primary"
                >
                    Gerenciar produtos
                </a>

            </div>

            <!-- Reservas -->
            <div class="account-box">

                <h2>Reservas</h2>

                <p>
                    Consulte as reservas realizadas pelos clientes.
                </p>

                <a
                    href="reservas/index.php"
                    class="btn btn-primary"
                >
                    Ver reservas
                </a>

            </div>

        </div>

        <div class="detail-actions">

            <a
                href="../index.php"
                class="btn btn-light"
            >
                Voltar para o site
            </a>

            <a
                href="../logout.php"
                class="btn btn-danger"
            >
                Sair do administrador
            </a>

        </div>

    </div>

</section>

<?php require '../includes/footer.php'; ?>