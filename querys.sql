CREATE DATABASE twitterClone CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;

CREATE TABLE usuarios
(
    id    int          not null primary key AUTO_INCREMENT,
    nome  varchar(100) not null,
    email varchar(150) not null,
    senha varchar(32)  not null
);

CREATE TABLE tweets
(
    id         int          not null primary key AUTO_INCREMENT,
    id_usuario int          not null,
    tweet      varchar(140) not null,
    data       datetime default current_timestamp
);

CREATE TABLE usuariosSeguidores
(
    id                  int not null primary key AUTO_INCREMENT,
    id_usuario          int not null,
    id_usuario_seguindo int not null
);