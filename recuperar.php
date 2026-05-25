<?php

session_start();

require_once 'db.php';
require_once 'Usuario.php';

$usuario  = new Usuario($db);
$erro     = '';
$mensagem = '';
$etapa    = $_GET['etapa'] ?? '1'; 

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Requisição inválida.');
    }

    if ($etapa === '1') {
        $resultado = $usuario->recuperarSenha($_POST['cpf'] ?? '', $_POST['nascimento'] ?? '');

        if (is_array($resultado)) {
            
            $_SESSION['recuperar_id'] = $resultado['id'];
            header('Location: recuperar.php?etapa=2');
            exit;
        } else {
            $erro = $resultado;
        }
    }

    
    if ($etapa === '2' && !empty($_SESSION['recuperar_id'])) {
        $erro = $usuario->redefinirSenha(
            $_SESSION['recuperar_id'],
            $_POST['nova_senha']    ?? '',
            $_POST['confirmar']     ?? ''
        );

        if (!$erro) {
            unset($_SESSION['recuperar_id']); 
            $mensagem = 'Senha redefinida com sucesso! <a href="login.php">Faça login</a>.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Recuperar senha — CineScore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>CineScore</h1>
<h2>Recuperar senha</h2>

<?php if ($erro): ?>
    <div class="msg-erro">Erro <?= htmlspecialchars($erro) ?></div>
<?php endif; ?>
<?php if ($mensagem): ?>
    <div class="msg-sucesso">Sucesso <?= $mensagem ?></div>
<?php endif; ?>

<?php if (!$mensagem): ?>
<form method="POST" action="recuperar.php?etapa=<?= $etapa ?>">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

    <table>
        <?php if ($etapa === '1'): ?>
        
        <tr>
            <td>CPF:</td>
            <td><input type="text" name="cpf" placeholder="000.000.000-00" required></td>
        </tr>
        <tr>
            <td>Data de nascimento:</td>
            <td><input type="date" name="nascimento" required></td>
        </tr>

        <?php else: ?>
        
        <tr>
            <td>Nova senha:</td>
            <td><input type="password" name="nova_senha" required></td>
        </tr>
        <tr>
            <td>Confirmar senha:</td>
            <td><input type="password" name="confirmar" required></td>
        </tr>
        <?php endif; ?>

        <tr>
            <td></td>
            <td>
                <button type="submit"><?= $etapa === '1' ? 'Verificar' : 'Salvar nova senha' ?></button>
                <a href="login.php" class="btn-cancelar">Voltar</a>
            </td>
        </tr>
    </table>
</form>
<?php endif; ?>

</body>
</html>
