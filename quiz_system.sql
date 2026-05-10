-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 10/05/2026 às 23:49
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `quiz_system`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_text` varchar(255) NOT NULL,
  `answer_text_en` varchar(255) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer_text`, `answer_text_en`, `is_correct`) VALUES
(1, 1, 'Londres', 'Londres', 0),
(2, 1, 'Berlim', 'Berlim', 0),
(3, 1, 'Paris', 'Paris', 1),
(4, 1, 'Madrid', 'Madrid', 0),
(5, 2, 'Oceano Atlântico', 'Oceano Atlântico', 0),
(6, 2, 'Oceano Índico', 'Oceano Índico', 0),
(7, 2, 'Oceano Pacífico', 'Oceano Pacífico', 1),
(8, 2, 'Oceano Ártico', 'Oceano Ártico', 0),
(9, 3, 'Van Gogh', 'Van Gogh', 0),
(10, 3, 'Picasso', 'Picasso', 0),
(11, 3, 'Da Vinci', 'Da Vinci', 1),
(12, 3, 'Rembrandt', 'Rembrandt', 0),
(13, 4, 'Ag', 'Ag', 0),
(14, 4, 'Fe', 'Fe', 0),
(15, 4, 'Au', 'Au', 1),
(16, 4, 'Cu', 'Cu', 0),
(17, 5, '5', '5', 0),
(18, 5, '6', '6', 0),
(19, 5, '7', '7', 1),
(20, 5, '8', '8', 0),
(21, 6, 'Computer Style Sheets', 'Computer Style Sheets', 0),
(22, 6, 'Creative Style Sheets', 'Creative Style Sheets', 0),
(23, 6, 'Cascading Style Sheets', 'Cascading Style Sheets', 1),
(24, 6, 'Colorful Style Sheets', 'Colorful Style Sheets', 0),
(25, 7, 'Python', 'Python', 0),
(26, 7, 'Java', 'Java', 0),
(27, 7, 'JavaScript', 'JavaScript', 1),
(28, 7, 'PHP', 'PHP', 0),
(29, 8, 'Personal Home Page', 'Personal Home Page', 0),
(30, 8, 'PHP: Hypertext Preprocessor', 'PHP: Hypertext Preprocessor', 1),
(31, 8, 'Preprocessed Hypertext Page', 'Preprocessed Hypertext Page', 0),
(32, 8, 'Professional Home Page', 'Professional Home Page', 0),
(33, 9, 'Laravel', 'Laravel', 0),
(34, 9, 'Django', 'Django', 0),
(35, 9, 'Angular', 'Angular', 1),
(36, 9, 'Spring Boot', 'Spring Boot', 0),
(37, 10, 'GET', 'GET', 1),
(38, 10, 'SEND', 'SEND', 0),
(39, 10, 'FETCH', 'FETCH', 0),
(40, 10, 'REQUEST', 'REQUEST', 0),
(41, 11, 'Isaac Newton', 'Isaac Newton', 0),
(42, 11, 'Galileu Galilei', 'Galileu Galilei', 0),
(43, 11, 'Albert Einstein', 'Albert Einstein', 1),
(44, 11, 'Nikola Tesla', 'Nikola Tesla', 0),
(45, 12, 'Vénus', 'Vénus', 0),
(46, 12, 'Terra', 'Terra', 0),
(47, 12, 'Marte', 'Marte', 0),
(48, 12, 'Mercúrio', 'Mercúrio', 1),
(49, 13, 'Artificial Intelligence', 'Artificial Intelligence', 1),
(50, 13, 'Automated Interface', 'Automated Interface', 0),
(51, 13, 'Algorithmic Input', 'Algorithmic Input', 0),
(52, 13, 'Advanced Integration', 'Advanced Integration', 0),
(53, 14, 'Apple', 'Apple', 0),
(54, 14, 'Microsoft', 'Microsoft', 0),
(55, 14, 'Google', 'Google', 1),
(56, 14, 'Samsung', 'Samsung', 0),
(57, 15, 'HTML', 'HTML', 0),
(58, 15, 'Python', 'Python', 1),
(59, 15, 'CSS', 'CSS', 0),
(60, 15, 'JSON', 'JSON', 0),
(61, 16, 'Benguela', 'Benguela', 0),
(62, 16, 'Huambo', 'Huambo', 0),
(63, 16, 'Luanda', 'Luanda', 1),
(64, 16, 'Lubango', 'Lubango', 0),
(65, 17, '1974', '1974', 0),
(66, 17, '1975', '1975', 1),
(67, 17, '1976', '1976', 0),
(68, 17, '1977', '1977', 0),
(69, 18, 'José Eduardo dos Santos', 'José Eduardo dos Santos', 0),
(70, 18, 'João Lourenço', 'João Lourenço', 0),
(71, 18, 'Agostinho Neto', 'Agostinho Neto', 1),
(72, 18, 'Holden Roberto', 'Holden Roberto', 0),
(73, 19, 'Rio Kwanza', 'Rio Kwanza', 1),
(74, 19, 'Rio Cunene', 'Rio Cunene', 0),
(75, 19, 'Rio Zambeze', 'Rio Zambeze', 0),
(76, 19, 'Rio Congo', 'Rio Congo', 0),
(77, 20, 'Zulu', 'Zulu', 0),
(78, 20, 'Xhosa', 'Xhosa', 0),
(79, 20, 'Umbundu', 'Umbundu', 1),
(80, 20, 'Maasai', 'Maasai', 0),
(81, 21, 'Nocturna', 'Nocturna', 0),
(82, 21, 'Uncle Eli', 'Uncle Eli', 1),
(83, 21, 'Cadence', 'Cadence', 0),
(84, 22, 'Open Room', 'Open Room', 0),
(85, 22, 'Loft', 'Loft', 0),
(86, 22, 'Parlor', 'Parlor', 1),
(87, 22, 'Sitting Room', 'Sitting Room', 0),
(88, 21, 'Octavian (Bard)', 'Octavian (Bard)', 0),
(89, 23, 'Washington D.C.', 'Washington D.C.', 0),
(90, 23, 'Olympia', 'Olympia', 1),
(91, 24, '481', '481', 0),
(92, 23, 'Seattle', 'Seattle', 0),
(93, 23, 'Yukon', 'Yukon', 0),
(94, 25, '6', '6', 0),
(95, 24, '244', '244', 1),
(96, 24, '94', '94', 0),
(97, 24, '128', '128', 0),
(98, 25, '5', '5', 0),
(99, 25, '3', '3', 0),
(100, 25, '4', '4', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `attempt_details`
--

CREATE TABLE `attempt_details` (
  `id` int(11) NOT NULL,
  `attempt_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_answer_id` int(11) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT 0,
  `points_earned` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `attempt_details`
--

INSERT INTO `attempt_details` (`id`, `attempt_id`, `question_id`, `selected_answer_id`, `is_correct`, `points_earned`) VALUES
(1, 1, 1, 3, 1, 1),
(2, 1, 2, 11, 1, 1),
(3, 1, 3, 15, 1, 1),
(4, 1, 4, 18, 1, 1),
(5, 1, 5, 22, 0, 0),
(6, 2, 6, 27, 1, 1),
(7, 2, 7, 31, 1, 1),
(8, 2, 8, 35, 1, 1),
(9, 2, 9, 39, 1, 1),
(10, 2, 10, 41, 1, 1),
(11, 3, 16, 63, 1, 1),
(12, 3, 17, 67, 1, 1),
(13, 3, 18, 71, 1, 1),
(14, 3, 19, 74, 0, 0),
(15, 3, 20, 78, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_text_en` text DEFAULT NULL,
  `question_type` enum('multiple_choice','true_false') DEFAULT 'multiple_choice',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `question_text_en`, `question_type`, `created_at`) VALUES
(1, 1, 'Qual é a capital da França?', 'Qual é a capital da França?', 'multiple_choice', '2026-05-10 17:51:01'),
(2, 1, 'Qual é o maior oceano do mundo?', 'Qual é o maior oceano do mundo?', 'multiple_choice', '2026-05-10 17:51:01'),
(3, 1, 'Quem pintou a Mona Lisa?', 'Quem pintou a Mona Lisa?', 'multiple_choice', '2026-05-10 17:51:02'),
(4, 1, 'Qual é o símbolo químico do ouro?', 'Qual é o símbolo químico do ouro?', 'multiple_choice', '2026-05-10 17:51:02'),
(5, 1, 'Quantos continentes existem?', 'Quantos continentes existem?', 'multiple_choice', '2026-05-10 17:51:02'),
(6, 2, 'O que significa CSS?', 'O que significa CSS?', 'multiple_choice', '2026-05-10 17:51:02'),
(7, 2, 'Qual linguagem é usada para criar interatividade no navegador?', 'Qual linguagem é usada para criar interatividade no navegador?', 'multiple_choice', '2026-05-10 17:51:02'),
(8, 2, 'O que significa PHP?', 'O que significa PHP?', 'multiple_choice', '2026-05-10 17:51:02'),
(9, 2, 'Qual framework é usado para criar componentes reutilizáveis no frontend?', 'Qual framework é usado para criar componentes reutilizáveis no frontend?', 'multiple_choice', '2026-05-10 17:51:02'),
(10, 2, 'Qual destes é um formato de requisição HTTP?', 'Qual destes é um formato de requisição HTTP?', 'multiple_choice', '2026-05-10 17:51:02'),
(11, 3, 'Quem desenvolveu a teoria da relatividade?', 'Quem desenvolveu a teoria da relatividade?', 'multiple_choice', '2026-05-10 17:51:02'),
(12, 3, 'Qual é o planeta mais próximo do Sol?', 'Qual é o planeta mais próximo do Sol?', 'multiple_choice', '2026-05-10 17:51:03'),
(13, 3, 'O que significa \"AI\"?', 'O que significa \"AI\"?', 'multiple_choice', '2026-05-10 17:51:03'),
(14, 3, 'Qual empresa criou o sistema operativo Android?', 'Qual empresa criou o sistema operativo Android?', 'multiple_choice', '2026-05-10 17:51:03'),
(15, 3, 'Qual destas é uma linguagem de programação?', 'Qual destas é uma linguagem de programação?', 'multiple_choice', '2026-05-10 17:51:03'),
(16, 4, 'Qual é a capital de Angola?', 'Qual é a capital de Angola?', 'multiple_choice', '2026-05-10 17:51:03'),
(17, 4, 'Em que ano Angola conquistou a independência?', 'Em que ano Angola conquistou a independência?', 'multiple_choice', '2026-05-10 17:51:03'),
(18, 4, 'Quem foi o primeiro presidente de Angola?', 'Quem foi o primeiro presidente de Angola?', 'multiple_choice', '2026-05-10 17:51:03'),
(19, 4, 'Qual é o rio mais extenso de Angola?', 'Qual é o rio mais extenso de Angola?', 'multiple_choice', '2026-05-10 17:51:03'),
(20, 4, 'Qual destes é um grupo étnico de Angola?', 'Qual destes é um grupo étnico de Angola?', 'multiple_choice', '2026-05-10 17:51:04'),
(21, 5, 'Which Crypt of the NecroDancer (2015) character has a soundtrack by Jake \"Virt\" Kaufman?', 'Which Crypt of the NecroDancer (2015) character has a soundtrack by Jake \"Virt\" Kaufman?', 'multiple_choice', '2026-05-10 20:57:32'),
(22, 5, 'Before the 19th Century, the \"Living Room\" was originally called the...', 'Before the 19th Century, the \"Living Room\" was originally called the...', 'multiple_choice', '2026-05-10 20:57:32'),
(23, 5, 'What is the capital of the State of Washington, United States?', 'What is the capital of the State of Washington, United States?', 'multiple_choice', '2026-05-10 20:57:33'),
(24, 5, 'What is the standard atomic weight of a Plutonium nucleus?', 'What is the standard atomic weight of a Plutonium nucleus?', 'multiple_choice', '2026-05-10 20:57:33'),
(25, 5, 'In Chemistry, how many isomers does Butanol (C4H9OH) have?', 'In Chemistry, how many isomers does Butanol (C4H9OH) have?', 'multiple_choice', '2026-05-10 20:57:33');

-- --------------------------------------------------------

--
-- Estrutura para tabela `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `title_en` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `quizzes`
--

INSERT INTO `quizzes` (`id`, `title`, `title_en`, `description`, `description_en`, `created_by`, `created_at`) VALUES
(1, 'Conhecimentos Gerais', 'Conhecimentos Gerais', 'Teste os seus conhecimentos em várias áreas do saber', 'Teste os seus conhecimentos em várias áreas do saber', 1, '2026-05-10 17:51:01'),
(2, 'Programação Web', 'Programação Web', 'Perguntas sobre HTML, CSS, JavaScript, PHP e Angular', 'Perguntas sobre HTML, CSS, JavaScript, PHP e Angular', 1, '2026-05-10 17:51:01'),
(3, 'Ciência e Tecnologia', 'Ciência e Tecnologia', 'Explore o mundo da ciência e inovações tecnológicas', 'Explore o mundo da ciência e inovações tecnológicas', 1, '2026-05-10 17:51:01'),
(4, 'História de Angola', 'História de Angola', 'Perguntas sobre a história e cultura angolana', 'Perguntas sobre a história e cultura angolana', 1, '2026-05-10 17:51:01'),
(5, 'Livros que mais influenciaram as gerações', 'Livros que mais influenciaram as gerações', '', '', 1, '2026-05-10 20:56:21');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','user') DEFAULT 'user',
  `reset_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `reset_token`, `created_at`) VALUES
(1, 'Palmira Nzau', 'palmiranzau@gmail.com', '$2y$10$t6tXrhKwvoNyrR.tHqnNaOXWZhfUwdjowp3S5MkqWGzKbFsQ/dK62', 'admin', NULL, '2026-05-10 11:11:04'),
(2, 'Zuko ', 'zuko@gmail.com', '$2y$10$t6tXrhKwvoNyrR.tHqnNaOXWZhfUwdjowp3S5MkqWGzKbFsQ/dK62', 'admin', NULL, '2026-05-10 17:51:01'),
(3, 'Carlos Silva', 'carlossilva@gmail.com', '$2y$10$HPzptFvO5XnFkGa.R7GCm.h5ih1mnp1ytM93pquDe3KKi5l0ZWBZe', 'user', NULL, '2026-05-10 17:51:01'),
(4, 'Mariana Santos', 'marianasantos@gmail.com', '$2y$10$HPzptFvO5XnFkGa.R7GCm.h5ih1mnp1ytM93pquDe3KKi5l0ZWBZe', 'user', NULL, '2026-05-10 17:51:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `user_quiz_attempts`
--

CREATE TABLE `user_quiz_attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `attempt_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_score` int(11) DEFAULT 0,
  `max_possible_score` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `user_quiz_attempts`
--

INSERT INTO `user_quiz_attempts` (`id`, `user_id`, `quiz_id`, `attempt_date`, `total_score`, `max_possible_score`) VALUES
(1, 2, 1, '2026-05-10 17:51:04', 4, 5),
(2, 3, 2, '2026-05-10 17:51:04', 5, 5),
(3, 2, 4, '2026-05-10 17:51:04', 3, 5);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Índices de tabela `attempt_details`
--
ALTER TABLE `attempt_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attempt_id` (`attempt_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `selected_answer_id` (`selected_answer_id`);

--
-- Índices de tabela `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Índices de tabela `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `user_quiz_attempts`
--
ALTER TABLE `user_quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de tabela `attempt_details`
--
ALTER TABLE `attempt_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `user_quiz_attempts`
--
ALTER TABLE `user_quiz_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `attempt_details`
--
ALTER TABLE `attempt_details`
  ADD CONSTRAINT `attempt_details_ibfk_1` FOREIGN KEY (`attempt_id`) REFERENCES `user_quiz_attempts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attempt_details_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attempt_details_ibfk_3` FOREIGN KEY (`selected_answer_id`) REFERENCES `answers` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `user_quiz_attempts`
--
ALTER TABLE `user_quiz_attempts`
  ADD CONSTRAINT `user_quiz_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_quiz_attempts_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
