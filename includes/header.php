<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$carrinhoQtd = 0;

if (!empty($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        $carrinhoQtd += (int)$item['quantidade'];
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= isset($tituloPagina) ? htmlspecialchars($tituloPagina) . ' | ' : '' ?>
        Café Lumière
    </title>
    <meta
        name="description"
        content="Café Lumière — cafeteria literária que une cafés especiais, livros e experiências culturais."
    >
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;1,500&display=swap"
        rel="stylesheet"
    >
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
    <div class="container nav-wrap">
        <a href="index.php" class="brand">
            <span class="brand-mark">CL</span>
            <span>
                <strong>CAFÉ LUMIÈRE</strong>
                <small>CAFETERIA LITERÁRIA</small>
            </span>
        </a>

        <button
            class="menu-toggle"
            id="menuToggle"
            aria-label="Abrir menu"
        >
            ☰
        </button>

        <nav class="main-nav" id="mainNav">
            <a href="index.php">Início</a>
            <a href="cardapio.php">Cardápio</a>
            <a href="livros.php">Livros</a>
            <a href="recomendacoes.php">Recomendações</a>
            <a href="eventos.php">Eventos</a>
            <a href="reservas.php">Reservas</a>
            <a href="contato.php">Contato</a>
        </nav>

        <div class="nav-actions">
            <a href="login.php" class="login-link">
                <?= !empty($_SESSION['usuario'])
                    ? 'Minha conta'
                    : 'Login'
                ?>
            </a>

            <a
                href="carrinho.php"
                class="cart-link"
                aria-label="Carrinho"
            >
                🛒
                <span class="cart-count">
                    <?= $carrinhoQtd ?>
                </span>
            </a>
        </div>
    </div>
</header>
<main>