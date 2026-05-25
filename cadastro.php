<?php

session_start();

require_once 'db.php';
require_once 'Usuario.php';

$usuario = new Usuario($db);
$erro     = '';
$mensagem = '';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Requisição inválida.');
    }

    $erro = $usuario->cadastrar($_POST);

    if (!$erro) {
        $mensagem = 'Cadastro realizado! <a href="login.php">Faça login</a>.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro — CineScore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>CineScore</h1>
<h2>Criar conta</h2>

<?php if ($erro): ?>
    <div class="msg-erro">Erro <?= htmlspecialchars($erro) ?></div>
<?php endif; ?>
<?php if ($mensagem): ?>
    <div class="msg-sucesso">Sucesso <?= $mensagem ?></div>
<?php endif; ?>

<form method="POST" action="cadastro.php">

    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

    <div>
        <label for="nome">Nome: *</label>
        <input id="nome" type="text" name="nome" required value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>">
    </div>

    <div>
        <label for="email">E-mail: *</label>
        <input id="email" type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    </div>

    <div>
        <label for="cpf">CPF: *</label>
        <input id="cpf" type="text" name="cpf" placeholder="000.000.000-00" required value="<?= htmlspecialchars($_POST['cpf'] ?? '') ?>">
    </div>

    <div>
        <label for="nascimento">Data de nascimento: *</label>
        <input id="nascimento" type="date" name="nascimento" required value="<?= htmlspecialchars($_POST['nascimento'] ?? '') ?>">
    </div>

    <div>
        <label for="senha">Senha: *</label>
        <input id="senha" type="password" name="senha" required>
    </div>

    <div>
        <label for="confirmar">Confirmar senha: *</label>
        <input id="confirmar" type="password" name="confirmar" required>
    </div>

    <div>
        <button type="submit">Cadastrar</button>
        <a href="login.php" class="btn-cancelar">Já tenho conta</a>
    </div>
</form>

</body>
</html>
