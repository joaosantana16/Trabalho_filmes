<?php


session_start();

require_once 'db.php';
require_once 'Usuario.php';

$usuario = new Usuario($db);
$erro    = '';


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Requisição inválida.');
    }

    $resultado = $usuario->login($_POST['email'] ?? '', $_POST['senha'] ?? '');

    if (is_array($resultado)) {
        
        $_SESSION['usuario_id']   = $resultado['id'];
        $_SESSION['usuario_nome'] = $resultado['nome'];

        
        if (!empty($_POST['lembrar'])) {
            setcookie('usuario_email', $resultado['email'], time() + (30 * 24 * 60 * 60), '/');
        }

        
        header('Location: index.php');
        exit;

    } else {
        
        $erro = $resultado;
    }
}


$emailSalvo = $_COOKIE['usuario_email'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login — CineScore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>CineScore</h1>
<h2>Entrar na conta</h2>

<?php if ($erro): ?>
    <div class="msg-erro">Erro <?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<form method="POST" action="login.php">

    
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        E-mail: <input type="email" name="email" required value="<?= htmlspecialchars($emailSalvo) ?>">
        Senha: <input type="password" name="senha" required>
        <input type="checkbox" name="lembrar"> Lembrar de mim
        <button type="submit">Entrar</button>
        <a href="recuperar.php" class="btn-cancelar">Esqueci minha senha</a>
</form>

<p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>

</body>
</html>
