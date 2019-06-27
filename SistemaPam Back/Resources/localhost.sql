-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 27, 2019 at 01:50 AM
-- Server version: 5.7.25
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arocena_db`
--
CREATE DATABASE IF NOT EXISTS `arocena_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `arocena_db`;

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `id` int(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `administrator_role_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `last_password_change` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`id`, `email`, `password`, `name`, `last_name`, `phone`, `administrator_role_id`, `active`, `last_password_change`, `deleted`, `token`) VALUES
(1, 'agustin.pazosm@gmail.com', '$2y$10$c7efb37223f19ec766a9cOaCCL./lf0H/ayMsaSZ8rCcF6OsKER.W', 'Agustin', 'Pazos', '0', 1, 1, '2019-06-25 13:43:23', 0, 'XQ23XHM272HR96NARPR6K6XE39KCZPDV'),
(2, 'matigru@gmail.com', '$2y$10$c7efb37223f19ec766a9cOaCCL./lf0H/ayMsaSZ8rCcF6OsKER.W', 'Agustin', 'Pazos', '095985987', 1, 1, '1900-01-01 00:00:00', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `administrator_files`
--

CREATE TABLE `administrator_files` (
  `id` int(11) NOT NULL,
  `administrator_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `administrator_login_attempts`
--

CREATE TABLE `administrator_login_attempts` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `created_on` datetime NOT NULL,
  `success` tinyint(4) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `cookie` varchar(32) NOT NULL,
  `session` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administrator_login_attempts`
--

INSERT INTO `administrator_login_attempts` (`id`, `email`, `created_on`, `success`, `ip`, `cookie`, `session`) VALUES
(1, 'agustin.pazosm@gmail.com', '2019-06-25 13:49:03', 1, '::1', 'mw0efqms3qes6f0jktxl1ukq3r2v63ol', 'fk0mt6ts74jnsbk1kebrnfb436'),
(2, 'agustin.pazosm@gmail.com', '2019-06-25 18:48:15', 1, '::1', '0qm5vk5qcwid0sgi32dpf2h6x0ytel5g', 'scrdd2p5rtsap8ccvmu4mr0f2g'),
(3, 'agustin.pazosm@gmail.com', '2019-06-25 18:48:18', 1, '::1', '0qm5vk5qcwid0sgi32dpf2h6x0ytel5g', 'scrdd2p5rtsap8ccvmu4mr0f2g'),
(4, 'agustin.pazosm@gmail.com', '2019-06-26 18:44:40', 1, '::1', '0qm5vk5qcwid0sgi32dpf2h6x0ytel5g', 'scrdd2p5rtsap8ccvmu4mr0f2g'),
(5, 'agustin.pazosm@gmail.com', '2019-06-26 19:31:14', 1, '::1', '0qm5vk5qcwid0sgi32dpf2h6x0ytel5g', 'scrdd2p5rtsap8ccvmu4mr0f2g'),
(6, 'agustin.pazosm@gmail.com', '2019-06-26 19:36:51', 1, '::1', '0qm5vk5qcwid0sgi32dpf2h6x0ytel5g', 'scrdd2p5rtsap8ccvmu4mr0f2g'),
(7, 'agustin.pazosm@gmail.com', '2019-06-26 19:37:11', 1, '::1', '0qm5vk5qcwid0sgi32dpf2h6x0ytel5g', 'scrdd2p5rtsap8ccvmu4mr0f2g'),
(8, 'AGUSTIN.PAZOSM@GMAIL.COM', '2019-06-26 21:35:46', 1, '::1', 'mw0efqms3qes6f0jktxl1ukq3r2v63ol', 'fk0mt6ts74jnsbk1kebrnfb436'),
(9, 'AGUSTIN.PAZOSM@GMAIL.COM', '2019-06-26 21:36:45', 1, '::1', 'kc1ebtc3gwsdgfe4g8x9nq7x2kkgyei8', 't09sv7h4jqlh40qfaoj67ro8u5'),
(10, 'agustin.pazosm@gmail.com', '2019-06-26 21:40:09', 1, '::1', '0qm5vk5qcwid0sgi32dpf2h6x0ytel5g', 'scrdd2p5rtsap8ccvmu4mr0f2g'),
(11, 'agustin.pazosm@gmail.com', '2019-06-26 21:40:25', 1, '::1', '0qm5vk5qcwid0sgi32dpf2h6x0ytel5g', 'scrdd2p5rtsap8ccvmu4mr0f2g');

-- --------------------------------------------------------

--
-- Table structure for table `administrator_sessions`
--

CREATE TABLE `administrator_sessions` (
  `id` int(11) NOT NULL,
  `administrator_id` int(11) NOT NULL,
  `session` varchar(32) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administrator_sessions`
--

INSERT INTO `administrator_sessions` (`id`, `administrator_id`, `session`, `date`) VALUES
(1, 1, 'fk0mt6ts74jnsbk1kebrnfb436', '2019-06-25 13:49:03'),
(2, 1, 'scrdd2p5rtsap8ccvmu4mr0f2g', '2019-06-25 18:48:15'),
(3, 1, 'scrdd2p5rtsap8ccvmu4mr0f2g', '2019-06-25 18:48:18'),
(4, 1, 'scrdd2p5rtsap8ccvmu4mr0f2g', '2019-06-26 18:44:40'),
(5, 1, 'scrdd2p5rtsap8ccvmu4mr0f2g', '2019-06-26 19:31:14'),
(6, 1, 'scrdd2p5rtsap8ccvmu4mr0f2g', '2019-06-26 19:36:51'),
(7, 1, 'scrdd2p5rtsap8ccvmu4mr0f2g', '2019-06-26 19:37:11'),
(8, 1, 'fk0mt6ts74jnsbk1kebrnfb436', '2019-06-26 21:35:46'),
(9, 1, 't09sv7h4jqlh40qfaoj67ro8u5', '2019-06-26 21:36:45'),
(10, 1, 'scrdd2p5rtsap8ccvmu4mr0f2g', '2019-06-26 21:40:09'),
(11, 1, 'scrdd2p5rtsap8ccvmu4mr0f2g', '2019-06-26 21:40:25');

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `administrator_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `message` varchar(1024) NOT NULL,
  `aux` varchar(1024) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `browser` varchar(64) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `address` varchar(256) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `code` varchar(128) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `address`, `phone`, `code`, `created_on`, `updated_on`, `deleted`) VALUES
(1, 'Agustin', 'Brenda 6030', '095985987', 'AGUS', '2019-06-26 19:42:49', '2019-06-26 19:42:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cookies`
--

CREATE TABLE `cookies` (
  `id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cookies`
--

INSERT INTO `cookies` (`id`, `code`, `user_id`, `created_on`) VALUES
(1, 'lopd90nnpx4ovepmkcw7c5bwas6r3ebp', 0, '2019-06-25 13:35:22'),
(2, 'mw0efqms3qes6f0jktxl1ukq3r2v63ol', 0, '2019-06-25 13:48:58'),
(3, '0qm5vk5qcwid0sgi32dpf2h6x0ytel5g', 0, '2019-06-25 18:41:41'),
(4, 'kc1ebtc3gwsdgfe4g8x9nq7x2kkgyei8', 0, '2019-06-26 21:36:40');

-- --------------------------------------------------------

--
-- Table structure for table `crons`
--

CREATE TABLE `crons` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` varchar(256) NOT NULL,
  `function` varchar(64) NOT NULL,
  `parameter` varchar(512) NOT NULL DEFAULT ' ',
  `from` varchar(32) NOT NULL,
  `to` varchar(32) NOT NULL,
  `every` int(11) NOT NULL,
  `just_once` tinyint(4) NOT NULL DEFAULT '0',
  `executions` int(11) NOT NULL,
  `last_execution` datetime NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `errors`
--

CREATE TABLE `errors` (
  `id` int(11) NOT NULL,
  `administrator_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `message` varchar(1024) NOT NULL,
  `aux` mediumtext NOT NULL,
  `ip` varchar(32) NOT NULL,
  `browser` varchar(64) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `errors`
--

INSERT INTO `errors` (`id`, `administrator_id`, `user_id`, `title`, `message`, `aux`, `ip`, `browser`, `date`) VALUES
(1, 1, 0, 'Error en AdministratorController/actionAdd', 'CDbCommand falló al ejecutar la sentencia SQL: SQLSTATE[HY000]: General error: 1364 Field \'token\' doesn\'t have a default value. The SQL statement executed was: INSERT INTO `administrators` (`active`, `deleted`, `email`, `password`, `name`, `last_name`, `phone`, `administrator_role_id`, `last_password_change`) VALUES (:yp0, :yp1, :yp2, :yp3, :yp4, :yp5, :yp6, :yp7, :yp8)', '', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 19:39:15'),
(2, 1, 0, 'Error en Models/WorkBounds/create', 'Error creating workBound', 'Array\n(\n    [others_text] => Array\n        (\n            [0] => OthersText no puede estar vac&iacute;o.\n        )\n\n)\n', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 20:18:59'),
(3, 1, 0, 'Error en Models/WorkBounds/create', 'Error creating workBound', 'Array\n(\n    [others_text] => Array\n        (\n            [0] => OthersText no puede estar vac&iacute;o.\n        )\n\n)\n', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 20:19:48'),
(4, 1, 0, 'Error en Models/WorkBounds/create', 'Error creating workBound', 'Array\n(\n    [others_text] => Array\n        (\n            [0] => OthersText no puede estar vac&iacute;o.\n        )\n\n)\n', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 20:19:56'),
(5, 1, 0, 'Error en Models/WorkBounds/create', 'Error creating workBound', 'Array\n(\n    [others_text] => Array\n        (\n            [0] => OthersText no puede estar vac&iacute;o.\n        )\n\n)\n', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 20:20:02'),
(6, 1, 0, 'Error en Models/WorkBounds/create', 'Error creating workBound', 'Array\n(\n    [others_text] => Array\n        (\n            [0] => OthersText no puede estar vac&iacute;o.\n        )\n\n)\n', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 20:20:29'),
(7, 1, 0, 'Error en Models/WorkDelivers/create', 'Error creating workDeliver', 'Array\n(\n    [deliver_date] => Array\n        (\n            [0] => The format of DeliverDate is invalid.\n        )\n\n)\n', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 20:20:29'),
(8, 1, 0, 'Error en Models/WorkStatusChanges/create', 'Error creating workStatusChang', 'Array\n(\n    [notes] => Array\n        (\n            [0] => Notes no puede estar vac&iacute;o.\n        )\n\n)\n', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 20:42:04'),
(9, 1, 0, 'Error en Models/WorkDelivers/create', 'Error creating workDeliver', 'Array\n(\n    [deliver_date] => Array\n        (\n            [0] => The format of DeliverDate is invalid.\n        )\n\n)\n', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 21:25:32');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `ref` varchar(16) NOT NULL,
  `name` varchar(64) NOT NULL,
  `url` varchar(128) NOT NULL,
  `original_name` varchar(64) NOT NULL,
  `file_type_id` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `hash` varchar(128) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `id`
--

CREATE TABLE `id` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `address` text NOT NULL,
  `contact_phone` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `administrator_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `text` varchar(512) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `browser` varchar(64) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `administrator_id`, `user_id`, `provider_id`, `text`, `ip`, `browser`, `date`) VALUES
(1, 1, 0, 0, 'El admin agustin.pazosm@gmail.com inició sesión', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 19:31:14'),
(2, 1, 0, 0, 'El admin agustin.pazosm@gmail.com inició sesión', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 19:36:51'),
(3, 1, 0, 0, 'El admin agustin.pazosm@gmail.com inició sesión', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 19:37:11'),
(4, 1, 0, 0, 'Se creó el Administrador 2', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 19:40:05'),
(5, 1, 0, 0, 'Se creó el Client 1', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 19:42:49'),
(6, 1, 0, 0, 'Se creó el Work 2', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 20:05:12'),
(7, 1, 0, 0, 'Se creó el Work 3', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 20:12:28'),
(8, 1, 0, 0, 'Se creó el Work 8', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 20:20:29'),
(9, 1, 0, 0, 'Se creó el Work 9', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 21:25:32'),
(10, 1, 0, 0, 'Se creó el Work 10', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 21:28:17'),
(11, 1, 0, 0, 'El admin AGUSTIN.PAZOSM@GMAIL.COM inició sesión', '::1', 'Google Chrome|74.0.3729.157|mac', '2019-06-26 21:35:46'),
(12, 1, 0, 0, 'El admin AGUSTIN.PAZOSM@GMAIL.COM inició sesión', '::1', 'Google Chrome|74.0.3729.157|mac', '2019-06-26 21:36:45'),
(13, 1, 0, 0, 'El admin agustin.pazosm@gmail.com inició sesión', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 21:40:09'),
(14, 1, 0, 0, 'El admin agustin.pazosm@gmail.com inició sesión', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 21:40:25'),
(15, 1, 0, 0, 'Se creó el Work 11', '::1', 'Unknown|7.15.0|Unknown', '2019-06-26 21:40:38');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `cookie` varchar(32) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `browser` varchar(128) NOT NULL,
  `referrer` varchar(256) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `phone` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `address` varchar(256) NOT NULL,
  `code_id` int(11) NOT NULL,
  `ci` varchar(128) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `updated_on` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `works`
--

CREATE TABLE `works` (
  `id` int(11) NOT NULL,
  `print_type_id` int(11) NOT NULL,
  `paper_size` varchar(64) NOT NULL,
  `paper_type_id` varchar(128) NOT NULL,
  `prints_amount` int(11) NOT NULL,
  `image_url` varchar(512) NOT NULL,
  `notes` text NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `current_work_status_id` int(11) NOT NULL,
  `current_status_type_id` int(11) NOT NULL,
  `due_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `works`
--

INSERT INTO `works` (`id`, `print_type_id`, `paper_size`, `paper_type_id`, `prints_amount`, `image_url`, `notes`, `created_on`, `updated_on`, `deleted`, `admin_id`, `current_work_status_id`, `current_status_type_id`, `due_date`) VALUES
(2, 1, 'A4', 'hoja', 50, 'link', 'notas', '2019-06-26 20:05:12', '2019-06-26 20:05:12', 0, 1, 1, 0, '1969-12-31 21:00:00'),
(3, 1, 'A4', 'hoja', 50, 'link', 'notas', '2019-06-26 20:12:28', '2019-06-26 20:12:28', 0, 1, 1, 0, '1969-12-31 21:00:00'),
(4, 1, 'A4', 'hoja', 50, 'link', 'notas', '2019-06-26 20:18:59', '2019-06-26 20:18:59', 0, 1, 1, 0, '1969-12-31 21:00:00'),
(5, 1, 'A4', 'hoja', 50, 'link', 'notas', '2019-06-26 20:19:48', '2019-06-26 20:19:48', 0, 1, 1, 0, '1969-12-31 21:00:00'),
(6, 1, 'A4', 'hoja', 50, 'link', 'notas', '2019-06-26 20:19:56', '2019-06-26 20:49:00', 0, 1, 4, 3, '1969-12-31 21:00:00'),
(7, 1, 'A4', 'hoja', 50, 'link', 'notas', '2019-06-26 20:20:02', '2019-06-26 20:20:02', 0, 1, 1, 0, '1969-12-31 21:00:00'),
(8, 1, 'A4', 'hoja', 50, 'link', 'notas', '2019-06-26 20:20:29', '2019-06-26 20:20:29', 0, 1, 1, 0, '1969-12-31 21:00:00'),
(9, 1, 'A4', 'hoja', 50, 'link', 'notas', '2019-06-26 21:25:32', '2019-06-26 21:25:32', 0, 1, 1, 0, '1969-12-31 21:00:00'),
(10, 1, 'A4', 'hoja', 50, 'link', 'notas', '2019-06-26 21:28:17', '2019-06-26 21:28:17', 0, 1, 1, 0, '1969-12-31 21:00:00'),
(11, 1, 'A4', 'hoja', 50, 'link', 'notas', '2019-06-26 21:40:38', '2019-06-26 21:43:13', 0, 1, 6, 2, '1969-12-31 21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `work_bounds`
--

CREATE TABLE `work_bounds` (
  `id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `others_text` text NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `work_bounds`
--

INSERT INTO `work_bounds` (`id`, `work_id`, `type`, `others_text`, `created_on`, `updated_on`, `deleted`, `admin_id`) VALUES
(1, 9, 1, '-', '2019-06-26 21:25:32', '2019-06-26 21:25:32', 0, 1),
(2, 10, 1, '-', '2019-06-26 21:28:17', '2019-06-26 21:28:17', 0, 1),
(3, 11, 1, '-', '2019-06-26 21:40:38', '2019-06-26 21:40:38', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `work_delivers`
--

CREATE TABLE `work_delivers` (
  `id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `deliver_date` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `work_delivers`
--

INSERT INTO `work_delivers` (`id`, `work_id`, `client_id`, `deliver_date`, `created_on`, `updated_on`, `deleted`, `admin_id`) VALUES
(1, 10, 1, '1969-12-31 21:00:00', '2019-06-26 21:28:17', '2019-06-26 21:28:17', 0, 1),
(2, 11, 1, '1969-12-31 21:00:00', '2019-06-26 21:40:38', '2019-06-26 21:40:38', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `work_details`
--

CREATE TABLE `work_details` (
  `id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `work_finished`
--

CREATE TABLE `work_finished` (
  `id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `work_finished`
--

INSERT INTO `work_finished` (`id`, `work_id`, `created_on`, `updated_on`, `deleted`) VALUES
(2, 2, '2019-06-26 20:05:12', '2019-06-26 20:05:12', 0),
(3, 3, '2019-06-26 20:12:28', '2019-06-26 20:12:28', 0),
(4, 4, '2019-06-26 20:18:59', '2019-06-26 20:18:59', 0),
(5, 5, '2019-06-26 20:19:48', '2019-06-26 20:19:48', 0),
(6, 6, '2019-06-26 20:19:56', '2019-06-26 20:19:56', 0),
(7, 7, '2019-06-26 20:20:02', '2019-06-26 20:20:02', 0),
(8, 8, '2019-06-26 20:20:29', '2019-06-26 20:20:29', 0),
(9, 9, '2019-06-26 21:25:32', '2019-06-26 21:25:32', 0),
(10, 10, '2019-06-26 21:28:17', '2019-06-26 21:28:17', 0),
(11, 11, '2019-06-26 21:40:38', '2019-06-26 21:40:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `work_laminates`
--

CREATE TABLE `work_laminates` (
  `id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `printing` varchar(128) NOT NULL,
  `type` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `work_laminates`
--

INSERT INTO `work_laminates` (`id`, `work_id`, `printing`, `type`, `created_on`, `updated_on`, `deleted`, `admin_id`) VALUES
(1, 3, '1', 1, '2019-06-26 20:12:28', '2019-06-26 20:12:28', 0, 1),
(2, 4, 'largo', 1, '2019-06-26 20:18:59', '2019-06-26 20:18:59', 0, 1),
(3, 5, 'largo', 1, '2019-06-26 20:19:48', '2019-06-26 20:19:48', 0, 1),
(4, 6, 'largo', 1, '2019-06-26 20:19:56', '2019-06-26 20:19:56', 0, 1),
(5, 7, 'largo', 1, '2019-06-26 20:20:02', '2019-06-26 20:20:02', 0, 1),
(6, 8, 'largo', 1, '2019-06-26 20:20:29', '2019-06-26 20:20:29', 0, 1),
(7, 9, 'largo', 1, '2019-06-26 21:25:32', '2019-06-26 21:25:32', 0, 1),
(8, 10, 'largo', 1, '2019-06-26 21:28:17', '2019-06-26 21:28:17', 0, 1),
(9, 11, 'largo', 1, '2019-06-26 21:40:38', '2019-06-26 21:40:38', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `work_prints`
--

CREATE TABLE `work_prints` (
  `id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `work_prints`
--

INSERT INTO `work_prints` (`id`, `work_id`, `created_on`, `updated_on`, `deleted`, `admin_id`) VALUES
(1, 11, '2019-06-26 21:40:38', '2019-06-26 21:40:38', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `work_rumblings`
--

CREATE TABLE `work_rumblings` (
  `id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `shape` varchar(256) NOT NULL,
  `amount` int(11) NOT NULL,
  `detail` text NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `work_rumblings`
--

INSERT INTO `work_rumblings` (`id`, `work_id`, `shape`, `amount`, `detail`, `created_on`, `updated_on`, `deleted`, `admin_id`) VALUES
(1, 4, 'redondo', 20, 'detalles', '2019-06-26 20:18:59', '2019-06-26 20:18:59', 0, 1),
(2, 5, 'redondo', 20, 'detalles', '2019-06-26 20:19:48', '2019-06-26 20:19:48', 0, 1),
(3, 6, 'redondo', 20, 'detalles', '2019-06-26 20:19:56', '2019-06-26 20:19:56', 0, 1),
(4, 7, 'redondo', 20, 'detalles', '2019-06-26 20:20:02', '2019-06-26 20:20:02', 0, 1),
(5, 8, 'redondo', 20, 'detalles', '2019-06-26 20:20:29', '2019-06-26 20:20:29', 0, 1),
(6, 9, 'redondo', 20, 'detalles', '2019-06-26 21:25:32', '2019-06-26 21:25:32', 0, 1),
(7, 10, 'redondo', 20, 'detalles', '2019-06-26 21:28:17', '2019-06-26 21:28:17', 0, 1),
(8, 11, 'redondo', 20, 'detalles', '2019-06-26 21:40:38', '2019-06-26 21:40:38', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `work_status_changes`
--

CREATE TABLE `work_status_changes` (
  `id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `original_work_status_id` int(11) NOT NULL,
  `final_work_status_id` int(11) NOT NULL,
  `notes` text NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `work_status_changes`
--

INSERT INTO `work_status_changes` (`id`, `work_id`, `original_work_status_id`, `final_work_status_id`, `notes`, `created_on`, `updated_on`, `deleted`, `admin_id`) VALUES
(1, 6, 4, 3, 'notas de cambio', '2019-06-26 20:42:38', '2019-06-26 20:42:38', 0, 1),
(2, 6, 3, 4, 'notas de cambio', '2019-06-26 20:49:00', '2019-06-26 20:49:00', 0, 1),
(3, 11, 0, 3, 'notas de cambio', '2019-06-26 21:41:39', '2019-06-26 21:41:39', 0, 1),
(4, 11, 0, 3, 'notas de cambio', '2019-06-26 21:42:18', '2019-06-26 21:42:18', 0, 1),
(5, 11, 9, 2, 'notas de cambio', '2019-06-26 21:43:06', '2019-06-26 21:43:06', 0, 1),
(6, 11, 1, 3, 'notas de cambio', '2019-06-26 21:43:10', '2019-06-26 21:43:10', 0, 1),
(7, 11, 9, 4, 'notas de cambio', '2019-06-26 21:43:10', '2019-06-26 21:43:10', 0, 1),
(8, 11, 8, 5, 'notas de cambio', '2019-06-26 21:43:11', '2019-06-26 21:43:11', 0, 1),
(9, 11, 8, 6, 'notas de cambio', '2019-06-26 21:43:11', '2019-06-26 21:43:11', 0, 1),
(10, 11, 3, 7, 'notas de cambio', '2019-06-26 21:43:12', '2019-06-26 21:43:12', 0, 1),
(11, 11, 11, 8, 'notas de cambio', '2019-06-26 21:43:13', '2019-06-26 21:43:13', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `work_uvs`
--

CREATE TABLE `work_uvs` (
  `id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `work_uvs`
--

INSERT INTO `work_uvs` (`id`, `work_id`, `created_on`, `updated_on`, `deleted`, `admin_id`) VALUES
(1, 4, '2019-06-26 20:18:59', '2019-06-26 20:18:59', 0, 1),
(2, 5, '2019-06-26 20:19:48', '2019-06-26 20:19:48', 0, 1),
(3, 6, '2019-06-26 20:19:56', '2019-06-26 20:19:56', 0, 1),
(4, 7, '2019-06-26 20:20:02', '2019-06-26 20:20:02', 0, 1),
(5, 8, '2019-06-26 20:20:29', '2019-06-26 20:20:29', 0, 1),
(6, 9, '2019-06-26 21:25:32', '2019-06-26 21:25:32', 0, 1),
(7, 10, '2019-06-26 21:28:17', '2019-06-26 21:28:17', 0, 1),
(8, 11, '2019-06-26 21:40:38', '2019-06-26 21:40:38', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `administrator_files`
--
ALTER TABLE `administrator_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `administrator_login_attempts`
--
ALTER TABLE `administrator_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `administrator_sessions`
--
ALTER TABLE `administrator_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cookies`
--
ALTER TABLE `cookies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crons`
--
ALTER TABLE `crons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `errors`
--
ALTER TABLE `errors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `id`
--
ALTER TABLE `id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `works`
--
ALTER TABLE `works`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_bounds`
--
ALTER TABLE `work_bounds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_delivers`
--
ALTER TABLE `work_delivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_details`
--
ALTER TABLE `work_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_finished`
--
ALTER TABLE `work_finished`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_laminates`
--
ALTER TABLE `work_laminates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_prints`
--
ALTER TABLE `work_prints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_rumblings`
--
ALTER TABLE `work_rumblings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_status_changes`
--
ALTER TABLE `work_status_changes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_uvs`
--
ALTER TABLE `work_uvs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `administrator_files`
--
ALTER TABLE `administrator_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `administrator_login_attempts`
--
ALTER TABLE `administrator_login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `administrator_sessions`
--
ALTER TABLE `administrator_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cookies`
--
ALTER TABLE `cookies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `crons`
--
ALTER TABLE `crons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `errors`
--
ALTER TABLE `errors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `id`
--
ALTER TABLE `id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `works`
--
ALTER TABLE `works`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `work_bounds`
--
ALTER TABLE `work_bounds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `work_delivers`
--
ALTER TABLE `work_delivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `work_details`
--
ALTER TABLE `work_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_finished`
--
ALTER TABLE `work_finished`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `work_laminates`
--
ALTER TABLE `work_laminates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `work_prints`
--
ALTER TABLE `work_prints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `work_rumblings`
--
ALTER TABLE `work_rumblings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `work_status_changes`
--
ALTER TABLE `work_status_changes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `work_uvs`
--
ALTER TABLE `work_uvs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
