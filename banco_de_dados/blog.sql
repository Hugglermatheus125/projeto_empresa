DROP DATABASE IF EXISTS Blog;
CREATE DATABASE Blog;
USE Blog;

-- USUARIOS --
CREATE TABLE Usuarios (
    IdUsuario INT NOT NULL AUTO_INCREMENT,
    Nome VARCHAR(40) NOT NULL,
    Email VARCHAR(60) NOT NULL UNIQUE,
    Senha VARCHAR(255) NOT NULL,
    Telefone VARCHAR(20) NOT NULL,
    DataNasc DATE NOT NULL,
    StatusFuncionario BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (IdUsuario)
);

-- FUNCIONARIOS --
CREATE TABLE Funcionarios (
    IdFuncionario INT NOT NULL,
    Cargo VARCHAR(30) NOT NULL,
    CEP VARCHAR(10),
    Telefone VARCHAR(24),
    Salario DECIMAL(18,2) DEFAULT 0.00,

    PRIMARY KEY (IdFuncionario),
    FOREIGN KEY (IdFuncionario) REFERENCES Usuarios(IdUsuario)
);

-- POSTAGENS --
CREATE TABLE Postagens (
    IdPostagem INT NOT NULL AUTO_INCREMENT,
    IdUsuario INT NOT NULL,

    Titulo VARCHAR(120) NOT NULL,
    Conteudo TEXT NOT NULL,

    DataPostagem DATETIME DEFAULT CURRENT_TIMESTAMP,
    Anexo VARCHAR(255),

    PRIMARY KEY (IdPostagem),
    FOREIGN KEY (IdUsuario) REFERENCES Usuarios(IdUsuario)
);

-- NOTICIAS --
CREATE TABLE Noticias (
    IdNoticia INT NOT NULL AUTO_INCREMENT,
    IdFuncionario INT NOT NULL,

    Titulo VARCHAR(120) NOT NULL,
    Resumo VARCHAR(300),
    Conteudo TEXT NOT NULL,

    DataPublicacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    Anexo VARCHAR(255),

    Visivel BOOLEAN DEFAULT TRUE,

    PRIMARY KEY (IdNoticia),
    FOREIGN KEY (IdFuncionario) REFERENCES Funcionarios(IdFuncionario)
);
