-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: mysql62.mydevil.net
-- Czas generowania: 12 Gru 2023, 12:55
-- Wersja serwera: 8.0.33
-- Wersja PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `m1039_roulette_demo`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pools`
--

CREATE TABLE `pools` (
  `id` int NOT NULL,
  `pool` varchar(255) NOT NULL,
  `pool_members` int NOT NULL,
  `date_last_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `pool_status` varchar(255) NOT NULL,
  `date_will_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Zrzut danych tabeli `pools`
--

INSERT INTO `pools` (`id`, `pool`, `pool_members`, `date_last_update`, `pool_status`, `date_will_end`) VALUES
(1, '140', 3, '2023-12-12 11:28:51', 'active', '2023-12-31');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pools_members`
--

CREATE TABLE `pools_members` (
  `id` int NOT NULL,
  `pool_id` int DEFAULT NULL,
  `member_id` int DEFAULT NULL,
  `session_id` varchar(255) NOT NULL,
  `added_to_pool` decimal(10,2) NOT NULL,
  `added_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Zrzut danych tabeli `pools_members`
--

INSERT INTO `pools_members` (`id`, `pool_id`, `member_id`, `session_id`, `added_to_pool`, `added_date`) VALUES
(19, 1, 0, 'c68114a28766d534868121f98d7a53ed', '100.00', '2023-12-12 04:30:39'),
(20, 1, 0, '1046d452276f429e9301f71c9702af19', '25.00', '2023-12-12 11:19:10'),
(21, 1, 0, '1542169e0314f78552f05337714680bc', '15.00', '2023-12-12 11:28:51');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `user_balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `session_id`, `user_balance`) VALUES
(5, 'c68114a28766d534868121f98d7a53ed', '1900.00'),
(6, '1046d452276f429e9301f71c9702af19', '1975.00'),
(7, '1542169e0314f78552f05337714680bc', '1985.00');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `pools`
--
ALTER TABLE `pools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indeksy dla tabeli `pools_members`
--
ALTER TABLE `pools_members`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `member_id` (`member_id`),
  ADD KEY `id` (`id`),
  ADD KEY `pool_id` (`pool_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `pools`
--
ALTER TABLE `pools`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `pools_members`
--
ALTER TABLE `pools_members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `pools_members`
--
ALTER TABLE `pools_members`
  ADD CONSTRAINT `pools_members_ibfk_1` FOREIGN KEY (`pool_id`) REFERENCES `pools` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
