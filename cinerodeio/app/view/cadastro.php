
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar Conta — Cinerodeio</title>
    <link rel="stylesheet" href="/cinerodeio/public/css/style.css">
</head>
<body>
<?php include __DIR__ . '/partials/navbar.php'; ?>

<main class="container-form">
    <h2>Criar Conta</h2>

    <?php if (!empty($_SESSION['erro'])): ?>
        <p class="erro"><?= $_SESSION['erro']; unset($_SESSION['erro']); ?></p>
    <?php endif; ?>

    <form action="/cinerodeio/index.php?rota=cadastro" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <label>Nome completo
            <input type="text" name="nome" required>
        </label>

        <label>Email
            <input type="email" name="email" required>
        </label>

        <label>Senha
            <input type="password" name="senha" required minlength="6">
        </label>

        <label>CPF (será usado para recuperar a senha)
            <input type="text" name="cpf" placeholder="000.000.000-00" required>
        </label>

        <label>Data de nascimento
            <input type="date" name="nascimento" required>
        </label>

        <button type="submit">Criar conta</button>
    </form>

    <a href="/cinerodeio/index.php?rota=login">Já tenho conta</a>
</main>
</body>
</html>
