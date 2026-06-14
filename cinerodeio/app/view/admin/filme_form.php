<?php

$editando = !empty($filme);
$acao     = $editando
    ? '/cinerodeio/index.php?rota=admin_atualizar_filme'
    : '/cinerodeio/index.php?rota=admin_cadastrar_filme';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $editando ? 'Editar' : 'Novo' ?> Filme — Cinerodeio</title>
    <link rel="stylesheet" href="/cinerodeio/public/css/style.css">
</head>
<body>
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<main class="container-form">
    <h2><?= $editando ? 'Editar Filme' : 'Novo Filme' ?></h2>

    <form action="<?= $acao ?>" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <?php if ($editando): ?>
            <input type="hidden" name="id" value="<?= $filme['id'] ?>">
        <?php endif; ?>

        <label>Título
            <input type="text" name="titulo" value="<?= htmlspecialchars($filme['titulo'] ?? '') ?>" required>
        </label>

        <label>Sinopse
            <textarea name="sinopse" rows="5"><?= htmlspecialchars($filme['sinopse'] ?? '') ?></textarea>
        </label>

        <label>Ano
            <input type="number" name="ano" value="<?= $filme['ano'] ?? '' ?>" min="1900" max="2099">
        </label>

        <label>Diretor
            <input type="text" name="diretor" value="<?= htmlspecialchars($filme['diretor'] ?? '') ?>">
        </label>

        <label>Gênero
            <input type="text" name="genero" value="<?= htmlspecialchars($filme['genero'] ?? '') ?>">
        </label>

        <label>Imagem (caminho, ex: img/filmes/popcorn.jpg)
            <input type="text" name="imagem" value="<?= htmlspecialchars($filme['imagem'] ?? '') ?>">
        </label>

        <button type="submit"><?= $editando ? 'Salvar alterações' : 'Cadastrar filme' ?></button>
        <a href="/cinerodeio/index.php?rota=admin_filmes">Cancelar</a>
    </form>
</main>
</body>
</html>
