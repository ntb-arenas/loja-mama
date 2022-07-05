-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2022 at 04:01 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `projetoalmo`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CODE` varchar(10) NOT NULL,
  `TITLE` varchar(100) NOT NULL,
  `SEQUENCE` int(10) NOT NULL,
  `VISIBLE` int(2) NOT NULL,
  `LINK` varchar(200) NOT NULL,
  `IMAGE_URL` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CODE`, `TITLE`, `SEQUENCE`, `VISIBLE`, `LINK`, `IMAGE_URL`) VALUES
('AAC', 'ALMOFADAS ANTI-CÓLICAS', 7, 1, 'almofadas-anticolicas', 'antiColicas.png'),
('AAM', 'ALMOFADAS DE AMAMENTAÇÃO', 2, 1, 'almofadas-de-amamentacao', 'almofadaImg.png'),
('CS', 'CUNHAS', 3, 1, 'cunhas', 'cunhas.png'),
('KM', 'KIT MATERNIDADE', 5, 1, 'kit-maternidade', 'kitMaternidadeAzul.png'),
('MF', 'MUDA FRALDAS', 6, 1, 'muda-fraldas', 'mudaFraldas.png'),
('PROM', 'PROMOÇÕES', 8, 0, '#', ''),
('SL', 'SLINGS', 4, 1, 'slings', 'slingBebe1.png');

-- --------------------------------------------------------

--
-- Table structure for table `option_group`
--

