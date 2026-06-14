
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gêneros — Cinerodeio</title>
    <link rel="stylesheet" href="/cinerodeio/public/css/style.css">
</head>
<body>
<?php include __DIR__ . '/partials/navbar.php'; ?>
<main class="container">
    <h2>Navegar por Gênero</h2>
    <div class="lista-generos">
        <?php
        $generos = ['Ação', 'Comédia', 'Drama', 'Terror', 'Ficção Científica', 'Romance', 'Animação', 'Documentário'];
        foreach ($generos as $g):
        ?>
            <a href="/cinerodeio/index.php?rota=filmes_genero&genero=<?= urlencode($g) ?>" class="tag-genero">
                <?= $g ?>
            </a>
        <?php endforeach; ?>
    </div>
</main>
<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
