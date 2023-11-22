-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/11/2023 às 06:28
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
  `senha_cad` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `cadastro`
--

INSERT INTO `cadastro` (`id_cad`, `nome_cad`, `data_cad`, `gen_cad`, `email_cad`, `senha_cad`) VALUES
(1, 'ikki', '2005-08-02', 'masculino', 'ikki@gmail.com', '123'),
(2, 'kaique', '1900-01-01', 'masculino', 'clewertonkaique2@gmail.com', 'dfsf'),
(3, 'kaique', '2005-08-02', 'masculino', 'clewertonkaique2@gmail.com', '123'),
(8, 'Juan', '2004-11-21', 'masc', 'dev.juanvinicius@gmail.com', 'juanvoi2'),
(10, 'Juan', '0000-00-00', 'masc', 'admin@basilisk.com', '12345'),
(11, 'Juan Vinicius', '2004-11-21', 'masc', 'juangamerxbrcwb2004@gmail.com', 'vivi2004'),
(12, 'Juan Souza', '2004-11-21', 'masc', 'kng@gmail.com', 'juanvi2004'),
(13, 'dasdasdas Souza', '2004-11-21', 'masc', 'dev.juanlinicius@gmail.com', 'dasdasdasdas'),
(14, 'Leticia Marques', '2009-01-01', 'masc', 'leticia@gmail.com', '123456'),
(15, 'tesTTT TTT', '1988-05-04', 'fem', 'RGREG@gmail.comad', 'senhaadm'),
(16, 'TERG FERGER', '0456-05-25', 'masc', 'GREGdmincad@gmail.comERGER', 'senhaadm');

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
  `gastos_investimento` int(20) NOT NULL,
  `id_user` int(11) NOT NULL,
  `visualizar_saldo_usd` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `infos_bancarias`
--

INSERT INTO `infos_bancarias` (`id_dados`, `renda_mensal`, `outra_renda`, `renda_final`, `gastos_moradia`, `gastos_alimentacao`, `gastos_transporte`, `gastos_saude`, `gastos_educacao`, `gastos_pessoais`, `gastos_comunicacao`, `gastos_lazer`, `gastos_investimento`, `id_user`, `visualizar_saldo_usd`) VALUES
(11, 1000, 100, 1100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 10, 0),
(12, 545, 545, 1090, 545, 545, 65, 545, 656, 54, 4, 0, 0, 8, 0);

--
-- Índices para tabelas despejadas
--


CREATE TABLE `postagem_blog` (
  `id_post` int(11) NOT NULL,
  `title_post` varchar(30) NOT NULL,
  `subt_post` varchar(60) NOT NULL,
  `text_post` varchar(15000) NOT NULL,
  `data_post` datetime NOT NULL,
  `img_post` varchar(300) NOT NULL,
  `id_escritor` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `postagem_blog`
--

INSERT INTO `postagem_blog` (`id_post`, `title_post`, `subt_post`, `text_post`, `data_post`, `img_post`, `id_escritor`) VALUES
(1, 'Juan', 'Vinicius', 'KKKKKKKKKKKKKK\r\nMMMMMMMMMMM', '2023-11-19 17:09:10', '66450773_2330973560553917_607020578485829632_n.jpg', 0);
--
-- Índices de tabela `cadastro`
--
ALTER TABLE `cadastro`
  ADD PRIMARY KEY (`id_cad`);

--
-- Índices de tabela `infos_bancarias`
--
ALTER TABLE `infos_bancarias`
  ADD PRIMARY KEY (`id_dados`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

ALTER TABLE `postagem_blog`
  ADD PRIMARY KEY (`id_post`);

--
-- AUTO_INCREMENT de tabela `cadastro`
--
ALTER TABLE `cadastro`
  MODIFY `id_cad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `infos_bancarias`
--
ALTER TABLE `infos_bancarias`
  MODIFY `id_dados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `infos_bancarias`
--
ALTER TABLE `infos_bancarias`
  ADD CONSTRAINT `infos_bancarias_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `cadastro` (`id_cad`);
COMMIT;

ALTER TABLE `postagem_blog`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;