DROP DATABASE IF EXISTS prototipo;
CREATE DATABASE prototipo;
USE prototipo;
CREATE TABLE prototipo.escolas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cidade VARCHAR(100) -- modelo padrão das escolas para copiar e colar pelo ID
);
CREATE TABLE prototipo.alimentos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    escola_id INT UNSIGNED NOT NULL,
    nome_produto VARCHAR(100) NOT NULL,
    categoria ENUM('perecivel','nao_perecivel') NOT NULL,
    unidade ENUM('kg','g','L','un','cx') NOT NULL,
    quantidade_estoque INT NOT NULL DEFAULT 0 CHECK (quantidade_estoque >= 0),
    data_validade DATE NULL,
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (escola_id) REFERENCES escolas(id) ON DELETE CASCADE -- mudanças colocando a categoria ENUM, Unidade, check, e data do alimento
); 

Create table prototipo.usuarios (
ID Int UNSIGNED NOT NULL AUTO_INCREMENT,
login VARCHAR (30) UNIQUE NOT NULL,
senha Varchar(255), -- aumentei a quantidade de caracteres de 50===255
Primary Key (ID)) ENGINE = InnoDB; -- https://www.devmedia.com.br/criando-um-sistema-de-cadastro-e-login-com-php-e-mysql/37213 link do script que peguei


CREATE TABLE prototipo.alunos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    escola_id INT UNSIGNED NOT NULL,
    nome VARCHAR(150) NOT NULL,
    responsavel_nome VARCHAR(150) NULL,
    responsavel_contato VARCHAR(20) NULL, -- telefone p/ avisar da retirada
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (escola_id) REFERENCES escolas(id) ON DELETE CASCADE -- REVISAO NECESSARIA, FEITO PELA IA E NN VERIFIQUEI AINDA
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
    FOREIGN KEY (alimento_id) REFERENCES alimentos(id) -- REVISAO NECESSARIA, FEITO PELA IA E NN VERIFIQUEI AINDA
);

START TRANSACTION;
SELECT quantidade_estoque FROM alimentos WHERE id = ? FOR UPDATE;
-- valida se tem estoque suficiente
UPDATE alimentos SET quantidade_estoque = quantidade_estoque - ? WHERE id = ?;
UPDATE retiradas SET status = 'confirmada', confirmado_em = NOW() WHERE id = ?;
COMMIT;
SHOW TABLE STATUS FROM prototipo; -- REVISAO NECESSARIA, FEITO PELA IA E NN VERIFIQUEI AINDA
