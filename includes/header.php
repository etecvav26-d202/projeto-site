<?php
if (!isset($tituloPagina)) {
    $tituloPagina = 'Café Lumière';
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Café Lumière — cafeteria literária que une cafés especiais, livros e experiências culturais."
    >

    <title>
        <?= htmlspecialchars($tituloPagina) ?> | Café Lumière
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href=""
        href="/projeto-site/assets/css/style.css"
    >

</head>
<body>
<header class="site-header">
    <div class="container nav-container">
        <a href="index.php" class="logo">
            <span class="logo-symbol">L</span>
            <span class="logo-text">
                Café Lumière
            </span>

        </a>

        <button
            class="menu-toggle"
            id="menuToggle"
            aria-label="Abrir menu"
            type="button"
        >
            <span></span>
            <span></span>
            <span></span>

        </button>

        <nav
            class="main-nav"
            id="mainNav"
        >

            <a href="index.php">
                Início
            </a>

            <a href="cardapio.php">
                Cardápio
            </a>

            <a href="livros.php">
                Livros
            </a>

            <a href="recomendacoes.php">
                Recomendações
            </a>

            <a href="eventos.php">
                Eventos
            </a>

            <a href="contato.php">
                Contato
            </a>

            <a
                href="carrinho.php"
                class="nav-cart"
            >
                Carrinho
            </a>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                
                <a href="minha_conta.php">Minha conta</a>
                
                <?php else: ?>
                    
                    <a href="login.php">Entrar</a>
                    
                    <?php endif; ?>
        </nav>
    </div>
</header>
<main>