CREATE TABLE `option_group` (
  `PACK` varchar(5) NOT NULL,
  `CODE` varchar(5) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `DESCRIPTION` varchar(200) DEFAULT NULL,
  `PRICE` float DEFAULT NULL,
  `IMAGE_URL` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `option_group`
--

INSERT INTO `option_group` (`PACK`, `CODE`, `NAME`, `DESCRIPTION`, `PRICE`, `IMAGE_URL`) VALUES
('OP1', 'F1', 'LARANJA', 'Almofadas de Amamentação', 45, './gallery/productimg/laranja.jpg'),
('OP1', 'F2', 'CASTANHO', 'Almofadas de Amamentação', 45, './gallery/productimg/castanho.jpg'),
('OP1', 'F3', 'AZUL', 'Almofadas de Amamentação', 45, './gallery/productimg/azul.jpg'),
('OP2', 'V1', 'BALÕES', 'Almofadas de Amamentação', 45, './gallery/productimg/baloes.jpg'),
('OP2', 'V2', 'RISCAS LARGAS', 'Almofadas de Amamentação', 45, './gallery/productimg/riscas_largas.jpg'),
('OP2', 'V3', 'BOLAS BRANCAS', 'Almofadas de Amamentação', 45, './gallery/productimg/bolas_brancas.jpg'),
('OPAC', 'AC1', 'PINTINHAS', 'Almofadas Anti-cólicas', 9.5, './gallery/antiColicas/pintinhas.jpg'),
('OPAC', 'AC2', 'ARGOLAS', 'Almofadas Anti-cólicas', 9.5, './gallery/antiColicas/argolas.jpg'),
('OPAC', 'AC3', 'FANTASIA BONECOS', 'Almofadas Anti-cólicas', 9.5, './gallery/antiColicas/fantasia_bonecos.jpg'),
('OPAC', 'AC4', 'ELEFANTE', 'Almofadas Anti-cólicas', 9.5, './gallery/antiColicas/1.jpg'),
('OPAC', 'AC5', 'SELVA', 'Almofadas Anti-cólicas', 9.5, './gallery/antiColicas/selva.jpg'),
('OPC', 'C1', 'AZUL', 'Cunhas', 45, './gallery/cunhaProduct/azul_bebe.jpg'),
('OPC', 'C2', 'AZUL ESCURO', 'Cunhas', 45, './gallery/cunhaProduct/azul_escuro.jpg'),
('OPC', 'C3', 'LARANJA', 'Cunhas', 45, './gallery/cunhaProduct/laranja.jpg'),
('OPC', 'C4', 'VERDE', 'Cunhas', 45, './gallery/cunhaProduct/verde.jpg'),
('OPKM', 'KM1', 'AZUL CLARO', 'Kit Maternidade', 18, './gallery/kitMaternidade/azul.jpg'),
('OPKM', 'KM2', 'OVELHAS ROSA', 'Kit Maternidade', 18, './gallery/kitMaternidade/ovelhas_rosa.jpg'),
('OPKM', 'KM3', 'RISCAS COM TAMANHOS DIFERENTES', 'Kit Maternidade', 18, './gallery/kitMaternidade/riscas_diferentes.jpg'),
('OPKM', 'KM4', 'ROSA CLARO', 'Kit Maternidade', 18, './gallery/kitMaternidade/rosa.jpg'),
('OPKM', 'KM5', 'URSINHO COM FUNDO AZUL', 'Kit Maternidade', 18, './gallery/kitMaternidade/ursinho_azul.jpg'),
('OPMF', 'MF1', 'ROSA PIQUÉ', 'Muda Fraldas', 15, './gallery/mudaFraldas/rosa_pique.jpg'),
('OPMF', 'MF2', 'AZUL PIQUÉ', 'Muda Fraldas', 15, './gallery/mudaFraldas/azul_pique.jpg'),
('OPS', 'S1', 'AZUL PIQUE', 'Slings', 25, './gallery/slings/azul_pique.jpg'),
('OPS', 'S2', 'CASTANHO', 'Slings', 25, './gallery/slings/castanho.jpg'),
('OPS', 'S3', 'FLORES AZUIS', 'Slings', 25, './gallery/slings/flores_azuis.jpg'),
('OPS', 'S4', 'FLORES COLORIDO', NULL, 25, './gallery/slings/flores_colorido.jpg'),
('OPS', 'S5', 'GANGA', NULL, 25, './gallery/slings/ganga.jpg'),
('OPS', 'S6', 'VERDE', NULL, 25, './gallery/slings/verde.jpg'),
('OPS', 'S7', 'VERMELHO', NULL, 25, './gallery/slings/vermelho.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `INVOICE_ID` varchar(10) NOT NULL,
  `USER_ID` int(5) NOT NULL,
  `STATUS` int(3) NOT NULL,
  `PRICE` double NOT NULL,
  `DATE` varchar(50) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `PRODUCT_ID` varchar(10) NOT NULL,
  `id` int(11) NOT NULL,
  `CODE` varchar(11) NOT NULL,
  `TYPE` varchar(50) DEFAULT NULL,
  `NAME` varchar(50) DEFAULT NULL,
  `PRICE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`PRODUCT_ID`, `id`, `CODE`, `TYPE`, `NAME`, `PRICE`) VALUES
('INV_4378', 47, 'AC1', 'Almofadas Anti-cólicas', 'PINTINHAS', NULL),
('INV_4378', 48, 'AC4', 'Almofadas Anti-cólicas', 'ELEFANTE', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `USER_ID` varchar(50) NOT NULL,
  `CODE` int(10) NOT NULL,
  `DESCRIPTION` varchar(200) NOT NULL,
  `IMAGE_URL` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`USER_ID`, `CODE`, `DESCRIPTION`, `IMAGE_URL`) VALUES
('110-review', 1, 'Recebi este presente personalizado para mim e Mimikas &#128515 Vamos ver se será a salvação para as noites mal dormidas!!!', 'gallery/reviews/mafaldat/1901905_290796084402925_1569932787_n.jpg'),
('105-review', 2, 'Hoje passeámos em Narbonne assim. A bebé em kit mãos livres o que dá muito jeito para a caminhada &#128523', 'gallery/reviews/carolinap/10170969_626128334130776_1748500768364158520_n.jpg'),
('111-review', 3, 'Eu acho muito prático. Eu comprei um sling e a minha filha adora estar lá dentro, adormece logo.', 'gallery/reviews/sandrag/245045074_10221146591829479_765770891105073748_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `fNAME` varchar(200) NOT NULL,
  `lNAME` varchar(200) NOT NULL,
  `MORADA` varchar(200) DEFAULT NULL,
  `COD_POSTAL` varchar(8) DEFAULT NULL,
  `CIDADE` varchar(100) DEFAULT NULL,
  `PAIS` varchar(100) DEFAULT NULL,
  `TELEMOVEL` varchar(9) DEFAULT NULL,
  `USER_LEVEL` int(11) NOT NULL DEFAULT 0,
  `USER_STATUS` int(11) NOT NULL DEFAULT 0,
  `TOKEN_CODE` varchar(200) DEFAULT NULL,
  `MSGS_MARKETING` int(11) NOT NULL DEFAULT 0,
  `REVIEW_ID` varchar(50) DEFAULT NULL,
  `DATE_HOUR` varchar(100) NOT NULL DEFAULT '2022-05-20 01:10:38'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `USERNAME`, `EMAIL`, `PASSWORD`, `fNAME`, `lNAME`, `MORADA`, `COD_POSTAL`, `CIDADE`, `PAIS`, `TELEMOVEL`, `USER_LEVEL`, `USER_STATUS`, `TOKEN_CODE`, `MSGS_MARKETING`, `REVIEW_ID`, `DATE_HOUR`) VALUES
(105, 'carolinap', 'carolina@gmail.com', '$2y$10$No5b.JlzYh6R3X.5ncdI.u2A82RQNlcAkWR/4dxxHeBF.iNB0joQC', 'Carolina', 'Patrocínio', 'Praça José Fontana Nº1, 1RP - Cv/Dta', '1653-589', 'Lisboa', 'Portugal', '999888777', 1, 1, NULL, 1, '105-review', '2022-05-29 15:34:15'),
(107, 'ninoarenas', 'ntbarenas@gmail.com', '$2y$10$PWewh3JBMeZlHXR5R1KOu.uFoFmUJ5xBLyT4G/NY.cPT7tySlhJKe', 'Niño', 'Arenas', NULL, NULL, NULL, 'Portugal', NULL, 2, 1, NULL, 1, NULL, '2022-06-02 22:37:02'),
(110, 'mafaldat', 'mafaldat@gmail.com', '$2y$10$1yntICJ6ObsnWISzKPrk8uX0QsZuFpWnNzPHHYyLWurL/28veAaS2', 'Mafalda', 'Teixeira', NULL, NULL, NULL, 'Portugal', NULL, 1, 1, NULL, 1, '110-review', '2022-06-03 17:00:19'),
(111, 'sandrag', 'sandrag@gmail.com', '$2y$10$uAUNyVPt6Gs5R9ERtGRLE.xRr2y31LrbnH78wslOu1LerQ7weAwfy', 'Sandra', 'Gabriel', '', '1111-111', '', 'Portugal', '999999999', 1, 1, NULL, 1, '111-review', '2022-06-03 20:18:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CODE`);

--
-- Indexes for table `option_group`
--
ALTER TABLE `option_group`
  ADD PRIMARY KEY (`PACK`,`CODE`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`INVOICE_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PRODUCT_ID` (`PRODUCT_ID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`CODE`),
  ADD KEY `PACK` (`USER_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `REVIEW_ID` (`REVIEW_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `CODE` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`INVOICE_ID`) REFERENCES `products` (`PRODUCT_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`REVIEW_ID`) REFERENCES `reviews` (`USER_ID`);
COMMIT;