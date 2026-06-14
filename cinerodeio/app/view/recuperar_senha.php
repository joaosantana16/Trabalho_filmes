<?php // app/view/recuperar_senha.php ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha — Cinerodeio</title>
    <link rel="stylesheet" href="/cinerodeio/public/css/style.css">
</head>
<body>
<?php include __DIR__ . '/partials/navbar.php'; ?>

<main class="container-form">
    <h2>Recuperar Senha</h2>
    <p>Informe seu CPF e data de nascimento para redefinir a senha.</p>

    <?php if (!empty($_SESSION['erro'])): ?>
        <p class="erro"><?= $_SESSION['erro']; unset($_SESSION['erro']); ?></p>
    <?php endif; ?>

    <form action="/cinerodeio/index.php?rota=recuperar_senha" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <label>CPF
            <input type="text" name="cpf" placeholder="000.000.000-00" required>
        </label>

        <label>Data de nascimento
            <input type="date" name="nascimento" required>
        </label>

        <label>Nova senha
            <input type="password" name="nova_senha" required minlength="6">
        </label>

        <button type="submit">Redefinir senha</button>
    </form>
</main>
</body>
</html>
