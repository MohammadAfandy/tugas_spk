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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_dosen` */

insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (27,'4935590607993192','Limar Prasetya Maheswara','Laki - Laki','Pariaman','1936-02-21','Dk. Sumpah Pemuda No. 381, Blitar 67416, Papua','08023057886','kprakasa@pertiwi.or.id');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (28,'3072761806166108','Oliva Yulianti S.Farm','Perempuan','Batu','2005-12-26','Kpg. Madrasah No. 636, Malang 86782, Bengkulu','0887342319','rajasa.jasmin@kusmawati.net');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (29,'3285356107139442','Cecep Mustofa','Laki - Laki','Pariaman','1994-01-08','Jr. Acordion No. 639, Kendari 91127, JaBar','0846008476','laksmiwati.tri@mardhiyah.tv');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (30,'2904087005032843','Rini Sudiati','Laki - Laki','Ternate','2009-04-17','Kpg. Casablanca No. 319, Banjarmasin 25810, SumUt','08880045246','gamani.hartati@marpaung.desa.id');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (31,'1391266708096911','Mahdi Winarno S.Farm','Laki - Laki','Kendari','1938-07-12','Jr. Kalimalang No. 418, Batu 41982, JaTeng','0861282233','ahabibi@yahoo.com');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (32,'8323252706976795','Bakijan Nashiruddin','Perempuan','Banjar','1987-03-05','Psr. Abdul Rahmat No. 191, Tanjung Pinang 99717, Maluku','08539990704','puspita.ganda@yahoo.co.id');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (33,'0816881406117734','Novi Usamah','Laki - Laki','Bontang','1995-04-05','Dk. Untung Suropati No. 853, Administrasi Jakarta Timur 65119, JaBar','08808797994','jpuspasari@yahoo.com');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (34,'4600481307000032','Edison Mangunsong','Perempuan','Pagar Alam','1922-02-11','Jln. Moch. Ramdan No. 192, Payakumbuh 53209, NTB','0828944803','vicky91@gmail.co.id');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (35,'3992150901037406','Dian Hasanah','Perempuan','Pekalongan','1988-11-15','Kpg. Daan No. 14, Bandung 16231, Bali','08196682029','rendy.anggriawan@dongoran.biz');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (36,'0185296812931127','Jefri Setiawan','Perempuan','Banjarmasin','2014-06-13','Dk. Abdul No. 335, Tanjungbalai 86864, JaTeng','085330793968','nilam77@putra.name');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (37,'0877123107157114','Patricia Nuraini','Perempuan','Manado','2013-09-14','Ds. Tambak No. 576, Pangkal Pinang 68350, MalUt','086186238648','okta33@yahoo.com');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (38,'3681782702966825','Situmorang Papahan','Perempuan','Bengkulu','1926-06-19','Gg. Jamika No. 437, Solok 69625, SulSel','086793504135','widya96@yahoo.co.id');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (39,'7086211012056172','Puspa Mila Wijayanti','Perempuan','Padangsidempuan','1995-02-22','Jln. Elang No. 635, Tual 99194, BaBel','08029762443','muhammad.rajata@pertiwi.info');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (40,'4769630308066781','Ajiman Setiawan','Laki - Laki','Makassar','1974-02-24','Ki. Rajawali Barat No. 59, Magelang 40313, NTB','089617100403','wijayanti.fitria@yahoo.co.id');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (41,'3117261605161188','Hani Puspasari','Laki - Laki','Medan','1926-11-10','Dk. Ters. Pasir Koja No. 730, Tual 50083, SulTeng','0859328655','irawan.balidin@yolanda.info');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (42,'4845252403127022','Jaya Damanik','Laki - Laki','Blitar','1929-11-15','Kpg. Baladewa No. 870, Kotamobagu 69128, Aceh','088281326780','pudjiastuti.almira@farida.biz');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (43,'9656170801099135','Raina Farah Nuraini','Laki - Laki','Pagar Alam','2000-07-30','Dk. Cemara No. 462, Pekanbaru 63100, BaBel','086170350158','oni.usada@dabukke.ac.id');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (44,'0271322405055758','Oni Rahmawati M.TI.','Laki - Laki','Balikpapan','2011-01-17','Jln. Achmad No. 214, Pangkal Pinang 81128, Lampung','08032354637','opadmasari@gmail.com');
insert  into `tbl_dosen`(`id`,`nidn`,`nama_dosen`,`jk`,`tempat_lahir`,`tgl_lahir`,`alamat`,`no_hp`,`email`) values (45,'7571460612148119','Mila Permata S.Pt','Perempuan','Kendari','1948-06-19','Jr. Diponegoro No. 921, Blitar 35125, SumSel','0863398988','manullang.jatmiko@gmail.co.id');

/*Table structure for table `tbl_kriteria` */

DROP TABLE IF EXISTS `tbl_kriteria`;

CREATE TABLE `tbl_kriteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kriteria` varchar(255) NOT NULL,
  `tipe` enum('BENEFIT','COST') DEFAULT NULL,
  `bobot` double DEFAULT NULL,
  `sub_kriteria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_kriteria` */

insert  into `tbl_kriteria`(`id`,`nama_kriteria`,`tipe`,`bobot`,`sub_kriteria`) values (1,'Psikotest','BENEFIT',0.15,NULL);
insert  into `tbl_kriteria`(`id`,`nama_kriteria`,`tipe`,`bobot`,`sub_kriteria`) values (12,'Wawancara','BENEFIT',0.2,NULL);
insert  into `tbl_kriteria`(`id`,`nama_kriteria`,`tipe`,`bobot`,`sub_kriteria`) values (13,'Umur','COST',0.2,NULL);
insert  into `tbl_kriteria`(`id`,`nama_kriteria`,`tipe`,`bobot`,`sub_kriteria`) values (14,'Jarak Rumah','COST',0.1,NULL);
insert  into `tbl_kriteria`(`id`,`nama_kriteria`,`tipe`,`bobot`,`sub_kriteria`) values (15,'Penampilan','BENEFIT',0.25,NULL);
insert  into `tbl_kriteria`(`id`,`nama_kriteria`,`tipe`,`bobot`,`sub_kriteria`) values (16,'Kemampuan','BENEFIT',0.1,NULL);

/*Table structure for table `tbl_penilaian` */

DROP TABLE IF EXISTS `tbl_penilaian`;

CREATE TABLE `tbl_penilaian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_dosen` int(11) NOT NULL,
  `nilai` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_penilaian` */

