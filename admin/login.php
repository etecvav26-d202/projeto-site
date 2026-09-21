<?php

session_start();

require_once '../config/conexao.php';

$tituloPagina = 'Login do Administrador';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email === '' || $senha === '') {

        $erro = 'Preencha o e-mail e a senha.';

    } else {

        $stmt = $pdo->prepare("
            SELECT *
            FROM administradores
            WHERE email = ?
        ");

        $stmt->execute([$email]);

        $admin = $stmt->fetch();

        if ($admin && password_verify($senha, $admin['senha'])) {

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_nome'] = $admin['nome'];
            $_SESSION['admin_email'] = $admin['email'];

            header('Location: index.php');
            exit;

        } else {

            $erro = 'E-mail ou senha de administrador incorretos.';

        }
    }
}

require '../includes/header.php';

?>

<section class="page-hero">

    <div class="container">

        <span class="eyebrow">
            Café Lumière
        </span>

        <h1>
            Área do administrador
        </h1>

        <p>
            Entre com sua conta de administrador para gerenciar o site.
        </p>

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

                    <label for="email">
                        E-mail
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        autocomplete="email"
                    >

                </div>

                <div class="form-group">

                    <label for="senha">
                        Senha
                    </label>

                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        required
                        autocomplete="current-password"
                    >

                </div>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Entrar como administrador
                </button>

            </form>

            <p class="account-link">

                <a href="../login.php">
                    ← Voltar para o login
                </a>

            </p>

        </div>

    </div>

</section>

<?php require '../includes/footer.php'; ?>