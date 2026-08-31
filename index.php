<?php
require 'config/conexao.php';
$livros = $pdo->query("SELECT * FROM livros ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
include 'includes/header.php';
?>

<section class="hero">
    <div class="hero-texto">
        <span class="hero-tag">☕ Cafeteria Literária</span>
        <h1>Café e Literatura, no Seu Momento.</h1>
        <p>O Café Lumière une o aroma do café artesanal ao universo dos livros, criando um refúgio para quem ama boas histórias e boas xícaras.</p>
        <div class="hero-botoes">
            <a href="#livros" class="btn-primario">Ver Livros <span>→</span></a>
            <a href="#cardapio" class="btn-secundario">Ver Cardápio</a>
        </div>
        <div class="hero-stats">
            <div class="stat">
                <strong>50+</strong>
                <span>Títulos Disponíveis</span>
            </div>
            <div class="stat">
                <strong>15+</strong>
                <span>Itens no Cardápio</span>
            </div>
            <div class="stat">
                <strong>200+</strong>
                <span>Clientes Satisfeitos</span>
            </div>
        </div>
    </div>
    <div class="hero-imagem">
        <div class="badge-flutuante badge-1">📖</div>
        <div class="badge-flutuante badge-2">☕</div>
        <img src="/projeto-site/images/hero-cafe.jpg" alt="Xícara de café com livro">
        <div class="hero-selo">
            <strong>Livro do mês</strong>
            <span>-20% OFF</span>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
