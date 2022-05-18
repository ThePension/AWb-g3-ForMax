-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `aw2_formax`;
CREATE DATABASE `aw2_formax` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `aw2_formax`;

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(50) NOT NULL,
  `likes` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user` int(11) NOT NULL,
  `fk_topic` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user` (`fk_user`),
  KEY `fk_topic` (`fk_topic`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `user` (`id`),
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`fk_topic`) REFERENCES `topic` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `comment` (`id`, `title`, `likes`, `content`, `timestamp`, `fk_user`, `fk_topic`) VALUES
(1,	'TOUT A FAIT',	0,	'La bière c\'est merveilleux !',	'2022-04-02 09:51:59',	1,	2),
(2,	'bel article',	0,	'Cet article décrit très bien les cerisiers merci bien !',	'2022-04-02 09:53:01',	3,	1),
(3,	'Passablement bon',	0,	'C\'est un aliment tout à fait sympathique !',	'2022-04-02 09:53:42',	2,	3);

DROP TABLE IF EXISTS `topic`;
CREATE TABLE `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `content` text NOT NULL,
  `rank` int(11) NOT NULL,
  `update_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `creation_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user` int(11) NOT NULL,
  `status` char(10) NOT NULL DEFAULT 'HIDDEN',
  `private_key` char(255),
  PRIMARY KEY (`id`),
  KEY `fk_user` (`fk_user`),
  CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `topic` (`id`, `name`, `content`, `rank`, `update_timestamp`, `creation_timestamp`, `fk_user`, `status`) VALUES
