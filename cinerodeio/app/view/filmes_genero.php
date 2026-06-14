
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($genero) ?> — Cinerodeio</title>
    <link rel="stylesheet" href="/cinerodeio/public/css/style.css">
</head>
<body>
<?php include __DIR__ . '/partials/navbar.php'; ?>
<main class="container">
    <h2>Filmes: <?= htmlspecialchars($genero) ?></h2>

    <?php if (empty($filmes)): ?>
        <p>Nenhum filme encontrado neste gênero ainda.</p>
    <?php endif; ?>

    <div class="grid-filmes">
        <?php foreach ($filmes as $filme): ?>
            <div class="card-filme">
                <img src="/cinerodeio/public/<?= htmlspecialchars($filme['imagem']) ?>"
                     alt="<?= htmlspecialchars($filme['titulo']) ?>">
                <div class="card-info">
                    <h3><?= htmlspecialchars($filme['titulo']) ?></h3>
                    <p><?= $filme['ano'] ?></p>
                    <?php if ($filme['media_nota']): ?>
                        <p>⭐ <?= round($filme['media_nota'], 1) ?></p>
                    <?php endif; ?>
                    <a href="/cinerodeio/index.php?rota=detalhe&id=<?= $filme['id'] ?>" class="btn">Ver detalhes</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
