/*
SQLyog Community v13.3.0 (64 bit)
MySQL - 8.0 : Database - team_mgr
*********************************************************************
*/

/*!40101 SET NAMES utf8mb4 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`team_mgr` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `team_mgr`;

/*Table structure for table `leagues` */

DROP TABLE IF EXISTS `leagues`;

CREATE TABLE `leagues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `leagues` */

insert  into `leagues`(`id`,`name`) values 
(1,'Little League'),
(2,'Big Boys'),
(3,'Peanut League');

/*Table structure for table `players` */

DROP TABLE IF EXISTS `players`;

CREATE TABLE `players` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` int(10) unsigned NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `address` varchar(128) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `state_id` tinyint(3) unsigned DEFAULT NULL,
  `zip` varchar(32) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `team_id` (`team_id`),
  KEY `state_id` (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `players` */

insert  into `players`(`id`,`team_id`,`first_name`,`last_name`,`address`,`city`,`state_id`,`zip`,`email`,`phone`) values 
(1,1,'Billy','Bob','','',0,'','',''),
(2,2,'Tom','Foolery','123 Street','Big City',33,'12345','',''),
(3,3,'Shifty','Steve','Back Alley','Chicago',14,'54321','shifty.steve@scams.com','(123) 456-7890'),
(4,4,'Lefty','Jones','Long Road','West Side',11,'','',''),
(5,4,'Sammy','Slider','','',0,'','',''),
(6,3,'Dan','Diver','','',0,'','',''),
(7,1,'Pete','Popper','','',0,'','',''),
(8,1,'Robby','Runner','','',0,'','',''),
(9,4,'Horace','Homer','426 Elm Street','New York',33,'23422','horace.homer@superstrikers.com','(234) 234-2343 ext. 43');

/*Table structure for table `states` */

DROP TABLE IF EXISTS `states`;

CREATE TABLE `states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `abbr` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `states` */

insert  into `states`(`id`,`name`,`abbr`) values 
(1,'ALABAMA','AL'),
(2,'ALASKA','AK'),
(3,'ARIZONA','AZ'),
(4,'ARKANSAS','AR'),
(5,'CALIFORNIA','CA'),
(6,'COLORADO','CO'),
(7,'CONNECTICUT','CT'),
(8,'DELAWARE','DE'),
(9,'DISTRICT OF COLUMBIA','DC'),
(10,'FLORIDA','FL'),
(11,'GEORGIA','GA'),
(12,'HAWAII','HI'),
(13,'IDAHO','ID'),
(14,'ILLINOIS','IL'),
(15,'INDIANA','IN'),
(16,'IOWA','IA'),
(17,'KANSAS','KS'),
(18,'KENTUCKY','KY'),
(19,'LOUISIANA','LA'),
(20,'MAINE','ME'),
(21,'MARYLAND','MD'),
(22,'MASSACHUSETTS','MA'),
(23,'MICHIGAN','MI'),
(24,'MINNESOTA','MN'),
(25,'MISSISSIPPI','MS'),
(26,'MISSOURI','MO'),
(27,'MONTANA','MT'),
(28,'NEBRASKA','NE'),
(29,'NEVADA','NV'),
(30,'NEW HAMPSHIRE','NH'),
(31,'NEW JERSEY','NJ'),
(32,'NEW MEXICO','NM'),
(33,'NEW YORK','NY'),
(34,'NORTH CAROLINA','NC'),
(35,'NORTH DAKOTA','ND'),
(36,'OHIO','OH'),
(37,'OKLAHOMA','OK'),
(38,'OREGON','OR'),
(39,'PENNSYLVANIA','PA'),
(40,'RHODE ISLAND','RI'),
(41,'SOUTH CAROLINA','SC'),
(42,'SOUTH DAKOTA','SD'),
(43,'TENNESSEE','TN'),
(44,'TEXAS','TX'),
(45,'UTAH','UT'),
(46,'VERMONT','VT'),
(47,'VIRGINIA','VA'),
(48,'WASHINGTON','WA'),
(49,'WEST VIRGINIA','WV'),
(50,'WISCONSIN','WI'),
(51,'WYOMING','WY');

/*Table structure for table `teams` */

DROP TABLE IF EXISTS `teams`;

CREATE TABLE `teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `league_id` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `mascot` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `league_id` (`league_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `teams` */

insert  into `teams`(`id`,`league_id`,`name`,`mascot`) values 
(1,1,'Tigers','Tigger'),
(2,2,'Lions',''),
(3,3,'Bears','Pooh'),
(4,2,'Super Strikers',''),
(5,3,'Little Sluggers','');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
