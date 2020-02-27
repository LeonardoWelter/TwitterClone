CREATE DATABASE twitterClone CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;

CREATE TABLE usuarios (
                          id int not null primary key AUTO_INCREMENT,
                          nome varchar(100) not null,
                          email varchar(150) not null,
                          senha varchar(32) not null
);