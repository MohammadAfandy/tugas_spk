/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.1.37-MariaDB : Database - db_spk_dosen
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_spk_dosen` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_spk_dosen`;

/*Table structure for table `tbl_dosen` */

DROP TABLE IF EXISTS `tbl_dosen`;

CREATE TABLE `tbl_dosen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nidn` varchar(50) NOT NULL,
  `nama_dosen` varchar(255) NOT NULL,
  `jk` enum('Laki - Laki','Perempuan') DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_kriteria` */

DROP TABLE IF EXISTS `tbl_kriteria`;

CREATE TABLE `tbl_kriteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kriteria` varchar(255) NOT NULL,
  `tipe` enum('BENEFIT','COST') DEFAULT NULL,
  `bobot` double DEFAULT NULL,
  `sub_kriteria` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_penilaian` */

DROP TABLE IF EXISTS `tbl_penilaian`;

CREATE TABLE `tbl_penilaian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_dosen` int(11) NOT NULL,
  `nilai` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_dosen` (`id_dosen`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
