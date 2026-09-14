DROP DATABASE IF EXISTS prototipo;
CREATE DATABASE prototipo;
USE prototipo;

CREATE TABLE prototipo.escolas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cidade VARCHAR(100)
);

CREATE TABLE prototipo.usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    login VARCHAR(30) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'escola', 'comum') NOT NULL DEFAULT 'comum',
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

CREATE TABLE prototipo.alimentos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    escola_id INT UNSIGNED NOT NULL,
    nome_produto VARCHAR(100) NOT NULL,
    categoria ENUM('perecivel','nao_perecivel') NOT NULL,
    unidade ENUM('kg','g','L','un','cx') NOT NULL,
    quantidade_estoque INT NOT NULL DEFAULT 0 CHECK (quantidade_estoque >= 0),
    data_validade DATE NULL,
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (escola_id) REFERENCES escolas(id) ON DELETE CASCADE
);

CREATE TABLE prototipo.alunos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    escola_id INT UNSIGNED NOT NULL,
    nome VARCHAR(150) NOT NULL,
    responsavel_nome VARCHAR(150) NULL,
    responsavel_contato VARCHAR(20) NULL,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (escola_id) REFERENCES escolas(id) ON DELETE CASCADE
);

CREATE TABLE prototipo.retiradas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT UNSIGNED NOT NULL,
    alimento_id INT UNSIGNED NOT NULL,
    quantidade INT UNSIGNED NOT NULL,
    status ENUM('pendente','confirmada','retirada','cancelada') NOT NULL DEFAULT 'pendente',
    retirado_por ENUM('aluno','responsavel') NULL,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    confirmado_em DATETIME NULL,
    retirado_em DATETIME NULL,
    FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE,
    FOREIGN KEY (alimento_id) REFERENCES alimentos(id)
);

CREATE TABLE prototipo.contatos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    sobrenome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    mensagem TEXT NOT NULL,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

INSERT INTO prototipo.usuarios (nome, login, email, senha, tipo, criado_em) VALUES
('Administrador 1', 'admin1', 'admin1@rgeats.com', '1234', 'admin', NOW()),
('Administrador 2', 'admin2', 'admin2@rgeats.com', 'abc', 'admin', NOW());