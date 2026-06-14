
<nav class="navbar">
    <a href="/cinerodeio/index.php?rota=home" class="logo">Cinerodeio</a>

    <ul>
        <li><a href="/cinerodeio/index.php?rota=catalogo">Catálogo</a></li>
        <li><a href="/cinerodeio/index.php?rota=em_cartaz">Em Cartaz</a></li>
        <li><a href="/cinerodeio/index.php?rota=generos">Gêneros</a></li>
        <li><a href="/cinerodeio/index.php?rota=sobre">Sobre</a></li>
    </ul>

    <div class="nav-usuario">
        <?php if (!empty($_SESSION['usuario_id'])): ?>
            <span>Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>

            <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
                <a href="/cinerodeio/index.php?rota=admin_filmes">Painel Admin</a>
            <?php endif; ?>

            <a href="/cinerodeio/index.php?rota=logout">Sair</a>

        <?php else: ?>
            <a href="/cinerodeio/index.php?rota=login">Entrar</a>
            <a href="/cinerodeio/index.php?rota=cadastro">Criar conta</a>
        <?php endif; ?>
    </div>
</nav>
