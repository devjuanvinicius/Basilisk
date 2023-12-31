-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/12/2023 às 02:06
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `basilisk`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro`
--

CREATE TABLE `cadastro` (
  `id_cad` int(11) NOT NULL,
  `nome_cad` varchar(80) NOT NULL,
  `data_cad` date NOT NULL,
  `gen_cad` varchar(20) NOT NULL,
  `email_cad` varchar(80) NOT NULL,
  `senha_cad` varchar(255) NOT NULL,
  `url_cad` varchar(50) NOT NULL,
  `type_user` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `cadastro`
--

INSERT INTO `cadastro` (`id_cad`, `nome_cad`, `data_cad`, `gen_cad`, `email_cad`, `senha_cad`, `url_cad`, `type_user`) VALUES
(28, 'Juan  Vinicius ', '2004-11-21', 'masc', 'juan.souza@basiliskfs.com', '$2y$10$lsiSDItyYX7i1vUThHMTH.YatCfBha7TnGo15hdwXWeuy/91RCPKe', 'perfil-5.svg', 1),
(30, 'Leticia  Marques', '2007-11-21', 'fem', 'leticia@marques.com', '$2y$10$Fpqv5VVo59EjBjrYegLkEeu95.haJwqPUAK/3S.IvJ3pwM3iWoQce', 'perfil-6.svg', 0),
(31, 'Eltermann Marques', '1998-01-25', 'fem', 'leticiaeltermann@gmail.com', '$2y$10$FTh3tkn8sKtgub0Sc6VFWOiad0Tr7e7Q2zzJpRQADHi9.4LNgwk8G', 'perfil-6.svg', 0),
(32, 'Juan  Souza', '2004-11-21', 'masc', 'dev.juanvinicius@gmail.com', '$2y$10$8RrvEQLTzDznceYvxkKu5Oc2y/yCVe80qh4BDBSTp9HyDukUj2xRG', 'perfil-6.svg', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cofrinho`
--

CREATE TABLE `cofrinho` (
  `id_meta` int(20) NOT NULL,
  `nome_meta` varchar(20) NOT NULL,
  `valor_meta` int(20) NOT NULL,
  `tempo_meta` int(10) NOT NULL,
  `id_user` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cofrinho`
--

INSERT INTO `cofrinho` (`id_meta`, `nome_meta`, `valor_meta`, `tempo_meta`, `id_user`) VALUES
(17, 'Geladeira', 125, 16, 29),
(18, 'Televisão', 300, 10, 29),
(19, 'Video game', 292, 12, 28),
(20, 'Televisao', 222, 9, 28);

-- --------------------------------------------------------

--
-- Estrutura para tabela `infos_bancarias`
--

CREATE TABLE `infos_bancarias` (
  `id_dados` int(11) NOT NULL,
  `renda_mensal` int(20) NOT NULL,
  `outra_renda` int(20) NOT NULL,
  `renda_final` int(20) NOT NULL,
  `gastos_moradia` int(20) NOT NULL,
  `gastos_alimentacao` int(20) NOT NULL,
  `gastos_transporte` int(20) NOT NULL,
  `gastos_saude` int(20) NOT NULL,
  `gastos_educacao` int(20) NOT NULL,
  `gastos_pessoais` int(20) NOT NULL,
  `gastos_comunicacao` int(20) NOT NULL,
  `gastos_lazer` int(20) NOT NULL,
  `moeda-renda` varchar(20) NOT NULL,
  `moeda-gasto` varchar(20) NOT NULL,
  `id_user` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `infos_bancarias`
--

INSERT INTO `infos_bancarias` (`id_dados`, `renda_mensal`, `outra_renda`, `renda_final`, `gastos_moradia`, `gastos_alimentacao`, `gastos_transporte`, `gastos_saude`, `gastos_educacao`, `gastos_pessoais`, `gastos_comunicacao`, `gastos_lazer`, `moeda-renda`, `moeda-gasto`, `id_user`, `status`) VALUES
(37, 10000, 0, 0, 500, 1000, 700, 0, 0, 200, 0, 0, 'BRL', 'BRL', 28, 0),
(38, 3700, 1000, 4700, 1800, 400, 0, 0, 0, 300, 300, 400, 'BRL', 'BRL', 29, 1),
(39, 1000, 0, 0, 1500, 100, 0, 0, 0, 100, 0, 0, 'USD', 'BRL', 31, 1),
(40, 5000, 0, 0, 100, 1000, 0, 0, 0, 300, 0, 0, 'BRL', 'BRL', 28, 1),
(41, 3000, 0, 0, 100, 500, 0, 0, 0, 700, 0, 0, 'USD', 'BRL', 32, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `infos_investimento`
--

CREATE TABLE `infos_investimento` (
  `id_inv` int(10) NOT NULL,
  `CDB_inv` int(20) NOT NULL,
  `poupanca_inv` int(20) NOT NULL,
  `rendavariavel_inv` int(20) NOT NULL,
  `imoveis_inv` int(20) NOT NULL,
  `id_user` int(10) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `infos_investimento`
--

INSERT INTO `infos_investimento` (`id_inv`, `CDB_inv`, `poupanca_inv`, `rendavariavel_inv`, `imoveis_inv`, `id_user`, `status`) VALUES
(8, 100, 0, 200, 0, 29, 1),
(9, 1000, 200, 0, 0, 28, 0),
(10, 1000, 0, 350, 0, 28, 0),
(11, 0, 2000, 0, 0, 28, 0),
(12, 1000, 200, 300, 0, 28, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `postagem_blog`
--

CREATE TABLE `postagem_blog` (
  `id_post` int(11) NOT NULL,
  `title_post` varchar(100) NOT NULL,
  `subt_post` varchar(100) NOT NULL,
  `text_post` varchar(15000) NOT NULL,
  `data_post` datetime NOT NULL,
  `img_post` varchar(300) NOT NULL,
  `catego_post` text NOT NULL,
  `id_escritor` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `postagem_blog`
--

INSERT INTO `postagem_blog` (`id_post`, `title_post`, `subt_post`, `text_post`, `data_post`, `img_post`, `catego_post`, `id_escritor`) VALUES
(34, 'Titulo ', 'COisa legal', 'Investimento', '2023-12-05 10:14:05', '../assets/imagens-blog/1a027c2b3a0c29c68129869509b78a6d.png', 'Investimento', 28);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cadastro`
--
ALTER TABLE `cadastro`
  ADD PRIMARY KEY (`id_cad`);

--
-- Índices de tabela `cofrinho`
--
ALTER TABLE `cofrinho`
  ADD PRIMARY KEY (`id_meta`);

--
-- Índices de tabela `infos_bancarias`
--
ALTER TABLE `infos_bancarias`
  ADD PRIMARY KEY (`id_dados`);

--
-- Índices de tabela `infos_investimento`
--
ALTER TABLE `infos_investimento`
  ADD PRIMARY KEY (`id_inv`);

--
-- Índices de tabela `postagem_blog`
--
ALTER TABLE `postagem_blog`
  ADD PRIMARY KEY (`id_post`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cadastro`
--
ALTER TABLE `cadastro`
  MODIFY `id_cad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `cofrinho`
--
ALTER TABLE `cofrinho`
  MODIFY `id_meta` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `infos_bancarias`
--
ALTER TABLE `infos_bancarias`
  MODIFY `id_dados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `infos_investimento`
--
ALTER TABLE `infos_investimento`
  MODIFY `id_inv` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `postagem_blog`
--
ALTER TABLE `postagem_blog`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
