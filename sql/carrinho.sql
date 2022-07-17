-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Jun-2022 às 20:22
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `carrinho`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active | 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `created`, `modified`, `status`) VALUES
(1, '123', '456', '123123@sdas.com', '351 925733737', 'Rua Comandante Fontoura da costa nº20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(2, 'Diogo', 'Sardinha', 'zzdarkshadow@gmail.com', '963 508 737', 'Rua Comandante Fontoura da costa nº20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(3, 'Diogo', 'Sardinha', 'zzdarkshadow@gmail.com', '351 925733737', 'Rua Comandante Fontoura da costa nº20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(4, 'Diogo', 'Sardinha', 'zzdarkshadow@gmail.com', '351 925733737', 'Rua Comandante Fontoura da costa nº20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(5, 'Diogo', 'Bissoli', '123123@sdas.com', '351 925733737', 'Rua Comandante Fontoura da costa nº20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(6, 'Diogo', 'Bissoli', '123123@sdas.com', '351 925733737', 'Rua Comandante Fontoura da costa nº20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(7, 'Diogo', 'Sardinha', 'zzdarkshadow@gmail.com', '351 925733737', 'rua defoege', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(8, 'Diogo', 'Sardinha', 'zzdarkshadow@gmail.com', '351 925733737', 'rua defoege', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(9, 'Diogo', 'Sardinha', 'zzdarkshadow@gmail.com', '351 925733737', 'rua defoege', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(10, 'Diogo', 'Sardinha', 'zzdarkshadow@gmail.com', '351 925733737', 'rua defoege', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(11, 'Diogo', 'Sardinha', 'zzdarkshadow@gmail.com', '351 925733737', 'rua defoege', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(12, 'Diogo', 'Sardinha', 'zzdarkshadow@gmail.com', '351 925733737', 'rua defoege', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `grand_total` float(10,2) NOT NULL,
  `created` datetime NOT NULL,
  `status` enum('Pending','Completed','Cancelled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `grand_total`, `created`, `status`) VALUES
(1, 1, 123.00, '2022-04-21 12:47:31', 'Pending'),
(2, 2, 80.00, '2022-05-02 16:55:00', 'Pending'),
(3, 3, 60.00, '2022-05-03 00:27:13', 'Pending'),
(4, 4, 110.00, '2022-05-03 00:31:00', 'Pending'),
(5, 5, 50.00, '2022-05-06 10:50:27', 'Pending'),
(6, 6, 60.00, '2022-05-06 10:56:17', 'Pending'),
(7, 7, 60.00, '2022-05-06 10:58:32', 'Pending'),
(8, 8, 60.00, '2022-05-06 11:01:26', 'Pending'),
(9, 9, 60.00, '2022-05-06 11:50:50', 'Pending'),
(10, 10, 80.00, '2022-05-31 10:51:36', 'Pending'),
(11, 11, 50.00, '2022-05-31 10:51:59', 'Pending'),
(12, 12, 70.00, '2022-05-31 11:12:31', 'Pending');

-- --------------------------------------------------------

--
-- Estrutura da tabela `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 1),
(2, 2, 3, 1),
(3, 3, 7, 1),
(4, 4, 6, 1),
(5, 4, 7, 1),
(6, 5, 6, 1),
(7, 6, 7, 1),
(8, 7, 7, 1),
(9, 8, 7, 1),
(10, 9, 7, 1),
(11, 10, 3, 1),
(12, 11, 6, 1),
(13, 12, 8, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `price` float(10,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active | 0=Inactive',
  `img` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `created`, `modified`, `status`, `img`) VALUES
(3, 'Pod Ignite 1500', 'Laranja Ice, Morango com Goiaba, Shake de Morango e Cereja Ice', 80.00, '2022-04-21 15:59:54', '2022-04-21 15:59:54', '1', './img/pod1500.jpeg'),
(4, 'Pod Ignite 2500', 'Framboesa com Melancia, Maça Verde Ice, Morango com Melancia, Menta, Torta de Morango, Frutas Vermelhas', 110.00, '2022-04-21 16:45:34', '2022-04-21 16:45:34', '1', './img/pod2500.jpeg'),
(5, 'Vapesoul 1500', 'Love 66, Laranja Ice', 70.00, '2022-04-21 16:47:22', '2022-04-21 16:47:22', '1', './img/vapesoul1500.jpeg'),
(6, 'Balmy 600', 'Maracujá, Melancia, Mentol, Cereja, Lichia', 50.00, '2022-04-21 16:48:00', '2022-04-21 16:48:00', '1', './img/balmy600.jpeg'),
(7, 'Balmy 1000', 'Maracujá, Mentol, Lichia, Cereja', 60.00, '2022-04-21 16:48:59', '2022-04-21 16:48:59', '1', './img/balmy1000.jpeg'),
(8, 'Balmy 1500', 'Melancia, Lichia, Uva, Maça Verde, Cereja', 70.00, '2022-04-21 16:49:26', '2022-04-21 16:49:26', '1', './img/balmy1500.jpeg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `CODIGO` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `NOME` varchar(200) NOT NULL,
  `NIVEL` int(11) NOT NULL DEFAULT 0,
  `USER_STATUS` int(11) NOT NULL DEFAULT 0,
  `TOKEN_CODE` varchar(200) DEFAULT NULL,
  `MENSAGENS_MARKETING` int(11) NOT NULL DEFAULT 0,
  `DATA_HORA` varchar(100) NOT NULL DEFAULT '2021-01-15 04:56:38'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`CODIGO`, `EMAIL`, `PASSWORD`, `NOME`, `NIVEL`, `USER_STATUS`, `TOKEN_CODE`, `MENSAGENS_MARKETING`, `DATA_HORA`) VALUES
('teste', 'teste@teste.com', '$2y$10$bEKmJ8UpJWXkTpTPDr6.1O6v8POh5Bp/9jZFVf0h6pclhfmF5QBcG', 'Teste', 1, 1, '0db9645f02374db666ad419a78ac9cde', 0, '2022-03-12 22:37:48');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Índices para tabela `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`CODIGO`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
