-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 03/08/2021 às 14:47
-- Versão do servidor: 8.0.26-0ubuntu0.20.04.2
-- Versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `servicos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int UNSIGNED NOT NULL,
  `id_usuario` int UNSIGNED DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `id_usuario`, `nome`, `email`, `telefone`, `endereco`, `created_at`, `updated_at`) VALUES
(1, 2, 'Aline Souza Pinage', 'alinesouza2002@email.com', '22-99957-7181', 'Rua: Aline Souza Pinage, 1498', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(2, 3, 'Renata Barros Teixiera', 'renatabarro2016@email.com', '(22)99891-4862', 'Rua: Renata Barros Teixiera, 1280', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(3, 3, 'Jose Meneguici Figueira', 'josemenegui2019@email.com', '(22)99725-4698', 'Rua: Jose Meneguici Figueira, 1596', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(4, 2, 'Pedro Rodrigues', 'pedrorodrig1991@email.com', '(22)99701-5098', 'Rua: Pedro Rodrigues, 1868', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(5, 3, 'Divamar Vasconcelos Messias', 'divamarvasc2017@email.com', '(22)99708-3394', 'Rua: Divamar Vasconcelos Messias, 609', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(6, 3, 'Luiz Rodrigues Meneguici', 'luizrodrigu1998@email.com', '(22)99738-4524', 'Rua: Luiz Rodrigues Meneguici, 296', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(7, 2, 'Michele Barros Meneguici', 'michelebarr2003@email.com', '(22)99932-3222', 'Rua: Michele Barros Meneguici, 229', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(8, 2, 'Nilce Silva Vasconcelos', 'nilcesilva2010@email.com', '(22)99212-2449', 'Rua: Nilce Silva Vasconcelos, 1326', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(9, 2, 'Ana Barros Pinto', 'anabarrosp2000@email.com', '(22)99214-4602', 'Rua: Ana Barros Pinto, 946', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(10, 3, 'Ana Pinto Freitas', 'anapintofr1998@email.com', '(22)99139-8263', 'Rua: Ana Pinto Freitas, 1443', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(11, 3, 'Gleice Andrade Figueira', 'gleiceandra2003@email.com', '(22)99903-9926', 'Rua: Gleice Andrade Figueira, 215', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(12, 3, 'Henrique Vargas Meneguici', 'henriquevar2015@email.com', '(22)99886-4550', 'Rua: Henrique Vargas Meneguici, 1552', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(13, 3, 'Alessandra Junior Pereira', 'alessandraj1998@email.com', '(22)99788-1145', 'Rua: Alessandra Junior Pereira, 134', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(14, 2, 'Jair Pereira Rodrigues', 'jairpereira1999@email.com', '(22)99221-4580', 'Rua: Jair Pereira Rodrigues, 26', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(15, 2, 'Juliana Gomes Messias', 'julianagome2014@email.com', '(22)99570-9792', 'Rua: Juliana Gomes Messias, 1214', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(16, 3, 'Michele Vasconcelos Barros', 'michelevasc2015@email.com', '(22)99426-57', 'Rua: Michele Vasconcelos Barros, 1934', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(17, 2, 'Michele Andrade Rodrigues', 'micheleandr1990@email.com', '(22)99441-3533', 'Rua: Michele Andrade Rodrigues, 733', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(18, 2, 'Arnaldo Silveira Junior', 'arnaldosilv2020@email.com', '(22)99920-9547', 'Rua: Arnaldo Silveira Junior, 1672', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(19, 3, 'Clara Pinage', 'clarapinage2011@email.com', '(22)99489-1450', 'Rua: Clara Pinage, 380', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(20, 2, 'Juliana Souza Silva', 'julianasouz2009@email.com', '(22)99910-45', 'Rua: Juliana Souza Silva, 704', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(21, 3, 'Samuel Messias Junior', 'samuelmessi1991@email.com', '(22)99740-7159', 'Rua: Samuel Messias Junior, 431', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(22, 2, 'Fabio Vargas Silva', 'fabiovargas2013@email.com', '(22)99252-113', 'Rua: Fabio Vargas Silva, 1130', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(23, 2, 'Divamar Freitas Barros', 'divamarfrei1999@email.com', '(22)99472-9485', 'Rua: Divamar Freitas Barros, 1390', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(24, 2, 'Alessandra Fernandes Freitas', 'alessandraf2004@email.com', '22-99384-3902', 'Rua: Alessandra Fernandes Freitas, 1263', '2020-11-10 12:28:21', '2020-11-10 12:28:21'),
(25, 3, 'Arnaldo Vasconcelos Souza', 'arnaldovasc1992@email.com', '(22)99331-5945', 'Rua: Arnaldo Vasconcelos Souza, 1475', '2020-11-10 12:28:21', '2020-11-10 12:28:21');

-- --------------------------------------------------------

--
-- Estrutura para tabela `logs`
--

CREATE TABLE `logs` (
  `id_log` bigint UNSIGNED NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `mensagem` varchar(200) DEFAULT NULL,
  `data_hora` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id_servico` int UNSIGNED NOT NULL,
  `id_cliente` int UNSIGNED DEFAULT NULL,
  `orcamento` tinyint(1) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `quantidade` tinyint DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int UNSIGNED NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `senha` varchar(200) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `permissoes` varchar(50) DEFAULT NULL,
  `codigo_validacao` varchar(200) DEFAULT NULL,
  `validado` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `senha`, `nome`, `email`, `permissoes`, `codigo_validacao`, `validado`, `created_at`, `updated_at`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrador', 'cameraeuterpe@gmail.com', '11111111111111111111111111111111111111111111111111', 'WpfSnPYfWJxlc75TpKa7plOA5KeIf', 1, '2020-11-10 12:12:07', '2020-11-10 12:12:07'),
(2, 'luiz', '77949c9f02621a4c85964be115a9dcc9', 'Luiz Gomes', 'luiz@email.com', '01111111111111111111111111111111111111111111111111', 'WpfSnPYfWJxlc75TpKa7plOA5KeIf', 1, '2020-11-10 12:12:07', '2020-11-10 12:12:07'),
(3, 'miguel', '9eb0c9605dc81a68731f61b3e0838937', 'Miguel Gomes', 'miguel@email.com', '00111111111111111111111111111111111111111111111111', 'WpfSnPYfWJxlc75TpKa7plOA5KeIf', 1, '2020-11-10 12:12:07', '2020-11-10 12:12:07');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Índices de tabela `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id_log`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id_servico`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `id_log` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servico` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
