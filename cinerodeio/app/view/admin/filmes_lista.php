<?php?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin — Cinerodeio</title>
    <link rel="stylesheet" href="/cinerodeio/public/css/style.css">
</head>
<body>
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<main class="container">
    <h2>Gerenciar Filmes</h2>
    <a href="/cinerodeio/index.php?rota=admin_novo_filme" class="btn">+ Novo Filme</a>

    <table class="tabela-admin">
        <thead>
            <tr>
                <th>Título</th>
                <th>Gênero</th>
                <th>Ano</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filmes as $filme): ?>
                <tr>
                    <td><?= htmlspecialchars($filme['titulo']) ?></td>
                    <td><?= htmlspecialchars($filme['genero']) ?></td>
                    <td><?= $filme['ano'] ?></td>
                    <td>
                        <a href="/cinerodeio/index.php?rota=admin_editar_filme&id=<?= $filme['id'] ?>">Editar</a>
                        <form action="/cinerodeio/index.php?rota=admin_deletar_filme" method="POST"
                              style="display:inline"
                              onsubmit="return confirm('Tem certeza que quer deletar?')">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                            <button type="submit" class="btn-deletar">Deletar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>
