-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2017 at 10:54 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `lname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `fname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `lname`, `fname`, `username`, `password`) VALUES
(1, 'Admin', 'Admin', 'admin1', 'e10adc3949ba59abbe56e057f20f883e'),
(2, 'Debeljak', 'Mateo', 'mateo', '18ac1b45e5df9da5bd141876f3dd453e');

-- --------------------------------------------------------

--
-- Table structure for table `dates`
--

CREATE TABLE `dates` (
  `id` int(11) NOT NULL,
  `dates` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dates`
--

INSERT INTO `dates` (`id`, `dates`) VALUES
(6, '10.11.2017.'),
(7, '16.11.2017.'),
(8, '05.12.2017.'),
(9, '14.12.2017.'),
(10, '21.12.2017.'),
(11, '11.01.2018.');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `value` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'MaxTeamMembers', '4'),
(2, 'MaxTeamsPerGroup', '6');

-- --------------------------------------------------------

--
-- Table structure for table `teamdates`
--

CREATE TABLE `teamdates` (
  `id` int(11) NOT NULL,
  `teamid` int(11) NOT NULL,
  `dateid` int(11) NOT NULL,
  `groups` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teamdates`
--

INSERT INTO `teamdates` (`id`, `teamid`, `dateid`, `groups`) VALUES
(11, 24, 6, 'g3'),
(12, 22, 6, 'g7'),
(25, 26, 11, 'g6');

-- --------------------------------------------------------

--
-- Table structure for table `teammembers`
--

CREATE TABLE `teammembers` (
  `id` int(11) NOT NULL,
  `teamid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teammembers`
--

INSERT INTO `teammembers` (`id`, `teamid`, `userid`) VALUES
(62, 16, 33),
(64, 16, 15),
(65, 16, 6),
(81, 22, 10),
(82, 22, 29),
(84, 24, 22),
(85, 25, 31),
(86, 25, 13),
(87, 26, 2),
(88, 26, 16),
(89, 26, 44),
(92, 28, 14),
(93, 28, 3);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `groups` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `groups`) VALUES
(16, 'Prvi tim', 'g1'),
(22, 'grupa', 'g7'),
(24, 'sama', 'g3'),
(25, 'proba', 'g3'),
(26, 'Diplomski', 'g6'),
(28, 'grupa 5', 'g5');

-- --------------------------------------------------------

--
-- Table structure for table `teamtopics`
--

CREATE TABLE `teamtopics` (
  `id` int(11) NOT NULL,
  `teamid` int(11) NOT NULL,
  `topicid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teamtopics`
--

INSERT INTO `teamtopics` (`id`, `teamid`, `topicid`) VALUES
(14, 16, 16),
(21, 24, 2),
(22, 26, 3);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `title`) VALUES
(1, 'Baze podataka'),
(2, 'MS Office'),
(3, 'Wordpress'),
(5, 'Upoteba alata Open Office u poslovanju'),
(7, 'Vrste zaslona'),
(8, 'Izrada baze podataka za studentsku evidenciju u programu MS Access (ili npr. auto-salon ili videoteku, ili auto-školu ili dr.)'),
(10, 'Youtube'),
(13, 'Uporaba alata MS Excel za obračun plaće radnika'),
(14, 'Dizajn i izrade baze podataka u alatu MS Access'),
(15, 'Izrada kalkulacije maloprodajne cijene proizvoda uz pomoć alata MS Excel'),
(16, 'Google Apps Script'),
(17, 'Usporedba aplikacija za organizaciju poslovanja'),
(18, 'Obrada slika s pomoću alata Pixlr na vlastitim primjerima'),
(19, 'Izrada stripa kao načina promocije'),
(20, 'Besplatne alternative MS Office-u'),
(22, 'Izrada obrasca putnog naloga koristeći alat MS Excel Upute: Napraviti obrazac putnog naloga na 3 radna lista: 1. list treba sadržavati opće podatke o putnom nalogu, 2. list obračun troškova, a 3. list izvješće s puta. Pritom treba obratiti pozornost na obvezne elemente koje svaki putni nalog mora sadržavati. Upisati formule kojima će se računati ukupni troškovi.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `groups` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `status`, `lname`, `fname`, `email`, `groups`, `password`) VALUES
(2, 'Izvanredan', 'Ivanović', 'Ivan', 'ivanovic3@efos.hr', 'g6', 'e10adc3949ba59abbe56e057f20f883e'),
(3, 'Izvanredan', 'Marković', 'Marko', 'mmarkov22@efos.hr', 'g5', 'fa08326d5ef9f391b25ee3df21f00cc7'),
(4, 'Redovan', 'Ivanović', 'Ana', 'aivanov@efos.hr', 'g4', '68b413c82915122e6c0a47a861497069'),
(5, 'Redovan', 'Horvat', 'Ivan', 'ihorvat@gmail.com', 'g2', '10067f208ac3409b0a1e72ab47f8da3a'),
(6, 'Redovan', 'Čolić', 'Toni', 'tcolic1@efos.hr', 'g1', 'e10adc3949ba59abbe56e057f20f883e'),
(7, 'Izvanredan', 'Duvnjak', 'Ivana', 'iduvnj1@efos.hr', 'g7', '26b067c1daf5e608e89582053a83b985'),
(8, 'Redovan', 'Kontić', 'Karla', 'kkontic@efos.hr', 'g2', 'edb2918db6670ef7495e03d29999da5f'),
(10, 'Redovan', 'Bilić', 'Martina', 'mbilic5@efos.hr', 'g7', 'e10adc3949ba59abbe56e057f20f883e'),
(11, 'Redovan', 'Novak', 'Ivano', 'inovak@efos.hr', 'g2', 'e10adc3949ba59abbe56e057f20f883e'),
(12, 'Redovan', 'Ćosić', 'Tin', 'tcosic2@efos.hr', 'g3', 'e10adc3949ba59abbe56e057f20f883e'),
(13, 'Redovan', 'Kovačević', 'Matea', 'mkovac3@efos.hr', 'g3', '8de15fa6a0fe944ece519bcc7cea5f63'),
(14, 'Redovan', 'Babić', 'Kristijan', 'kbabic@efos.hr', 'g5', 'e10adc3949ba59abbe56e057f20f883e'),
(15, 'Redovan', 'Marić', 'Jurica', 'jmaric@efos.hr', 'g1', 'e10adc3949ba59abbe56e057f20f883e'),
(16, 'Redovan', 'Pavlinek', 'Marin', 'mpavl2@efos.hr', 'g6', 'f28214b14d74944ecb00e7ad828803c9'),
(18, 'Redovan', 'Martić', 'Sanja', 'smatric@efos.hr', 'g1', 'd04d19b96bafee34c986ee71681f3f06'),
(21, 'Redovan', 'Kramarić', 'Ante', 'akrama@efos.hr', 'g4', 'd648e2f133ee14426100ca60b530687f'),
(22, 'Izvanredan', 'Kant', 'Anja', 'akant1@efos.hr', 'g3', 'e10adc3949ba59abbe56e057f20f883e'),
(23, 'Redovan', 'Ćović', 'Ivan', 'icovic@efos.hr', 'g1', 'e10adc3949ba59abbe56e057f20f883e'),
(24, 'Izvanredan', 'Duboš Ivić', 'Ana-Marija', 'dubiv@efos.hr', 'g6', 'e10adc3949ba59abbe56e057f20f883e'),
(26, 'Redovan', 'Test', 'Luka ', 'test@efos.hr', 'g3', '40aea2f38665653172cff1b8a4286bd1'),
(29, 'Redovan', 'Rak', 'Sara', 'sararak@efos.hr', 'g7', '752d6a4d8520a923a4f05e5a4e22b94c'),
(30, 'Redovan', 'Kaniški', 'Mihaela', 'mkaniski@efos.hr', 'g5', 'e10adc3949ba59abbe56e057f20f883e'),
(31, 'Redovan', 'Mrkonjić', 'Vedran', 'vedran.mrki@hotmail.com', 'g3', '8aa87050051efe26091a13dbfdf901c6'),
(33, 'Redovan', 'Bošnjaković', 'Marko', 'marko.bosnjakovic@gmail.com', 'g1', '4297f44b13955235245b2497399d7a93'),
(34, 'Redovan', 'Tonkovac', 'Sandra', 'stonkovac@efos.hr', 'g5', '59162c107a793e56ac6a5bc1525a30a9'),
(35, 'Redovan', 'Debeljak', 'Andrea', 'andrea-snk@hotmail.com', 'g1', 'e10adc3949ba59abbe56e057f20f883e'),
(36, 'Redovan', 'Perić', 'Pero', 'pperic@efos.hr', 'g6', 'e10adc3949ba59abbe56e057f20f883e'),
(37, 'Redovan', 'Jurić', 'Ivan', 'ijuric@efos.hr', 'g1', 'e10adc3949ba59abbe56e057f20f883e'),
(38, 'Izvanredan', 'Kovačević', 'Anita', 'akovac3@efos.hr', 'g1', '8de15fa6a0fe944ece519bcc7cea5f63'),
(39, 'Redovan', 'Miličević', 'Ivana', 'imilicev@efos.hr', 'g1', 'c9d1cafe7f668ae0a4c748cf8ee119c4'),
(40, 'Redovan', 'Malčić', 'Zdravko', 'zmalcic@efos.hr', 'g1', 'e063ebe103751e3d849d0dc88b267334'),
(41, 'Izvanredan', 'Horvat', 'Ines', 'ihorv6@efos.hr', 'g1', '10067f208ac3409b0a1e72ab47f8da3a'),
(42, 'Redovan', 'Balić', 'Matej', 'mbalic@efos.hr', 'g2', 'e10adc3949ba59abbe56e057f20f883e'),
(43, 'Redovan', 'Hlevnjak', 'Katarina', 'khlevn1@efos.hr', 'g6', 'aa1da4918a48503d125ee3325c7f135e'),
(44, 'Izvanredan', 'Klaić', 'Gordan', 'gklaic@efos.hr', 'g6', 'e10adc3949ba59abbe56e057f20f883e'),
(45, 'Redovan', 'korisnik', 'novi', '123@efos.hr', 'g6', 'e10adc3949ba59abbe56e057f20f883e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`username`);

--
-- Indexes for table `dates`
--
ALTER TABLE `dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teamdates`
--
ALTER TABLE `teamdates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teamid` (`teamid`),
  ADD KEY `dateid` (`dateid`);

--
-- Indexes for table `teammembers`
--
ALTER TABLE `teammembers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `teamid` (`teamid`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teamtopics`
--
ALTER TABLE `teamtopics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teamid` (`teamid`),
  ADD KEY `topicid` (`topicid`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `dates`
--
ALTER TABLE `dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `teamdates`
--
ALTER TABLE `teamdates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `teammembers`
--
ALTER TABLE `teammembers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `teamtopics`
--
ALTER TABLE `teamtopics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `teamdates`
--
ALTER TABLE `teamdates`
  ADD CONSTRAINT `teamdates_ibfk_1` FOREIGN KEY (`teamid`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `teamdates_ibfk_2` FOREIGN KEY (`dateid`) REFERENCES `dates` (`id`);

--
-- Constraints for table `teammembers`
--
ALTER TABLE `teammembers`
  ADD CONSTRAINT `teammembers_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `teammembers_ibfk_2` FOREIGN KEY (`teamid`) REFERENCES `teams` (`id`);

--
-- Constraints for table `teamtopics`
--
ALTER TABLE `teamtopics`
  ADD CONSTRAINT `teamtopics_ibfk_1` FOREIGN KEY (`teamid`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `teamtopics_ibfk_2` FOREIGN KEY (`topicid`) REFERENCES `topics` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
