-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28-Nov-2021 às 18:21
-- Versão do servidor: 10.4.21-MariaDB
-- versão do PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `coisarada`
--
CREATE DATABASE IF NOT EXISTS `coisarada` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `coisarada`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `coisas`
--

DROP TABLE IF EXISTS `coisas`;
CREATE TABLE `coisas` (
  `id_coisa` int(11) NOT NULL,
  `nome_coisa` varchar(40) NOT NULL,
  `categoria` varchar(40) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `coisas`
--

INSERT INTO `coisas` (`id_coisa`, `nome_coisa`, `categoria`, `usuario`) VALUES
(1, 'Mona Lisa', 'Pintura', 1),
(2, 'Homem Vitruviano', 'Anatomia', 1),
(3, 'Máquina Voadora', 'Transporte', 1),
(4, 'A Batalha de Anghiari', 'Pintura', 1),
(5, 'O Segundo Sexo', 'Livro', 2),
(6, 'A convidada', 'Livro', 2),
(7, 'Caneta de Pena', 'Papelaria', 2),
(8, 'Máquina de Escrever', 'Escritório', 2),
(9, 'Escrivanhinha', 'Móveis', 2),
(10, 'Xícara', 'Utensílio', 3),
(11, 'Fone de ouvido', 'Eletrônico', 3),
(12, 'Crocs', 'Calçado', 3),
(13, 'Kindle', 'Eletrônico', 3),
(14, 'Violão', 'Instrumento Musical', 3),
(15, 'Furadeira', 'Ferramenta', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `emprestimo`
--

DROP TABLE IF EXISTS `emprestimo`;
CREATE TABLE `emprestimo` (
  `id_emprestimo` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `data_emprestimo` date NOT NULL,
  `data_combinada` date NOT NULL,
  `data_devolvido` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `emprestimo`
--

INSERT INTO `emprestimo` (`id_emprestimo`, `item`, `usuario`, `data_emprestimo`, `data_combinada`, `data_devolvido`) VALUES
(1, 6, 3, '2021-10-20', '2021-11-22', '0000-00-00'),
(2, 2, 3, '2021-11-10', '0000-00-00', '0000-00-00'),
(3, 7, 3, '2021-10-20', '0000-00-00', '0000-00-00'),
(4, 10, 3, '2021-10-25', '2021-11-29', '0000-00-00'),
(5, 15, 1, '2021-11-16', '0000-00-00', '0000-00-00'),
(6, 9, 1, '2021-11-07', '2021-12-14', '0000-00-00'),
(7, 13, 2, '2021-11-28', '2022-01-18', '0000-00-00'),
(8, 3, 2, '2021-11-20', '0000-00-00', '0000-00-00'),
(9, 12, 2, '2021-09-18', '2021-11-05', '0000-00-00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `senha` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `telefone`, `endereco`, `senha`) VALUES
(1, 'Leonardo da Vinci', 'leonardo@renascimento.com', '(41) 9863-2548', 'Itália do séc XV', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2'),
(2, 'Simone de Beauvoir', 'simone@escritora.com', '41 98989-1574', 'Paris, França, 1908', '1c6637a8f2e1f75e06ff9984894d6bd16a3a36a9'),
(3, 'Jairo Bankhardt', 'jairo.bankhardt@gmail.com', '(41) 99611-2665', 'Rua João Ramalho, 436, casa 4', '43814346e21444aaf4f70841bf7ed5ae93f55a9d');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `coisas`
--
ALTER TABLE `coisas`
  ADD PRIMARY KEY (`id_coisa`);

--
-- Índices para tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD PRIMARY KEY (`id_emprestimo`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `coisas`
--
ALTER TABLE `coisas`
  MODIFY `id_coisa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  MODIFY `id_emprestimo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
