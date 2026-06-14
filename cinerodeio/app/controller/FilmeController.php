<?php
require_once __DIR__ . '/../model/Filme.php';
require_once __DIR__ . '/../model/Avaliacao.php';

class FilmeController {

    private Filme $filmeModel;
    private Avaliacao $avaliacaoModel;
    private Comentario $comentarioModel;

    public function __construct() {
        $this->filmeModel      = new Filme();
        $this->avaliacaoModel  = new Avaliacao();
        $this->comentarioModel = new Comentario();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function requerLogin(): void {
        if (empty($_SESSION['usuario_id'])) {
            header('Location: /cinerodeio/index.php?rota=login');
            exit;
        }
    }

    private function requerAdmin(): void {
        $this->requerLogin();
        if ($_SESSION['usuario_tipo'] !== 'admin') {
            header('Location: /cinerodeio/index.php?rota=catalogo');
            exit;
        }
    }

    public function catalogo(): void {
        $filmes = $this->filmeModel->listarTodos();
        require_once __DIR__ . '/../view/catalogo.php';
    }

    public function detalhe(): void {
        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            header('Location: /cinerodeio/index.php?rota=catalogo');
            exit;
        }

        $filme       = $this->filmeModel->buscarPorId($id);
        $comentarios = $this->comentarioModel->listarPorFilme($id);

        $minhaAvaliacao = null;
        if (!empty($_SESSION['usuario_id'])) {
            $minhaAvaliacao = $this->avaliacaoModel->buscarNota($_SESSION['usuario_id'], $id);
        }

        require_once __DIR__ . '/../view/detalhe_filme.php';
    }

    public function porGenero(): void {
        $genero = htmlspecialchars($_GET['genero'] ?? '');
        $filmes = $this->filmeModel->listarPorGenero($genero);
        require_once __DIR__ . '/../view/filmes_genero.php';
    }

    public function avaliar(): void {

        $this->requerLogin();

        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('Requisição inválida.');
        }

        $idFilme = (int)($_POST['id_filme'] ?? 0);
        $nota    = (int)($_POST['nota'] ?? 0);

        if ($nota >= 1 && $nota <= 5 && $idFilme > 0) {
            $this->avaliacaoModel->salvar($_SESSION['usuario_id'], $idFilme, $nota);
        }

        header("Location: /cinerodeio/index.php?rota=detalhe&id=$idFilme");
        exit;
    }

    public function comentar(): void {

        $this->requerLogin();

        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('Requisição inválida.');
        }

        $idFilme = (int)($_POST['id_filme'] ?? 0);
        $texto   = htmlspecialchars(trim($_POST['texto'] ?? ''));

        if ($idFilme > 0 && !empty($texto)) {
            $this->comentarioModel->adicionar($_SESSION['usuario_id'], $idFilme, $texto);
        }

        header("Location: /cinerodeio/index.php?rota=detalhe&id=$idFilme");
        exit;
    }

    public function adminFilmes(): void {
        $this->requerAdmin();
        $filmes = $this->filmeModel->listarTodos();
        require_once __DIR__ . '/../view/admin/filmes_lista.php';
    }

    public function adminNovo(): void {
        $this->requerAdmin();
        require_once __DIR__ . '/../view/admin/filme_form.php';
    }

    public function adminCadastrar(): void {

        $this->requerAdmin();

        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('Requisição inválida.');
        }

        $dados = [
            ':titulo'   => htmlspecialchars(trim($_POST['titulo']  ?? '')),
            ':sinopse'  => htmlspecialchars(trim($_POST['sinopse'] ?? '')),
            ':ano'      => (int)($_POST['ano'] ?? 0),
            ':diretor'  => htmlspecialchars(trim($_POST['diretor'] ?? '')),
            ':genero'   => htmlspecialchars(trim($_POST['genero']  ?? '')),
            ':imagem'   => htmlspecialchars(trim($_POST['imagem']  ?? ''))
        ];

        $this->filmeModel->cadastrar($dados);
        header('Location: /cinerodeio/index.php?rota=admin_filmes');
        exit;
    }

    public function adminEditar(): void {
        $this->requerAdmin();
        $id    = (int)($_GET['id'] ?? 0);
        $filme = $this->filmeModel->buscarPorId($id);
        require_once __DIR__ . '/../view/admin/filme_form.php';
    }

    public function adminAtualizar(): void {

        $this->requerAdmin();

        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('Requisição inválida.');
        }

        $id = (int)($_POST['id'] ?? 0);
        $dados = [
            ':titulo'   => htmlspecialchars(trim($_POST['titulo']  ?? '')),
            ':sinopse'  => htmlspecialchars(trim($_POST['sinopse'] ?? '')),
            ':ano'      => (int)($_POST['ano'] ?? 0),
            ':diretor'  => htmlspecialchars(trim($_POST['diretor'] ?? '')),
            ':genero'   => htmlspecialchars(trim($_POST['genero']  ?? '')),
            ':imagem'   => htmlspecialchars(trim($_POST['imagem']  ?? ''))
        ];

        $this->filmeModel->editar($id, $dados);
        header('Location: /cinerodeio/index.php?rota=admin_filmes');
        exit;
    }

    public function adminDeletar(): void {

        $this->requerAdmin();

        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('Requisição inválida.');
        }

        $id = (int)($_POST['id'] ?? 0);
        $this->filmeModel->deletar($id);
        header('Location: /cinerodeio/index.php?rota=admin_filmes');
        exit;
    }
}
