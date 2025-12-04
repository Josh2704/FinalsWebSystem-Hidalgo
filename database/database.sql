/*
SQLyog Community v13.3.0 (64 bit)
MySQL - 10.4.32-MariaDB : Database - ccdidb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ccdidb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `ccdidb`;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=989 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`fullname`,`created_at`) values 
(1,'user','admin','Jay Clarksen','2025-12-03 11:06:01');

/*Table structure for table `visitors` */

DROP TABLE IF EXISTS `visitors`;

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(150) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `school_office` varchar(255) DEFAULT NULL,
  `purpose` enum('inquiry','exam','visit','others') DEFAULT 'others',
  `visit_date` date NOT NULL,
  `visit_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_visit_date` (`visit_date`),
  KEY `idx_name` (`last_name`,`first_name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `visitors` */

insert  into `visitors`(`id`,`last_name`,`first_name`,`address`,`contact`,`school_office`,`purpose`,`visit_date`,`visit_time`,`created_at`) values 
(1,'De Castro','Aldwin','Bulusan','09171234567','CCDI','inquiry','2025-12-09','09:15:00','2025-12-03 11:05:03'),
(2,'Mayores','BonJhon','Pangpang','09281234567','CCDI','exam','2025-01-11','10:20:00','2025-12-03 11:05:03'),
(3,'Aquino','Adrian','Gubat','09391234567','CCDI','visit','2025-12-03','08:45:00','2025-12-03 11:05:03'),
(4,'Mojica','Jewelyn','Prieto','09051234567','CCDI','visit','2025-01-13','11:05:00','2025-12-03 11:05:03'),
(5,'Zybel','Dianne','Sorsogon City','09981234567','CCDI','others','2025-12-03','13:30:00','2025-12-03 11:05:03');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
