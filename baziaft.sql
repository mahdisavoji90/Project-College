-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2026 at 01:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baziaft`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '123');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recycling`
--

CREATE TABLE `recycling` (
  `id` int(255) NOT NULL,
  `recyclingtype` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recycling`
--

INSERT INTO `recycling` (`id`, `recyclingtype`) VALUES
(1, 'کامپیوتر'),
(2, 'آهن'),
(3, 'مس'),
(4, 'آلمینیوم'),
(5, 'برنج'),
(6, 'سایر');

-- --------------------------------------------------------

--
-- Table structure for table `register_sell`
--

CREATE TABLE `register_sell` (
  `id` int(255) NOT NULL,
  `recyclingtype_id` int(255) NOT NULL,
  `weight` int(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `numberphone` varchar(255) DEFAULT NULL,
  `users_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register_sell`
--

INSERT INTO `register_sell` (`id`, `recyclingtype_id`, `weight`, `description`, `numberphone`, `users_id`) VALUES
(2, 1, 3123, 'dadsdadwq', '0', 11),
(3, 2, 31231, 'qwddSD', '12313123', 11),
(4, 1, 23, 'ADQFDADF', '2147483647', 11),
(5, 2, 11, 'FDFFFFFFFFFF', '2147483647', 11),
(6, 2, 9, 'DDDD', '2147483647', 11),
(7, 2, 9, 'DDDD', '2147483647', 11),
(8, 2, 9, 'DDDD', '2147483647', 11),
(9, 2, 123, 'QWSQSQW', '2147483647', 11),
(10, 2, 123, 'QWSQSQW', '2147483647', 11),
(11, 1, 2131, 'ثضصثضصث', '2147483647', 11),
(12, 2, 2323, 'یبسیبس', '2147483647', 11),
(13, 2, 2323, 'یبسیبس', '2147483647', 11),
(14, 2, 2323, 'یبسیبس', '2147483647', 11),
(15, 1, 2112, 'ضضض', '2147483647', 11),
(16, 2, 22, '3123', '2147483647', 11),
(17, 1, 212, 'ص', '2147483647', 11),
(18, 2, 312, 'سشیش', '2147483647', 11),
(19, 2, 312, 'سشیش', '2147483647', 11),
(20, 2, 12312, 'شسیشسی', '2147483647', 11),
(21, 2, 12312, 'شسیشسی', '2147483647', 11),
(22, 2, 424, 'dsad', '2147483647', 11),
(23, 1, 11, '11', '2147483647', 11),
(24, 1, 11, '11', '09333203676', 11),
(25, 1, 123, 'سشسیشسی', '09333203676', 11),
(26, 1, 123, 'سشسیشسی', '09333203676', 11),
(27, 1, 23, 'ضصثضصث', '09333203676', 11),
(34, 1, 23, 'ضصثضصث', '09333203676', 14),
(39, 2, 500, '23423', '09333203676', 14);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `user_level` enum('bronze','silver','gold','diamond','vip') DEFAULT 'bronze',
  `total_points` int(11) DEFAULT 0,
  `wallet_balance` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `phone`, `address`, `profile_picture`, `user_level`, `total_points`, `created_at`, `updated_at`) VALUES
(5, 'asdas@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(6, 'asdas@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(7, 'dasdasd@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(8, 'dasdasd@gmail.com', '123', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(9, 'amdmasd@gmail.com', '999', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(10, 'qwqwqw@mail.com', '', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(11, 'qwqwqw@mail.com', '$2y$10$zd8li49y9Y7SRfDDkPgdG.K7ErxPGvtAEN0OIk34/PuuyOaVYZ6MO', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(12, 'qw@mail.com', '$2y$10$.gzZS7mMFQj71Fjo1JpjW.waBfhsmju0z.7rDw0efp.V8KKhXqTS6', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(13, 'qwqwqw@mail.com', '$2y$10$z2ytLKJenXprACn.ckZbvepqVHtvrzpcN9NkSJNpIaC0924QomokW', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(14, '2121233qw@mail.com', '$2y$10$ai9Hm6zzy1kHgUJlG8yhAu/E3cMrisZSJ.TOwLRko3wHUiHJ5P6dO', 'مهدی', 'ساوجی', '09333203676', '', 'uploads/profiles/user_14_1779088708.png', 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 07:18:28'),
(15, 'aaa@gmail.com', '$2y$10$vTw9yF3I8oEkWBy6xbIC6.8vGY0D00FVOYHpkv9UHzvzwjL64va3q', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(16, '2121233qw@mail.com', '$2y$10$OpGCTObxKrNXfIBRK8pBEe4y37Ij/KICeJwjZbOcvV1ZjfVBPrenK', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(17, '2121233qw@mail.com', '$2y$10$2oZMAdnjH.iBPH0aGnbqsuLuzN4ROQ8Sg.APunXFBPcNIE1DUrTFe', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(18, '21sas21233qw@mail.com', '$2y$10$9rOxfX8F/cs3jGiPWwKnG.CnUtcRjSVIuHEW9DG0tf5qp1FasdPZK', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(19, '21sas21233qw@mail.com', '$2y$10$cAbV/VdvZYpL2CvZRfDSV.sLc4QqzHxPZ0zSDOP.xT5D3USn3/FB6', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(20, '21sas21233qw@mail.com', '$2y$10$gL9lm34SBUySib58MHpIcOLLFFQpYEvfCwX5d/DtrHIvgfeYdjfcS', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(21, '212121233qw@mail.com', '$2y$10$qXQAJO3v1tFAd5YWHPdwWOQNGQgQ0F8Vu4IuA5XOxc6fM1ISEGgW2', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(22, '2121233qw@mail.com', '$2y$10$0Y3d.GbGriSvfxnvDsdH6OqftHofnqRiXhYS1OZ8pwwPR7ZlggaA2', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(23, '2121233qw@mail.com', '$2y$10$kYNZLfaiA2jbOqcA.rviIuGYj6diXaLgXJ4joQGujxdbeOLLCLVh2', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(24, '2121233qw@mail.com', '$2y$10$WOw0ldUPVKPkMKs7rbn1eei0ZiVx.dU.vZHCntQT6tBWBR33Giy6G', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(25, '2121233qw@mail.com', '$2y$10$umiqUGvZxSoM2vbzO8cG4uxZll3xImAEUzZCBCMLZ31dHc9AoSeJa', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(26, '2121233qw@mail.com', '$2y$10$BgAv/5s0dTVArhlddEHPMOkvvO4aRkxyGqUOv3Q4sVFsexErXv1Pi', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(27, '2121233qw@mail.com', '$2y$10$WEsMUCZLVLWhg8ksxTzQKu8g5ENHyqeovqSTWw726aIkRFF7VpzU2', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(28, '2121233qw@mail.com', '$2y$10$uvpBMdVTzxS35laE2pCpMucRhwfixn8WhfYL0.RpBjJ11pWCHRoB.', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(29, '2121223433qw@mail.com', '$2y$10$AS2.76Cc47enn1riXx57budtU9nQuAjmRQ7h8E2SAb0DKAZmWBkK2', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(30, '2121233qw@mail.com', '$2y$10$LVeIzwyM7fFvG7DW.l7Fue7YqwENSImaqbLxlsfAfYfosYBOdjeEO', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(31, '2121233qw@mail.com', '$2y$10$kjMLxzFbjZBY.q4ZbjSqqOl4muoerzo/VHnLQoPhyDuSzFrjiQovm', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(32, '2121233qw@mail.com', '$2y$10$phIuDFA4/GNTUckPrIsheOA/N4it5/500xU9/9b3OaSGaHtxCdJfq', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(33, '2121233qw@mail.com', '$2y$10$mpnJmRx8qn5EDlMS7fLTQO1jaOVRIvrSFf3flZ6PNeg5j9t/fzlo2', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(34, '2121233qw@mail.com', '$2y$10$W6vZhvD5ECtWUqXL.Ib1x.0a0G2eYAczwQbvVK0eBztQLuonipVFC', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(35, '2121233qw@mail.com', '$2y$10$OcaGL.9npBVGeCNX850TqesPCMs9JPK4hPWau6fSTaTZwRgVaLTJe', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(36, '2121233qweqweqw@mail.com', '$2y$10$UhSpsfb3IJq8rmIrghUQde1vkFevgfXsnC1P4uS5TSJ0mV9IneyVK', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(37, '2121233qw@mail.comihiuj', '$2y$10$UctNCIcdXY2BEyCHVk41n.eFEs/bgL/hkr/1eJr41.6f457HUpZ8y', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(38, '2121233qw@mail.comihiuj', '$2y$10$VwPTND8zBQNONgXNJLc4Zuv77HdnkaQ.7KfaVIkl9TgOKKIObUAaa', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(39, '2121233qw@mail.com', '$2y$10$sOQxHdtoyCNg3w2nuz0/FOlZzZ9hZR9sTdZMfexw/VAkouU426GE2', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(40, '2121233qw@mail.com', '$2y$10$oeXcGSWGFJojoarplbY4muXSgobL40srbQQKLkmEVnCEK5dfqLNX2', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(41, '21sdasd21233qw@mail.com', '$2y$10$UMTJK9nAAFuzG9fxF41gLuSwKQVexoVgko1Nm51kDzRO339w9r2.C', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(42, '212123sss3qw@mail.com', '$2y$10$vulNGMTmwyuejR779zn.Aultu7e3tjSfMSyP6OvG1aGXGjv/UJ3LK', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(43, '212123sss3qw@mail.com', '$2y$10$u9QUvFU4Nx1.5CDT1IwQ.eXhrNYC1oeY/NwaH3SyKMGOb6KlcM54q', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(44, '2121233qw@mail.com', '$2y$10$LMqGiL1u2ulzR.bQti.2BehnmgVz/dE375JsfSquLVGKpE2K9Zg5e', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(45, '2121233qw@mail.com', '$2y$10$H91BA48uHy6kLo.xdnQYa.pa.ZJCMstHdZp7y7VS8qLZad7H9kOtK', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(46, '2121asd233qw@mail.com', '$2y$10$G4YF.mU45DY6AuDDlkcxHu4vPNYaW5xbHHoloH9nCU/icAkxVnaLS', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(47, '2121asd233qw@mail.com', '$2y$10$DQzDIOgOSpKUjiAI0eXOQe1qv.AYTrAlS/EFqBwWVwjPv/Xq0cMfC', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(48, '212121133qw@mail.com', '$2y$10$j9/Kb3v7jbwwGekmN8UNj.K3sjvGmKrAuvtYoPZNM0knDMUB4Uw92', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(49, '2121123233qw@mail.com', '$2y$10$L5vwCSRKRXq9..eAjOK5j.CK9bx6GyAVapPB5Ksd6cWX3JepuOnka', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(50, '2121233q2222222w@mail.com', '$2y$10$XVCznrEABjc5HTI6oGQC4eBjLrHwxMYMS0gp98zoJpbHp3ajZ6heO', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(51, '2121231233qw@mail.com', '$2y$10$CjlOEx8KNRpIq.0VERtZBupYOfwvSgSeW8sKrZfv.8QBKZ0yj0hFW', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(52, '212133233qw@mail.com', '$2y$10$jRQ2JLvWtmeyToPWkF4BEe4/v5HpaIvJJSosKXrFxC6tOc1IottyK', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(53, '2121233q11w@mail.com', '$2y$10$fAikPEsWx0ekWZQO/bN9cO2pwfX3Ega5/KUCXSBstHtFUxlQgYqNO', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(54, '212123asdas3qw@mail.com', '$2y$10$h/wUgHc4SBidJtjbzQJZ5uC7zsKtv.Alk.DHf4Fi8/nenbb3Mgpc6', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(55, '2121231113qw@mail.com', '$2y$10$hmKlh49UBd59.YMWieuFuONN7Mzjq4TRiacGpawqdTEI7krOljazK', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(56, '2121231113qw@mail.com', '$2y$10$clI4hXFdb3D/1461DTWas.qqG/YLwEwJv/mQpSA4ZHI7VIMeq0qXa', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(57, '2121221312333qw@mail.com', '$2y$10$DSdHgXdNpUn7je/GBnhnzufnQVSrfWjFaBZ2h4tq65tczxSwS1JWG', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(58, '2121233q213w@gmail.com', '$2y$10$VF.S.dmtyM16qGau4rg2se6TGUwea6h6CkzcfG8oy2rJsWeh/ufge', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(59, '2121233q11111111111111w@mail.com', '$2y$10$Y.kKvFTzJcQxvKgnY5KUxOGyYVugAEuFVxNeZ14AT.9PVWqHVZUiG', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(60, '21212331111111qw@mail.com', '$2y$10$sgYf5n7/qvMioF4p.mD00OgDBTehNydy7qp6PLdQLwzNECW22RGCS', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38'),
(61, '2121111111111233qw@mail.com', '$2y$10$tydGST4D6QjVN7KHLPHxl.34XZ28OesWvSxACXFl.Ne2ik8Mraroq', NULL, NULL, NULL, NULL, NULL, 'bronze', 0, '2026-05-18 06:31:38', '2026-05-18 06:31:38');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL COMMENT 'مبلغ به تومان',
  `type` enum('deposit','withdraw','purchase','sale','reward','fee') DEFAULT 'deposit',
  `description` varchar(255) DEFAULT NULL,
  `status` enum('success','pending','failed','cancelled') DEFAULT 'success',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `amount`, `type`, `description`, `status`, `created_at`) VALUES
(1, 14, 50000, 'deposit', 'شارژ کیف پول', 'success', '2026-07-08 10:30:00'),
(2, 14, 120000, 'sale', 'فروش ضایعات مس - 10 کیلو', 'success', '2026-07-09 14:15:00'),
(3, 14, 35000, 'withdraw', 'برداشت وجه', 'pending', '2026-07-10 08:00:00'),
(4, 14, 85000, 'reward', 'پاداش امتیازی', 'success', '2026-07-05 16:45:00'),
(5, 14, 20000, 'fee', 'کارمزد تراکنش', 'failed', '2026-07-07 11:20:00'),
(6, 14, 150000, 'deposit', 'شارژ کیف پول', 'success', '2026-07-03 09:00:00'),
(7, 14, 90000, 'purchase', 'خرید محصول بازیافتی', 'success', '2026-07-02 13:30:00'),
(8, 14, 41000, 'sale', 'فروش ضایعات آلومینیوم', 'success', '2026-07-01 15:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recycling`
--
ALTER TABLE `recycling`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_sell`
--
ALTER TABLE `register_sell`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recyclingtype_id` (`recyclingtype_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`email`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recycling`
--
ALTER TABLE `recycling`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `register_sell`
--
ALTER TABLE `register_sell`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `register_sell`
--
ALTER TABLE `register_sell`
  ADD CONSTRAINT `register_sell_ibfk_1` FOREIGN KEY (`recyclingtype_id`) REFERENCES `recycling` (`id`),
  ADD CONSTRAINT `register_sell_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
