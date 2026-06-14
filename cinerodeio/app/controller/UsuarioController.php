<?php

require_once __DIR__ . '/../model/Usuario.php';

class UsuarioController {

    private Usuario $model;

    public function __construct() {
        $this->model = new Usuario();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function exibirLogin(): void {
        require_once __DIR__ . '/../view/login.php';
    }

    public function processarLogin(): void {

        $email = htmlspecialchars(trim($_POST['email'] ?? ''));
        $senha = $_POST['senha'] ?? '';

        $usuario = $this->model->buscarPorEmail($email);

        if ($usuario && password_verify($senha, $usuario['senha'])) {

            $_SESSION['usuario_id']   = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];

            session_regenerate_id(true);

            if ($usuario['tipo'] === 'admin') {
                header('Location: /cinerodeio/index.php?rota=admin_filmes');
            } else {
                header('Location: /cinerodeio/index.php?rota=catalogo');
            }
            exit;

        } else {
            $_SESSION['erro'] = 'Email ou senha inválidos.';
            header('Location: /cinerodeio/index.php?rota=login');
            exit;
        }
    }

    public function exibirCadastro(): void {
        require_once __DIR__ . '/../view/cadastro.php';
    }

    public function processarCadastro(): void {

        $nome       = htmlspecialchars(trim($_POST['nome'] ?? ''));
        $email      = htmlspecialchars(trim($_POST['email'] ?? ''));
        $senha      = $_POST['senha'] ?? '';
        $cpf        = htmlspecialchars(trim($_POST['cpf'] ?? ''));
        $nascimento = $_POST['nascimento'] ?? '';

        if (empty($nome) || empty($email) || empty($senha) || empty($cpf) || empty($nascimento)) {
            $_SESSION['erro'] = 'Preencha todos os campos.';
            header('Location: /cinerodeio/index.php?rota=cadastro');
            exit;
        }

        $ok = $this->model->cadastrar($nome, $email, $senha, $cpf, $nascimento);

        if ($ok) {
            $_SESSION['sucesso'] = 'Conta criada! Faça login.';
            header('Location: /cinerodeio/index.php?rota=login');
        } else {
            $_SESSION['erro'] = 'Email ou CPF já cadastrado.';
            header('Location: /cinerodeio/index.php?rota=cadastro');
        }
        exit;
    }

    public function exibirRecuperarSenha(): void {
        require_once __DIR__ . '/../view/recuperar_senha.php';
    }

    public function processarRecuperarSenha(): void {

        $cpf        = htmlspecialchars(trim($_POST['cpf'] ?? ''));
        $nascimento = $_POST['nascimento'] ?? '';
        $novaSenha  = $_POST['nova_senha'] ?? '';

        $usuario = $this->model->buscarPorCpfNascimento($cpf, $nascimento);

        if ($usuario) {
            $this->model->atualizarSenha($usuario['id'], $novaSenha);
            $_SESSION['sucesso'] = 'Senha atualizada com sucesso!';
            header('Location: /cinerodeio/index.php?rota=login');
        } else {
            $_SESSION['erro'] = 'CPF ou data de nascimento incorretos.';
            header('Location: /cinerodeio/index.php?rota=recuperar_senha');
        }
        exit;
    }

    public function logout(): void {
        session_start();
        session_destroy();
        header('Location: /cinerodeio/index.php?rota=home');
        exit;
    }
}