(1,	'La période des cerisiers',	'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Commodo nulla facilisi nullam vehicula ipsum a arcu cursus. Feugiat nisl pretium fusce id velit ut tortor pretium. Lacus sed viverra tellus in hac habitasse platea dictumst vestibulum. Massa vitae tortor condimentum lacinia quis vel eros donec. Eu ultrices vitae auctor eu augue. Dignissim sodales ut eu sem integer vitae. Nibh sit amet commodo nulla facilisi nullam vehicula. Facilisis leo vel fringilla est ullamcorper eget nulla. Iaculis urna id volutpat lacus laoreet. Consequat nisl vel pretium lectus quam id leo. In hendrerit gravida rutrum quisque non tellus orci ac. Mattis molestie a iaculis at erat pellentesque adipiscing. Orci eu lobortis elementum nibh tellus molestie nunc. A diam sollicitudin tempor id eu nisl nunc mi. Posuere morbi leo urna molestie at elementum eu facilisis. Fusce id velit ut tortor pretium viverra. Et ultrices neque ornare aenean. Malesuada nunc vel risus commodo viverra maecenas. Urna nunc id cursus metus aliquam eleifend mi.\r\n\r\nNisl rhoncus mattis rhoncus urna neque viverra justo. Non diam phasellus vestibulum lorem sed. Massa tempor nec feugiat nisl pretium. Facilisis mauris sit amet massa. Sem nulla pharetra diam sit amet nisl suscipit adipiscing. Semper quis lectus nulla at volutpat diam ut venenatis. Nisl pretium fusce id velit ut. Sodales ut etiam sit amet nisl. Mattis vulputate enim nulla aliquet porttitor lacus luctus accumsan. Pulvinar etiam non quam lacus suspendisse faucibus interdum posuere lorem. Integer vitae justo eget magna fermentum iaculis. Sit amet consectetur adipiscing elit duis tristique sollicitudin nibh. Faucibus nisl tincidunt eget nullam non nisi est. Tempor commodo ullamcorper a lacus vestibulum sed. Pretium viverra suspendisse potenti nullam ac tortor. Ullamcorper sit amet risus nullam eget. Rhoncus mattis rhoncus urna neque viverra justo nec ultrices. Risus commodo viverra maecenas accumsan lacus. Ultrices sagittis orci a scelerisque purus semper.',	0,	'2022-04-02 09:49:54',	'2022-04-02 09:49:54',	1, 'PUBLIC'),
(2,	'La bière',	'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Commodo nulla facilisi nullam vehicula ipsum a arcu cursus. Feugiat nisl pretium fusce id velit ut tortor pretium. Lacus sed viverra tellus in hac habitasse platea dictumst vestibulum. Massa vitae tortor condimentum lacinia quis vel eros donec. Eu ultrices vitae auctor eu augue. Dignissim sodales ut eu sem integer vitae. Nibh sit amet commodo nulla facilisi nullam vehicula. Facilisis leo vel fringilla est ullamcorper eget nulla. Iaculis urna id volutpat lacus laoreet. Consequat nisl vel pretium lectus quam id leo. In hendrerit gravida rutrum quisque non tellus orci ac. Mattis molestie a iaculis at erat pellentesque adipiscing. Orci eu lobortis elementum nibh tellus molestie nunc. A diam sollicitudin tempor id eu nisl nunc mi. Posuere morbi leo urna molestie at elementum eu facilisis. Fusce id velit ut tortor pretium viverra. Et ultrices neque ornare aenean. Malesuada nunc vel risus commodo viverra maecenas. Urna nunc id cursus metus aliquam eleifend mi.\r\n\r\nNisl rhoncus mattis rhoncus urna neque viverra justo. Non diam phasellus vestibulum lorem sed. Massa tempor nec feugiat nisl pretium. Facilisis mauris sit amet massa. Sem nulla pharetra diam sit amet nisl suscipit adipiscing. Semper quis lectus nulla at volutpat diam ut venenatis. Nisl pretium fusce id velit ut. Sodales ut etiam sit amet nisl. Mattis vulputate enim nulla aliquet porttitor lacus luctus accumsan. Pulvinar etiam non quam lacus suspendisse faucibus interdum posuere lorem. Integer vitae justo eget magna fermentum iaculis. Sit amet consectetur adipiscing elit duis tristique sollicitudin nibh. Faucibus nisl tincidunt eget nullam non nisi est. Tempor commodo ullamcorper a lacus vestibulum sed. Pretium viverra suspendisse potenti nullam ac tortor. Ullamcorper sit amet risus nullam eget. Rhoncus mattis rhoncus urna neque viverra justo nec ultrices. Risus commodo viverra maecenas accumsan lacus. Ultrices sagittis orci a scelerisque purus semper.',	0,	'2022-04-02 09:50:21',	'2022-04-02 09:50:21',	2, 'PRIVATE'),
(3,	'Les gaufres c\'est génial',	'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Commodo nulla facilisi nullam vehicula ipsum a arcu cursus. Feugiat nisl pretium fusce id velit ut tortor pretium. Lacus sed viverra tellus in hac habitasse platea dictumst vestibulum. Massa vitae tortor condimentum lacinia quis vel eros donec. Eu ultrices vitae auctor eu augue. Dignissim sodales ut eu sem integer vitae. Nibh sit amet commodo nulla facilisi nullam vehicula. Facilisis leo vel fringilla est ullamcorper eget nulla. Iaculis urna id volutpat lacus laoreet. Consequat nisl vel pretium lectus quam id leo. In hendrerit gravida rutrum quisque non tellus orci ac. Mattis molestie a iaculis at erat pellentesque adipiscing. Orci eu lobortis elementum nibh tellus molestie nunc. A diam sollicitudin tempor id eu nisl nunc mi. Posuere morbi leo urna molestie at elementum eu facilisis. Fusce id velit ut tortor pretium viverra. Et ultrices neque ornare aenean. Malesuada nunc vel risus commodo viverra maecenas. Urna nunc id cursus metus aliquam eleifend mi.\r\n\r\nNisl rhoncus mattis rhoncus urna neque viverra justo. Non diam phasellus vestibulum lorem sed. Massa tempor nec feugiat nisl pretium. Facilisis mauris sit amet massa. Sem nulla pharetra diam sit amet nisl suscipit adipiscing. Semper quis lectus nulla at volutpat diam ut venenatis. Nisl pretium fusce id velit ut. Sodales ut etiam sit amet nisl. Mattis vulputate enim nulla aliquet porttitor lacus luctus accumsan. Pulvinar etiam non quam lacus suspendisse faucibus interdum posuere lorem. Integer vitae justo eget magna fermentum iaculis. Sit amet consectetur adipiscing elit duis tristique sollicitudin nibh. Faucibus nisl tincidunt eget nullam non nisi est. Tempor commodo ullamcorper a lacus vestibulum sed. Pretium viverra suspendisse potenti nullam ac tortor. Ullamcorper sit amet risus nullam eget. Rhoncus mattis rhoncus urna neque viverra justo nec ultrices. Risus commodo viverra maecenas accumsan lacus. Ultrices sagittis orci a scelerisque purus semper.',	0,	'2022-04-02 09:51:09',	'2022-04-02 09:51:09',	3, 'PUBLIC');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(50) NOT NULL UNIQUE,
  `password` char(255) NOT NULL,
  `description` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `username`, `password`, `description`, `timestamp`) VALUES
(1,	'Francis',	'pass',	'Je suis Francis et c\'est tout !',	'2022-04-02 09:48:16'),
(2,	'Pascal',	'pass',	'Bien le bonjour !',	'2022-04-02 09:48:31'),
(3,	'Josianne',	'pass',	'J\'apprécie lire le journal',	'2022-04-02 09:48:52');

-- 2022-04-02 09:56:13
