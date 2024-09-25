CREATE DATABASE IF NOT EXISTS `projeto_pw`;

USE `projeto_pw`;

CREATE TABLE IF NOT EXISTS `tab_usuarios` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(50) NOT NULL,
    `email` varchar(50),
    `telefone` varchar(50),
    `senha` varchar(50) NOT NULL,
    `is_admin` char(1),
    `is_driver` char(1),
    `ativo` char(1),
    `status` char(1),
    `created_on` varchar(10),
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `tab_rotas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `rota` varchar(50) NOT NULL,
    `veiculo` varchar(50) NOT NULL,
    `motorista` int(11) NOT NULL,
    `datas` varchar(50) NOT NULL,
    `horarios` varchar(50) NOT NULL,
    `status` char(1),
    `created_on` varchar(10),
    PRIMARY KEY (`id`),
    KEY `fk_rota_motorista` (`motorista`),
    CONSTRAINT `fk_rota_motorista` FOREIGN KEY (`motorista`) REFERENCES `tab_usuarios` (`id`)
);

CREATE TABLE IF NOT EXISTS `tab_mensagens` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `usuario` int(11) NOT NULL,
    `rota` int(11) NOT NULL,
    `data` varchar(50),
    `hora` varchar(50),
    `descricao` varchar(100) NOT NULL,
    `status` char(1),
    `created_on` varchar(10),
    PRIMARY KEY (`id`),
    KEY `fk_mensagem_usuario` (`usuario`),
    CONSTRAINT `fk_mensagem_usuario` FOREIGN KEY (`usuario`) REFERENCES `tab_usuarios` (`id`),
    KEY `fk_mensagem_rota` (`rota`),
    CONSTRAINT `fk_mensagem_rota` FOREIGN KEY (`rota`) REFERENCES `tab_rotas` (`id`)
);

INSERT INTO `tab_usuarios` (`id`,`nome`,`email`,`telefone`,`senha`,`is_admin`,`is_driver`,`status`) VALUES
(1,'Cassiano','cassiano@email.com','1234-5678','Cassiano','1','0','A'),
(2,'Eduardo','eduardo@email.com','1234-5678','Eduardo','0','1','A');

INSERT INTO `tab_rotas` (`id`,`rota`,`veiculo`,`motorista`,`datas`,`horarios`,`status`) VALUES
(1,'Itapema-Itajaí','1','2','Seg-Sex','18:00, 22:00','A'),
(2,'Tijucas-Itajaí','2','1','Seg-Sex','18:00, 22:00','A');

INSERT INTO `tab_mensagens` (`id`,`usuario`,`rota`,`data`,`hora`,`descricao`,`status`) VALUES
(1,'1','1','22-05-2023','18:00','Ônibus chegou!','A'),
(2,'2','2','22-05-2023','22:00','Ônibus saindo!','A');
