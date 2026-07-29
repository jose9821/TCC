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

create table tipo_usuario (
id_tipo int unsigned auto_increment primary key,
descricao varchar(30) not null
);

create table login (
id_usuario int unsigned auto_increment primary key,
usuario varchar(50) not null unique,
senha varchar(255) not null,
id_tipo int unsigned not null,
data_cadastro datetime default current_timestamp,
foreign key (id_tipo) references tipo_usuario (id_tipo) on delete cascade
);

create table dados_usuario (
id_dados int unsigned auto_increment primary key,
id_usuario int unsigned not null,
nome varchar(100) not null,
idade tinyint unsigned,
genero enum ('M', 'F'),
email varchar(100) not null unique,
data_nasc date,
foreign key (id_usuario) references login (id_usuario) on delete cascade
);

create table usuario_cadastro(
id_cadastro int unsigned auto_increment primary key,
usuario varchar(50) not null,
senha varchar(255) not null,
nome varchar(50) not null,
data_nascimento int(8),
idade int(3),
genero enum ('Masculino', 'Feminino'),
email varchar(100) not null,
cep varchar(9) not null,
rua varchar(500) not null,
bairro varchar(500) not null,
cidade varchar(500) not null,
estado varchar(2) not null
);
    
insert into tipo_usuario (descricao) values
('Adm'),
('Pessoa_comum'),
('Aluno'),
('Professor');

insert into login (usuario, senha, id_tipo) values
("Te-Rasgo", "1234", 1);

insert into login (usuario, senha, id_tipo) values
("Thigas", "senha", 2);

insert into login (usuario, senha, id_tipo) values
("Gozé", "Gozoé", 3);

insert into login (usuario, senha, id_tipo) values
("Victor", "senha123", 4);

insert into dados_usuario (id_usuario, nome, idade, genero, email, data_nasc) values
(1, "Te-Rasgo", 17, "M", "adm@adm.com", "2009-01-18");

insert into dados_usuario (id_usuario, nome, idade, genero, email, data_nasc) values
(2, "Thiaguitos Thiaguitas", 17, "M", "thiaguitos@tt.com", "2009-01-18");

insert into dados_usuario (id_usuario, nome, idade, genero, email, data_nasc) values
(3, "Gozé", 19, "M", "jojo@jojo.com", "2001-09-11");

insert into dados_usuario (id_usuario, nome, idade, genero, email, data_nasc) values
(4, "Professor Victor", 99, "M", "victor@prof.com", "2001-09-11");

SHOW TABLE STATUS FROM prototipo;


SHOW TABLE STATUS FROM prototipo;
