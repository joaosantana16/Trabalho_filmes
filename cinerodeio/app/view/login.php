
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login — Cinerodeio</title>
    <link rel="stylesheet" href="/cinerodeio/public/css/style.css">
</head>
<body>

<?php include __DIR__ . '/partials/navbar.php'; ?>

<main class="container-form">
    <h2>Entrar</h2>

    <?php
    if (!empty($_SESSION['erro'])) {
        echo '<p class="erro">' . $_SESSION['erro'] . '</p>';
        unset($_SESSION['erro']);
    }
    if (!empty($_SESSION['sucesso'])) {
        echo '<p class="sucesso">' . $_SESSION['sucesso'] . '</p>';
        unset($_SESSION['sucesso']);
    }
    ?>
    <form action="/cinerodeio/index.php?rota=login" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <label>Email
            <input type="email" name="email" required>
        </label>
        <label>Senha
            <input type="password" name="senha" required>
        </label>
        <button type="submit">Entrar</button>
    </form>

    <a href="/cinerodeio/index.php?rota=cadastro">Criar conta</a> |
    <a href="/cinerodeio/index.php?rota=recuperar_senha">Esqueci a senha</a>
</main>

</body>
</html>
