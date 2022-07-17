-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09-Jul-2022 às 21:03
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
(16, 'Diogo', 'Sardinha', 'zzdarkshadow@gmail.com', '963 508 737', 'Rua Comandante Fontoura da costa nº20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(17, 'Diogo', 'Sardinha', 'zzdarkshadow@gmail.com', '963 508 737', 'Rua Comandante Fontoura da costa nº20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1');

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
(16, 16, 60.00, '2022-06-29 13:30:41', 'Pending'),
(17, 17, 60.00, '2022-06-29 15:37:11', 'Pending');

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
(18, 16, 7, 1),
(19, 17, 7, 1);

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
(3, 'Pod Ignite 1500', 'O Ignite Pod é um cigarro eletrônico descartável leve, prático e fácil de ser levado para qualquer lugar.\n\nAlém disso, o Ignite Stig possui uma bateria interna de 850mAh e 5.1mL de Juice. A força de nicotina é de 5,0% e a nicotina de sal equivale a cerca de 4 maços de cigarros convencionais.', 80.00, '2022-04-21 15:59:54', '2022-04-21 15:59:54', '1', './img/pod1500.jpeg'),
(4, 'Pod Ignite 2500', 'O Ignite Pod é um cigarro eletrônico descartável leve, prático e fácil de ser levado para qualquer lugar.\n\nAlém disso, o Ignite V25 Stig possui uma bateria interna de 1000mAh e 7.5mL de Juice. A força de nicotina é de 5,0% e a nicotina de sal equivale a cerca de 5 maços de cigarros convencionais.', 110.00, '2022-04-21 16:45:34', '2022-04-21 16:45:34', '1', './img/pod2500.jpeg'),
(5, 'Vapesoul 1500', 'O VapeSoul Pod é um pod descartável com capacidade média de 1500puffs de sabor único e grande durabilidade!\n\nAlém disso, o VapeSoul Stig possui uma bateria interna de 400mAh e 4mL de Juice. A força de nicotina é de 5,0% e sua quantidade de tragadas equivale a cerca de 2 maços de cigarros convencionais.', 70.00, '2022-04-21 16:47:22', '2022-04-21 16:47:22', '1', './img/vapesoul1500.jpeg'),
(6, 'Balmy 600', 'O BalMy Pod é um cigarro eletrônico descartável leve, prático e fácil de ser levado para qualquer lugar!\n\nAlém disso, o Balmy Stig possui uma bateria interna de 550mAh e 2.2mL de Juice. A força de nicotina é de 5,0% e é equivalente a cerca de 4 maços de cigarros convencionais.', 50.00, '2022-04-21 16:48:00', '2022-04-21 16:48:00', '1', './img/balmy600.jpeg'),
(7, 'Balmy 1000', 'O descartável BalMy é um cigarro eletrônico descartável leve, prático e fácil de ser levado para qualquer lugar.\n\nAlém disso, o Balmy Stig possui uma bateria interna de 550mAh e 3.5mL de Juice. A força de nicotina é de 6,0% e é equivalente a cerca de 3 maços de cigarros convencionais.', 60.00, '2022-04-21 16:48:59', '2022-04-21 16:48:59', '1', './img/balmy1000.jpeg'),
(8, 'Balmy 1500', 'O descartável BalMy é um cigarro eletrônico descartável leve, prático e fácil de ser levado para qualquer lugar.\n\nAlém disso, o Balmy Stig possui uma bateria interna de 850mAh e 5.5mL de Juice. A força de nicotina é de 5,0% e é equivalente a cerca de 4 maços de cigarros convencionais.', 70.00, '2022-04-21 16:49:26', '2022-04-21 16:49:26', '1', './img/balmy1500.jpeg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_sabor`
--

CREATE TABLE `produto_sabor` (
  `id_produto` int(11) NOT NULL,
  `id_sabor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produto_sabor`
--

INSERT INTO `produto_sabor` (`id_produto`, `id_sabor`) VALUES
(3, 10),
(3, 11),
(3, 12),
(3, 13),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(4, 21),
(4, 31),
(5, 10),
(5, 22),
(6, 23),
(6, 24),
(6, 25),
(6, 27),
(6, 28),
(7, 23),
(7, 25),
(7, 27),
(7, 28),
(8, 24),
(8, 27),
(8, 28),
(8, 29),
(8, 30);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sabores`
--

CREATE TABLE `sabores` (
  `id` int(11) NOT NULL,
  `sabor` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `sabores`
--

INSERT INTO `sabores` (`id`, `sabor`) VALUES
(10, 'Laranja Ice'),
(11, 'Morango com Goiaba'),
(12, 'Shake de Morango'),
(13, 'Cereja Ice'),
(17, 'Framboesa com Melancia'),
(18, 'Maçã Verde Ice'),
(19, 'Menta'),
(20, 'Torta de Morango'),
(21, 'Frutas Vermelhas'),
(22, 'Love 66'),
(23, 'Maracujá'),
(24, 'Melancia'),
(25, 'Mentol'),
(27, 'Lichia'),
(28, 'Cereja'),
(29, 'Uva'),
(30, 'Maçã Verde'),
(31, 'Morango com Melancia');

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
-- Índices para tabela `produto_sabor`
--
ALTER TABLE `produto_sabor`
  ADD PRIMARY KEY (`id_produto`,`id_sabor`),
  ADD KEY `id_produto` (`id_produto`,`id_sabor`),
  ADD KEY `id_sabor` (`id_sabor`);

--
-- Índices para tabela `sabores`
--
ALTER TABLE `sabores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `sabores`
--
ALTER TABLE `sabores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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

--
-- Limitadores para a tabela `produto_sabor`
--
ALTER TABLE `produto_sabor`
  ADD CONSTRAINT `produto_sabor_ibfk_1` FOREIGN KEY (`id_sabor`) REFERENCES `sabores` (`id`),
  ADD CONSTRAINT `produto_sabor_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
