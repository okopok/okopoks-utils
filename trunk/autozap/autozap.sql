/*
SQLyog Enterprise - MySQL GUI v6.0
Host - 5.0.18-nt : Database - autozap
*********************************************************************
Server version : 5.0.18-nt
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `autozap`;

USE `autozap`;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `auto_articles` */

DROP TABLE IF EXISTS `auto_articles`;

CREATE TABLE `auto_articles` (
  `pk_article_id` int(11) NOT NULL auto_increment,
  `article_name` varchar(255) character set cp1251 NOT NULL,
  `article_name_tag` varchar(255) character set cp1251 NOT NULL,
  `article_text` text character set cp1251 NOT NULL,
  `article_timestamp` int(11) NOT NULL default '0',
  `article_owner` int(11) NOT NULL default '0',
  `article_publish` enum('yes','no') character set cp1251 NOT NULL default 'yes',
  `article_changetime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pk_article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `auto_articles` */

insert  into `auto_articles`(`pk_article_id`,`article_name`,`article_name_tag`,`article_text`,`article_timestamp`,`article_owner`,`article_publish`,`article_changetime`) values (1,'Контактная информация','kotaktnaya_informaciya','Бугага\r\nбугага\r\nбуГаг',1194856773,1,'yes',0);
insert  into `auto_articles`(`pk_article_id`,`article_name`,`article_name_tag`,`article_text`,`article_timestamp`,`article_owner`,`article_publish`,`article_changetime`) values (2,'Контакты','kontakty','Типа контактная информация тут\r\n\r\nи тут тоже :)	',0,1,'yes',0);

/*Table structure for table `auto_blocks` */

DROP TABLE IF EXISTS `auto_blocks`;

CREATE TABLE `auto_blocks` (
  `fk_block_if` int(11) NOT NULL auto_increment,
  `block_name` varchar(255) NOT NULL,
  `block_name_tag` varchar(255) NOT NULL,
  PRIMARY KEY  (`fk_block_if`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `auto_blocks` */

insert  into `auto_blocks`(`fk_block_if`,`block_name`,`block_name_tag`) values (1,'????? ????','left_block');
insert  into `auto_blocks`(`fk_block_if`,`block_name`,`block_name_tag`) values (2,'??????????? ????','central_block');

/*Table structure for table `auto_blocks_themes` */

DROP TABLE IF EXISTS `auto_blocks_themes`;

CREATE TABLE `auto_blocks_themes` (
  `fk_block_id` int(11) NOT NULL,
  `fk_theme_id` int(11) NOT NULL,
  `theme_align` enum('left','center','right','justify') NOT NULL default 'justify',
  `theme_width` varchar(5) NOT NULL,
  `theme_order` int(3) NOT NULL default '0',
  PRIMARY KEY  (`fk_block_id`,`fk_theme_id`,`theme_align`,`theme_order`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `auto_blocks_themes` */

/*Table structure for table `auto_brands` */

DROP TABLE IF EXISTS `auto_brands`;

CREATE TABLE `auto_brands` (
  `pk_brands_id` int(11) NOT NULL auto_increment,
  `brands_name` varchar(255) character set cp1251 NOT NULL,
  `brands_name_tag` varchar(255) character set cp1251 NOT NULL,
  `brands_info` text character set cp1251,
  PRIMARY KEY  (`pk_brands_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `auto_brands` */

insert  into `auto_brands`(`pk_brands_id`,`brands_name`,`brands_name_tag`,`brands_info`) values (3,'Mazda','mazda',NULL);
insert  into `auto_brands`(`pk_brands_id`,`brands_name`,`brands_name_tag`,`brands_info`) values (4,'Nissan','nissan',NULL);

/*Table structure for table `auto_models` */

DROP TABLE IF EXISTS `auto_models`;

CREATE TABLE `auto_models` (
  `pk_models_id` int(11) NOT NULL auto_increment,
  `fk_brands_id` int(11) NOT NULL,
  `models_name` varchar(255) character set cp1251 NOT NULL,
  `models_name_tag` varchar(255) character set cp1251 NOT NULL,
  `models_info` text character set cp1251,
  PRIMARY KEY  (`pk_models_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `auto_models` */

insert  into `auto_models`(`pk_models_id`,`fk_brands_id`,`models_name`,`models_name_tag`,`models_info`) values (7,3,'MPV 2000-2005','mpv_2000_2005',NULL);
insert  into `auto_models`(`pk_models_id`,`fk_brands_id`,`models_name`,`models_name_tag`,`models_info`) values (8,4,'Конкорд 1998-2004','konkord_1998_2004',NULL);
insert  into `auto_models`(`pk_models_id`,`fk_brands_id`,`models_name`,`models_name_tag`,`models_info`) values (10,3,'MPV 2001','mpv_2001',NULL);
insert  into `auto_models`(`pk_models_id`,`fk_brands_id`,`models_name`,`models_name_tag`,`models_info`) values (21,4,'300М','300m',NULL);
insert  into `auto_models`(`pk_models_id`,`fk_brands_id`,`models_name`,`models_name_tag`,`models_info`) values (22,4,'Конкорд','konkord',NULL);
insert  into `auto_models`(`pk_models_id`,`fk_brands_id`,`models_name`,`models_name_tag`,`models_info`) values (23,3,'3','3',NULL);
insert  into `auto_models`(`pk_models_id`,`fk_brands_id`,`models_name`,`models_name_tag`,`models_info`) values (24,3,'6','6',NULL);
insert  into `auto_models`(`pk_models_id`,`fk_brands_id`,`models_name`,`models_name_tag`,`models_info`) values (25,3,'MPV','mpv',NULL);

/*Table structure for table `auto_parts` */

DROP TABLE IF EXISTS `auto_parts`;

CREATE TABLE `auto_parts` (
  `pk_parts_id` int(11) NOT NULL auto_increment,
  `fk_models_id` int(11) NOT NULL default '0',
  `parts_name` varchar(255) character set cp1251 NOT NULL,
  `parts_info` text character set cp1251,
  `parts_cost` float default '0',
  `parts_cost_old` float default '0',
  `parts_number` int(11) default '0',
  `parts_number_old` int(11) default '0',
  `parts_uid` varchar(255) character set cp1251 default NULL,
  `parts_cond` enum('yes','no','waiting') character set cp1251 default 'yes',
  PRIMARY KEY  (`pk_parts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `auto_parts` */

insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1747,7,'MAF сенсор',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1748,7,'TPS сенсор',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1749,7,'Амортизатор задний левый',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1750,7,'Амортизатор задний правый',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1751,7,'Амортизатор передний левый',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1752,7,'Амортизатор передний правый',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1753,7,'Амортизаторы пятой двери 2 шт',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1754,7,'Аэрбег водительский с рулем',NULL,0,5000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1755,7,'Аэрбэг пассажирский',NULL,0,5000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1756,7,'Бампер задний',NULL,0,5000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1757,7,'Бампер передний в сборе',NULL,0,12000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1758,7,'Барабан тормозной 2шт',NULL,0,0,0,1,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1759,7,'Бачек ГУРа',NULL,0,600,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1760,7,'Бачек омывателя',NULL,0,750,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1761,7,'Бачек расширительный ',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1762,7,'Бензобак',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1763,7,'Бензонасос',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1764,7,'Блок АВС',NULL,0,6000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1765,7,'Бочка глушителя',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1766,7,'Брызговики',NULL,0,600,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1767,7,'Впускной коллектор',NULL,0,3000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1768,7,'Генератор ',NULL,0,4500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1769,7,'Гидроусилитель',NULL,0,4500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1770,7,'Главный тормозной цилиндр',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1771,7,'Датчик кислородный',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1772,7,'Датчик положения коленвала',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1773,7,'Датчик положения распредвала',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1774,7,'Дверь задняя левая',NULL,0,10000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1775,7,'Дверь задняя правая',NULL,0,10000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1776,7,'Дверь передняя левая',NULL,0,10000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1777,7,'Дверь передняя правая',NULL,0,10000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1778,7,'Дверь пятая',NULL,0,15000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1779,7,'Дворник',NULL,0,500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1780,7,'ДВС 2,0 FS',NULL,0,10000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1781,7,'Дефлектор радиатора',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1782,7,'Диск тормозной передний 2 шт',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1783,7,'Диски колесные с резиной',NULL,0,12000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1784,7,'Замок багажника',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1785,7,'Замок двери задней левой',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1786,7,'Замок двери задней правой',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1787,7,'Замок двери передей левой',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1788,7,'Замок двери передей правой',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1789,7,'Замок зажигания + дверные личинки',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1790,7,'Замок капота',NULL,0,1200,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1791,7,'Защита двигателя пластиковая левая',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1792,7,'Защита двигателя пластиковая правая',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1793,7,'Зеркало заднего вида левое',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1794,7,'Зеркало заднего вида правое',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1795,7,'Испаритель',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1796,7,'Капот',NULL,0,7000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1797,7,'Катализатор',NULL,0,5000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1798,7,'Коллектор выпускной',NULL,0,3000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1799,7,'Кнопки стелоподъемника 3шт',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1800,7,'Кнопки управления моршрутным компьютером',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1801,7,'Компрессор кондиционера',NULL,0,7500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1802,7,'Компьютер',NULL,0,6000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1803,7,'Корпус воздушного фильтра',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1804,7,'Крыло левое заднее',NULL,0,9000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1805,7,'Крыло левое переднее',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1806,7,'Крыло правое заднее',NULL,0,9000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1807,7,'Крыло правое переднее',NULL,0,2500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1808,7,'Крыша',NULL,0,15000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1809,7,'Лонжерон передний левый',NULL,0,12000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1810,7,'Лонжерон передний правый',NULL,0,12000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1811,7,'Лючек бензобака',NULL,0,500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1812,7,'Механизм стеклоподъемника 4шт',NULL,0,3000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1813,7,'МКПП',NULL,0,15000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1814,7,'Молдинг двери задн правой',NULL,0,600,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1815,7,'Молдинг двери пер правой',NULL,0,600,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1816,7,'Молдинг задней левой двери',NULL,0,600,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1817,7,'Молдинг передней левой двери',NULL,0,600,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1818,7,'Мотор вентилятора',NULL,0,7500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1819,7,'Мотор стеклоомывателя',NULL,0,600,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1820,7,'Мотор стеклоочистителя',NULL,0,3000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1821,7,'Мотор стеклоподъёмника задний левый',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1822,7,'Мотор стеклоподъёмника задний правый',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1823,7,'Мотор стеклоподъёмника передний левый',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1824,7,'Мотор стеклоподъёмника передний правый',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1825,7,'Мотор центрозамка 4шт',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1826,7,'Накладка пластиковая',NULL,0,500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1827,7,'Наполнитель заднего бампера',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1828,7,'Наполнитель переднего бампера',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1829,7,'Насос охлаждающей жидкости',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1830,7,'Натяжитель',NULL,0,500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1831,7,'Облицовка щитка приборов',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1832,7,'Обшивка двери пер левой',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1833,7,'Обшивка двери пер правой',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1834,7,'Опоры ДВС и АКПП',NULL,0,3000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1835,7,'Отопитель задний',NULL,0,6000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1836,7,'Патрубок (тройник на задний отопитель)',NULL,0,500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1837,7,'Передняя панель',NULL,0,4500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1838,7,'Петли багажника 2шт',NULL,0,0,0,1,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1839,7,'Петли капота 2 шт',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1840,7,'Пластиковая накладка задней панели',NULL,0,500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1841,7,'Плафон с очешником',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1842,7,'Площадка АКБ',NULL,0,750,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1843,7,'Площадка дворников',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1844,7,'Поворотник в крыло лев',NULL,0,450,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1845,7,'Поворотник в крыло прав',NULL,0,450,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1846,7,'Поворотник лев',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1847,7,'Поворотник прав',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1848,7,'Поворотный кулак задний левый',NULL,0,3500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1849,7,'Поворотный кулак задний правый',NULL,0,3500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1850,7,'Поворотный кулак передний левый',NULL,0,3500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1851,7,'Поворотный кулак передний правый',NULL,0,3500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1852,7,'Подкрылок лев',NULL,0,750,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1853,7,'Подкрылок лев задн',NULL,0,500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1854,7,'Подкрылок прав',NULL,0,750,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1855,7,'Подкрылок прав задн',NULL,0,500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1856,7,'Подрамник',NULL,0,10000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1857,7,'Потолок',NULL,0,3500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1858,7,'Привод левый',NULL,0,5000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1859,7,'Привод правый',NULL,0,5000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1860,7,'Проводка',NULL,0,3000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1861,7,'Пружина задняя',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1862,7,'Пружина передняя',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1863,7,'Пылезащита под бампер',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1864,7,'Радиатор кондиционера',NULL,0,5000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1865,7,'Радиатор отопителя',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1866,7,'Радиатор охл. ДВС',NULL,0,4000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1867,7,'Регулятор ХХ',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1868,7,'Рейка рулевая',NULL,0,10000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1869,7,'Релинги',NULL,0,3000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1870,7,'Ремень передний левый с преднатяжителем',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1871,7,'Ремень передний правый с преднатяжителем',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1872,7,'Решотка в бампер боковая 2шт',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1873,7,'Решотка в бампер центральная',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1874,7,'Решотка радиатора',NULL,0,2500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1875,7,'Ролик паразитный',NULL,0,500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1876,7,'Руль',NULL,0,500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1877,7,'Ручка двери задн лев наружняя',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1878,7,'Ручка двери задн прав наружняя',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1879,7,'Ручка двери пер лев наружняя',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1880,7,'Ручка двери пер прав наружняя',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1881,7,'Ручка дверная внутренняя левая',NULL,0,500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1882,7,'Ручка дверная внутренняя правая',NULL,0,500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1883,7,'Рычаг передней подвески левый',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1884,7,'Рычаг передней подвески правый',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1885,7,'Салон',NULL,0,10000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1886,7,'Стабилизатор задний',NULL,0,1000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1887,7,'Стабилизатор передний',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1888,7,'Стартер',NULL,0,4500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1889,7,'Стекло заднее левое',NULL,0,3000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1890,7,'Стекло заднее открывающееся левое',NULL,0,4000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1891,7,'Стекло заднее открывающееся правое',NULL,0,4000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1892,7,'Стекло заднее правое',NULL,0,3000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1893,7,'Стекло переднее левое',NULL,0,3000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1894,7,'Стекло переднее правое',NULL,0,3000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1895,7,'Стекло пятой двери',NULL,0,6000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1896,7,'Суппорт задний левый',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1897,7,'Суппорт задний правый',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1898,7,'Суппорт передний левый',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1899,7,'Суппорт передний правый',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1900,7,'Суппорт радиатора',NULL,0,10000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1901,7,'Торпеда',NULL,0,10000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1902,7,'Трос ручника 2шт',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1903,7,'Трубки печные на задний отопитель',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1904,7,'Уплотнители дверные',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1905,7,'Уплотнитель багажника',NULL,0,750,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1906,7,'Управление задним отопителем',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1907,7,'Усилитель переднего бампера',NULL,0,5000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1908,7,'Фара левая',NULL,0,2500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1909,7,'Фара правая',NULL,0,2500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1910,7,'Фаркоп',NULL,0,2500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1911,7,'Фонарь задний левый',NULL,0,2500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1912,7,'Фонарь задний правый',NULL,0,2500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1913,7,'Форсунка 4 шт',NULL,0,2400,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1914,7,'Шланг ГУРа высокого давления',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1915,7,'Шланг ГУРа низкого давления',NULL,0,1500,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1916,7,'Щиток приборов',NULL,0,2000,0,1,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1917,8,'MAF сенсор',NULL,0,1500,0,3,'F4DZ 6062-AA','yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1918,8,'TPS сенсор',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1919,8,'АКПП',NULL,0,30000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1920,8,'Амортизатор задний левый',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1921,8,'Амортизатор задний правый',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1922,8,'Амортизатор передний левый',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1923,8,'Амортизатор передний правый',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1924,8,'Аэрбег водительский с рулем',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1925,8,'Бампер задний',NULL,0,7500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1926,8,'Бампер передний',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1927,8,'Бензобак',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1928,8,'Бензонасос',NULL,0,2000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1929,8,'Блок АВС',NULL,0,6000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1930,8,'Бочка глушителя',NULL,0,1500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1931,8,'Впускной коллектор',NULL,0,4000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1932,8,'Генератор ',NULL,0,4500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1933,8,'Гидроусилитель',NULL,0,4500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1934,8,'Датчик кислородный',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1935,8,'Датчик положения коленвала',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1936,8,'Датчик положения распредвала',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1937,8,'Дверь задняя левая',NULL,0,10000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1938,8,'Дверь задняя правая',NULL,0,10000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1939,8,'Дверь передняя левая',NULL,0,10000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1940,8,'Дверь передняя правая',NULL,0,10000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1941,8,'ДВС 2,7',NULL,0,50000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1942,8,'Диски колесные',NULL,0,7500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1943,8,'Замок багажника',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1944,8,'Замок двери задней левой',NULL,0,750,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1945,8,'Замок двери задней правой',NULL,0,750,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1946,8,'Замок двери передей левой',NULL,0,750,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1947,8,'Замок двери передей правой',NULL,0,750,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1948,8,'Замок зажигания + дверные личинки',NULL,0,3000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1949,8,'Замок капота',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1950,8,'Зеркало заднего вида левое',NULL,0,2000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1951,8,'Зеркало заднего вида правое',NULL,0,2000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1952,8,'Испаритель',NULL,0,1500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1953,8,'Капот',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1954,8,'Катализатор',NULL,0,4500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1955,8,'Компрессор кондиционера',NULL,0,5000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1956,8,'Компьютер',NULL,0,6000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1957,8,'Крыло левое заднее',NULL,0,6000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1958,8,'Крыло левое переднее',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1959,8,'Крыло правое заднее',NULL,0,6000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1960,8,'Крыло правое переднее',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1961,8,'Крышка багажника',NULL,0,6000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1962,8,'Молдинг задней левой двери',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1963,8,'Молдинг задней правой двери',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1964,8,'Молдинг передней левой двери',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1965,8,'Молдинг передней правой двери',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1966,8,'Мотор вентилятора',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1967,8,'Мотор стеклоомывателя',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1968,8,'Мотор стеклоочистителя',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1969,8,'Мотор стеклоподъёмника задний левый',NULL,0,750,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1970,8,'Мотор стеклоподъёмника задний правый',NULL,0,750,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1971,8,'Мотор стеклоподъёмника передний левый',NULL,0,750,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1972,8,'Мотор стеклоподъёмника передний правый',NULL,0,750,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1973,8,'Мотор центрозамка ',NULL,0,2400,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1974,8,'Насос охлаждающей жидкости',NULL,0,2000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1975,8,'Натяжитель',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1976,8,'Опоры ДВС и АКПП',NULL,0,3000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1977,8,'Передняя панель',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1978,8,'Поворотный кулак задний левый',NULL,0,2000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1979,8,'Поворотный кулак задний правый',NULL,0,2000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1980,8,'Поворотный кулак передний левый',NULL,0,2000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1981,8,'Поворотный кулак передний правый',NULL,0,2000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1982,8,'Подрамник',NULL,0,5000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1983,8,'Привод левый',NULL,0,4500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1984,8,'Привод правый',NULL,0,4500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1985,8,'Проводка',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1986,8,'Пружина задняя',NULL,0,2000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1987,8,'Пружина передняя',NULL,0,2000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1988,8,'Радиатор кондиционера',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1989,8,'Радиатор отопителя',NULL,0,2000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1990,8,'Радиатор охл. ДВС',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1991,8,'Регулятор ХХ',NULL,0,1500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1992,8,'Рейка рулевая',NULL,0,6000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1993,8,'Ролик паразитный',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1994,8,'Рычаг передней подвески левый',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1995,8,'Рычаг передней подвески правый',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1996,8,'Салон',NULL,0,9000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1997,8,'Стартер',NULL,0,4500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1998,8,'Стекло заднее',NULL,0,7500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (1999,8,'Стекло заднее левое',NULL,0,3000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2000,8,'Стекло заднее правое',NULL,0,3000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2001,8,'Стекло переднее левое',NULL,0,3000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2002,8,'Стекло переднее правое',NULL,0,3000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2003,8,'Суппорт задний левый',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2004,8,'Суппорт задний правый',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2005,8,'Суппорт передний левый',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2006,8,'Суппорт передний правый',NULL,0,1000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2007,8,'Торпеда с аэрбегом',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2008,8,'Уплотнители дверные',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2009,8,'Усилитель переднего бампера',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2010,8,'Фара левая',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2011,8,'Фара правая',NULL,0,0,0,3,NULL,'no');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2012,8,'Фонарь задний левый',NULL,0,2500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2013,8,'Фонарь задний правый',NULL,0,2500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2014,8,'Форсунка 6 шт',NULL,0,2000,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2015,8,'Шланг ГУРа высокого давления',NULL,0,1500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2016,8,'Шланг ГУРа низкого давления',NULL,0,1500,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2017,8,'Эмблема',NULL,0,400,0,3,NULL,'yes');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2134,10,'MAF сенсор',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2135,10,'TPS сенсор',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2136,10,'Амортизатор задний левый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2137,10,'Амортизатор задний правый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2138,10,'Амортизатор передний левый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2139,10,'Амортизатор передний правый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2140,10,'Амортизаторы пятой двери 2 шт',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2141,10,'Аэрбег водительский с рулем',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2142,10,'Аэрбэг пассажирский',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2143,10,'Бампер задний',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2144,10,'Бампер передний в сборе',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2145,10,'Барабан тормозной 2шт',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2146,10,'Бачек ГУРа',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2147,10,'Бачек омывателя',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2148,10,'Бачек расширительный ',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2149,10,'Бензобак',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2150,10,'Бензонасос',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2151,10,'Блок АВС',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2152,10,'Бочка глушителя',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2153,10,'Брызговики',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2154,10,'Впускной коллектор',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2155,10,'Генератор ',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2156,10,'Гидроусилитель',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2157,10,'Главный тормозной цилиндр',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2158,10,'Датчик кислородный',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2159,10,'Датчик положения коленвала',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2160,10,'Датчик положения распредвала',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2161,10,'Дверь задняя левая',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2162,10,'Дверь задняя правая',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2163,10,'Дверь передняя левая',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2164,10,'Дверь передняя правая',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2165,10,'Дверь пятая',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2166,10,'Дворник',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2167,10,'ДВС 2,0 FS',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2168,10,'Дефлектор радиатора',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2169,10,'Диск тормозной передний 2 шт',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2170,10,'Диски колесные с резиной',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2171,10,'Замок багажника',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2172,10,'Замок двери задней левой',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2173,10,'Замок двери задней правой',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2174,10,'Замок двери передей левой',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2175,10,'Замок двери передей правой',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2176,10,'Замок зажигания + дверные личинки',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2177,10,'Замок капота',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2178,10,'Защита двигателя пластиковая левая',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2179,10,'Защита двигателя пластиковая правая',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2180,10,'Зеркало заднего вида левое',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2181,10,'Зеркало заднего вида правое',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2182,10,'Испаритель',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2183,10,'Капот',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2184,10,'Катализатор',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2185,10,'Коллектор выпускной',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2186,10,'Кнопки стелоподъемника 3шт',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2187,10,'Кнопки управления моршрутным компьютером',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2188,10,'Компрессор кондиционера',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2189,10,'Компьютер',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2190,10,'Корпус воздушного фильтра',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2191,10,'Крыло левое заднее',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2192,10,'Крыло левое переднее',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2193,10,'Крыло правое заднее',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2194,10,'Крыло правое переднее',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2195,10,'Крыша',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2196,10,'Лонжерон передний левый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2197,10,'Лонжерон передний правый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2198,10,'Лючек бензобака',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2199,10,'Механизм стеклоподъемника 4шт',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2200,10,'МКПП',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2201,10,'Молдинг двери задн правой',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2202,10,'Молдинг двери пер правой',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2203,10,'Молдинг задней левой двери',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2204,10,'Молдинг передней левой двери',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2205,10,'Мотор вентилятора',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2206,10,'Мотор стеклоомывателя',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2207,10,'Мотор стеклоочистителя',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2208,10,'Мотор стеклоподъёмника задний левый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2209,10,'Мотор стеклоподъёмника задний правый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2210,10,'Мотор стеклоподъёмника передний левый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2211,10,'Мотор стеклоподъёмника передний правый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2212,10,'Мотор центрозамка 4шт',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2213,10,'Накладка пластиковая',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2214,10,'Наполнитель заднего бампера',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2215,10,'Наполнитель переднего бампера',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2216,10,'Насос охлаждающей жидкости',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2217,10,'Натяжитель',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2218,10,'Облицовка щитка приборов',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2219,10,'Обшивка двери пер левой',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2220,10,'Обшивка двери пер правой',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2221,10,'Опоры ДВС и АКПП',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2222,10,'Отопитель задний',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2223,10,'Патрубок (тройник на задний отопитель)',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2224,10,'Передняя панель',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2225,10,'Петли багажника 2шт',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2226,10,'Петли капота 2 шт',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2227,10,'Пластиковая накладка задней панели',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2228,10,'Плафон с очешником',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2229,10,'Площадка АКБ',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2230,10,'Площадка дворников',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2231,10,'Поворотник в крыло лев',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2232,10,'Поворотник в крыло прав',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2233,10,'Поворотник лев',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2234,10,'Поворотник прав',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2235,10,'Поворотный кулак задний левый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2236,10,'Поворотный кулак задний правый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2237,10,'Поворотный кулак передний левый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2238,10,'Поворотный кулак передний правый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2239,10,'Подкрылок лев',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2240,10,'Подкрылок лев задн',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2241,10,'Подкрылок прав',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2242,10,'Подкрылок прав задн',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2243,10,'Подрамник',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2244,10,'Потолок',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2245,10,'Привод левый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2246,10,'Привод правый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2247,10,'Проводка',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2248,10,'Пружина задняя',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2249,10,'Пружина передняя',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2250,10,'Пылезащита под бампер',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2251,10,'Радиатор кондиционера',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2252,10,'Радиатор отопителя',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2253,10,'Радиатор охл. ДВС',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2254,10,'Регулятор ХХ',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2255,10,'Рейка рулевая',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2256,10,'Релинги',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2257,10,'Ремень передний левый с преднатяжителем',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2258,10,'Ремень передний правый с преднатяжителем',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2259,10,'Решотка в бампер боковая 2шт',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2260,10,'Решотка в бампер центральная',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2261,10,'Решотка радиатора',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2262,10,'Ролик паразитный',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2263,10,'Руль',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2264,10,'Ручка двери задн лев наружняя',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2265,10,'Ручка двери задн прав наружняя',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2266,10,'Ручка двери пер лев наружняя',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2267,10,'Ручка двери пер прав наружняя',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2268,10,'Ручка дверная внутренняя левая',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2269,10,'Ручка дверная внутренняя правая',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2270,10,'Рычаг передней подвески левый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2271,10,'Рычаг передней подвески правый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2272,10,'Салон',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2273,10,'Стабилизатор задний',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2274,10,'Стабилизатор передний',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2275,10,'Стартер',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2276,10,'Стекло заднее левое',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2277,10,'Стекло заднее открывающееся левое',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2278,10,'Стекло заднее открывающееся правое',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2279,10,'Стекло заднее правое',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2280,10,'Стекло переднее левое',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2281,10,'Стекло переднее правое',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2282,10,'Стекло пятой двери',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2283,10,'Суппорт задний левый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2284,10,'Суппорт задний правый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2285,10,'Суппорт передний левый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2286,10,'Суппорт передний правый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2287,10,'Суппорт радиатора',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2288,10,'Торпеда',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2289,10,'Трос ручника 2шт',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2290,10,'Трубки печные на задний отопитель',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2291,10,'Уплотнители дверные',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2292,10,'Уплотнитель багажника',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2293,10,'Управление задним отопителем',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2294,10,'Усилитель переднего бампера',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2295,10,'Фара левая',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2296,10,'Фара правая',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2297,10,'Фаркоп',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2298,10,'Фонарь задний левый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2299,10,'Фонарь задний правый',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2300,10,'Форсунка 4 шт',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2301,10,'Шланг ГУРа высокого давления',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2302,10,'Шланг ГУРа низкого давления',NULL,0,0,0,0,NULL,'waiting');
insert  into `auto_parts`(`pk_parts_id`,`fk_models_id`,`parts_name`,`parts_info`,`parts_cost`,`parts_cost_old`,`parts_number`,`parts_number_old`,`parts_uid`,`parts_cond`) values (2303,10,'Щиток приборов',NULL,0,0,0,0,NULL,'waiting');

/*Table structure for table `auto_repare` */

DROP TABLE IF EXISTS `auto_repare`;

CREATE TABLE `auto_repare` (
  `pk_repare_id` int(11) NOT NULL auto_increment,
  `fk_models_id` int(11) NOT NULL default '0',
  `repare_name` varchar(255) character set cp1251 NOT NULL,
  `repare_info` text character set cp1251,
  `repare_cost` float NOT NULL default '0',
  `repare_hours` varchar(255) character set cp1251 NOT NULL default '0',
  PRIMARY KEY  (`pk_repare_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `auto_repare` */

/*Table structure for table `auto_themes` */

DROP TABLE IF EXISTS `auto_themes`;

CREATE TABLE `auto_themes` (
  `pk_theme_id` int(11) NOT NULL auto_increment,
  `theme_name` varchar(255) NOT NULL,
  `theme_type` enum('method','text','article') NOT NULL,
  `theme_type_article_id` int(11) default '0',
  `theme_type_text` text,
  `theme_type_method` varchar(255) default NULL,
  PRIMARY KEY  (`pk_theme_id`,`theme_name`,`theme_type`),
  UNIQUE KEY `pk_theme_id` (`pk_theme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `auto_themes` */

/*Table structure for table `auto_users` */

DROP TABLE IF EXISTS `auto_users`;

CREATE TABLE `auto_users` (
  `pk_users_id` int(11) NOT NULL auto_increment,
  `users_name` varchar(255) default NULL,
  `users_login` varchar(255) default NULL,
  `users_password` varchar(255) default NULL,
  `users_email` varchar(255) default NULL,
  PRIMARY KEY  (`pk_users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `auto_users` */

insert  into `auto_users`(`pk_users_id`,`users_name`,`users_login`,`users_password`,`users_email`) values (1,'Sasha','asid','satana',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;