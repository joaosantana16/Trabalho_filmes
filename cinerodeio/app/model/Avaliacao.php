<?php

require_once __DIR__ . '/Conexao.php';

class Avaliacao {

    public function salvar(int $idUsuario, int $idFilme, int $nota): void {

        $pdo  = Conexao::getConexao();
        $stmt = $pdo->prepare("
            INSERT INTO avaliacoes (id_usuario, id_filme, nota)
            VALUES (:id_usuario, :id_filme, :nota)
            ON DUPLICATE KEY UPDATE nota = :nota2
        ");
        $stmt->execute([
            ':id_usuario' => $idUsuario,
            ':id_filme'   => $idFilme,
            ':nota'       => $nota,
            ':nota2'      => $nota
        ]);
    }

    public function buscarNota(int $idUsuario, int $idFilme): int|null {

        $pdo  = Conexao::getConexao();
        $stmt = $pdo->prepare("
            SELECT nota FROM avaliacoes
            WHERE id_usuario = :id_usuario AND id_filme = :id_filme
        ");
        $stmt->execute([':id_usuario' => $idUsuario, ':id_filme' => $idFilme]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? (int)$resultado['nota'] : null;
    }
}

class Comentario {

    public function adicionar(int $idUsuario, int $idFilme, string $texto): void {

        $pdo  = Conexao::getConexao();
        $stmt = $pdo->prepare("
            INSERT INTO comentarios (id_usuario, id_filme, texto)
            VALUES (:id_usuario, :id_filme, :texto)
        ");
        $stmt->execute([
            ':id_usuario' => $idUsuario,
            ':id_filme'   => $idFilme,
            ':texto'      => $texto
        ]);
    }

    public function listarPorFilme(int $idFilme): array {

        $pdo  = Conexao::getConexao();
        $stmt = $pdo->prepare("
            SELECT c.*, u.nome AS nome_usuario
            FROM comentarios c
            JOIN usuarios u ON u.id = c.id_usuario
            WHERE c.id_filme = :id_filme
            ORDER BY c.criado_em DESC
        ");
        $stmt->execute([':id_filme' => $idFilme]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deletar(int $idComentario): void {

        $pdo  = Conexao::getConexao();
        $stmt = $pdo->prepare("DELETE FROM comentarios WHERE id = :id");
        $stmt->execute([':id' => $idComentario]);
    }
}
