-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/06/2025 às 05:34
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER, SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE ON *.* TO `usuario`@`localhost` IDENTIFIED BY PASSWORD '*AD77F56D2FD78299B87609DCC0423260B5AADB03';

GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER, SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE ON `fiscal`.* TO `usuario`@`localhost`;


--
-- Banco de dados: `fiscal`
--
CREATE DATABASE IF NOT EXISTS `fiscal` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fiscal`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro`
--

CREATE TABLE `cadastro` (
  `id` int(25) NOT NULL,
  `cnpj` varchar(15) DEFAULT NULL,
  `tipo` int(8) NOT NULL DEFAULT 1,
  `nome` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csv_2024`
--

CREATE TABLE `csv_2024` (
  `id` int(11) NOT NULL,
  `numero_nota` int(10) NOT NULL,
  `data_post` varchar(2) NOT NULL DEFAULT '00',
  `data_insert` date NOT NULL DEFAULT '1970-01-01',
  `cpf_doador` varchar(14) NOT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT 0.00,
  `doacao` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '1 - Cadastrador, 2 - Doação, 3 - Doação automática',
  `cnpj_estabelecimento` varchar(20) NOT NULL,
  `credito` decimal(10,2) NOT NULL DEFAULT 0.00,
  `id_file` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csv_2025`
--

CREATE TABLE `csv_2025` (
  `id` int(11) NOT NULL,
  `numero_nota` int(10) NOT NULL,
  `data_post` varchar(2) NOT NULL DEFAULT '00',
  `data_insert` date NOT NULL DEFAULT '1970-01-01',
  `cpf_doador` varchar(14) NOT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT 0.00,
  `doacao` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '1 - Cadastrador, 2 - Doação, 3 - Doação automática',
  `cnpj_estabelecimento` varchar(20) NOT NULL,
  `credito` decimal(10,2) NOT NULL DEFAULT 0.00,
  `id_file` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csv_2026`
--

CREATE TABLE `csv_2026` (
  `id` int(11) NOT NULL,
  `numero_nota` int(10) NOT NULL,
  `data_post` varchar(2) NOT NULL DEFAULT '00',
  `data_insert` date NOT NULL DEFAULT '1970-01-01',
  `cpf_doador` varchar(14) NOT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT 0.00,
  `doacao` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '1 - Cadastrador, 2 - Doação, 3 - Doação automática',
  `cnpj_estabelecimento` varchar(20) NOT NULL,
  `credito` decimal(10,2) NOT NULL DEFAULT 0.00,
  `id_file` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csv_2027`
--

CREATE TABLE `csv_2027` (
  `id` int(11) NOT NULL,
  `numero_nota` int(10) NOT NULL,
  `data_post` varchar(2) NOT NULL DEFAULT '00',
  `data_insert` date NOT NULL DEFAULT '1970-01-01',
  `cpf_doador` varchar(14) NOT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT 0.00,
  `doacao` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '1 - Cadastrador, 2 - Doação, 3 - Doação automática',
  `cnpj_estabelecimento` varchar(20) NOT NULL,
  `credito` decimal(10,2) NOT NULL DEFAULT 0.00,
  `id_file` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csv_arquivos`
--

CREATE TABLE `csv_arquivos` (
  `id` int(11) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `quantidade` varchar(32) NOT NULL,
  `hash` varchar(64) DEFAULT NULL,
  `linha` decimal(24,0) NOT NULL DEFAULT 0,
  `conclusao` enum('0','1','2') NOT NULL DEFAULT '2',
  `dmais1` int(1) DEFAULT NULL,
  `dmais2` int(1) DEFAULT NULL,
  `dmais3` int(1) DEFAULT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csv_nocredt`
--

CREATE TABLE `csv_nocredt` (
  `id` int(11) NOT NULL,
  `numero_nota` int(10) NOT NULL,
  `data_post` varchar(2) NOT NULL DEFAULT '00',
  `data_insert` date NOT NULL DEFAULT '1970-01-01',
  `cpf_doador` varchar(14) NOT NULL,
  `valor` decimal(10,2) DEFAULT 0.00,
  `doacao` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '1 - Cadastrador, 2 - Doação, 3 - Doação automática',
  `cnpj_estabelecimento` varchar(20) NOT NULL,
  `credito` decimal(10,2) NOT NULL DEFAULT 0.00,
  `id_file` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `parceria`
--

CREATE TABLE `parceria` (
  `id` int(5) NOT NULL,
  `CNPJ` varchar(14) NOT NULL,
  `INSTITUTO` varchar(64) NOT NULL,
  `CPF` varchar(11) NOT NULL,
  `NOME` varchar(128) NOT NULL,
  `Status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `csv_2024`
--
ALTER TABLE `csv_2024`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `csv_2025`
--
ALTER TABLE `csv_2025`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `csv_2026`
--
ALTER TABLE `csv_2026`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `csv_2027`
--
ALTER TABLE `csv_2027`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `csv_arquivos`
--
ALTER TABLE `csv_arquivos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `csv_nocredt`
--
ALTER TABLE `csv_nocredt`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `csv_2024`
--
ALTER TABLE `csv_2024`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csv_2025`
--
ALTER TABLE `csv_2025`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csv_2026`
--
ALTER TABLE `csv_2026`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csv_2027`
--
ALTER TABLE `csv_2027`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csv_arquivos`
--
ALTER TABLE `csv_arquivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csv_nocredt`
--
ALTER TABLE `csv_nocredt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
