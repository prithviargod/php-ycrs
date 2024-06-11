-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2023 at 06:11 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `ycrs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Hatha Yoga', 1, 0, '2023-01-31 10:45:26', NULL),
(2, 'Ashtanga Yoga', 1, 0, '2023-01-31 10:45:46', NULL),
(3, 'Vinyasa Yoga', 1, 0, '2023-01-31 10:45:58', NULL),
(4, 'Kundalini Yoga', 1, 0, '2023-01-31 10:46:09', NULL),
(5, 'Iyengar Yoga', 1, 0, '2023-01-31 10:46:19', NULL),
(6, 'Aerial Yoga', 1, 0, '2023-01-31 10:46:29', NULL),
(7, 'Prenatal Yoga', 1, 0, '2023-01-31 10:47:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_list`
--

CREATE TABLE `class_list` (
  `id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `instructor` text NOT NULL,
  `fee` float(12,2) NOT NULL DEFAULT 0.00,
  `image_path` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_list`
--

INSERT INTO `class_list` (`id`, `category_id`, `name`, `description`, `instructor`, `fee`, `image_path`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 7, 'Prenatal Yoga Class', '&lt;p&gt;&lt;span style=&quot;text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec nibh nec augue cursus laoreet. Nulla aliquam felis magna, ac laoreet velit commodo in. Integer eu rutrum mi. Quisque placerat nisi purus. Praesent ut sagittis libero, quis lacinia urna. Pellentesque elementum odio a quam dapibus, eu hendrerit dui pulvinar. Donec suscipit nisi sit amet dolor posuere, sit amet accumsan libero feugiat. Etiam et facilisis nisi.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 'Colby Donaldson', 1200.00, 'uploads/classs//yoga-2.jpg?v=1675134698', 1, 0, '2023-01-31 11:11:38', '2023-01-31 11:11:38'),
(2, 4, 'Kundalini Yoga Class', '&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;&quot;&gt;Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi posuere, velit et luctus dapibus, diam elit mattis elit, quis congue erat eros a magna. Donec facilisis ex a ullamcorper mattis. Aenean sit amet urna at mi condimentum sagittis. Sed vitae arcu convallis, viverra orci a, consequat nulla. Ut blandit nunc eu augue consectetur, non imperdiet elit tempor. Curabitur lacinia orci sit amet ultricies facilisis. Cras scelerisque magna a dapibus auctor. Nulla vestibulum pulvinar consequat. Sed eu lacinia enim. Phasellus risus metus, tempus a lorem et, convallis varius diam. Quisque laoreet nisi quis urna malesuada egestas. Praesent at est ex. Aliquam egestas faucibus orci. Mauris aliquet dictum turpis ac maximus.&lt;/p&gt;&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;&quot;&gt;In semper diam vitae sapien maximus rhoncus. Duis id bibendum magna. Nulla facilisi. Pellentesque et purus facilisis diam cursus accumsan. Integer blandit eleifend ante in porta. Vivamus et aliquet dui. Quisque quis vehicula augue. Vivamus tristique cursus libero, at tincidunt neque ultrices in. Quisque commodo mauris vitae elit fermentum dapibus. Mauris a tristique nisi. Nulla interdum pharetra dapibus. Cras tincidunt, metus non rutrum vehicula, est odio rutrum orci, ut ornare quam lectus et nisl. Proin at augue nunc. Mauris interdum leo non nibh imperdiet ullamcorper ac sit amet nunc.&lt;/p&gt;', 'Amaya Forbes', 1100.00, 'uploads/classs//yoga-3.jpg?v=1675134910', 1, 0, '2023-01-31 11:15:10', '2023-01-31 11:15:10');

-- --------------------------------------------------------

--
-- Table structure for table `inquiry_list`
--

CREATE TABLE `inquiry_list` (
  `id` int(30) NOT NULL,
  `fullname` text NOT NULL,
  `contact` text NOT NULL,
  `email` text DEFAULT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inquiry_list`
--

INSERT INTO `inquiry_list` (`id`, `fullname`, `contact`, `email`, `subject`, `message`, `status`, `date_created`, `date_updated`) VALUES
(2, 'Samantha Lou', '09123654789', 'sam23@mail.com', 'Sample Mail Only', 'Sample Inquiry', 1, '2023-01-31 13:07:10', '2023-01-31 13:07:18');

-- --------------------------------------------------------

--
-- Table structure for table `registration_list`
--

CREATE TABLE `registration_list` (
  `id` int(30) NOT NULL,
  `code` varchar(50) NOT NULL,
  `class_id` int(30) NOT NULL,
  `fullname` text NOT NULL,
  `email` text NOT NULL,
  `dob` date NOT NULL,
  `sex` varchar(50) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registration_list`
--

INSERT INTO `registration_list` (`id`, `code`, `class_id`, `fullname`, `email`, `dob`, `sex`, `contact`, `address`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, '2023013100001', 1, 'Anika Hunter', 'ahunter@mail.com', '2005-03-21', 'Female', '09123546897', '944 Overlook Rd., Depew, NY 14043', 0, 0, '2023-01-31 11:56:23', NULL),
(2, '2023013100002', 1, 'Gemma Tate', 'gtate@mail.com', '2001-08-09', 'Male', '09456987123', '\r\n96 Riverview Lane, Decatur, GA 30030', 1, 0, '2023-01-31 12:02:44', '2023-01-31 13:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Yoga Classes Registration System'),
(6, 'short_name', 'YCRS - PHP'),
(11, 'logo', 'uploads/logo.png?v=1675131756'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover.png?v=1675131770'),
(17, 'phone', '456-987-1231'),
(18, 'mobile', '09123456987 / 094563212222 '),
(19, 'email', 'info@xyzsanitizationservices.com'),
(20, 'address', '7087 Henry St. Clifton Park, NY 12065');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='2';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', '', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatars/1.png?v=1649834664', NULL, 1, '2021-01-20 14:02:37', '2022-05-16 14:17:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_list`
--
ALTER TABLE `class_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_category_id_fk` (`category_id`);

--
-- Indexes for table `inquiry_list`
--
ALTER TABLE `inquiry_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration_list`
--
ALTER TABLE `registration_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `class_list`
--
ALTER TABLE `class_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inquiry_list`
--
ALTER TABLE `inquiry_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registration_list`
--
ALTER TABLE `registration_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class_list`
--
ALTER TABLE `class_list`
  ADD CONSTRAINT `class_category_id_fk` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;
