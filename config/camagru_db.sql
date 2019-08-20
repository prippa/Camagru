-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Час створення: Сер 20 2019 р., 07:50
-- Версія сервера: 8.0.16
-- Версія PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `camagru_db`
--

-- --------------------------------------------------------

--
-- Структура таблиці `email_reset`
--

CREATE TABLE `email_reset` (
                               `id` bigint(20) UNSIGNED NOT NULL,
                               `email` varchar(320) NOT NULL,
                               `token` char(32) NOT NULL,
                               `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `password_reset`
--

CREATE TABLE `password_reset` (
                                  `id` bigint(20) UNSIGNED NOT NULL,
                                  `email` varchar(320) NOT NULL,
                                  `token` char(32) NOT NULL,
                                  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `user`
--

CREATE TABLE `user` (
                        `id` bigint(20) UNSIGNED NOT NULL,
                        `login` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                        `password` char(255) NOT NULL,
                        `email` varchar(320) NOT NULL,
                        `verified` tinyint(1) NOT NULL DEFAULT '0',
                        `vkey` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                        `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `notifications` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `email`, `verified`, `vkey`, `notifications`) VALUES
(10, 'prippa', '$2y$10$BPG3yC50PW7gFnk8hJEsiOdbbMwD7Nfj/wDkct0Af6WCIueOLCzEq', 'pavelrippa@gmail.com', 1, '1a1566c986796727b6e6025d6b0960cd', 1);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `email_reset`
--
ALTER TABLE `email_reset`
    ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `password_reset`
--
ALTER TABLE `password_reset`
    ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `email_reset`
--
ALTER TABLE `email_reset`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблиці `password_reset`
--
ALTER TABLE `password_reset`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблиці `user`
--
ALTER TABLE `user`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;




--
-- Events
--
CREATE EVENT delete_unconfirmed_users
    ON SCHEDULE
        EVERY 1 DAY
            STARTS (TIMESTAMP(CURRENT_DATE) + INTERVAL 1 DAY + INTERVAL 1 HOUR)
    DO
    DELETE FROM user WHERE `verified` = '0' AND `create_date` < NOW() - INTERVAL 1 DAY;

CREATE EVENT delete_unconfirmed_password_reset
    ON SCHEDULE
        EVERY 3 HOUR
            STARTS (TIMESTAMP(CURRENT_DATE) + INTERVAL 1 DAY + INTERVAL 1 HOUR)
    DO
    DELETE FROM password_reset WHERE `create_date` < NOW() - INTERVAL 3 HOUR;

CREATE EVENT delete_unconfirmed_email_reset
    ON SCHEDULE
        EVERY 3 HOUR
            STARTS (TIMESTAMP(CURRENT_DATE) + INTERVAL 1 DAY + INTERVAL 1 HOUR)
    DO
    DELETE FROM email_reset WHERE `create_date` < NOW() - INTERVAL 3 HOUR;
