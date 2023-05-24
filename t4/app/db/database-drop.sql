DROP DATABASE IF EXISTS `projeto_pw`;
CREATE DATABASE `projeto_pw`;

USE `projeto_pw`;

DROP TABLE IF EXISTS `tab_usuarios`;
CREATE TABLE `tab_usuarios` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `usuario` varchar(50) NOT NULL,
    `email` varchar(50),
    `telefone` varchar(50),
    `senha` varchar(50) NOT NULL,
    `administrador` char(1),
    `motorista` char(1),
    `ativo` char(1),
    `status` char(1),
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `tab_rotas`;
CREATE TABLE `tab_rotas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `rota` varchar(50) NOT NULL,
    `veiculo` varchar(50) NOT NULL,
    `motorista` varchar(50) NOT NULL,
    `data` varchar(50) NOT NULL,
    `horarios` varchar(50) NOT NULL,
    `status` char(1),
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `tab_mensagens`;
CREATE TABLE `tab_mensagens` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `usuario` varchar(50) NOT NULL,
    `rota` varchar(50) NOT NULL,
    `data` varchar(50),
    `hora` varchar(50),
    `descricao` varchar(100) NOT NULL,
    `status` char(1),
    PRIMARY KEY (`id`)
);

INSERT INTO `tab_usuarios` (`id`,`usuario`,`email`,`telefone`,`senha`,`status`) VALUES
(1,'Cassiano','cassiano@email.com','1234-5678','Cassiano','A'),
(2,'Eduardo','eduardo@email.com','1234-5678','Eduardo','A');

INSERT INTO `tab_rotas` (`id`,`rota`,`veiculo`,`motorista`,`data`,`horarios`,`status`) VALUES
(1,'Itapema-Itajaí','Linha 256','Eduardo','Seg-Sex','18:00, 22:00','A'),
(2,'Tijucas-Itajaí','Linha 255','David','Seg-Sex','18:00, 22:00','A');

INSERT INTO `tab_mensagens` (`id`,`usuario`,`rota`,`data`,`hora`,`descricao`,`status`) VALUES
(1,'Cassiano','Linha 256','22-05-2023','18:00','Ônibus chegou!','A'),
(2,'Eduardo','Linha 255','22-05-2023','22:00','Ônibus saindo!','A');
