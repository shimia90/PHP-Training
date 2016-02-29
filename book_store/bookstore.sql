-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2016 at 04:35 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `group_acp` tinyint(1) DEFAULT '0',
  `created` date DEFAULT '0000-00-00',
  `created_by` int(11) DEFAULT NULL,
  `modified` date DEFAULT '0000-00-00',
  `modified_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int(11) DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`, `group_acp`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`) VALUES
(1, 'Admin', 0, '2013-11-11', NULL, '2013-11-12', 10, 1, 2),
(2, 'Manager', 0, '2013-11-07', NULL, '2013-11-12', 10, 1, 1),
(3, 'Member', 0, '2013-11-12', 1, '2013-11-12', 10, 1, 1),
(4, 'Founder', 0, '2016-02-01', 1, '0000-00-00', NULL, 1, 6),
(73, 'Founder 3', 1, '2016-02-01', 1, '0000-00-00', NULL, 0, 3),
(74, 'Founder 10', 0, '2016-02-01', 1, '2016-02-01', NULL, 1, 12),
(75, 'Founder 4', 1, '2016-02-01', 1, '2016-02-01', NULL, 0, 44),
(76, 'Member 1', 0, '2016-02-01', 1, '2016-02-01', NULL, 0, 1),
(77, 'Member 2', 1, '2016-02-01', 1, '0000-00-00', NULL, 1, 22);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created` date DEFAULT '0000-00-00',
  `created_by` int(11) DEFAULT NULL,
  `modified` date DEFAULT '0000-00-00',
  `modified_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int(11) DEFAULT '10',
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `fullname`, `password`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`, `group_id`) VALUES
(1, 'nvan', 'nvan@gmail.com', 'Nguyễn Văn An', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00', 1, '0000-00-00', NULL, 1, 8, 1),
(2, 'nvb', 'nvb@gmail.com', 'Nguyễn Văn B', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00', 1, '0000-00-00', NULL, 1, 7, 2),
(3, 'nvc', 'nvc@gmail.com', 'Nguyễn Văn C', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00', 1, '0000-00-00', NULL, 1, 6, 3),
(4, 'admin', 'admin@gmail.com', 'Admin', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00', 1, '0000-00-00', NULL, 1, 5, 4),
(11, 'nvc3', 'nvc@gmail.com', 'Nguyễn Văn C', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00', 1, '0000-00-00', NULL, 1, 6, 3),
(12, 'abcd', 'thanh@gmail.com', 'Thanh Nguyen', '3b269d99b6c31f1467421bbcfdec7908', '2016-02-02', 1, '0000-00-00', NULL, 0, 12, 2),
(13, 'abcde', 'thanh1@gmail.com', 'DatNVT', '3b269d99b6c31f1467421bbcfdec7908', '2016-02-02', 1, '0000-00-00', NULL, 0, 44, 75),
(14, 'admin3', 'thanh2@gmail.com', 'DatNVT', '3b269d99b6c31f1467421bbcfdec7908', '2016-02-02', 1, '2016-02-03', 10, 1, 12, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
