CREATE DATABASE yeticave
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `category` char(128) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `email` char(64) NOT NULL,
  `password` char(64) NOT NULL,
  `name` char(128) DEFAULT NULL,
  `avatar` char(64) DEFAULT NULL,
  `contact` text,
  `registration_date` date DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS `lots` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `winner_id` int(11) NULL,
  `category_id` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `name_lot` char(30) NOT NULL,
  `description` text,
  `url_picture` varchar(100) DEFAULT NULL,
  `start_price` int(5) NOT NULL,
  `date_finish` datetime NOT NULL,
  FOREIGN KEY (category_id)  REFERENCES category(id),
  FOREIGN KEY (user_id)  REFERENCES users(id),
  FOREIGN KEY (winner_id)  REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS `bids` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lot_id` int(11) NOT NULL,
  `bid_date` date DEFAULT NULL,
  `bid_amount` int(11) DEFAULT NULL,
  FOREIGN KEY (user_id)  REFERENCES users(id),
  FOREIGN KEY (lot_id)  REFERENCES lots(id)
);

