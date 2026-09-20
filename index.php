<?php

require_once 'config/conexao.php';
$tituloPagina = 'Onde simplicidade encontra sabor';
require 'includes/header.php';

$produtos = $pdo->query("
    SELECT *
    FROM produtos
    WHERE ativo = 1
    ORDER BY destaque DESC, id DESC
    LIMIT 4
")->fetchAll();

$livros = $pdo->query("
    SELECT *
    FROM livros
    WHERE ativo = 1
    ORDER BY id DESC
    LIMIT 3
")->fetchAll();

$eventos = $pdo->query("
    SELECT *
    FROM eventos
    WHERE ativo = 1
    AND data_evento >= CURDATE()
    ORDER BY data_evento ASC
    LIMIT 3
")->fetchAll();

?>

<section class="hero">
    <div class="container hero-grid">
        <div class="fade-up">
            <span class="eyebrow">
                Cafeteria literária
            </span>

            <h1>
                Onde a simplicidade encontra
                <em>sabor.</em>
            </h1>

            <p>
                Um espaço para tomar um café especial,
                descobrir uma nova história e transformar
                pequenos momentos em memórias.
            </p>

            <div class="hero-actions">

                <a
                    href="cardapio.php"
                    class="btn btn-primary"
                >
                    Conheça o cardápio
                </a>

                <a
                    href="livros.php"
                    class="btn btn-light"
                >
                    Explorar livros
                </a>
            </div>
        </div>

        <div class="hero-image float">
            <img
                src="assets/img/hero-cafe.jpg"
                alt="Ambiente do Café Lumière"
            >
            <div class="image-placeholder">
                COLOQUE SUA FOTO AQUI
            </div>
        </div>
    </div>
</section>


<section class="section">
    <div class="container">
        <div class="section-heading reveal">
            <div>
                <span class="eyebrow">
                    Nossa experiência
                </span>

                <h2>
                    Café, livros e tempo para você.
                </h2>
            </div>

            <p>
                O Café Lumière nasceu para unir
                o aconchego de uma cafeteria sofisticada
                ao universo encantador da literatura.
            </p>
        </div>


        <div class="cards">
            <article class="card reveal">
                <div class="card-image">
                    <div class="image-placeholder">
                        FOTO DO AMBIENTE
                    </div>

                    <img
                        src="assets/img/ambiente.jpg"
                        alt="Ambiente da cafeteria"
                    >

                </div>
                <div class="card-content">
                    <h3>
                        Um lugar para ficar
                    </h3>

                    <p>
                        Mesas confortáveis, iluminação
                        acolhedora e um cantinho perfeito
                        para estudar, conversar ou ler.
                    </p>
                </div>

            </article>
            <article class="card reveal">
                <div class="card-image">
                    <div class="image-placeholder">
                        FOTO DO CAFÉ
                    </div>

                    <img
                        src="assets/img/cafe-destaque.jpg"
                        alt="Café especial"
                    >
                </div>
                <div class="card-content">
                    <h3>
                        Sabores especiais
                    </h3>

                    <p>
                        Cafés, bebidas e sobremesas pensados
                        para acompanhar cada capítulo do seu dia.
                    </p>
                </div>
            </article>

            <article class="card reveal">
                <div class="card-image">
                    <div class="image-placeholder">
                        FOTO DOS LIVROS
                    </div>

                    <img
                        src="assets/img/livros.jpg"
                        alt="Livros na cafeteria"
                    >
                </div>

                <div class="card-content">
                    <h3>
                        Histórias para descobrir
                    </h3>

                    <p>
                        Uma seleção de livros para você comprar,
                        conhecer e encontrar sua próxima leitura favorita.
                    </p>
                </div>
            </article>
        </div>
    </div>
</section>


<section class="section section-soft">
    <div class="container">
        <div class="section-heading reveal">
            <div>
                <span class="eyebrow">
                    Destaques
                </span>

                <h2>
                    Do nosso balcão.
                </h2>
            </div>

            <a
                href="cardapio.php"
                class="btn btn-light"
            >
                Ver tudo
            </a>
        </div>


        <div class="product-grid">
            <?php foreach ($produtos as $produto): ?>
                <article class="product-card reveal">
                    <div class="product-image">
                        <div class="image-placeholder">
                            IMAGEM DO PRODUTO
                        </div>

                        <img
                            src="<?= htmlspecialchars($produto['imagem']) ?>"
                            alt="<?= htmlspecialchars($produto['nome']) ?>"
                        >
                    </div>

                    <div class="product-info">
                        <h3>
                            <?= htmlspecialchars($produto['nome']) ?>
                        </h3>

                        <p>
                            <?= htmlspecialchars($produto['descricao']) ?>
                        </p>

                        <div class="product-footer">
                            <span class="price">
                                R$
                                <?= number_format(
                                    $produto['preco'],
                                    2,
                                    ',',
                                    '.'
                                ) ?>
                            </span>

                            <a
                                class="btn btn-primary"
                                href="adicionar_carrinho.php?tipo=produto&id=<?= $produto['id'] ?>"
                            >
                                Adicionar
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<section class="section">
    <div class="container">
        <div class="section-heading reveal">
            <div>
                <span class="eyebrow">
                    Curadoria Lumière
                </span>

                <h2>
                    Novas histórias.
                </h2>
            </div>

            <a
                href="livros.php"
                class="btn btn-light"
            >
                Ver livros
            </a>

        </div>


        <div class="book-grid">
            <?php foreach ($livros as $livro): ?>
                <article class="card reveal">
                    <div class="book-cover">
                        <div class="image-placeholder">
                            CAPA DO LIVRO
                        </div>

                        <img
                            src="<?= htmlspecialchars($livro['imagem']) ?>"
                            alt="Capa de <?= htmlspecialchars($livro['titulo']) ?>"
                        >
                    </div>

                    <div class="book-body">
                        <h3>
                            <?= htmlspecialchars($livro['titulo']) ?>
                        </h3>

                        <div class="book-meta">
                            <?= htmlspecialchars($livro['autor']) ?>
                            ·
                            <?= htmlspecialchars($livro['genero']) ?>
                        </div>

                        <p>
                            <?= htmlspecialchars($livro['sinopse']) ?>
                        </p>

                        <strong class="price">

                            R$
                            <?= number_format(
                                $livro['preco'],
                                2,
                                ',',
                                '.'
                            ) ?>
                        </strong>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<section class="section section-soft">
    <div class="container">
        <div class="section-heading reveal">
            <div>
                <span class="eyebrow">
                    Agenda
                </span>

                <h2>
                    Encontros que inspiram.
                </h2>
            </div>

            <a
                href="eventos.php"
                class="btn btn-light"
            >
                Todos os eventos
            </a>
        </div>


        <div class="event-list">
            <?php foreach ($eventos as $evento): ?>
                <article class="event-card reveal">
                    <div class="event-date">
                        <strong>
                            <?= date(
                                'd',
                                strtotime($evento['data_evento'])
                            ) ?>
                        </strong>

                        <?= date(
                            'M',
                            strtotime($evento['data_evento'])
                        ) ?>
                    </div>

                    <div>
                        <h3>
                            <?= htmlspecialchars($evento['titulo']) ?>
                        </h3>

                        <p>
                            <?= htmlspecialchars($evento['descricao']) ?>
                        </p>

                    </div>
                    <a
                        href="eventos.php"
                        class="btn btn-light"
                    >
                        Saiba mais
                    </a>

                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<section class="section">
    <div
        class="container"
        style="text-align:center"
    >

        <span class="eyebrow">
            Reserve seu momento
        </span>

        <h2 style="
            font-family:'Playfair Display',serif;
            font-size:clamp(40px,6vw,72px);
            font-weight:500;
            margin:15px 0;
        ">

            Sua mesa.
            Seu café.
            Sua história.

        </h2>

        <p style="
            max-width:620px;
            margin:0 auto 25px;
            color:var(--muted)
        ">

            Escolha o horário, reúna quem você gosta
            e deixe o restante com a gente.

        </p>

        <a
            href="reservas.php"
            class="btn btn-primary"
        >
            Fazer uma reserva
        </a>
    </div>
</section>


<?php require 'includes/footer.php'; ?>