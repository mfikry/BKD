-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql201.byetcluster.com
-- Generation Time: Jun 21, 2020 at 06:13 AM
-- Server version: 5.6.47-87.0
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_26066011_db_bkd`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_proposal`
--

CREATE TABLE `tb_proposal` (
  `id_proposal` int(11) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `jenis` text NOT NULL,
  `file` text NOT NULL,
  `nilai` varchar(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(150) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id_user`, `name`, `email`, `password`, `role_id`, `is_active`) VALUES
(14, 'Admin', 'admin@gmail.com', '$2y$10$Mc40d8GydYlQ0XtJOwZlJeI4LFvQaImXNHyUg0BxR4QmHNsmvw7Mu', 1, 1),
(16, 'Dosen', 'dosen@gmail.com', '$2y$10$jJByx3uiFby9pTK8VH6RyewVAC5LZGX1USTALZ83/35pdAFxIHIUC', 2, 1),
(17, 'Dosen Terpilih', 'dosenterpilih@gmail.com', '$2y$10$nMFmozViq3hfgm89l/BZEuFchhvlZCjOIovBiWMOnFlF7GC71HD76', 3, 1),
(18, 'Kaprodi', 'kaprodi@gmail.com', '$2y$10$bqzJGXiiupfVRalqDAD7cueOburWAqvOAHqiZyqrOfqtrY6hRm0Ka', 4, 1),
(19, 'viewer', 'viewer@gmail.com', '$2y$10$cSk9zTuC5snBNzdiGUiKHOYzKMM2ipYce0ousCT6uPGX47IZbwqIW', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'dosen'),
(3, 'dosen terpilih'),
(4, 'kaprodi'),
(5, 'viewer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_proposal`
--
ALTER TABLE `tb_proposal`
  ADD PRIMARY KEY (`id_proposal`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_proposal`
--
ALTER TABLE `tb_proposal`
  MODIFY `id_proposal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
