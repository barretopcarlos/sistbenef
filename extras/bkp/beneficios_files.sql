/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 5.1.61 : Database - beneficios_files
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`beneficios_files` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `beneficios_files`;

/*Table structure for table `upload_anexos` */

DROP TABLE IF EXISTS `upload_anexos`;

CREATE TABLE `upload_anexos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conteudo` longblob,
  `id_solicitacao` int(11) DEFAULT NULL,
  `documento` varchar(12) NOT NULL,
  `extensao` char(3) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Table structure for table `upload_lancamento_contratual` */

DROP TABLE IF EXISTS `upload_lancamento_contratual`;

CREATE TABLE `upload_lancamento_contratual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conteudo` longblob,
  `id_educacao` int(11) DEFAULT NULL,
  `extensao` char(3) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Table structure for table `upload_notificacao` */

DROP TABLE IF EXISTS `upload_notificacao`;

CREATE TABLE `upload_notificacao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `conteudo` longblob,
  `extensao` char(3) NOT NULL,
  `id_notificacao` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
