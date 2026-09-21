<?php

session_start();

require_once 'config/conexao.php';

$tituloPagina = 'Login';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("
        SELECT *
        FROM usuarios
        WHERE email = ?
    ");

    $stmt->execute([$email]);

    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];

        header('Location: minha_conta.php');
        exit;

    } else {

        $erro = 'E-mail ou senha incorretos.';
    }
}

require 'includes/header.php';

?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Café Lumière</span>
        <h1>Entrar</h1>
        <p>Acesse sua conta para continuar.</p>
    </div>
</section>

<section class="section">

    <div class="container">

        <div class="admin-form account-form">

            <?php if (isset($_GET['cadastro'])): ?>

                <div class="form-success">
                    Cadastro realizado com sucesso. Faça login para continuar.
                </div>

            <?php endif; ?>

            <?php if ($erro): ?>

                <div class="form-error">
                    <?= htmlspecialchars($erro) ?>
                </div>

            <?php endif; ?>

            <form method="POST">

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

                <button type="submit" class="btn btn-primary">
                    Entrar
                </button>

            </form>

            <p class="account-link">
                Ainda não possui uma conta?
                <a href="cadastro.php">Criar conta</a>
            </p>

            <p>
                É administrador?
                <a href="admin/login.php">Entrar como administrador</a>
            </p>

        </div>

    </div>

</section>

<?php require 'includes/footer.php'; ?>