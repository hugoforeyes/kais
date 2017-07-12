# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.35)
# Database: kais
# Generation Time: 2017-07-12 03:48:50 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table crawler
# ------------------------------------------------------------

CREATE TABLE `crawler` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(225) DEFAULT NULL,
  `website` text,
  `data` text,
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `crawler` WRITE;
/*!40000 ALTER TABLE `crawler` DISABLE KEYS */;

INSERT INTO `crawler` (`id`, `name`, `website`, `data`, `delete_flg`)
VALUES
	(2,'123PHIM - NOW SHOWING','http://www.123phim.vn/phim/','{\"website\":\"http://www.123phim.vn/phim/\",\"object_name\":\"film\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"class\":\"container\",\"$$tag\":\"SECTION\",\"id\":\"showing\"},\"4\":{\"$$ele_index\":4,\"class\":\"group\",\"$$tag\":\"DIV\"},\"5\":{\"$$ele_index\":5,\"class\":\"block-base movie\",\"$$tag\":\"DIV\"}},\"selector_text\":\"SECTION.container#showing DIV.group DIV.block-base.movie \",\"crawler_name\":\"123PHIM - NOW SHOWING\",\"property\":[{\"name\":\"name\",\"value_field\":\"$$text\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"class\":\"film-name\",\"$$tag\":\"A\"}},\"selector_text\":\"A.film-name \"},{\"name\":\"href\",\"value_field\":\"href\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"$$tag\":\"A\",\"class\":\"film-name\"}},\"selector_text\":\"A.film-name \"},{\"name\":\"img\",\"value_field\":\"src\",\"data_selector\":{\"1\":{\"$$ele_index\":1,\"$$tag\":\"IMG\",\"class\":\"thumb\"}},\"selector_text\":\"IMG.thumb \"},{\"name\":\"publish_day\",\"value_field\":\"$$text\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"class\":\"publish-date-new\",\"$$tag\":\"SPAN\"},\"1\":{\"$$ele_index\":1,\"class\":\"date\",\"$$tag\":\"SPAN\"}},\"selector_text\":\"SPAN.publish-date-new SPAN.date \"},{\"name\":\"publish_month\",\"value_field\":\"$$text\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"class\":\"publish-date-new\",\"$$tag\":\"SPAN\"},\"1\":{\"$$ele_index\":1,\"class\":\"month\",\"$$tag\":\"SPAN\"}},\"selector_text\":\"SPAN.publish-date-new SPAN.month \"}]}',0),
	(3,'123PHIM - DETAIL FILM','http://www.123phim.vn/phim/1173-lich-chieu-wonder-woman.html','{\"website\":\"http://www.123phim.vn/phim/1173-lich-chieu-wonder-woman.html\",\"object_name\":\"film_detail\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"id\":\"detail-banner\",\"$$tag\":\"SECTION\",\"$$order\":\"\"},\"1\":{\"$$ele_index\":1,\"id\":\"box-info\",\"$$tag\":\"SECTION\",\"$$order\":\"\"}},\"selector_text\":\"SECTION#detail-banner SECTION#box-info \",\"crawler_name\":\"123PHIM - DETAIL FILM\",\"property\":[{\"name\":\"vi_name\",\"value_field\":\"$$text\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"id\":\"box-sidebar\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"1\":{\"$$ele_index\":1,\"class\":\"filmDescription\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"2\":{\"$$ele_index\":2,\"$$tag\":\"H2\",\"$$order\":\"\"}},\"selector_text\":\"DIV#box-sidebar DIV.filmDescription H2 \"},{\"name\":\"en_name\",\"value_field\":\"$$text\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"id\":\"box-sidebar\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"1\":{\"$$ele_index\":1,\"class\":\"filmDescription\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"2\":{\"$$ele_index\":2,\"$$tag\":\"H3\",\"$$order\":\"\"}},\"selector_text\":\"DIV#box-sidebar DIV.filmDescription H3 \"},{\"name\":\"info\",\"value_field\":\"$$text\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"id\":\"box-sidebar\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"1\":{\"$$ele_index\":1,\"class\":\"filmDescription\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"2\":{\"$$ele_index\":2,\"class\":\"filmInfo\",\"$$tag\":\"P\",\"$$order\":\"\"}},\"selector_text\":\"DIV#box-sidebar DIV.filmDescription P.filmInfo \"},{\"name\":\"description\",\"value_field\":\"$$text\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"id\":\"box-sidebar\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"1\":{\"$$ele_index\":1,\"class\":\"filmDescription\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"2\":{\"$$ele_index\":2,\"class\":\"filmShortDesc\",\"$$tag\":\"P\",\"$$order\":\"\"}},\"selector_text\":\"DIV#box-sidebar DIV.filmDescription P.filmShortDesc \"},{\"name\":\"publish_date\",\"value_field\":\"$$text\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"id\":\"box-sidebar\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"1\":{\"$$ele_index\":1,\"class\":\"filmDescription\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"2\":{\"$$ele_index\":2,\"class\":\"publish-date-block\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"3\":{\"$$ele_index\":3,\"class\":\"label\",\"$$tag\":\"SPAN\",\"$$order\":\"\"}},\"selector_text\":\"DIV#box-sidebar DIV.filmDescription DIV.publish-date-block SPAN.label \"},{\"name\":\"poster\",\"value_field\":\"src\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"class\":\"main\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"1\":{\"$$ele_index\":1,\"$$tag\":\"IMG\",\"$$order\":\"\",\"class\":\"poster-img\"}},\"selector_text\":\"DIV.main IMG.poster-img \"},{\"name\":\"media_id\",\"value_field\":\"data-media\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"class\":\"main\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"2\":{\"$$ele_index\":2,\"id\":\"list-trailer\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"3\":{\"$$ele_index\":3,\"class\":\"trailer-youtube\",\"$$tag\":\"A\",\"$$order\":\"1\"}},\"selector_text\":\"DIV.main DIV#list-trailer A.trailer-youtube \"}]}',0),
	(4,'GENK.VN','genk.vn','{\"website\":\"genk.vn\",\"object_name\":\"news\",\"data_selector\":{\"3\":{\"$$ele_index\":3,\"class\":\"genk-body-wrapper\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"10\":{\"$$ele_index\":10,\"id\":\"LoadListCate\",\"$$tag\":\"UL\",\"$$order\":\"\"}},\"selector_text\":\"DIV.genk-body-wrapper UL#LoadListCate \",\"crawler_name\":\"GENK.VN\",\"property\":[{\"name\":\"title\",\"value_field\":\"$$text\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"class\":\"knswli clearfix \",\"$$tag\":\"LI\",\"$$order\":\"\"},\"2\":{\"$$ele_index\":2,\"class\":\"knswli-title\",\"$$tag\":\"H4\",\"$$order\":\"\"},\"3\":{\"$$ele_index\":3,\"$$tag\":\"A\",\"$$order\":\"\"}},\"selector_text\":\"LI.knswli.clearfix H4.knswli-title A \"},{\"name\":\"pre_text\",\"value_field\":\"$$text\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"$$tag\":\"LI\",\"$$order\":\"\",\"class\":\"knswli clearfix \"},\"1\":{\"$$ele_index\":1,\"class\":\"knswli-right elp-list\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"2\":{\"$$ele_index\":2,\"class\":\"knswli-sapo\",\"$$tag\":\"SPAN\",\"$$order\":\"\"}},\"selector_text\":\"LI.knswli.clearfix DIV.knswli-right.elp-list SPAN.knswli-sapo \"}]}',1),
	(5,'LAY THONG TIN TU 123PHIM','http://www.123phim.vn/phim/','{\"website\":\"http://www.123phim.vn/phim/\",\"object_name\":\"tyeas\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"id\":\"showing\",\"$$tag\":\"SECTION\",\"$$order\":\"\"},\"2\":{\"$$ele_index\":2,\"class\":\"main\",\"$$tag\":\"DIV\",\"$$order\":\"\"},\"5\":{\"$$ele_index\":5,\"class\":\"block-base movie\",\"$$tag\":\"DIV\",\"$$order\":\"\"}},\"selector_text\":\"SECTION#showing DIV.main DIV.block-base.movie \",\"crawler_name\":\"LAY THONG TIN TU 123PHIM\",\"property\":[{\"name\":\"tenphim\",\"value_field\":\"$$text\",\"data_selector\":{\"0\":{\"$$ele_index\":0,\"$$tag\":\"A\",\"$$order\":\"\",\"class\":\"film-name\"}},\"selector_text\":\"A.film-name \"},{\"name\":\"hinh\",\"value_field\":\"src\",\"data_selector\":{\"1\":{\"$$ele_index\":1,\"$$tag\":\"IMG\",\"$$order\":\"\",\"class\":\"thumb\"}},\"selector_text\":\"IMG.thumb \"}]}',1);

