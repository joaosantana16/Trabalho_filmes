
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Catálogo — Cinerodeio</title>
    <link rel="stylesheet" href="/cinerodeio/public/css/style.css">
</head>
<body>
<?php include __DIR__ . '/partials/navbar.php'; ?>

<main class="container">
    <h2>Catálogo de Filmes</h2>

    <div class="grid-filmes">
        <?php
        foreach ($filmes as $filme):
        ?>
            <div class="card-filme">
                <img src="/cinerodeio/public/<?= htmlspecialchars($filme['imagem']) ?>"
                     alt="<?= htmlspecialchars($filme['titulo']) ?>">

                <div class="card-info">
                    <h3><?= htmlspecialchars($filme['titulo']) ?></h3>
                    <p><?= htmlspecialchars($filme['genero']) ?> · <?= $filme['ano'] ?></p>

                    <?php if ($filme['media_nota']): ?>
                        <p>⭐ <?= round($filme['media_nota'], 1) ?> (<?= $filme['total_avaliacoes'] ?> avaliações)</p>
                    <?php else: ?>
                        <p>Sem avaliações ainda</p>
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