insert  into `tbl_penilaian`(`id`,`id_dosen`,`nilai`) values (3,28,'{\"1\":\"70\",\"12\":\"80\",\"13\":\"70\",\"14\":\"70\",\"15\":\"80\",\"16\":\"90\"}');
insert  into `tbl_penilaian`(`id`,`id_dosen`,`nilai`) values (4,38,'{\"1\":\"70\",\"12\":\"75\",\"13\":\"70\",\"14\":\"80\",\"15\":\"90\",\"16\":\"80\"}');
insert  into `tbl_penilaian`(`id`,`id_dosen`,`nilai`) values (5,27,'{\"1\":\"70\",\"12\":\"80\",\"13\":\"90\",\"14\":\"70\",\"15\":\"80\",\"16\":\"60\"}');
insert  into `tbl_penilaian`(`id`,`id_dosen`,`nilai`) values (6,41,'{\"1\":\"70\",\"12\":\"80\",\"13\":\"70\",\"14\":\"60\",\"15\":\"80\",\"16\":\"70\"}');
insert  into `tbl_penilaian`(`id`,`id_dosen`,`nilai`) values (7,29,'{\"1\":\"90\",\"12\":\"70\",\"13\":\"70\",\"14\":\"80\",\"15\":\"85\",\"16\":\"80\"}');
insert  into `tbl_penilaian`(`id`,`id_dosen`,`nilai`) values (8,31,'{\"1\":\"80\",\"12\":\"80\",\"13\":\"70\",\"14\":\"75\",\"15\":\"80\",\"16\":\"90\"}');
insert  into `tbl_penilaian`(`id`,`id_dosen`,`nilai`) values (9,34,'{\"1\":\"70\",\"12\":\"75\",\"13\":\"80\",\"14\":\"90\",\"15\":\"80\",\"16\":\"75\"}');
insert  into `tbl_penilaian`(`id`,`id_dosen`,`nilai`) values (10,32,'{\"1\":\"80\",\"12\":\"80\",\"13\":\"70\",\"14\":\"75\",\"15\":\"80\",\"16\":\"90\"}');
insert  into `tbl_penilaian`(`id`,`id_dosen`,`nilai`) values (11,33,'{\"1\":\"85\",\"12\":\"80\",\"13\":\"80\",\"14\":\"85\",\"15\":\"80\",\"16\":\"60\"}');
insert  into `tbl_penilaian`(`id`,`id_dosen`,`nilai`) values (12,35,'{\"1\":\"80\",\"12\":\"70\",\"13\":\"75\",\"14\":\"80\",\"15\":\"70\",\"16\":\"80\"}');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
