<?php

require_once __DIR__ . '/Conexao.php';

class Filme {

    public function listarTodos(): array {

        $pdo  = Conexao::getConexao();
        $stmt = $pdo->query("
            SELECT f.*, AVG(a.nota) AS media_nota, COUNT(a.id) AS total_avaliacoes
            FROM filmes f
            LEFT JOIN avaliacoes a ON a.id_filme = f.id
            GROUP BY f.id
            ORDER BY f.titulo ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id): array|false {

        $pdo  = Conexao::getConexao();
        $stmt = $pdo->prepare("
            SELECT f.*, AVG(a.nota) AS media_nota, COUNT(a.id) AS total_avaliacoes
            FROM filmes f
            LEFT JOIN avaliacoes a ON a.id_filme = f.id
            WHERE f.id = :id
            GROUP BY f.id
        ");
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarPorGenero(string $genero): array {

        $pdo  = Conexao::getConexao();
        $stmt = $pdo->prepare("
            SELECT f.*, AVG(a.nota) AS media_nota
            FROM filmes f
            LEFT JOIN avaliacoes a ON a.id_filme = f.id
            WHERE f.genero = :genero
            GROUP BY f.id
        ");
        $stmt->execute([':genero' => $genero]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrar(array $dados): bool {

        $pdo  = Conexao::getConexao();
        $stmt = $pdo->prepare("
            INSERT INTO filmes (titulo, sinopse, ano, diretor, genero, imagem)
            VALUES (:titulo, :sinopse, :ano, :diretor, :genero, :imagem)
        ");

        try {
            $stmt->execute($dados);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function editar(int $id, array $dados): void {

        $pdo  = Conexao::getConexao();
        $stmt = $pdo->prepare("
            UPDATE filmes
            SET titulo = :titulo, sinopse = :sinopse, ano = :ano,
                diretor = :diretor, genero = :genero, imagem = :imagem
            WHERE id = :id
        ");
        $dados[':id'] = $id;
        $stmt->execute($dados);
    }

    public function deletar(int $id): void {

        $pdo  = Conexao::getConexao();
        $stmt = $pdo->prepare("DELETE FROM filmes WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
