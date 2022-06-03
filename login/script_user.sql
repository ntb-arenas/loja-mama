-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2022 at 08:45 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

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
  `code` varchar(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `sequence` int(10) NOT NULL,
  `visible` int(2) NOT NULL,
  `link` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`code`, `title`, `sequence`, `visible`, `link`) VALUES
('AAC', 'ALMOFADAS ANTI-CÓLICAS', 7, 1, 'almofadas-anticolicas'),
('AAM', 'ALMOFADAS DE AMAMENTAÇÃO', 2, 1, 'almofadas-de-amamentacao'),
('CS', 'CUNHAS', 3, 1, 'cunhas'),
('KM', 'KIT MATERNIDADE', 5, 1, 'kit-maternidade'),
('MF', 'MUDA FRALDAS', 6, 1, 'muda-fraldas'),
('PROM', 'PROMOÇÕES', 8, 0, '#'),
('SL', 'SLINGS', 4, 1, 'slings');

-- --------------------------------------------------------

--
-- Table structure for table `option_group`
--

CREATE TABLE `option_group` (
  `pack` varchar(5) NOT NULL,
  `code` varchar(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `image_url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `option_group`
--

INSERT INTO `option_group` (`pack`, `code`, `name`, `description`, `price`, `image_url`) VALUES
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
('OPAP1', 'F1', 'VERDE', 'Almofadas de Amamentação', 35, './gallery/almofadaPequena/verde.jpg'),
('OPAP1', 'F2', 'AZUL', 'Almofadas de Amamentação', 35, './gallery/almofadaPequena/azul.jpg'),
('OPAP1', 'F3', 'LARANJA', 'Almofadas de Amamentação', 35, './gallery/almofadaPequena/laranja.jpg'),
('OPAP2', 'V1', 'BHEN', 'Almofadas de Amamentação', 35, './gallery/almofadaPequena/bhen.jpg'),
('OPAP2', 'V2', 'CARROS', 'Almofadas de Amamentação', 35, './gallery/almofadaPequena/carros.jpg'),
('OPAP2', 'V3', 'SELVA', 'Almofadas de Amamentação', 35, './gallery/almofadaPequena/selva.jpg'),
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
-- Table structure for table `option_pack`
--

CREATE TABLE `option_pack` (
  `code` varchar(5) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `option_pack`
--

INSERT INTO `option_pack` (`code`, `name`) VALUES
('OP1', 'FRENTE'),
('OP2', 'VERSO');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `PRODUCT_CODE` varchar(5) NOT NULL,
  `OPTION_PACK` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`PRODUCT_CODE`, `OPTION_PACK`) VALUES
('P1', 'OP1'),
('P1', 'OP2');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `pack` varchar(10) NOT NULL,
  `code` int(5) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `image_url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `test_order`
--

CREATE TABLE `test_order` (
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `IMAGE` varchar(100) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_order`
--

INSERT INTO `test_order` (`code`, `name`, `IMAGE`, `price`) VALUES
('C1', 'LARANJA', '', 40),
('C2', 'CASTANHO', '', 40),
('C3', 'AZUL', '', 40);

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
  `REVIEW_ID` varchar(10) DEFAULT NULL,
  `DATE_HOUR` varchar(100) NOT NULL DEFAULT '2022-05-20 01:10:38'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `USERNAME`, `EMAIL`, `PASSWORD`, `fNAME`, `lNAME`, `MORADA`, `COD_POSTAL`, `CIDADE`, `PAIS`, `TELEMOVEL`, `USER_LEVEL`, `USER_STATUS`, `TOKEN_CODE`, `MSGS_MARKETING`, `REVIEW_ID`, `DATE_HOUR`) VALUES
(105, 'carolinap', 'carolina@gmail.com', '$2y$10$No5b.JlzYh6R3X.5ncdI.u2A82RQNlcAkWR/4dxxHeBF.iNB0joQC', 'Carolina', 'Patrocínio', 'Praça José Fontana', '1653-589', 'Lisboa', 'Portugal', '999888777', 1, 1, NULL, 1, 'Y2Fyb2xpbm', '2022-05-29 15:34:15'),
(107, 'ninoarenas', 'ntbarenas@gmail.com', '$2y$10$PWewh3JBMeZlHXR5R1KOu.uFoFmUJ5xBLyT4G/NY.cPT7tySlhJKe', 'Niño', 'Arenas', NULL, NULL, NULL, NULL, NULL, 2, 1, NULL, 1, NULL, '2022-06-02 22:37:02'),
(110, 'mafaldat', 'mafaldat@gmail.com', '$2y$10$1yntICJ6ObsnWISzKPrk8uX0QsZuFpWnNzPHHYyLWurL/28veAaS2', 'Mafalda', 'Teixeira', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 1, 'bWFmYWxkYX', '2022-06-03 17:00:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `option_group`
--
ALTER TABLE `option_group`
  ADD PRIMARY KEY (`pack`,`code`);

--
-- Indexes for table `option_pack`
--
ALTER TABLE `option_pack`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD KEY `PROD_OPT-PA_FK` (`OPTION_PACK`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`code`,`pack`),
  ADD KEY `pack` (`pack`);

--
-- Indexes for table `test_order`
--
ALTER TABLE `test_order`
  ADD PRIMARY KEY (`code`);

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
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `code` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `option_pack`
--
ALTER TABLE `option_pack`
  ADD CONSTRAINT `OPT_PAGR_FK` FOREIGN KEY (`code`) REFERENCES `option_group` (`pack`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `PROD_OPT-PA_FK` FOREIGN KEY (`OPTION_PACK`) REFERENCES `option_pack` (`code`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`REVIEW_ID`) REFERENCES `reviews` (`pack`);
COMMIT;
