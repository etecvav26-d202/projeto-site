<?php
require 'config/conexao.php';
$livros = $pdo->query("SELECT * FROM livros ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
include 'includes/header.php';
?>

<section class="hero">
    <div class="hero-texto">
        <h1>Café e literatura, no mesmo lugar.</h1>
        <p>O Café Lumière une o aroma do café artesanal ao universo dos livros, criando um refúgio para quem ama boas histórias e boas xícaras.</p>
        <div class="hero-botoes">
            <a href="#livros" class="btn-primario">Ver Livros →</a>
            <a href="#cardapio" class="btn-secundario">Ver Cardápio</a>
        </div>
        <div class="hero-stats">
            <div class="stat">
                <strong>50+</strong>
                <span>Títulos disponíveis</span>
            </div>
            <div class="stat">
                <strong>15+</strong>
                <span>Itens no cardápio</span>
            </div>
            <div class="stat">
                <strong>200+</strong>
                <span>Clientes satisfeitos</span>
            </div>
        </div>
    </div>
    <div class="hero-imagem">
        <img src="/projeto-site/images/hero-cafe.jpg" alt="Xícara de café com livro">
    </div>
</section>

<?php include 'includes/footer.php'; ?>
