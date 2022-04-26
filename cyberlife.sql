-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Abr-2022 às 15:48
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cyberlife`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `creation` datetime NOT NULL,
  `unread` varchar(6) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `chats`
--

INSERT INTO `chats` (`id`, `sender_id`, `receiver_id`, `message`, `image`, `creation`, `unread`) VALUES
(184, 14, 15, 'Boa Noite!', NULL, '2022-04-26 00:46:31', 'true'),
(185, 15, 14, 'Boa noite como vai?', NULL, '2022-04-26 00:46:50', 'true'),
(186, 14, 15, 'Tudo bem e você?', NULL, '2022-04-26 00:47:04', 'true'),
(187, 21, 7, 'Olá Boa Noite!!', NULL, '2022-04-26 00:49:36', 'true'),
(188, 7, 21, 'Boa noite tudo bem?', NULL, '2022-04-26 00:53:24', 'true'),
(189, 21, 7, 'sim e com você?', NULL, '2022-04-26 00:53:39', 'true'),
(190, 7, 21, 'Bem também', NULL, '2022-04-26 00:53:54', 'true'),
(191, 3, 21, 'Bom Dia !!!', NULL, '2022-04-26 09:18:49', 'false'),
(192, 3, 4, 'Como vai?', NULL, '2022-04-26 09:57:01', 'true'),
(193, 4, 3, 'Bem e você?', NULL, '2022-04-26 09:59:57', 'true'),
(194, 3, 4, NULL, 'e6ed2f9e7d023a74463d0cae9e6f767f.jpg', '2022-04-26 10:00:42', 'true');

-- --------------------------------------------------------

--
-- Estrutura da tabela `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `main_user` int(11) NOT NULL,
  `other_user` int(11) NOT NULL,
  `unread` varchar(10) NOT NULL,
  `modification` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `conversations`
--

INSERT INTO `conversations` (`id`, `main_user`, `other_user`, `unread`, `modification`, `creation`) VALUES
(33, 14, 15, 'false', '2022-04-26 03:47:04', '2022-04-26 00:46:22'),
(34, 15, 14, 'true', '2022-04-26 03:47:11', '2022-04-26 00:46:22'),
(35, 21, 7, 'true', '2022-04-26 03:53:42', '2022-04-26 00:49:27'),
(36, 7, 21, 'true', '2022-04-26 03:54:03', '2022-04-26 00:49:27'),
(37, 3, 21, 'false', '2022-04-26 12:18:49', '2022-04-26 09:18:41'),
(38, 21, 3, 'true', '2022-04-26 12:18:41', '2022-04-26 09:18:41'),
(39, 3, 4, 'true', '2022-04-26 13:01:32', '2022-04-26 09:56:53'),
(40, 4, 3, 'true', '2022-04-26 13:00:10', '2022-04-26 09:56:53');

-- --------------------------------------------------------

--
-- Estrutura da tabela `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `user_receiver` int(11) NOT NULL,
  `user_sender` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `unread` varchar(6) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `user_receiver`, `user_sender`, `create_at`, `post_id`, `unread`) VALUES
(125, 'love', 3, 4, '2022-04-26 00:23:06', 53, 'true'),
(126, 'commented', 3, 4, '2022-04-26 00:23:15', 53, 'true'),
(127, 'love', 4, 3, '2022-04-26 00:24:25', 54, 'true'),
(128, 'commented', 4, 3, '2022-04-26 00:24:48', 54, 'true'),
(129, 'follow', 3, 6, '2022-04-26 00:26:13', 0, 'true'),
(130, 'commented', 3, 6, '2022-04-26 00:26:39', 53, 'true'),
(131, 'follow', 6, 15, '2022-04-26 00:31:06', 0, 'false'),
(132, 'love', 6, 15, '2022-04-26 00:31:08', 55, 'false'),
(133, 'commented', 6, 15, '2022-04-26 00:31:11', 55, 'false'),
(134, 'love', 15, 6, '2022-04-26 00:34:36', 56, 'false'),
(135, 'commented', 15, 6, '2022-04-26 00:34:58', 56, 'false'),
(136, 'love', 7, 15, '2022-04-26 00:37:04', 57, 'false'),
(137, 'follow', 15, 14, '2022-04-26 00:45:44', 0, 'false'),
(138, 'follow', 21, 14, '2022-04-26 00:45:50', 0, 'true'),
(139, 'follow', 6, 14, '2022-04-26 00:45:56', 0, 'false'),
(140, 'follow', 3, 14, '2022-04-26 00:46:02', 0, 'true'),
(141, 'follow', 4, 14, '2022-04-26 00:46:06', 0, 'true'),
(142, 'love', 4, 14, '2022-04-26 00:46:10', 54, 'true'),
(143, 'follow', 21, 3, '2022-04-26 09:18:38', 0, 'false');

-- --------------------------------------------------------

--
-- Estrutura da tabela `postcomments`
--

CREATE TABLE `postcomments` (
  `id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `postcomments`
