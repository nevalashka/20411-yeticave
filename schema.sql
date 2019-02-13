CREATE DATABASE yeticave
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE IF NOT EXISTS `bids` (
  `id` int(11) NOT NULL,
  `bid_date` date DEFAULT NULL,
  `bid_amount` int(11) DEFAULT NULL
);


CREATE TABLE IF NOT EXISTS `categoty` (
  `id` int(11) NOT NULL,
  `category` char(128) DEFAULT NULL
);


CREATE TABLE IF NOT EXISTS `lots` (
  `id` int(10) NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `name_lot` varchar(30) DEFAULT NULL,
  `description` text,
  `url_picture` varchar(100) DEFAULT NULL,
  `start_price` int(5) DEFAULT NULL,
  `date_finish` datetime DEFAULT NULL,
  `bid` int(5) DEFAULT NULL
);


CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` char(64) NOT NULL,
  `name` char(128) DEFAULT NULL,
  `avatar` char(64) DEFAULT NULL,
  `contact` text,
  `registration_date` date DEFAULT NULL
);


ALTER TABLE `bids`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `categoty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

ALTER TABLE `lots`
  ADD KEY `id` (`id`),
  ADD KEY `name_lot` (`name_lot`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `bids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `categoty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lots`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
