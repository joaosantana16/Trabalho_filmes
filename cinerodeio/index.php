<?php

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/app/controller/UsuarioController.php';
require_once __DIR__ . '/app/controller/FilmeController.php';

$usuarioCtrl = new UsuarioController();
$filmeCtrl   = new FilmeController();

$rota = $_GET['rota'] ?? 'home';

switch ($rota) {

    case 'home':
        require_once __DIR__ . '/app/view/home.php';
        break;

    case 'sobre':
        require_once __DIR__ . '/app/view/sobre.php';
        break;

    case 'em_cartaz':
        require_once __DIR__ . '/app/view/em_cartaz.php';
        break;

    case 'generos':
        require_once __DIR__ . '/app/view/generos.php';
        break;

    case 'catalogo':
        $filmeCtrl->catalogo();
        break;

    case 'detalhe':
        $filmeCtrl->detalhe();
        break;

    case 'filmes_genero':
        $filmeCtrl->porGenero();
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioCtrl->processarLogin();
        } else {
            $usuarioCtrl->exibirLogin();
        }
        break;

    case 'cadastro':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioCtrl->processarCadastro();
        } else {
            $usuarioCtrl->exibirCadastro();
        }
        break;

    case 'recuperar_senha':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioCtrl->processarRecuperarSenha();
        } else {
            $usuarioCtrl->exibirRecuperarSenha();
        }
        break;

    case 'logout':
        $usuarioCtrl->logout();
        break;

    case 'avaliar':
        $filmeCtrl->avaliar();
        break;

    case 'comentar':
        $filmeCtrl->comentar();
        break;

    case 'admin_filmes':
        $filmeCtrl->adminFilmes();
        break;

    case 'admin_novo_filme':
        $filmeCtrl->adminNovo();
        break;

    case 'admin_cadastrar_filme':
        $filmeCtrl->adminCadastrar();
        break;

    case 'admin_editar_filme':
        $filmeCtrl->adminEditar();
        break;

    case 'admin_atualizar_filme':
        $filmeCtrl->adminAtualizar();
        break;

    case 'admin_deletar_filme':
        $filmeCtrl->adminDeletar();
        break;

    default:
        http_response_code(404);
        echo '<h1>Página não encontrada</h1>';
        break;
}
