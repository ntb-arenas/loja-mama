-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2022 at 05:12 PM
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
-- Table structure for table `CATEGORY`
--

CREATE TABLE `CATEGORY` (
  `CODE` varchar(10) NOT NULL,
  `TITLE` varchar(100) NOT NULL,
  `SEQUENCE` int(10) NOT NULL,
  `VISIBLE` int(2) NOT NULL,
  `LINK` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `CATEGORY`
--

INSERT INTO `CATEGORY` (`CODE`, `TITLE`, `SEQUENCE`, `VISIBLE`, `LINK`) VALUES
('AAC', 'ALMOFADAS ANTI-CÓLICAS', 7, 1, 'almofadas-anticolicas.php'),
('AAM', 'ALMOFADAS DE AMAMENTAÇÃO', 2, 2, '#'),
('CS', 'CUNHAS', 3, 1, 'cunhas.php'),
('KM', 'KIT MATERNIDADE', 5, 1, 'kit-maternidade.php'),
('MF', 'MUDA FRALDAS', 6, 1, 'muda-fraldas.php'),
('PROM', 'PROMOÇÕES', 1, 0, '#'),
('SL', 'SLINGS', 4, 1, 'slings.php');

-- --------------------------------------------------------

--
-- Table structure for table `OPTION_GROUP`
--

CREATE TABLE `OPTION_GROUP` (
  `PACK` varchar(5) NOT NULL,
  `CODE` varchar(5) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `DESCRIPTION` varchar(200) DEFAULT NULL,
  `PRICE` float DEFAULT NULL,
  `IMAGE_URL` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `OPTION_GROUP`
--

INSERT INTO `OPTION_GROUP` (`PACK`, `CODE`, `NAME`, `DESCRIPTION`, `PRICE`, `IMAGE_URL`) VALUES
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
-- Table structure for table `OPTION_PACK`
--

CREATE TABLE `OPTION_PACK` (
  `CODE` varchar(5) NOT NULL,
  `NAME` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `OPTION_PACK`
--

INSERT INTO `OPTION_PACK` (`CODE`, `NAME`) VALUES
('OP1', 'FRENTE'),
('OP2', 'VERSO');

-- --------------------------------------------------------

--
-- Table structure for table `PRODUCT`
--

CREATE TABLE `PRODUCT` (
  `PRODUCT_CODE` varchar(5) NOT NULL,
  `OPTION_PACK` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `PRODUCT`
--

INSERT INTO `PRODUCT` (`PRODUCT_CODE`, `OPTION_PACK`) VALUES
('P1', 'OP1'),
('P1', 'OP2');

-- --------------------------------------------------------

--
-- Table structure for table `REVIEWS`
--

CREATE TABLE `REVIEWS` (
  `CODE` int(10) NOT NULL,
  `NAME` varchar(200) NOT NULL,
  `DESCRIPTION` varchar(200) NOT NULL,
  `IMAGE_URL` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `REVIEWS`
--

INSERT INTO `REVIEWS` (`CODE`, `NAME`, `DESCRIPTION`, `IMAGE_URL`) VALUES
(1, 'Mafalda Teixeira', 'Recebi este presente personalizado para mim e Mimikas &#128515 Vamos ver se será a salvação para as noites mal dormidas!!!', 'gallery/reviews/mafaldat/1901905_290796084402925_1569932787_n.jpg'),
(4, 'Carolina Patrocínio', 'Hoje passeámos em Narbonne assim. A bebé em kit mãos livres o que dá muito jeito para a caminhada &#128523', 'gallery/reviews/carolinap/10170969_626128334130776_1748500768364158520_n.jpg'),
(5, 'Sandra Gabriel', 'Eu acho muito prático. Eu comprei um sling e a minha filha adora estar lá dentro, adormece logo.', 'gallery/reviews/sandrag/245045074_10221146591829479_765770891105073748_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `TEST_ORDER`
--

CREATE TABLE `TEST_ORDER` (
  `CODE` varchar(10) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `IMAGE` varchar(100) NOT NULL,
  `PRICE` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TEST_ORDER`
--

INSERT INTO `TEST_ORDER` (`CODE`, `NAME`, `IMAGE`, `PRICE`) VALUES
('C1', 'LARANJA', '', 40),
('C2', 'CASTANHO', '', 40),
('C3', 'AZUL', '', 40);

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE `USERS` (
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
  `DATE_HOUR` varchar(100) NOT NULL DEFAULT '2022-05-20 01:10:38'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`ID`, `USERNAME`, `EMAIL`, `PASSWORD`, `fNAME`, `lNAME`, `MORADA`, `COD_POSTAL`, `CIDADE`, `PAIS`, `TELEMOVEL`, `USER_LEVEL`, `USER_STATUS`, `TOKEN_CODE`, `MSGS_MARKETING`, `DATE_HOUR`) VALUES
(103, 'mafaldat', 'mafaldateixeira@gmail.com', '$2y$10$AnWE6dgR033IdPR9b5IYLuscEOZtdEMOQ19EEuQmhPf1FV/9fS/8S', 'Mafalda', 'Teixeira', 'Praça José Fontana', '1653-589', 'Lisboa', 'Portugal', '999888777', 1, 1, NULL, 1, '2022-05-29 15:22:55'),
(105, 'carolinap', 'carolina@gmail.com', '$2y$10$No5b.JlzYh6R3X.5ncdI.u2A82RQNlcAkWR/4dxxHeBF.iNB0joQC', 'Carolina', 'Patrocínio', 'Praça José Fontana', '1653-589', 'Lisboa', 'Portugal', '999888777', 1, 1, NULL, 1, '2022-05-29 15:34:15'),
(106, 'sandrag', 'sandra@gmail.com', '$2y$10$hg.RBJtufPWU4DTOyW74e.fpKo/OoncU.ovWJrb.uTxxyrb3XfDtm', 'Sandra', 'Gabriel', 'Praça José Fontana', '1653-589', 'Lisboa', 'Portugal', '999888777', 1, 1, NULL, 1, '2022-05-29 15:39:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CATEGORY`
--
ALTER TABLE `CATEGORY`
  ADD PRIMARY KEY (`CODE`);

--
-- Indexes for table `OPTION_GROUP`
--
ALTER TABLE `OPTION_GROUP`
  ADD PRIMARY KEY (`PACK`,`CODE`);

--
-- Indexes for table `OPTION_PACK`
--
ALTER TABLE `OPTION_PACK`
  ADD PRIMARY KEY (`CODE`);

--
-- Indexes for table `PRODUCT`
--
ALTER TABLE `PRODUCT`
  ADD KEY `PROD_OPT-PA_FK` (`OPTION_PACK`);

--
-- Indexes for table `REVIEWS`
--
ALTER TABLE `REVIEWS`
  ADD PRIMARY KEY (`CODE`);

--
-- Indexes for table `TEST_ORDER`
--
ALTER TABLE `TEST_ORDER`
  ADD PRIMARY KEY (`CODE`);

--
-- Indexes for table `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `REVIEWS`
--
ALTER TABLE `REVIEWS`
  MODIFY `CODE` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `USERS`
--
ALTER TABLE `USERS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `OPTION_PACK`
--
ALTER TABLE `OPTION_PACK`
  ADD CONSTRAINT `OPT_PAGR_FK` FOREIGN KEY (`CODE`) REFERENCES `OPTION_GROUP` (`PACK`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PRODUCT`
--
ALTER TABLE `PRODUCT`
  ADD CONSTRAINT `PROD_OPT-PA_FK` FOREIGN KEY (`OPTION_PACK`) REFERENCES `OPTION_PACK` (`CODE`);
COMMIT;
