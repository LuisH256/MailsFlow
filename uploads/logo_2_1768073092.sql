-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 10/01/2026 às 17:40
-- Versão do servidor: 11.8.3-MariaDB-log
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u776995841_cliente`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `Id` int(255) NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `Cpf` varchar(14) NOT NULL,
  `Nascimento` date NOT NULL,
  `Cep` varchar(8) NOT NULL,
  `Numer_casa` int(6) NOT NULL,
  `Endereco` varchar(255) NOT NULL,
  `Bairro` varchar(255) NOT NULL,
  `Plano` varchar(50) NOT NULL,
  `Valor` decimal(20,0) NOT NULL,
  `Telefone` varchar(20) NOT NULL,
  `status` varchar(20) DEFAULT 'PENDENTE',
  `Vencimento_Dia` int(3) NOT NULL,
  `data_pagamento` date NOT NULL,
  `Login` varchar(255) NOT NULL,
  `Forma_Pagamento` varchar(25) NOT NULL,
  `Wifi_Nome` varchar(255) NOT NULL,
  `Wifi_Senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`Id`, `Nome`, `Cpf`, `Nascimento`, `Cep`, `Numer_casa`, `Endereco`, `Bairro`, `Plano`, `Valor`, `Telefone`, `status`, `Vencimento_Dia`, `data_pagamento`, `Login`, `Forma_Pagamento`, `Wifi_Nome`, `Wifi_Senha`) VALUES
(2, 'Luis Mattos', '071.289.635-02', '2006-03-30', '45656-11', 10, '2ª Travessa Senhor dos Passos', 'Nelson Costa', '50 mega - R$ 60', 70, '(73) 98820-2107', 'PAGO', 11, '2026-03-11', '', 'Pix', '', ''),
(3, 'CARLOS ROBERTO ROSA SANTOS', '013.951.845-26', '1981-08-08', '45658-09', 0, 'Casa', 'Barra do Itaípe', '200 mega - R$ 100', 60, '73988178835', 'PENDENTE', 20, '2026-02-20', 'carlosmaxguitarra@gmail.com', 'Pagar na Residência', '', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