--

INSERT INTO `postcomments` (`id`, `id_post`, `id_user`, `create_at`, `body`) VALUES
(100, 53, 4, '2022-04-26 00:23:15', 'muito bom'),
(101, 54, 3, '2022-04-26 00:24:48', 'Que lugar incrível!!!'),
(102, 53, 6, '2022-04-26 00:26:39', 'Parabéns!'),
(103, 55, 15, '2022-04-26 00:31:11', 'kkkkkkk'),
(104, 56, 6, '2022-04-26 00:34:58', 'Nossa! muito interessante, não sabia disso ... ');

-- --------------------------------------------------------

--
-- Estrutura da tabela `postlikes`
--

CREATE TABLE `postlikes` (
  `id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `postlikes`
--

INSERT INTO `postlikes` (`id`, `id_post`, `id_user`, `create_at`) VALUES
(125, 53, 4, '2022-04-26 00:23:06'),
(126, 54, 3, '2022-04-26 00:24:25'),
(127, 55, 15, '2022-04-26 00:31:08'),
(128, 56, 6, '2022-04-26 00:34:36'),
(129, 57, 15, '2022-04-26 00:37:04'),
(130, 54, 14, '2022-04-26 00:46:10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `create_at` datetime NOT NULL,
  `body` text NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `posts`
--

INSERT INTO `posts` (`id`, `type`, `create_at`, `body`, `id_user`) VALUES
(53, 'text', '2022-04-26 00:21:30', 'Algumas coisas são explicadas pela ciência, outras pela fé.\r\n\r\nA Páscoa é mais do que uma data, é mais do que ciência, é mais que fé, páscoa é amor.', 3),
(54, 'photo', '2022-04-26 00:24:13', 'b29ad1acb2eaea60de6ab6b85c2bed85.jpg', 4),
(55, 'photo', '2022-04-26 00:30:09', '4cb960b498930d4979b321ae7e57be80.jpg', 6),
(56, 'text', '2022-04-26 00:32:53', 'Curiosidade sobre o termo \"Bug\" \r\n\r\n\r\nUsado para definir uma falha no sistema, o termo foi criado em 9 de setembro de 1945 por Grace Hopper, enquanto tentava encontrar um erro no computador Harvard Mark II. Ela descobriu que o erro havia sido causado por um inseto (bug, em inglês) que, atraído pelas luzes do interior da máquina, provocou um mau funcionamento do sistema. Desde então, o termo “bug” passou a ser sinônimo de problemas imprevisíveis da informática.', 15),
(57, 'photo', '2022-04-26 00:36:44', 'abe00bb0705ed384b56f638f4248f807.jpg', 7),
(58, 'photo', '2022-04-26 09:59:00', 'dbccbe4d598cce1d112918e8187b44ab.jpg', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `userrelations`
--

CREATE TABLE `userrelations` (
  `id` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `userrelations`
--

INSERT INTO `userrelations` (`id`, `user_from`, `user_to`) VALUES
(6, 4, 3),
(23, 7, 3),
(25, 3, 4),
(48, 21, 4),
(49, 21, 7),
(50, 4, 21),
(52, 6, 3),
(53, 15, 6),
(54, 14, 15),
(55, 14, 21),
(56, 14, 6),
(57, 14, 3),
(58, 14, 4),
(59, 3, 21);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `city` varchar(100) NOT NULL,
  `work` varchar(100) NOT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `cover` varchar(100) NOT NULL DEFAULT 'cover.jpg',
  `token` varchar(200) NOT NULL,
  `online` varchar(6) NOT NULL DEFAULT 'false',
  `modification` datetime DEFAULT NULL,
  `firsttime` varchar(6) NOT NULL DEFAULT 'true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `birthdate`, `city`, `work`, `avatar`, `cover`, `token`, `online`, `modification`, `firsttime`) VALUES
(3, 'pauladesouza82@gmail.com', '$2y$10$DxJPxAgLvnfUotFBVbZPheA7T8BgcHZ5DFEo21DyxEg8OWNuIEDb6', 'Paula de Souza', '1998-06-24', 'São Paulo', 'Estudante de Medicina ', '33faa1ed1bb3a6d564030d703cab839f.jpg', 'd185e894d05bb318259e78c0a990bb94.jpg', '75b08f1e379aa4b3bdebac39ed3ad379', 'false', '2022-04-26 10:38:34', 'false'),
(4, 'brunadossantos@gmail.com', '$2y$10$PGVxAVSvsY7FqxH1YwQUaePxKo3rAIgShW2GoglH.xb6SNiqIHUrW', 'Bruna dos Santos', '1992-11-14', 'Florianópolis', '', '06cb3eece7e75e99798413d837998deb.jpg', '56b3d4d52ca2177600cdea4e8932428f.jpg', '7e0a858dbb390982140b652abf70b667', 'false', '2022-04-26 10:29:56', 'false'),
(6, 'antonioaugusto@gmail.com', '$2y$10$s/NlNbYq9U/8RYoaDWyTiOt5L3.kAPnhtMErzGiScE984NMQ6zki.', 'Antônio Augusto', '1996-12-07', 'Salvador', 'Web Desinger ', 'c7474b2802cf1d21cfa1c721a3fc2575.jpg', '403f0e2ef90be10747467c8268671456.jpg', 'bd0114e9ed9ddb8975ed5707fd0575b9', 'false', '2022-04-26 00:35:32', 'false'),
(7, 'raqueloliver19@gmail.com', '$2y$10$2biyOKyIwGwuAq5DIKHRb.xJdvZxm4B9pu2/3ympLnSOT/DT6BjZO', 'Raquel Oliveira', '1999-04-12', 'Itaquaquecetuba', 'Professora', '98df204ec1484a4c744e845634ccd44f.jpg', '845f000b5a6193b51849661225e0d1e3.jpg', '79d5f7e8754d1c695f17e6a52297f1fb', 'true', '2022-04-26 00:45:32', 'false'),
(14, 'andreantonio@gmail.com', '$2y$10$ZH0/yEqaGwjKdESzRvhLv.0P.JNepHn./IhAz.jRHKyrSsoSNfq1C', 'Andre Gonçalves', '2000-12-12', 'Sorocaba - SP', 'Dev Java', '8b46ed256e1648cfac875288407187fb.jpg', '116a0173e755c52f94781cdc03bcbe58.jpg', 'f05e34c1d1816710aec0ffc244bd94dd', 'false', '2022-04-26 00:48:45', 'false'),
(15, 'matheusalves@gmail.com', '$2y$10$2RD91zfD3xCeW5G.X9NtqenUxNSJtz320WfAH7Dba6i.TRbwBry5K', 'Matheus Alves', '1997-12-03', 'Campinas -SP', 'Senior Developer', '817f73fec50969af0955ddf81f82202c.jpg', 'dfee439b95940e3630b8e56fef269810.jpg', '27b242e38bb1e08bc602cb2caf5dad0d', 'false', '2022-04-26 00:48:55', 'false'),
(21, 'convidado@email.com', '$2y$10$U6ZS4aME9.m8FApQFpXhTOdE/sB9mxmlopHHz9QIytwgxC4YhWvPi', 'Convidado (a)', '2002-01-01', '', '', 'default.jpg', 'cover.jpg', '37a4b22cb515cea42d70839532e7dd3d', 'false', '2022-04-26 00:56:50', 'false');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `postcomments`
--
ALTER TABLE `postcomments`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `postlikes`
--
ALTER TABLE `postlikes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `userrelations`
--
ALTER TABLE `userrelations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT de tabela `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT de tabela `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT de tabela `postlikes`
--
ALTER TABLE `postlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de tabela `userrelations`
--
ALTER TABLE `userrelations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
