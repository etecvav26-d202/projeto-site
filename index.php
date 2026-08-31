<?php
require 'config/conexao.php';
$livros = $pdo->query("SELECT * FROM livros ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
include 'includes/header.php';
?>

<section class="hero">
    <div class="hero-texto">
        <h1>Nosso Café, Seu Momento.</h1>
        <p>O Café Lumière une o aroma do café artesanal ao universo dos livros, criando um refúgio para quem ama boas histórias e boas xícaras.</p>
        <div class="hero-botoes">
            <a href="#livros" class="btn-primario">Ver Livros <span>→</span></a>
            <a href="#cardapio" class="btn-secundario">Explorar Mais</a>
        </div>
    </div>
    <div class="hero-imagem">
        <div class="badge-flutuante badge-1">🤎</div>
        <div class="badge-flutuante badge-2">🤎</div>
        <div class="badge-flutuante badge-3">🤎</div>
        <img src="uploads/hero-fundo.jpg" alt="Xícara de café">
    </div>
    <div class="hero-stats">
        <div class="stat">
            <strong>50+</strong>
            <span>Títulos de Livros</span>
        </div>
        <div class="stat">
            <strong>15+</strong>
            <span>Itens no Cardápio</span>
        </div>
        <div class="stat">
            <strong>2k+</strong>
            <span>Clientes Felizes</span>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
