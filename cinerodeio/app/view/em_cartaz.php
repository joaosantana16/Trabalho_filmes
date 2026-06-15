<?php
require_once __DIR__ . '/../model/Filme.php';
$filmeModel = new Filme();
$filmes = $filmeModel->listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Em Cartaz — Cinerodeio</title>
    <link rel="stylesheet" href="/cinerodeio/public/css/style.css">
</head>
<body>
<?php include __DIR__ . '/partials/navbar.php'; ?>
<main class="container">
    <h2>Em Cartaz — <?= date('Y') ?></h2>
    <div class="grid-filmes">
        <?php foreach ($filmes as $filme): ?>
            <?php if ($filme['ano'] == date('Y')): ?>
                <div class="card-filme">
                    <img src="/cinerodeio/public/<?= htmlspecialchars($filme['imagem']) ?>"
                         alt="<?= htmlspecialchars($filme['titulo']) ?>">
                    <div class="card-info">
                        <h3><?= htmlspecialchars($filme['titulo']) ?></h3>
                        <a href="/cinerodeio/index.php?rota=detalhe&id=<?= $filme['id'] ?>" class="btn">Ver</a>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</main>
<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
