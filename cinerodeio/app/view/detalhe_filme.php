
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($filme['titulo']) ?> — Cinerodeio</title>
    <link rel="stylesheet" href="/cinerodeio/public/css/style.css">
</head>
<body>
<?php include __DIR__ . '/partials/navbar.php'; ?>

<main class="container">
    <div class="detalhe-filme">
        <img src="/cinerodeio/public/<?= htmlspecialchars($filme['imagem']) ?>"
             alt="<?= htmlspecialchars($filme['titulo']) ?>" class="capa">

        <div class="detalhe-info">
            <h1><?= htmlspecialchars($filme['titulo']) ?></h1>
            <p><strong>Diretor:</strong> <?= htmlspecialchars($filme['diretor']) ?></p>
            <p><strong>Gênero:</strong> <?= htmlspecialchars($filme['genero']) ?></p>
            <p><strong>Ano:</strong> <?= $filme['ano'] ?></p>
            <p><?= htmlspecialchars($filme['sinopse']) ?></p>

            <?php if ($filme['media_nota']): ?>
                <p>⭐ Média: <?= round($filme['media_nota'], 1) ?>/5 (<?= $filme['total_avaliacoes'] ?> votos)</p>
            <?php endif; ?>
        </div>
    </div>
    <?php if (!empty($_SESSION['usuario_id'])): ?>

        <section class="avaliar">
            <h3>Sua avaliação</h3>
            <?php if ($minhaAvaliacao): ?>
                <p>Você já avaliou este filme: <?= str_repeat('⭐', $minhaAvaliacao) ?></p>
            <?php endif; ?>

            <form action="/cinerodeio/index.php?rota=avaliar" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="id_filme" value="<?= $filme['id'] ?>">

                <label>Nota:
                    <select name="nota">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?= $i ?>" <?= $minhaAvaliacao == $i ? 'selected' : '' ?>>
                                <?= $i ?>★
                            </option>
                        <?php endfor; ?>
                    </select>
                </label>

                <button type="submit"><?= $minhaAvaliacao ? 'Atualizar nota' : 'Avaliar' ?></button>
            </form>
        </section>
        <section class="comentar">
            <h3>Deixe um comentário</h3>
            <form action="/cinerodeio/index.php?rota=comentar" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="id_filme" value="<?= $filme['id'] ?>">
                <textarea name="texto" rows="4" placeholder="O que achou do filme?" required></textarea>
                <button type="submit">Comentar</button>
            </form>
        </section>

    <?php else: ?>
        <p><a href="/cinerodeio/index.php?rota=login">Faça login</a> para avaliar e comentar.</p>
    <?php endif; ?>
    <section class="comentarios">
        <h3>Comentários (<?= count($comentarios) ?>)</h3>

        <?php if (empty($comentarios)): ?>
            <p>Nenhum comentário ainda. Seja o primeiro!</p>
        <?php endif; ?>

        <?php foreach ($comentarios as $c): ?>
            <div class="comentario">
                <strong><?= htmlspecialchars($c['nome_usuario']) ?></strong>
                <span><?= date('d/m/Y H:i', strtotime($c['criado_em'])) ?></span>
                <p><?= htmlspecialchars($c['texto']) ?></p>
            </div>
        <?php endforeach; ?>
    </section>

</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
