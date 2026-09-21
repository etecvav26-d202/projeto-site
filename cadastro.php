<?php

require_once 'config/conexao.php';

$tituloPagina = 'Criar conta';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';

    if ($nome === '' || $email === '' || $senha === '') {

        $erro = 'Preencha todos os campos.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $erro = 'Digite um e-mail válido.';

    } elseif ($senha !== $confirmarSenha) {

        $erro = 'As senhas não coincidem.';

    } elseif (strlen($senha) < 6) {

        $erro = 'A senha deve ter pelo menos 6 caracteres.';

    } else {

        $stmt = $pdo->prepare("
            SELECT id
            FROM usuarios
            WHERE email = ?
        ");

        $stmt->execute([$email]);

        if ($stmt->fetch()) {

            $erro = 'Este e-mail já está cadastrado.';

        } else {

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("
                INSERT INTO usuarios
                (nome, email, senha)
                VALUES (?, ?, ?)
            ");

            $stmt->execute([
                $nome,
                $email,
                $senhaHash
            ]);

            header('Location: login.php?cadastro=sucesso');
            exit;
        }
    }
}

require 'includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Café Lumière</span>
        <h1>Criar conta</h1>
        <p>Faça seu cadastro para reservar eventos e acompanhar seus pedidos.</p>
    </div>
</section>

<section class="section">

    <div class="container">

        <div class="admin-form account-form">

            <?php if ($erro): ?>

                <div class="form-error">
                    <?= htmlspecialchars($erro) ?>
                </div>

            <?php endif; ?>

            <form method="POST">

                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="confirmar_senha">Confirmar senha</label>
                    <input
                        type="password"
                        id="confirmar_senha"
                        name="confirmar_senha"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    Criar conta
                </button>

            </form>

            <p class="account-link">
                Já possui uma conta?
                <a href="login.php">Entrar</a>
            </p>

        </div>

    </div>

</section>

<?php require 'includes/footer.php'; ?>