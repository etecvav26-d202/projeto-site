<?php

$tituloPagina = 'Entre em contato';

require 'includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Contato</span>
        <h1>Fale com o Café Lumière</h1>
        <p>Tem alguma dúvida, sugestão ou mensagem? Envie para nossa equipe.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="contact-content">
            <div class="contact-info">
                <span class="eyebrow">Café Lumière</span>
                <h2>Estamos aqui para ouvir você.</h2>
                <p>
                    Entre em contato para tirar dúvidas sobre nossos produtos,
                    livros, eventos, reservas ou fazer uma sugestão.
                </p>

                <p><strong>E-mail:</strong> contato@cafelumiere.com</p>
                <p><strong>Horário:</strong> Segunda a sábado, das 9h às 20h.</p>
            </div>

            <div class="contact-form">
                <?php if (isset($_GET['sucesso'])): ?>
                    <div class="form-success">
                        Sua mensagem foi enviada com sucesso!
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['erro'])): ?>
                    <div class="form-error">
                        Preencha todos os campos obrigatórios.
                    </div>
                <?php endif; ?>

                <form action="enviar_contato.php" method="POST">

                    <div class="form-group">
                        <label for="nome">Nome *</label>
                        <input type="text" id="nome" name="nome" required>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="assunto">Assunto *</label>
                        <input type="text" id="assunto" name="assunto" required>
                    </div>

                    <div class="form-group">
                        <label for="mensagem">Mensagem *</label>
                        <textarea id="mensagem" name="mensagem" rows="7" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Enviar mensagem
                    </button>

                </form>
            </div>
        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>