/*!40000 ALTER TABLE `crawler` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table movie
# ------------------------------------------------------------

CREATE TABLE `movie` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `img` varchar(500) DEFAULT NULL,
  `release_date` varchar(15) DEFAULT NULL,
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0',
  `create_date` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `website_link` varchar(255) DEFAULT NULL,
  `detail` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `movie` WRITE;
/*!40000 ALTER TABLE `movie` DISABLE KEYS */;

INSERT INTO `movie` (`id`, `name`, `img`, `release_date`, `delete_flg`, `create_date`, `order`, `website_link`, `detail`)
VALUES
	(1,'Kẻ Trộm Mặt Trăng 3 - Despicable Me 3','http://s3img.vcdn.vn/123phim/2017/04/ke-cap-mat-trang-3-despicable-me-3-14927915156913.jpg','30/6',0,1499032800,0,'http://www.123phim.vn//phim/1355-ke-trom-mat-trang-3-despicable-me-3.html','{\"vi_name\":\"Kẻ Trộm Mặt Trăng 3\",\"en_name\":\"Despicable Me 3\",\"info\":\"\\n                    90 phút\\n                    Tiếng Anh phụ đề tiếng Việt\\n                \",\"description\":\"Trong phần phim này, Gru chính thức được vào biên chế của AVL (Liên Minh Chống Kẻ Ác). Tân đặc vụ “khó ở” phải đương đầu với một tên tội phạm quái dị. Đó là gã Balthazar Bratt mê bong bóng với kiểu đầu mullet dở hơi, mặc bộ jumpsuit màu tím sến sẩm và ra vẻ “dân chơi nửa mùa” với điệu nhảy “bước chân trên mặt trăng” (moonwalk) của Michael Jackson. Hắn ta từng là một giọng ca nhí vang danh nhờ một chương trình giải trí nhưng cũng trở nên hết thời khi chương trình đó bị xóa sổ. Hờn cả thế giới, Bratt quyết định chế tạo những vũ khí tối tân và lên kế hoạch trả thù loài người.\\r NPH: CGV\\r NSX: Mỹ\",\"publish_date\":\"Khởi chiếu: 30\\/06\",\"poster\":\"https:\\/\\/s3img.vcdn.vn\\/123phim\\/2017\\/06\\/ke-trom-mat-trang-3-despicable-me-3-14987886090910.jpg\",\"media_id\":\"EB7vjiZKMqo\"}'),
	(2,'Xóm Trọ 3D (C16)','https://s3img.vcdn.vn/123phim/2017/06/xom-tro-3d-c16-14986217306204.jpg','30/6',0,1499032800,1,'http://www.123phim.vn//phim/1435-lich-chieu-xom-tro-3D.html',NULL),
	(3,'Quái Xế Baby - Baby Driver (C16)','http://s3img.vcdn.vn/123phim/2017/06/quai-xe-baby-baby-driver-14974315054723.jpg','30/6',0,1499032800,2,'http://www.123phim.vn//phim/1370-lich-chieu-quai-xe-baby.html',NULL),
	(4,'Transformers: Chiến Binh Cuối Cùng - Transformers: The Last Knight (C13)','http://s3img.vcdn.vn/123phim/2017/06/transformers-chie-n-binh-cuo-i-cu-ng-transformers-the-last-knight-c16-14978403732830.jpg','23/6',0,1499032800,3,'http://www.123phim.vn//phim/1268-lich-chieu-transformers-the-last-knight.html',NULL),
	(5,'Bố Già Xứ Venice - Once Upon a Time in Venice (C18)','http://s3img.vcdn.vn/123phim/2017/06/bo-gia-xu-venice-once-upon-a-time-in-venice-14975098659332.jpg','30/6',0,1499032800,4,'http://www.123phim.vn//phim/1472-lich-chieu-bo-gia-xu-venice.html',NULL),
	(6,'Cuộc Chiến Ngầm - The Merciless (C18)','http://s3img.vcdn.vn/123phim/2017/05/cuoc-chien-ngam-the-merciless-14962137020239.jpg','23/6',0,1499032800,5,'http://www.123phim.vn//phim/1447-lich-chieu-cuoc-chien-ngam-the-merciless.html',NULL),
	(7,'Hung Thần Đại Dương - 47 Meters Down (C16)','http://s3img.vcdn.vn/123phim/2017/06/hung-than-dai-duong-47-meters-down-c13-14966470680759.jpg','16/6',0,1499032800,6,'http://www.123phim.vn//phim/1413-lich-chieu-hung-than-dai-duong-47-meters-down.html',NULL),
	(8,'Xác Ướp - The Mummy (C13)','http://s3img.vcdn.vn/123phim/2017/05/xac-uop-the-mummy-c16-14962026066507.jpg','9/6',0,1499032800,7,'http://www.123phim.vn//phim/1308-lich-chieu-the-mummy.html',NULL),
	(9,'[S.O.S] Sói Trắng (C16)','http://s3img.vcdn.vn/123phim/2017/05/s-o-s-soi-trang-14961191977999.jpg','16/6',0,1499032800,8,'http://www.123phim.vn//phim/1421-lich-chieu-sos-soi-trang.html',NULL),
	(10,'Lô Tô (C18)','http://s3img.vcdn.vn/123phim/2017/03/lo-to-14903646156152.jpg','31/3',0,1499032800,9,'http://www.123phim.vn//phim/1344-lich-chieu-lo-to.html',NULL),
	(11,'Hotboy Nổi Loạn 2 (C18)','http://s3img.vcdn.vn/mobile/123phim/2017/02/hotboy-noi-loan-2-14865272429011_160x230.jpg','3/3',0,1499032800,10,'http://www.123phim.vn//phim/1335-lich-chieu-hotboy-noi-loan-2.html',NULL),
	(12,'Cầu Vồng Không Sắc','http://s3img.vcdn.vn/123phim/2015/03/eb8c834af6bc24ffad1eaee58ac3a17b.jpg','20/3',0,1499032800,11,'http://www.123phim.vn//phim/773-cau-vong-khong-sac.html',NULL),
	(13,'Lạc Giới - Paradise in Heart','http://s3img.vcdn.vn/123phim/2014/08/1409125520408-lac-gioi-5c792f-1409125524.jpg','17/10',0,1499032800,12,'http://www.123phim.vn//phim/601-lac-gioi.html',NULL);

/*!40000 ALTER TABLE `movie` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
