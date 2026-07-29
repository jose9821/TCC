DROP DATABASE IF EXISTS prototipo;
CREATE DATABASE prototipo;
USE prototipo;
CREATE TABLE prototipo.escolas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cidade VARCHAR(100) -- modelo padrão das escolas para copiar e colar pelo ID
);
CREATE TABLE prototipo.alimentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    escola_id INT NOT NULL,
    nome_produto VARCHAR(100) NOT NULL,
    quantidade_estoque INT NOT NULL,
    FOREIGN KEY (escola_id) REFERENCES escolas(id) ON DELETE CASCADE -- modelo padrão das tabelas dos alimentos para copiar e colar pelo ID
); 

Create table prototipo.usuarios (
ID Int UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
login Varchar(30),
senha Varchar(40),
Primary Key (ID)) ENGINE = InnoDB; -- https://www.devmedia.com.br/criando-um-sistema-de-cadastro-e-login-com-php-e-mysql/37213 link do script que peguei

SHOW TABLE STATUS FROM prototipo;
