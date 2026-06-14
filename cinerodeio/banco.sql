CREATE DATABASE IF NOT EXISTS cinerodeio;
USE cinerodeio;

CREATE TABLE IF NOT EXISTS usuarios (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    senha      VARCHAR(255) NOT NULL,
    cpf        VARCHAR(14)  NOT NULL UNIQUE,
    nascimento DATE         NOT NULL,
    tipo       ENUM('comum','admin') DEFAULT 'comum',
    criado_em  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS filmes (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    titulo     VARCHAR(200) NOT NULL,
    sinopse    TEXT,
    ano        YEAR,
    diretor    VARCHAR(150),
    genero     VARCHAR(80),
    imagem     VARCHAR(300),
    criado_em  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS avaliacoes (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_filme   INT NOT NULL,
    nota       TINYINT NOT NULL CHECK (nota BETWEEN 1 AND 5),
    criado_em  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (id_usuario, id_filme),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_filme)   REFERENCES filmes(id)   ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS comentarios (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_filme   INT NOT NULL,
    texto      TEXT NOT NULL,
    criado_em  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_filme)   REFERENCES filmes(id)   ON DELETE CASCADE
);

INSERT IGNORE INTO usuarios (nome, email, senha, cpf, nascimento, tipo)
VALUES (
    'Admin Cinerodeio',
    'admin@cinerodeio.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    '000.000.000-00',
    '1990-01-01',
    'admin'
);
