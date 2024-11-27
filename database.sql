-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Nov 27, 2024 alle 17:33
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chito`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `info` varchar(255) NOT NULL,
  `owner` int(11) NOT NULL,
  `sensors` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `devices`
--

INSERT INTO `devices` (`id`, `name`, `location`, `info`, `owner`, `sensors`) VALUES
(1, 'Chito boa', '{\"lat\":0,\"lon\":0,\"alt\":0,\"prec\":0}', '{\"battery\":100,\"cpu\":23,\"memory\":10,\"temp\":33.2}', 1, '[{key:\"temperature\",unit:\"°C\"},{key:\"conductivity\",unit:\"V\"}]'),
(2, 'Mauro SS', '{\"lat\":0,\"lon\":0,\"alt\":0,\"prec\":0}', '{\"battery\":0,\"cpu\":0,\"memory\":0,\"temp\":0}', 1, '[{key:\"sexyness\",unit:\"MC\"}]');

-- --------------------------------------------------------

--
-- Struttura della tabella `records`
--

CREATE TABLE `records` (
  `id` int(11) NOT NULL,
  `device` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `rkey` varchar(255) NOT NULL,
  `rvalue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `records`
--

INSERT INTO `records` (`id`, `device`, `date`, `rkey`, `rvalue`) VALUES
(1, 1, '2024-11-27 17:10:06', 'temperature', '22.5'),
(2, 1, '2024-11-27 17:10:20', 'temperature', '31.0'),
(3, 1, '2024-11-27 17:10:26', 'conductivity', '11'),
(4, 1, '2024-11-27 17:10:38', 'conductivity', '12');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `displayname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `displayname`) VALUES
(1, 'davide', '$2y$10$CG/0ZMvdTIAGb8rhCAG0ResJBXOlkxFw4aFki74a7AXZTR1lE5G.C', 'Davide Nadin');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `records`
--
ALTER TABLE `records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
