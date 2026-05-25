<?php

class Usuario {

    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function cadastrar(array $dados): ?string {
        $nome      = trim($dados['nome']      ?? '');
        $email     = trim($dados['email']     ?? '');
        $senha     = trim($dados['senha']     ?? '');
        $confirmar = trim($dados['confirmar'] ?? '');
        $cpf       = preg_replace('/\D/', '', $dados['cpf'] ?? ''); // 
        $nascimento = trim($dados['nascimento'] ?? '');

        if (!$nome || !$email || !$senha || !$cpf || !$nascimento)
            return 'Preencha todos os campos.';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return 'E-mail inválido.';

        if ($senha !== $confirmar)
            return 'As senhas não coincidem.';

        if (strlen($senha) < 6)
            return 'A senha deve ter no mínimo 6 caracteres.';

        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE email = ? OR cpf = ?");
        $stmt->execute([$email, $cpf]);
        if ($stmt->fetch())
            return 'E-mail ou CPF já cadastrado.';

        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

        $this->db->prepare("
            INSERT INTO usuarios (nome, email, senha, cpf, nascimento)
            VALUES (?, ?, ?, ?, ?)
        ")->execute([$nome, $email, $senhaCriptografada, $cpf, $nascimento]);

        return null;
    }

    public function login(string $email, string $senha): array|string {

        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([trim($email)]);
        $usuario = $stmt->fetch();

        if (!$usuario || !password_verify($senha, $usuario['senha']))
            return 'E-mail ou senha incorretos.';

        return $usuario;
    }

    public function recuperarSenha(string $cpf, string $nascimento): array|string {
        $cpf = preg_replace('/\D/', '', $cpf);

        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE cpf = ? AND nascimento = ?");
        $stmt->execute([$cpf, $nascimento]);
        $usuario = $stmt->fetch();

        if (!$usuario)
            return 'CPF ou data de nascimento incorretos.';

        return $usuario;
    }

    public function redefinirSenha(int $id, string $nova, string $confirmar): ?string {
        if (strlen($nova) < 6)
            return 'A senha deve ter no mínimo 6 caracteres.';
        if ($nova !== $confirmar)
            return 'As senhas não coincidem.';

        $hash = password_hash($nova, PASSWORD_DEFAULT);
        $this->db->prepare("UPDATE usuarios SET senha = ? WHERE id = ?")
                 ->execute([$hash, $id]);

        return null;
    }
}
