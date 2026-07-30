-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.0
-- Время создания: Дек 27 2025 г., 18:24
-- Версия сервера: 8.0.35
-- Версия PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `db_korochka_net`
--

-- --------------------------------------------------------

--
-- Структура таблицы `courses`
--

CREATE TABLE `courses` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `courses`
--

INSERT INTO `courses` (`id`, `title`, `price`) VALUES
(1, 'Основы алгоритмизации и программирования', 1000),
(2, 'Основы\r\nвеб-дизайна', 2000),
(3, 'Основы проектирования баз данных', 3000);

-- --------------------------------------------------------

--
-- Структура таблицы `payment_method`
--

CREATE TABLE `payment_method` (
  `id` int NOT NULL,
  `method` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `payment_method`
--

INSERT INTO `payment_method` (`id`, `method`) VALUES
(1, 'money'),
(2, 'card');

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `course_id` int NOT NULL,
  `payment_method_id` int NOT NULL,
  `date_start` date NOT NULL,
  `status_id` int NOT NULL DEFAULT '5',
  `review` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `date_review` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `course_id`, `payment_method_id`, `date_start`, `status_id`, `review`, `date_review`) VALUES
(1, 11, 2, 2, '2025-12-20', 7, 'привет я дениска', '2025-12-19'),
(2, 11, 2, 2, '2025-12-28', 6, NULL, NULL),
(3, 14, 1, 2, '2025-12-27', 6, NULL, NULL),
(4, 14, 1, 2, '2025-12-26', 7, NULL, NULL),
(5, 14, 1, 2, '2025-12-27', 6, NULL, NULL),
(6, 11, 3, 1, '2025-12-31', 5, NULL, NULL),
(7, 11, 1, 1, '2025-12-19', 6, 'вафывыфвыф выфвыфвфыв выфвфывыф', '2025-12-19'),
(8, 20, 1, 1, '2025-12-27', 5, NULL, NULL),
(9, 20, 3, 1, '2025-12-25', 5, NULL, NULL),
(10, 20, 2, 2, '2025-12-26', 7, NULL, NULL),
(11, 21, 1, 2, '2025-12-27', 7, 'fdsfsdfsdfdsfs', '2025-12-19'),
(12, 21, 2, 2, '2025-12-20', 6, NULL, NULL),
(13, 21, 3, 2, '2025-12-24', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `id` int NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `status`) VALUES
(5, 'new'),
(6, 'learning'),
(7, 'complete');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `fio` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role_id` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pwd`, `fio`, `phone`, `email`, `role_id`) VALUES
(1, 'Admin', 'KorokNET', '', '', '', 2),
(11, 'ivan12', '$2y$10$v7WSsjJYZi8XBGp5yD5PXuqkRCVoKb7zV9ZGmsRN/zpeIu9LwfVi.', 'выаа выаываыв ываыва', '323422323432', 'ivan@g.c', 1),
(12, 'dsadsdasasdadsadsd423423en3di2dn2jnsi2s2sddfsfd23', '$2y$10$m1rUMOYepSF74yW73jhcY.WiMW/PbA5uNWQffVZ9C9I07peHrjotK', 'аываывававыааывадвыдаьывдаывдаьдвы авдыдаывдлавыаьдыв адвылаьдывьаывьалывь', '74923749324723742394', 'dsadsadadssssssssssssssssssssssssssssssssssssssssssssssssssssssadas@gmail.cacas', 1),
(13, 'admink', '$2y$10$pl5WUadsrsDvJHof99a24OXyyyKzm2ZUtPtBdmAP.EAn6dlzZRsAy', 'Гуууууу Ыыыы ААА', '799999999999', 'artem@artem.com', 1),
(14, 'afasfd', '$2y$10$y.G45cuVXTtyop3Bw5L1sOlPiPrNtB6CnS6JhMv99Lp5ypaxN1VkS', 'АА АА АА', '15231512361236', 'afasf@afasmf.com', 1),
(15, 'dsadsad12312', '$2y$10$V5vdZVb9UvPc1/0pNo9XAuyEl8psN9mL0AUHpyZfnt2nSjqQ2BgaW', 'вфывфы вфывыфв фвыыф', '43342332432432', 'dsaasd@dsadasd.cas', 1),
(16, 'dsadsad1231das2', '$2y$10$AMkY3sDzD1A0GduK9hl6ge5YCEvkZ5uBcMs7Cy1XW8Xgb/jMAbYmS', 'вфывфы вфывыфв фвыыф', '43342332432432', 'dsaasd@dsadasd.cas', 1),
(17, 'dsadas123', '$2y$10$xh6a4/gdrwPagTVqyDeCFOLPaReM./4vxpj1EdUGtpiIo6QUcTe8C', 'вафы выф выв', '231312123123', 'dsdsa@dad.ds', 1),
(18, 'dasdasasdas', '$2y$10$RQWba4SM72HOSxDE6ZxZc.hB7h8QLWQ8yUaeQAJqdFEyewQfgDjw2', 'вфывф фывфы выфв', '21313213212', 'dsadsad@dsads.dsa', 1),
(19, 'das4324fds', '$2y$10$8tWKGCCw3nMSuOoyMkI/u.RHJ99OFUfiLWF95VEKnSRvD0OEdQs5K', 'аываыв аываыва аыавыа', '42343243324234', 'fffdsfdsddsf@sfdfsdf.fsdfds', 1),
(20, 'deniska123', '$2y$10$GWi8BDn8O8V3FWOShg2qCel9T3e/PVmVFxu2rmPAnkuPmNnfC2K2m', 'аыва ываыва ыавыв', '423423423432', 'leitenant_den@gmail.com', 1),
(21, 'bobaaa', '$2y$10$CIJVjiUvFCCnNs9vP/PVIOa2ioAwiVzNojdTsgLmPmTXicPBI0c6u', 'аывавы авыавы аываыва', '1232131313123', 'bob@g.c', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `payment_method_id` (`payment_method_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_ibfk_3` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_method` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
