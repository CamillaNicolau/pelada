-- phpMyAdmin SQL Dump-- version 4.6.6deb5-- https://www.phpmyadmin.net/---- Host: localhost-- Generation Time: 31-Jan-2019 às 17:52-- Versão do servidor: 5.7.25-0ubuntu0.18.04.2-- PHP Version: 7.1.23-2+ubuntu18.04.1+deb.sury.org+1SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";SET time_zone = "+00:00";/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;/*!40101 SET NAMES utf8mb4 */;---- Database: `camilla_pelada`---- ------------------------------------------------------------ Estrutura da tabela `cidade`--CREATE TABLE `cidade` (  `id_cidade` int(11) NOT NULL,  `nome_cidade` varchar(255) NOT NULL,  `fk_estado` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `estado`--CREATE TABLE `estado` (  `id_estado` int(11) NOT NULL,  `nome` varchar(255) NOT NULL,  `sigla` char(2) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `localizacao_pelada`--CREATE TABLE `localizacao_pelada` (  `id_localizacao_pelada` int(11) NOT NULL,  `nome_quadra` varchar(100) NOT NULL,  `rua` varchar(250) NOT NULL,  `bairro` varchar(150) NOT NULL,  `numero` int(4) DEFAULT NULL,  `fk_cidade` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `marcacao`--CREATE TABLE `marcacao` (  `id_marcacao` int(11) NOT NULL,  `fk_tipo_marcacao` varchar(60) DEFAULT NULL,  `hora` time DEFAULT NULL,  `fk_time_partida` int(11) NOT NULL,  `fk_partida` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `partida`--CREATE TABLE `partida` (  `id_partida` int(11) NOT NULL,  `primeiro_time` varchar(60) DEFAULT NULL,  `segundo_time` varchar(60) DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `pelada`--CREATE TABLE `pelada` (  `id_pelada` int(11) NOT NULL,  `nome_pelada` varchar(150) DEFAULT NULL,  `descricao` text,  `duracao_pelada` time DEFAULT NULL,  `qt_jogadores` int(2) DEFAULT NULL,  `sorteio` char(10) DEFAULT NULL,  `data_pelada` datetime DEFAULT NULL,  `horario` time NOT NULL,  `data_criacao` datetime DEFAULT NULL,  `fk_peladeiro` int(11) DEFAULT NULL,  `fk_localizacao` int(11) DEFAULT NULL,  `status` varchar(15) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `pelada_peladeiro`--CREATE TABLE `pelada_peladeiro` (  `id` int(11) NOT NULL,  `fk_peladeiro` int(11) NOT NULL,  `fk_pelada` int(11) NOT NULL,  `confirmacao` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0- aguardando confimacao,1-confirmado,2-cancelou') ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `peladeiro_time`--CREATE TABLE `peladeiro_time` (  `id_peladeiro_time` int(11) NOT NULL,  `fk_peladeiro` int(11) NOT NULL,  `fk_time_partida` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `posicao_peladeiro`--CREATE TABLE `posicao_peladeiro` (  `id_posicao_peladeiro` int(11) NOT NULL,  `nome` varchar(60) DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `privilegios`--CREATE TABLE `privilegios` (  `id_privilegios` int(11) NOT NULL,  `tipo` varchar(40) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `recupera_senha`--CREATE TABLE `recupera_senha` (  `id_recupera_senha` int(11) NOT NULL,  `hash_senha` varchar(150) NOT NULL,  `email` varchar(150) NOT NULL,  `ativo` tinyint(4) NOT NULL,  `data_criacao` datetime DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;---- Estrutura da tabela `time_futebol`---- --------------------------------------------------------CREATE TABLE `time_futebol` (  `id_time_futebol` int(11) NOT NULL,  `nome` varchar(60) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `time_partida`--CREATE TABLE `time_partida` (  `id_time_partida` int(11) NOT NULL,  `nome` varchar(150) NOT NULL,  `fk_pelada` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `tipo_marcacao`--CREATE TABLE `tipo_marcacao` (  `id_tipo_marcacao` int(11) NOT NULL,  `nome` varchar(60) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `usuario`--CREATE TABLE `usuario` (  `id_usuario` int(11) NOT NULL,  `nome` varchar(150) NOT NULL,  `email` varchar(60) NOT NULL,  `apelido` varchar(60) DEFAULT NULL,  `senha` varchar(255) DEFAULT NULL,  `sexo` char(2) DEFAULT NULL,  `url_imagem` varchar(150) DEFAULT NULL,  `telefone` varchar(15) DEFAULT NULL,  `data_nascimento` datetime DEFAULT NULL,  `participacao` char(10) DEFAULT NULL,  `fk_criador` int(11) NOT NULL,  `fk_marcacoes` int(11) DEFAULT NULL,  `fk_time_futebol` int(11) DEFAULT NULL,  `fk_posicao` int(11) DEFAULT NULL,  `ativo` tinyint(4) DEFAULT '1',  `data_criacao` datetime DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `usuario_privilegio`--CREATE TABLE `usuario_privilegio` (  `id_privilegio_usuario` int(11) NOT NULL,  `fk_usuario` int(11) NOT NULL,  `fk_privilegio` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `financeiro`--CREATE TABLE `financeiro` (  `id_lancamento` int(11) NOT NULL,  `mensalidade` decimal(10,2) DEFAULT NULL,  `diaria` decimal(10,2) DEFAULT NULL,  `total_pelada` decimal(10,2) DEFAULT NULL,  `fk_peladeiro` int(11) NOT NULL,  `fk_pelada` int(11) NOT NULL,  `data_criacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Estrutura da tabela `financeiro_peladeiro`--CREATE TABLE `financeiro_peladeiro` (  `id_financeiro_peladeiro` int(11) NOT NULL,  `fk_peladeiro` int(11) NOT NULL,  `fk_financeiro` int(11) NOT NULL,  `status` tinyint(2) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;-- ------------------------------------------------------------ Indexes for table `cidade`--ALTER TABLE `cidade`  ADD PRIMARY KEY (`id_cidade`),  ADD KEY `fkestado` (`fk_estado`);---- Indexes for table `estado`--ALTER TABLE `estado`  ADD PRIMARY KEY (`id_estado`);---- Indexes for table `localizacao_pelada`--ALTER TABLE `localizacao_pelada`  ADD PRIMARY KEY (`id_localizacao_pelada`),  ADD KEY `fkcidade` (`fk_cidade`);---- Indexes for table `marcacao`--ALTER TABLE `marcacao`  ADD PRIMARY KEY (`id_marcacao`);---- Indexes for table `partida`--ALTER TABLE `partida`  ADD PRIMARY KEY (`id_partida`);---- Indexes for table `pelada`--ALTER TABLE `pelada`  ADD PRIMARY KEY (`id_pelada`),  ADD KEY `fklocalizacao` (`fk_localizacao`),  ADD KEY `fkpeladeiro` (`fk_peladeiro`) USING BTREE,  ADD KEY `fk_peladeiro` (`fk_peladeiro`);---- Indexes for table `pelada_peladeiro`--ALTER TABLE `pelada_peladeiro`  ADD PRIMARY KEY (`id`);---- Indexes for table `peladeiro_time`--ALTER TABLE `peladeiro_time`  ADD PRIMARY KEY (`id_peladeiro_time`);---- Indexes for table `posicao_peladeiro`--ALTER TABLE `posicao_peladeiro`  ADD PRIMARY KEY (`id_posicao_peladeiro`);---- Indexes for table `privilegios`--ALTER TABLE `privilegios`  ADD PRIMARY KEY (`id_privilegios`);---- Indexes for table `recupera_senha`--ALTER TABLE `recupera_senha`  ADD PRIMARY KEY (`id_recupera_senha`);---- Indexes for table `time_futebol`--ALTER TABLE `time_futebol`  ADD PRIMARY KEY (`id_time_futebol`);---- Indexes for table `time_partida`--ALTER TABLE `time_partida`  ADD PRIMARY KEY (`id_time_partida`),  ADD KEY `fkpelada` (`fk_pelada`);---- Indexes for table `tipo_marcacao`--ALTER TABLE `tipo_marcacao`  ADD PRIMARY KEY (`id_tipo_marcacao`);---- Indexes for table `usuario`--ALTER TABLE `usuario`  ADD PRIMARY KEY (`id_usuario`),  ADD KEY `fkCriador` (`fk_criador`);---- Indexes for table `usuario_privilegio`--ALTER TABLE `usuario_privilegio`  ADD PRIMARY KEY (`id_privilegio_usuario`);---- AUTO_INCREMENT for dumped tables------ AUTO_INCREMENT for table `cidade`--ALTER TABLE `cidade`  MODIFY `id_cidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9715;---- AUTO_INCREMENT for table `estado`--ALTER TABLE `estado`  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;---- AUTO_INCREMENT for table `localizacao_pelada`--ALTER TABLE `localizacao_pelada`  MODIFY `id_localizacao_pelada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;---- AUTO_INCREMENT for table `marcacao`--ALTER TABLE `marcacao`  MODIFY `id_marcacao` int(11) NOT NULL AUTO_INCREMENT;---- AUTO_INCREMENT for table `partida`--ALTER TABLE `partida`  MODIFY `id_partida` int(11) NOT NULL AUTO_INCREMENT;---- AUTO_INCREMENT for table `pelada`--ALTER TABLE `pelada`  MODIFY `id_pelada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;---- AUTO_INCREMENT for table `pelada_peladeiro`--ALTER TABLE `pelada_peladeiro`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;---- AUTO_INCREMENT for table `peladeiro_time`--ALTER TABLE `peladeiro_time`  MODIFY `id_peladeiro_time` int(11) NOT NULL AUTO_INCREMENT;---- AUTO_INCREMENT for table `posicao_peladeiro`--ALTER TABLE `posicao_peladeiro`  MODIFY `id_posicao_peladeiro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;---- AUTO_INCREMENT for table `privilegios`--ALTER TABLE `privilegios`  MODIFY `id_privilegios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;---- AUTO_INCREMENT for table `recupera_senha`--ALTER TABLE `recupera_senha`  MODIFY `id_recupera_senha` int(11) NOT NULL AUTO_INCREMENT;---- AUTO_INCREMENT for table `time_futebol`--ALTER TABLE `time_futebol`  MODIFY `id_time_futebol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;---- AUTO_INCREMENT for table `time_partida`--ALTER TABLE `time_partida`  MODIFY `id_time_partida` int(11) NOT NULL AUTO_INCREMENT;---- AUTO_INCREMENT for table `tipo_marcacao`--ALTER TABLE `tipo_marcacao`  MODIFY `id_tipo_marcacao` int(11) NOT NULL AUTO_INCREMENT;---- AUTO_INCREMENT for table `usuario`--ALTER TABLE `usuario`  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;---- AUTO_INCREMENT for table `usuario_privilegio`--ALTER TABLE `usuario_privilegio`  MODIFY `id_privilegio_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;---- Constraints for dumped tables------ Limitadores para a tabela `cidade`--ALTER TABLE `cidade`  ADD CONSTRAINT `fkestado` FOREIGN KEY (`fk_estado`) REFERENCES `estado` (`id_estado`);---- Limitadores para a tabela `localizacao_pelada`--ALTER TABLE `localizacao_pelada`  ADD CONSTRAINT `fkcidade` FOREIGN KEY (`fk_cidade`) REFERENCES `cidade` (`id_cidade`);---- Limitadores para a tabela `pelada`--ALTER TABLE `pelada`  ADD CONSTRAINT `fklocalizacao` FOREIGN KEY (`fk_localizacao`) REFERENCES `localizacao_pelada` (`id_localizacao_pelada`),  ADD CONSTRAINT `fkpeladeiro` FOREIGN KEY (`fk_peladeiro`) REFERENCES `usuario` (`id_usuario`),  ADD CONSTRAINT `pelada_ibfk_1` FOREIGN KEY (`fk_peladeiro`) REFERENCES `usuario` (`id_usuario`);---- Limitadores para a tabela `time_partida`--ALTER TABLE `time_partida`  ADD CONSTRAINT `fkpelada` FOREIGN KEY (`fk_pelada`) REFERENCES `pelada` (`id_pelada`);---- Limitadores para a tabela `usuario`--ALTER TABLE `usuario`  ADD CONSTRAINT `fkCriador` FOREIGN KEY (`fk_criador`) REFERENCES `usuario` (`id_usuario`);---- Indexes for table `financeiro`--ALTER TABLE `financeiro`  ADD PRIMARY KEY (`id_lancamento`),  ADD KEY `fkFinanceiroCriador` (`fk_peladeiro`),  ADD KEY `fkFinanceiroPelada` (`fk_pelada`);---- Indexes for table `financeiro_peladeiro`--ALTER TABLE `financeiro_peladeiro`  ADD PRIMARY KEY (`id_financeiro_peladeiro`),  ADD KEY `fkFinanceiroPeladeiro` (`fk_peladeiro`),  ADD KEY `fkFinanceiroPeladeiroLancanento` (`fk_financeiro`);---- Limitadores para a tabela `financeiro`--ALTER TABLE `financeiro`  ADD CONSTRAINT `fkFinanceiroCriador` FOREIGN KEY (`fk_peladeiro`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,  ADD CONSTRAINT `fkFinanceiroPelada` FOREIGN KEY (`fk_pelada`) REFERENCES `pelada` (`id_pelada`) ON DELETE CASCADE;---- Limitadores para a tabela `financeiro_peladeiro`--ALTER TABLE `financeiro_peladeiro`  ADD CONSTRAINT `fkFinanceiroPeladeiro` FOREIGN KEY (`fk_peladeiro`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,  ADD CONSTRAINT `fkFinanceiroPeladeiroLancanento` FOREIGN KEY (`fk_financeiro`) REFERENCES `financeiro` (`id_lancamento`);/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;