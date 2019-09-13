-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Час створення: Сер 23 2019 р., 12:23
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
  `email` varchar(320) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `photo_id` bigint(20) UNSIGNED NOT NULL,
  `like_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Тригери `likes`
--
CREATE TRIGGER increment_likes_count AFTER INSERT ON likes FOR EACH ROW
BEGIN
    IF NEW.like_status = TRUE THEN
        UPDATE photo SET likes = likes + 1 WHERE id = NEW.photo_id;
    ELSE
        UPDATE photo SET dislikes = dislikes + 1 WHERE id = NEW.photo_id;
    END IF;
END;


CREATE TRIGGER update_likes_count AFTER UPDATE ON likes FOR EACH ROW
BEGIN
    IF NEW.like_status = TRUE THEN
        UPDATE photo
        SET likes = likes + 1, dislikes = dislikes - 1
        WHERE id = NEW.photo_id;
    ELSE
        UPDATE photo
        SET likes = likes - 1, dislikes = dislikes + 1
        WHERE id = NEW.photo_id;
    END IF;
END;


CREATE TRIGGER decrement_likes_count AFTER DELETE ON likes FOR EACH ROW
BEGIN
    IF OLD.like_status = TRUE THEN
        UPDATE photo SET likes = likes - 1 WHERE id = OLD.photo_id;
    ELSE
        UPDATE photo SET dislikes = dislikes - 1 WHERE id = OLD.photo_id;
    END IF;
END;

-- --------------------------------------------------------

--
-- Структура таблиці `password_reset`
--

CREATE TABLE `password_reset` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(320) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `photo`
--

CREATE TABLE `photo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `img` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `likes` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `dislikes` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `photo`
--

INSERT INTO `photo` (`id`, `user_id`, `img`, `likes`, `dislikes`) VALUES
(8, 10, '/uploads/5d5e9aa02ac92.png', 0, 0),
(13, 10, '/uploads/5d5edd19a1f8a.jpg', 0, 0),
(14, 10, '/uploads/5d5ede63d66bd.jpg', 0, 0),
(15, 10, '/uploads/5d5ffd8d17a2d.png', 0, 0),
(16, 10, '/uploads/5d5ffd9d14448.jpg', 0, 0),
(17, 10, '/uploads/5d5ffda69beea.jpg', 0, 0),
(18, 10, '/uploads/5d5ffdba6fc5d.png', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблиці `photo_comment`
--

CREATE TABLE `photo_comment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `photo_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `login` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(320) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `vkey` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notifications` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `email`, `verified`, `vkey`, `notifications`) VALUES
(10, 'prippa', '$2y$10$gvc4Pv5ZokxNrAiKqBKkFu3mRxd0iBO/dvGa.nFC/f7tOP6HcyvZy', 'pavelrippa@gmail.com', 1, '1a1566c986796727b6e6025d6b0960cd', 1),
(11, 'katya', '$2y$10$cjGDcK2qgrKnYBQTDN05I.K6h84MzMzuFOn9zUdk1i.53CDyzo0F2', 'katya.osadchuk@gmail.com', 1, '37664b3c699fa039a277c807bf6e641b', 1);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `email_reset`
--
ALTER TABLE `email_reset`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photo_id` (`photo_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Індекси таблиці `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Індекси таблиці `photo_comment`
--
ALTER TABLE `photo_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photo_id` (`photo_id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT для таблиці `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT для таблиці `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблиці `photo`
--
ALTER TABLE `photo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблиці `photo_comment`
--
ALTER TABLE `photo_comment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблиці `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Обмеження зовнішнього ключа таблиці `photo_comment`
--
ALTER TABLE `photo_comment`
  ADD CONSTRAINT `photo_comment_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `photo_comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;


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

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
