<?php

require_once __DIR__ . '/Conexao.php';

class Usuario {

    public function cadastrar(string $nome, string $email, string $senha, string $cpf, string $nascimento): bool {

        $pdo = Conexao::getConexao();

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO usuarios (nome, email, senha, cpf, nascimento)
            VALUES (:nome, :email, :senha, :cpf, :nascimento)
        ");

        try {
            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':senha' => $senhaHash,
                ':cpf' => $cpf,
                ':nascimento' => $nascimento
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function buscarPorEmail(string $email): array|false {
        $pdo  = Conexao::getConexao();
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorCpfNascimento(string $cpf, string $nascimento): array|false {
        $pdo  = Conexao::getConexao();
        $stmt = $pdo->prepare("
            SELECT * FROM usuarios WHERE cpf = :cpf AND nascimento = :nascimento LIMIT 1
        ");
        $stmt->execute([':cpf' => $cpf, ':nascimento' => $nascimento]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarSenha(int $id, string $novaSenha): void {
        $pdo      = Conexao::getConexao();
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
        $stmt->execute([':senha' => $senhaHash, ':id' => $id]);
    }
}
