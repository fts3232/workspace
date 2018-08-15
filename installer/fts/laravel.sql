/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-08-15 12:05:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cms_banner
-- ----------------------------
DROP TABLE IF EXISTS `cms_banner`;
CREATE TABLE `cms_banner` (
  `BANNER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BANNER_NAME` varchar(30) DEFAULT NULL COMMENT 'banner名称',
  `BANNER_LANG` varchar(10) DEFAULT NULL COMMENT 'bannner所属语言',
  `CREATED_TIEM` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`BANNER_ID`),
  KEY `BANNER_NAME` (`BANNER_NAME`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COMMENT='存放banner信息';

-- ----------------------------
-- Records of cms_banner
-- ----------------------------
INSERT INTO `cms_banner` VALUES ('6', '124', 'zh_CN', '2018-07-20 16:06:12', '2018-07-24 09:55:36');
INSERT INTO `cms_banner` VALUES ('7', '12312', 'zh_CN', '2018-07-20 16:06:13', null);
INSERT INTO `cms_banner` VALUES ('8', '12312', 'zh_CN', '2018-07-20 16:06:13', null);
INSERT INTO `cms_banner` VALUES ('9', '12312', 'zh_CN', '2018-07-20 16:06:13', null);
INSERT INTO `cms_banner` VALUES ('10', '12312', 'zh_CN', '2018-07-20 16:06:14', null);
INSERT INTO `cms_banner` VALUES ('11', '12312', 'zh_CN', '2018-07-20 16:06:14', null);
INSERT INTO `cms_banner` VALUES ('12', '12312', 'zh_CN', '2018-07-20 16:06:14', null);
INSERT INTO `cms_banner` VALUES ('13', '12312', 'zh_CN', '2018-07-20 16:06:14', null);
INSERT INTO `cms_banner` VALUES ('14', '12312', 'zh_CN', '2018-07-20 16:06:15', null);
INSERT INTO `cms_banner` VALUES ('15', '12312', 'zh_CN', '2018-07-20 16:06:15', null);
INSERT INTO `cms_banner` VALUES ('16', '12312', 'zh_CN', '2018-07-20 16:06:15', null);
INSERT INTO `cms_banner` VALUES ('17', '12312', 'zh_CN', '2018-07-20 16:06:15', null);
INSERT INTO `cms_banner` VALUES ('18', '12312', 'zh_CN', '2018-07-20 16:06:15', null);
INSERT INTO `cms_banner` VALUES ('19', '12312', 'zh_CN', '2018-07-20 16:06:15', null);
INSERT INTO `cms_banner` VALUES ('20', '12312', 'zh_CN', '2018-07-20 16:06:16', null);
INSERT INTO `cms_banner` VALUES ('21', '12312', 'zh_CN', '2018-07-20 16:06:16', null);
INSERT INTO `cms_banner` VALUES ('22', '345', 'zh_CN', '2018-07-20 18:02:35', null);
INSERT INTO `cms_banner` VALUES ('23', '123', 'zh_CN', '2018-07-22 20:07:57', null);
INSERT INTO `cms_banner` VALUES ('24', '111', 'zh_CN', '2018-07-22 20:08:07', null);
INSERT INTO `cms_banner` VALUES ('25', '3242', 'zh_CN', '2018-07-22 20:46:13', null);
INSERT INTO `cms_banner` VALUES ('26', '复旦复华具体化服返回', 'zh_CN', '2018-07-24 10:36:14', null);
INSERT INTO `cms_banner` VALUES ('27', '复旦复华具体化服返回', 'zh_CN', '2018-07-24 10:36:21', null);
INSERT INTO `cms_banner` VALUES ('28', '复旦复华具体化服返回', 'zh_CN', '2018-07-24 10:36:56', null);
INSERT INTO `cms_banner` VALUES ('29', '现货黄金', 'zh_CN', '2018-07-24 16:48:26', null);
INSERT INTO `cms_banner` VALUES ('31', '123456', 'zh_CN', '2018-07-30 14:55:44', '2018-07-30 14:55:51');
INSERT INTO `cms_banner` VALUES ('32', '1g', 'zh_CN', '2018-07-30 14:59:43', '2018-08-09 10:08:11');
INSERT INTO `cms_banner` VALUES ('37', '54', 'zh_HK', '2018-08-09 12:23:21', null);
INSERT INTO `cms_banner` VALUES ('38', '456', 'zh_CN', '2018-08-14 15:36:50', null);
INSERT INTO `cms_banner` VALUES ('39', '5677', 'zh_CN', '2018-08-14 15:37:06', '2018-08-14 15:37:09');
INSERT INTO `cms_banner` VALUES ('41', '567', 'zh_CN', '2018-08-14 15:37:38', null);

-- ----------------------------
-- Table structure for cms_banner_item
-- ----------------------------
DROP TABLE IF EXISTS `cms_banner_item`;
CREATE TABLE `cms_banner_item` (
  `ITEM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BANNER_ID` int(11) DEFAULT NULL COMMENT '所属banner id',
  `ITEM_IMG` varchar(255) DEFAULT NULL COMMENT 'banner 项图片',
  `ITEM_URL` varchar(255) DEFAULT NULL COMMENT 'banner 项url',
  `ITEM_TITLE` varchar(45) DEFAULT NULL COMMENT 'banner项小标题',
  `ITEM_STATUS` tinyint(1) DEFAULT NULL COMMENT '项状态',
  `ITEM_ORDER` tinyint(3) DEFAULT NULL COMMENT '图片排序',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`ITEM_ID`),
  KEY `BANNER_ID` (`BANNER_ID`) USING BTREE,
  KEY `ITEM_STATUS` (`ITEM_STATUS`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='保存banner图片项信息\r\n状态\r\n0：下架\r\n1：上架';

-- ----------------------------
-- Records of cms_banner_item
-- ----------------------------
INSERT INTO `cms_banner_item` VALUES ('2', '6', '/Uploads/cms_banner/2018-07-22/5b547c1988fa2.jpg', '234234', null, '1', '0', '2018-07-22 20:44:34', '2018-07-28 17:27:40');
INSERT INTO `cms_banner_item` VALUES ('5', '31', '/Uploads/cms_banner/2018-07-30/5b5eb68293a44.png', '', null, '0', '1', '2018-07-30 14:58:07', '2018-07-30 15:01:38');
INSERT INTO `cms_banner_item` VALUES ('7', '31', '/Uploads/cms_banner/2018-07-30/5b5eb708b4084.png', '', null, '0', '2', '2018-07-30 14:58:24', '2018-07-30 15:01:38');
INSERT INTO `cms_banner_item` VALUES ('8', '31', '/Uploads/cms_banner/2018-07-30/5b5eb70d9e20d.png', '312', null, '1', '0', '2018-07-30 14:58:24', '2018-07-30 15:01:38');
INSERT INTO `cms_banner_item` VALUES ('9', '27', '/Uploads/cms_banner/2018-08-06/5b680a1907b53.jpg', '', null, '0', '0', '2018-08-06 16:43:19', null);
INSERT INTO `cms_banner_item` VALUES ('10', '27', '/Uploads/cms_banner/2018-08-06/5b680a220acb8.jpg', '', null, '1', '1', '2018-08-06 16:43:19', null);
INSERT INTO `cms_banner_item` VALUES ('11', '29', '/Uploads/cms_banner/2018-08-06/5b68173a6972b.png', '', null, '0', '0', '2018-08-06 17:39:34', null);
INSERT INTO `cms_banner_item` VALUES ('15', '32', '/Uploads/cms_banner/2018-08-09/5b6ba2150b413.png', '', null, '0', '1', '2018-08-09 10:09:23', '2018-08-09 10:33:30');
INSERT INTO `cms_banner_item` VALUES ('16', '32', '/Uploads/cms_banner/2018-08-09/5b6ba2344a30f.png', '', null, '0', '2', '2018-08-09 10:09:23', '2018-08-09 10:33:30');
INSERT INTO `cms_banner_item` VALUES ('22', '32', '/Uploads/cms_banner/2018-08-09/5b6ba29d05574.png', '', null, '0', '3', '2018-08-09 10:12:34', '2018-08-09 10:33:30');
INSERT INTO `cms_banner_item` VALUES ('23', '32', '/Uploads/cms_banner/2018-08-09/5b6ba5c2ce4a7.png', 'null', null, '0', '0', '2018-08-09 10:24:02', '2018-08-09 10:33:30');
INSERT INTO `cms_banner_item` VALUES ('24', '32', '/Uploads/cms_banner/2018-08-09/5b6ba5dee42ad.png', '', null, '0', '4', '2018-08-09 10:24:30', '2018-08-09 10:33:30');
INSERT INTO `cms_banner_item` VALUES ('25', '32', '/Uploads/cms_banner/2018-08-09/5b6ba7f58ce81.png', '', null, '0', '5', '2018-08-09 10:33:25', '2018-08-09 10:33:30');
INSERT INTO `cms_banner_item` VALUES ('29', '37', '/Uploads/cms_banner/2018-08-10/5b6cebf19cdbd.png', '2534', '53', '0', '0', '2018-08-10 09:35:45', '2018-08-10 09:36:11');
INSERT INTO `cms_banner_item` VALUES ('30', '37', '/Uploads/cms_banner/2018-08-10/5b6cec094ae9e.png', '', '', '0', '1', '2018-08-10 09:36:09', '2018-08-10 09:36:11');
INSERT INTO `cms_banner_item` VALUES ('31', '29', '/Uploads/cms_banner/2018-08-14/5b7235540ac0e.gif', null, null, null, null, '2018-08-14 09:50:12', null);
INSERT INTO `cms_banner_item` VALUES ('37', '41', '/Uploads/cms_banner/2018-08-14/5b7288afe0459.png', '', '', '1', '0', '2018-08-14 15:45:51', '2018-08-14 15:46:02');
INSERT INTO `cms_banner_item` VALUES ('38', '41', '/Uploads/cms_banner/2018-08-14/5b7288b17ee1c.png', '', '', '1', '1', '2018-08-14 15:45:53', '2018-08-14 15:46:02');

-- ----------------------------
-- Table structure for cms_category
-- ----------------------------
DROP TABLE IF EXISTS `cms_category`;
CREATE TABLE `cms_category` (
  `CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(30) DEFAULT NULL COMMENT '栏目名称',
  `CATEGORY_SLUG` varchar(30) DEFAULT NULL COMMENT '栏目别名',
  `CATEGORY_PARENT` int(11) DEFAULT NULL COMMENT '栏目父类',
  `CATEGORY_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT '栏目描述',
  `CATEGORY_LANG` varchar(10) DEFAULT NULL COMMENT '栏目语言',
  `SEO_TITLE` varchar(150) DEFAULT NULL COMMENT 'seo标题',
  `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
  `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`CATEGORY_ID`),
  KEY `CATEGORY_NAME` (`CATEGORY_NAME`),
  KEY `CATEGORY_SLUG` (`CATEGORY_SLUG`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='文章栏目信息';

-- ----------------------------
-- Records of cms_category
-- ----------------------------
INSERT INTO `cms_category` VALUES ('1', '新闻咨询', 'news', '0', 'null', 'zh_CN', 'null', 'null', 'null', '2018-07-19 17:03:20', '2018-08-01 11:02:14');
INSERT INTO `cms_category` VALUES ('2', '每日金评', 'comment', '1', '现货黄金市场2018年7月23日14点收盘于1230.9美元/盎司，金价在早间冲击重压1235美元/盎司一线后回撤，目前维持与1230-1233区间窄幅震荡。现货黄金在短期内可能面临小幅调整，在调整过后依然有机会继续上涨。后市关注1225-1230区间能否成为上涨后的回踩支点，为后市', 'zh_CN', '现货黄金，操作建议', '现货黄金，操作建议', '现货黄金市场2018年7月23日14点收盘于1230.9美元/盎司，金价在早间冲击重压1235美元/盎司一线后回撤，目前维持与1230-1233区间窄幅震荡。现货黄金在短期内可能面临小幅调整，在调整过后依然有机会继续上涨。后市关注1225-1230区间能否成为上涨后的回踩支点，为后市', '2018-07-19 17:03:20', '2018-08-14 09:50:46');
INSERT INTO `cms_category` VALUES ('3', '黄金头条', 'headline', '1', 'null', 'zh_CN', 'null', 'null', 'null', '2018-07-19 17:03:20', '2018-08-01 11:02:14');
INSERT INTO `cms_category` VALUES ('4', '汇市新闻', 'market', '1', 'null', 'zh_CN', 'null', 'null', 'null', '2018-07-19 17:03:20', '2018-08-01 11:02:14');
INSERT INTO `cms_category` VALUES ('7', '行业资讯', 'information', '1', 'null', 'zh_CN', 'null', 'null', 'null', '2018-07-19 17:51:39', '2018-08-01 11:02:14');
INSERT INTO `cms_category` VALUES ('8', '即时数据', 'data', '1', 'null', 'zh_CN', 'null', 'null', 'null', '2018-07-19 17:51:59', '2018-08-01 11:02:14');
INSERT INTO `cms_category` VALUES ('9', '财经日历', 'calendar', '1', '1231t', 'zh_CN', '31t', '313t', '1231t', '2018-07-22 00:50:10', '2018-08-01 11:02:14');
INSERT INTO `cms_category` VALUES ('11', '学院', 'college', '0', '313', 'zh_CN', '131', '31', '313', '2018-07-22 21:30:26', '2018-08-01 11:02:14');
INSERT INTO `cms_category` VALUES ('12', '新手入门', 'novice', '11', '131', 'zh_CN', '3213', '131', '131', '2018-07-22 21:30:50', '2018-08-01 11:02:14');
INSERT INTO `cms_category` VALUES ('13', '实战技巧', 'skill', '11', '2424', 'zh_CN', '24', '24', '2424', '2018-07-24 10:56:17', '2018-08-01 11:02:14');
INSERT INTO `cms_category` VALUES ('14', '名师指路', 'teacher', '11', 'null', 'zh_CN', 'null', 'null', 'null', '2018-08-01 10:58:02', '2018-08-01 11:02:14');
INSERT INTO `cms_category` VALUES ('15', '黄金法则', 'rule', '11', 'null', 'zh_CN', 'null', 'null', 'null', '2018-08-01 10:58:02', '2018-08-01 11:02:14');
INSERT INTO `cms_category` VALUES ('16', '外汇投资', 'investment', '11', 'null', 'zh_CN', 'null', 'null', 'null', '2018-08-01 10:58:02', '2018-08-01 11:02:14');
INSERT INTO `cms_category` VALUES ('17', '投资百科', 'wiki', '11', 'null', 'zh_CN', 'null', 'null', 'null', '2018-08-01 10:58:22', '2018-08-01 11:02:14');
INSERT INTO `cms_category` VALUES ('18', '新闻咨询1', 'news2424', '0', '234424', 'zh_HK', '4224', '4224', '424242', '2018-08-09 12:28:27', '2018-08-09 14:08:27');

-- ----------------------------
-- Table structure for cms_menu
-- ----------------------------
DROP TABLE IF EXISTS `cms_menu`;
CREATE TABLE `cms_menu` (
  `MENU_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_NAME` varchar(30) DEFAULT NULL COMMENT '菜单名',
  `MENU_LANG` varchar(10) DEFAULT NULL COMMENT '菜单所属语言',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL,
  PRIMARY KEY (`MENU_ID`),
  KEY `NAME` (`MENU_NAME`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='保存菜单信息';

-- ----------------------------
-- Records of cms_menu
-- ----------------------------
INSERT INTO `cms_menu` VALUES ('1', 'test', 'zh_CN', '2018-07-18 15:36:55', null);
INSERT INTO `cms_menu` VALUES ('18', 'sa12', 'zh_CN', '2018-07-19 16:59:23', '2018-07-20 15:05:23');
INSERT INTO `cms_menu` VALUES ('19', '111', 'zh_CN', '2018-07-24 10:00:59', null);
INSERT INTO `cms_menu` VALUES ('22', '复旦复华具体化服返回', 'zh_CN', '2018-07-24 10:39:59', null);
INSERT INTO `cms_menu` VALUES ('23', '23411', 'zh_CN', '2018-07-30 14:27:51', '2018-07-30 14:31:54');
INSERT INTO `cms_menu` VALUES ('25', '44', 'zh_CN', '2018-07-30 14:31:56', null);
INSERT INTO `cms_menu` VALUES ('26', '444', 'zh_CN', '2018-07-30 14:45:26', null);
INSERT INTO `cms_menu` VALUES ('27', '4444', 'zh_CN', '2018-07-30 14:46:04', null);
INSERT INTO `cms_menu` VALUES ('28', '测试123', 'zh_CN', '2018-08-06 15:15:48', '2018-08-08 17:55:59');
INSERT INTO `cms_menu` VALUES ('30', 'test4', 'zh_HK', '2018-08-09 12:08:48', '2018-08-09 12:24:03');
INSERT INTO `cms_menu` VALUES ('31', '4234', 'zh_HK', '2018-08-09 12:23:58', null);
INSERT INTO `cms_menu` VALUES ('32', '213', 'zh_CN', '2018-08-14 15:09:42', null);
INSERT INTO `cms_menu` VALUES ('33', '435', 'zh_CN', '2018-08-14 15:19:32', null);
INSERT INTO `cms_menu` VALUES ('34', '4561', 'zh_CN', '2018-08-14 15:19:48', '2018-08-14 15:19:52');
INSERT INTO `cms_menu` VALUES ('35', '6', 'zh_CN', '2018-08-14 15:20:02', null);
INSERT INTO `cms_menu` VALUES ('36', '654', 'zh_CN', '2018-08-14 15:20:20', null);

-- ----------------------------
-- Table structure for cms_menu_item
-- ----------------------------
DROP TABLE IF EXISTS `cms_menu_item`;
CREATE TABLE `cms_menu_item` (
  `ITEM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_ID` int(11) DEFAULT NULL COMMENT '所属菜单id',
  `ITEM_NAME` varchar(30) DEFAULT NULL COMMENT '菜单项名字',
  `ITEM_URL` varchar(255) DEFAULT NULL COMMENT '菜单项url',
  `ITEM_PARENT` int(11) DEFAULT NULL COMMENT '所属父类id',
  `ITEM_ORDER` tinyint(3) DEFAULT NULL COMMENT '排序',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`ITEM_ID`),
  KEY `MENU_ID` (`MENU_ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COMMENT='保存菜单项信息';

-- ----------------------------
-- Records of cms_menu_item
-- ----------------------------
INSERT INTO `cms_menu_item` VALUES ('18', '1', '2342', '23424', '0', '0', '2018-07-18 18:13:02', null);
INSERT INTO `cms_menu_item` VALUES ('20', '1', '11', '123', '0', '1', '2018-07-19 12:21:58', null);
INSERT INTO `cms_menu_item` VALUES ('21', '1', '11', '123', '20', '0', '2018-07-19 12:21:58', '2018-07-19 16:44:25');
INSERT INTO `cms_menu_item` VALUES ('22', '1', '11', '123', '0', '3', '2018-07-19 12:21:58', '2018-07-20 16:04:24');
INSERT INTO `cms_menu_item` VALUES ('23', '1', '11', '123', '22', '0', '2018-07-19 12:21:58', null);
INSERT INTO `cms_menu_item` VALUES ('24', '1', '11', '123', '0', '2', '2018-07-19 12:21:58', '2018-07-20 16:04:24');
INSERT INTO `cms_menu_item` VALUES ('25', '1', '11', '123', '0', '5', '2018-07-19 12:21:58', '2018-07-20 16:04:22');
INSERT INTO `cms_menu_item` VALUES ('26', '1', '11', '123', '0', '4', '2018-07-19 12:21:58', '2018-07-20 16:04:17');
INSERT INTO `cms_menu_item` VALUES ('27', '1', '3453455435', '5435', '0', '6', '2018-07-20 16:04:30', null);
INSERT INTO `cms_menu_item` VALUES ('28', '18', '1231', '231', '0', '0', '2018-07-22 20:43:34', null);
INSERT INTO `cms_menu_item` VALUES ('29', '18', '1231', '231', '0', '1', '2018-07-22 20:43:34', null);
INSERT INTO `cms_menu_item` VALUES ('30', '1', '撒大声地撒奥所', '23424234', '0', '7', '2018-07-24 10:47:25', null);
INSERT INTO `cms_menu_item` VALUES ('55', '28', '123', '123', '0', '0', '2018-08-09 10:00:52', null);
INSERT INTO `cms_menu_item` VALUES ('57', '28', '23424', '23424', '0', '1', '2018-08-09 10:01:55', null);
INSERT INTO `cms_menu_item` VALUES ('58', '28', '23424', '2342', '0', '0', '2018-08-09 10:02:54', '2018-08-09 10:02:55');
INSERT INTO `cms_menu_item` VALUES ('59', '31', 'sadadda', 'ad', '0', '0', '2018-08-10 09:33:51', '2018-08-10 09:34:06');
INSERT INTO `cms_menu_item` VALUES ('60', '31', 'sadadda', 'ad', '59', '0', '2018-08-10 09:33:52', '2018-08-10 09:34:06');
INSERT INTO `cms_menu_item` VALUES ('62', '31', 'sadadda1', 'ad', '0', '1', '2018-08-10 09:33:56', '2018-08-10 09:34:06');
INSERT INTO `cms_menu_item` VALUES ('63', '36', '4353453', '45345', '0', '1', '2018-08-14 15:33:28', '2018-08-14 15:33:43');
INSERT INTO `cms_menu_item` VALUES ('64', '36', '35435', '435', '0', '0', '2018-08-14 15:33:32', '2018-08-14 15:33:43');

-- ----------------------------
-- Table structure for cms_pages
-- ----------------------------
DROP TABLE IF EXISTS `cms_pages`;
CREATE TABLE `cms_pages` (
  `PAGE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PAGE_NAME` varchar(30) DEFAULT NULL COMMENT '页面名称',
  `PAGE_SLUG` varchar(30) DEFAULT NULL COMMENT '页面别名',
  `PAGE_DIRECTING` varchar(50) DEFAULT NULL COMMENT '页面指向',
  `PAGE_PARENT` tinyint(3) DEFAULT NULL COMMENT '页面父类',
  `PAGE_LANG` varchar(10) DEFAULT NULL COMMENT '页面语言',
  `SEO_TITLE` varchar(50) DEFAULT NULL COMMENT 'seo标题',
  `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
  `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`PAGE_ID`),
  KEY `POST_TRANSLATE_ID` (`PAGE_NAME`) USING BTREE,
  KEY `POST_TITLE` (`PAGE_DIRECTING`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='存放页面信息';

-- ----------------------------
-- Records of cms_pages
-- ----------------------------
INSERT INTO `cms_pages` VALUES ('1', '关于我们', 'about', 'AboutController@introduction', '0', 'zh_CN', '242', '242', '424', '2018-07-29 09:37:07', '2018-08-08 16:58:50');
INSERT INTO `cms_pages` VALUES ('2', '集团概况', 'introduction', 'AboutController@introduction', '1', 'zh_CN', '5435t', '5435t', '3543t', '2018-07-29 09:37:14', null);
INSERT INTO `cms_pages` VALUES ('5', '优势', 'advantage', 'AboutController@advantage', '1', 'zh_CN', 'tt', 'tt', 'tt', '2018-07-30 16:36:33', null);
INSERT INTO `cms_pages` VALUES ('6', '集团认证', 'authentication', 'AboutController@authentication', '1', 'zh_CN', null, null, null, '2018-07-31 12:21:10', null);
INSERT INTO `cms_pages` VALUES ('7', '投资者保障', 'guarantee', 'AboutController@guarantee', '1', 'zh_CN', null, null, null, '2018-07-31 12:21:10', null);
INSERT INTO `cms_pages` VALUES ('8', '公告', 'notice', 'AboutController@notice', '1', 'zh_CN', null, null, null, '2018-07-31 12:21:10', null);
INSERT INTO `cms_pages` VALUES ('9', '联系我们', 'contact', 'AboutController@contact', '1', 'zh_CN', null, null, null, '2018-07-31 12:21:10', null);
INSERT INTO `cms_pages` VALUES ('10', '开户交易', 'transaction', 'TransactionController@real', '0', 'zh_CN', null, null, null, '2018-07-31 12:21:11', null);
INSERT INTO `cms_pages` VALUES ('11', '真实账户', 'real', 'TransactionController@real', '10', 'zh_CN', null, null, null, '2018-07-31 12:21:11', null);
INSERT INTO `cms_pages` VALUES ('12', '模拟账户', 'simulation', 'TransactionController@simulation', '10', 'zh_CN', null, null, null, '2018-07-31 12:21:11', null);
INSERT INTO `cms_pages` VALUES ('13', '合约细则', 'rule', 'TransactionController@rule', '10', 'zh_CN', null, null, null, '2018-07-31 12:21:11', null);
INSERT INTO `cms_pages` VALUES ('14', '合约利息', 'interest', 'TransactionController@interest', '10', 'zh_CN', null, null, null, '2018-07-31 12:21:12', null);
INSERT INTO `cms_pages` VALUES ('15', '交易指南', 'guide', 'TransactionController@guide', '10', 'zh_CN', null, null, null, '2018-07-31 12:21:12', null);
INSERT INTO `cms_pages` VALUES ('16', '平台下载', 'platform', 'PlatformController@pc', '0', 'zh_CN', null, null, null, '2018-07-31 12:22:52', null);
INSERT INTO `cms_pages` VALUES ('17', '电脑交易平台', 'pc', 'PlatformController@pc', '16', 'zh_CN', null, null, null, '2018-07-31 12:22:52', null);
INSERT INTO `cms_pages` VALUES ('18', '手机交易平台', 'mobile', 'PlatformController@mobile', '16', 'zh_CN', null, null, null, '2018-07-31 12:22:52', null);
INSERT INTO `cms_pages` VALUES ('19', '新闻咨询', 'news', 'NewsController@comment', '0', 'zh_CN', null, null, null, '2018-07-31 12:22:52', null);
INSERT INTO `cms_pages` VALUES ('20', '每日金评', 'comment', 'NewsController@comment', '19', 'zh_CN', null, null, null, '2018-07-31 12:22:52', null);
INSERT INTO `cms_pages` VALUES ('21', '黄金头条', 'headline', 'NewsController@headline', '19', 'zh_CN', null, null, null, '2018-07-31 12:22:53', null);
INSERT INTO `cms_pages` VALUES ('22', '汇市新闻', 'market', 'NewsController@market', '19', 'zh_CN', null, null, null, '2018-07-31 12:22:53', null);
INSERT INTO `cms_pages` VALUES ('23', '行业资讯', 'information', 'NewsController@information', '19', 'zh_CN', null, null, null, '2018-07-31 12:22:53', null);
INSERT INTO `cms_pages` VALUES ('24', '即时数据', 'data', 'NewsController@data', '19', 'zh_CN', null, null, null, '2018-07-31 12:23:27', null);
INSERT INTO `cms_pages` VALUES ('25', '财经日历', 'calendar', 'NewsController@calendar', '19', 'zh_CN', null, null, null, '2018-07-31 12:23:27', null);
INSERT INTO `cms_pages` VALUES ('26', '学院', 'college', 'CollegeController@novice', '0', 'zh_CN', null, null, null, '2018-07-31 12:23:27', null);
INSERT INTO `cms_pages` VALUES ('27', '新手入门', 'novice', 'CollegeController@novice', '26', 'zh_CN', null, null, null, '2018-07-31 12:23:48', null);
INSERT INTO `cms_pages` VALUES ('28', '实战技巧', 'skill', 'CollegeController@skill', '26', 'zh_CN', null, null, null, '2018-07-31 12:23:48', null);
INSERT INTO `cms_pages` VALUES ('29', '名师指路', 'teacher', 'CollegeController@teacher', '26', 'zh_CN', null, null, null, '2018-07-31 12:23:48', null);
INSERT INTO `cms_pages` VALUES ('30', '黄金法则', 'rule', 'CollegeController@rule', '26', 'zh_CN', null, null, null, '2018-07-31 12:24:02', null);
INSERT INTO `cms_pages` VALUES ('31', '外汇投资', 'investment', 'CollegeController@investment', '26', 'zh_CN', null, null, null, '2018-07-31 12:24:03', null);
INSERT INTO `cms_pages` VALUES ('32', '投资百科', 'wiki', 'CollegeController@wiki', '26', 'zh_CN', null, null, null, '2018-07-31 12:24:18', null);

-- ----------------------------
-- Table structure for cms_posts
-- ----------------------------
DROP TABLE IF EXISTS `cms_posts`;
CREATE TABLE `cms_posts` (
  `POST_ID` int(11) NOT NULL AUTO_INCREMENT,
  `POST_TRANSLATE_ID` int(11) DEFAULT '0' COMMENT '翻译的文章ID',
  `POST_CATEGORY_ID` int(11) DEFAULT NULL COMMENT '文章所属栏目',
  `POST_TITLE` varchar(150) DEFAULT NULL,
  `POST_CONTENT` text COMMENT '文章正文',
  `POST_LANG` varchar(10) DEFAULT NULL COMMENT '文章语言',
  `POST_AUTHOR_ID` int(11) DEFAULT NULL COMMENT '作者用户ID',
  `POST_STATUS` tinyint(1) DEFAULT NULL COMMENT '文章状态',
  `POST_LAST_STATUS` tinyint(1) DEFAULT NULL COMMENT 'post删除前最后的状态',
  `POST_ORDER` tinyint(3) DEFAULT '0' COMMENT '文章排序',
  `SEO_TITLE` varchar(50) DEFAULT NULL COMMENT 'seo标题',
  `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
  `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `PUBLISHED_TIME` datetime DEFAULT NULL COMMENT '发布时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  `DELETED_TIME` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`POST_ID`),
  KEY `POST_TRANSLATE_ID` (`POST_TRANSLATE_ID`) USING BTREE,
  KEY `POST_TITLE` (`POST_TITLE`) USING BTREE,
  KEY `POST_STATUS` (`POST_STATUS`) USING BTREE,
  KEY `PUBLISHED_TIME` (`PUBLISHED_TIME`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COMMENT='存放文章信息\r\n状态\r\n0：草稿\r\n1：等待发布\r\n2：发布\r\n3：删除';

-- ----------------------------
-- Records of cms_posts
-- ----------------------------
INSERT INTO `cms_posts` VALUES ('31', '0', '3', '3123', '&lt;p&gt;123123&lt;/p&gt;', 'zh_CN', '0', '0', null, '0', '', '', '', '2018-07-22 18:42:36', '2018-07-22 18:42:36', null, null);
INSERT INTO `cms_posts` VALUES ('32', '0', '3', '3123', '&lt;p&gt;123123&lt;/p&gt;', 'zh_CN', '0', '0', null, '0', '', '', '', '2018-07-22 18:42:37', '2018-07-22 18:42:37', null, null);
INSERT INTO `cms_posts` VALUES ('33', '0', '3', '123', '&lt;p&gt;213123123&lt;/p&gt;', 'zh_HK', '0', '0', null, '0', '', '', '', '2018-07-22 18:43:34', '2018-07-22 18:43:34', null, '2018-08-09 15:13:46');
INSERT INTO `cms_posts` VALUES ('35', '0', '3', '123', '&lt;p&gt;1313&lt;/p&gt;', 'zh_CN', '0', '0', null, '0', '', '', '', '2018-07-22 23:06:06', '2018-07-22 23:06:06', null, null);
INSERT INTO `cms_posts` VALUES ('36', '0', '3', '123', '&lt;p&gt;1313&lt;/p&gt;', 'zh_CN', '0', '2', null, '0', '', '', '', '2018-07-22 23:06:43', '2018-07-22 23:06:43', null, null);
INSERT INTO `cms_posts` VALUES ('37', '0', '3', '123', '&lt;p&gt;1313&lt;/p&gt;', 'zh_CN', '0', '2', null, '0', '', '', '', '2018-07-22 23:06:47', '2018-07-22 23:06:47', null, null);
INSERT INTO `cms_posts` VALUES ('38', '0', '3', '123', '&lt;p&gt;1313&lt;/p&gt;', 'zh_CN', '0', '2', null, '0', '', '', '', '2018-07-22 23:06:51', '2018-07-22 23:06:51', null, null);
INSERT INTO `cms_posts` VALUES ('39', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:48', '2018-07-23 10:27:48', null, null);
INSERT INTO `cms_posts` VALUES ('40', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:49', '2018-07-23 10:27:49', null, null);
INSERT INTO `cms_posts` VALUES ('41', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:49', '2018-07-23 10:27:49', null, null);
INSERT INTO `cms_posts` VALUES ('42', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:50', '2018-07-23 10:27:50', null, null);
INSERT INTO `cms_posts` VALUES ('43', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:50', '2018-07-23 10:27:50', null, null);
INSERT INTO `cms_posts` VALUES ('44', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:50', '2018-07-23 10:27:50', null, null);
INSERT INTO `cms_posts` VALUES ('45', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:50', '2018-07-23 10:27:50', null, null);
INSERT INTO `cms_posts` VALUES ('46', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:51', '2018-07-23 10:27:51', null, null);
INSERT INTO `cms_posts` VALUES ('47', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:51', '2018-07-23 10:27:51', null, null);
INSERT INTO `cms_posts` VALUES ('48', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:51', '2018-07-23 10:27:51', null, null);
INSERT INTO `cms_posts` VALUES ('49', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:52', '2018-07-23 10:27:52', null, null);
INSERT INTO `cms_posts` VALUES ('50', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:52', '2018-07-23 10:27:52', null, null);
INSERT INTO `cms_posts` VALUES ('51', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:52', '2018-07-23 10:27:52', null, null);
INSERT INTO `cms_posts` VALUES ('52', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:52', '2018-07-23 10:27:52', null, null);
INSERT INTO `cms_posts` VALUES ('53', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:52', '2018-07-23 10:27:52', null, null);
INSERT INTO `cms_posts` VALUES ('54', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:53', '2018-07-23 10:27:53', null, null);
INSERT INTO `cms_posts` VALUES ('55', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:53', '2018-07-23 10:27:53', null, null);
INSERT INTO `cms_posts` VALUES ('56', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:53', '2018-07-23 10:27:53', null, null);
INSERT INTO `cms_posts` VALUES ('57', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:53', '2018-07-23 10:27:53', null, null);
INSERT INTO `cms_posts` VALUES ('68', '0', '3', 'asdasd', '&lt;p&gt;asdsad1313&lt;/p&gt;', 'zh_CN', '1', '0', '0', '0', '13', '131', '31', '2018-07-24 18:00:21', '2018-07-24 18:00:21', '2018-07-30 15:55:42', '2018-07-30 15:59:39');
INSERT INTO `cms_posts` VALUES ('69', '0', '3', 'asdasd', '&lt;p&gt;asdsad&lt;/p&gt;', 'zh_CN', '1', '2', '2', '0', '', '', '', '2018-07-24 18:00:42', '2018-07-24 18:00:42', '2018-07-28 19:10:22', '2018-07-28 19:10:32');
INSERT INTO `cms_posts` VALUES ('70', '0', '1', '24', '&lt;p&gt;fsdsdf&lt;/p&gt;', 'zh_CN', '1', '1', '1', '0', 'fsdf', 'fsdf', 'sf', '2018-07-30 16:00:55', '2018-07-30 16:00:55', '2018-08-06 17:22:02', null);
INSERT INTO `cms_posts` VALUES ('71', '0', '3', 'test', '&lt;p style=&quot;font-family: arial, helvetica, sans-serif; color: #444444; line-height: 1.5; font-size: 16px; margin-bottom: 24px;&quot;&gt;关键字：&lt;strong style=&quot;color: #000000; line-height: 1.5;&quot;&gt;&lt;strong style=&quot;line-height: 1.5;&quot;&gt;现货黄金，操作建议&lt;/strong&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;font-family: arial, helvetica, sans-serif; color: #444444; line-height: 1.5; font-size: 16px; margin-bottom: 24px;&quot;&gt;现货黄金依然处于弱势震荡走势之中，在周五非农数据较差的情况下，金价获得支持曾快速上涨至1220美元/盎司后回落。在本周初金价延续非农行情二次冲击1220美元/盎司，但最终止步于1217.7美元/盎司回落，跌破开盘价，整体走势已经偏弱，关注1210附近一线支撑。&lt;/p&gt;\n&lt;p style=&quot;font-family: arial, helvetica, sans-serif; color: #444444; line-height: 1.5; font-size: 16px; margin-bottom: 24px;&quot;&gt;&lt;img class=&quot;size-full wp-image-207201 aligncenter&quot; style=&quot;line-height: 1.5; height: auto; max-width: 640px; margin: 0px auto 12px; display: block; clear: both;&quot; src=&quot;http://www.202.hk/wp-content/uploads/2018/08/20180801071911987no_wm.jpg&quot; alt=&quot;&quot; width=&quot;640&quot; height=&quot;388&quot; /&gt;&lt;/p&gt;', 'zh_CN', '1', '2', '2', '1', '', '', '', '2018-08-06 17:00:11', '2018-08-06 17:00:11', '2018-08-07 11:54:01', null);
INSERT INTO `cms_posts` VALUES ('72', '0', '3', 'asdad', '&lt;p&gt;adsadsadas&lt;/p&gt;', 'zh_CN', '1', '0', '0', '0', '', '', '', '2018-08-07 17:07:04', '2018-08-07 17:07:04', null, null);
INSERT INTO `cms_posts` VALUES ('73', '0', '3', 'asd', '&lt;p&gt;asdasd&lt;/p&gt;', 'zh_CN', '1', '0', '0', '0', '', '', '', '2018-08-07 17:07:45', '2018-08-07 17:07:45', null, null);
INSERT INTO `cms_posts` VALUES ('74', '0', '2', 'asd', '&lt;p&gt;dada&lt;/p&gt;', 'zh_CN', '1', '0', '0', '0', '', '', '', '2018-08-07 17:08:32', '2018-08-07 17:08:32', null, null);
INSERT INTO `cms_posts` VALUES ('75', '0', '2', 'asd', '&lt;p&gt;dada&lt;/p&gt;', 'zh_CN', '1', '0', '0', '0', '', '', '', '2018-08-07 17:09:29', '2018-08-07 17:09:29', null, null);
INSERT INTO `cms_posts` VALUES ('76', '0', '3', 'asdas', '&lt;p&gt;asdad&lt;/p&gt;', 'zh_CN', '1', '0', '0', '0', '', '', '', '2018-08-07 17:09:35', '2018-08-07 17:09:35', null, null);
INSERT INTO `cms_posts` VALUES ('77', '0', '2', '1231', '&lt;p&gt;1313&lt;/p&gt;', 'zh_CN', '1', '0', '0', '0', '', '', '', '2018-08-07 17:10:03', '2018-08-07 17:10:03', null, null);
INSERT INTO `cms_posts` VALUES ('78', '0', '4', 'asdad555', '&lt;p&gt;sadad&lt;/p&gt;', 'zh_CN', '1', '0', '0', '0', '', '', '', '2018-08-07 17:10:13', '2018-08-07 17:10:13', null, null);
INSERT INTO `cms_posts` VALUES ('79', '0', '3', 'asdadada', '', 'zh_CN', '1', '0', '0', '0', '', '', '', '2018-08-07 17:11:50', '2018-08-07 17:11:50', null, null);
INSERT INTO `cms_posts` VALUES ('80', '0', '2', '3334', '&lt;p&gt;4444&lt;/p&gt;', 'zh_CN', '1', '0', '0', '0', '', '', '', '2018-08-07 17:19:29', '2018-08-07 17:19:29', null, null);
INSERT INTO `cms_posts` VALUES ('81', '0', '7', 'asdsa', '&lt;p&gt;dadsad&lt;/p&gt;', 'zh_CN', '0', '0', '0', '0', 'ad', 'ad', 'ad', '2018-08-08 17:46:44', '2018-08-08 17:46:44', null, null);
INSERT INTO `cms_posts` VALUES ('82', '0', '7', 'asdsa', '&lt;p&gt;dadsad&lt;/p&gt;', 'zh_CN', '0', '0', '0', '0', 'ad', 'ad', 'ad', '2018-08-08 17:47:05', '2018-08-08 17:47:05', null, null);
INSERT INTO `cms_posts` VALUES ('83', '0', '7', 'asdsa', '&lt;p&gt;dadsad&lt;/p&gt;', 'zh_CN', '0', '0', '0', '0', 'ad', 'ad', 'ad', '2018-08-08 17:47:07', '2018-08-08 17:47:07', null, null);
INSERT INTO `cms_posts` VALUES ('84', '0', '7', 'asdsa', '&lt;p&gt;dadsad&lt;/p&gt;', 'zh_CN', '0', '0', '0', '0', 'ad', 'ad', 'ad', '2018-08-08 17:47:13', '2018-08-08 17:47:13', null, null);
INSERT INTO `cms_posts` VALUES ('85', '0', '2', 'asdsa54646', '&lt;p&gt;dadsad456546&lt;/p&gt;', 'zh_CN', '0', '0', '0', '0', 'ad', 'ad', 'ad', '2018-08-08 17:47:18', '2018-08-08 17:47:18', '2018-08-08 17:50:33', null);
INSERT INTO `cms_posts` VALUES ('86', '0', '7', 'asdsa', '&lt;p&gt;dadsad&lt;/p&gt;', 'zh_CN', '0', '3', '0', '0', 'ad', 'ad', 'ad', '2018-08-08 17:47:38', '2018-08-08 17:47:38', null, '2018-08-08 17:50:03');
INSERT INTO `cms_posts` VALUES ('87', '0', '19', '43543', '&lt;p&gt;535、&lt;/p&gt;', 'zh_HK', '1', '0', '0', '0', '', '', '', '2018-08-09 14:30:46', '2018-08-09 14:30:46', null, null);
INSERT INTO `cms_posts` VALUES ('88', '0', '19', '43543', '&lt;p&gt;535、&lt;/p&gt;', 'zh_HK', '1', '0', '0', '0', '', '', '', '2018-08-09 14:30:48', '2018-08-09 14:30:48', null, null);
INSERT INTO `cms_posts` VALUES ('89', '0', '19', '43543', '&lt;p&gt;535、&lt;/p&gt;', 'zh_HK', '1', '0', '0', '0', '', '', '', '2018-08-09 14:31:21', '2018-08-09 14:31:21', null, null);
INSERT INTO `cms_posts` VALUES ('90', '0', '19', '43543', '&lt;p&gt;535、&lt;/p&gt;', 'zh_HK', '1', '0', '0', '0', '', '', '', '2018-08-09 14:31:24', '2018-08-09 14:31:24', null, null);
INSERT INTO `cms_posts` VALUES ('91', '0', '19', '43543', '&lt;p&gt;535、&lt;/p&gt;', 'zh_HK', '1', '0', '0', '0', '', '', '', '2018-08-09 14:31:29', '2018-08-09 14:31:29', null, '2018-08-09 15:14:14');
INSERT INTO `cms_posts` VALUES ('96', '91', '3', '5345345', '&lt;p&gt;34543&lt;/p&gt;', 'zh_CN', '1', '0', '0', '0', '', '', '', '2018-08-09 14:48:15', '2018-08-09 14:48:15', null, null);
INSERT INTO `cms_posts` VALUES ('97', '0', '19', 'dasd', '&lt;p&gt;sd234&lt;/p&gt;', 'zh_HK', '1', '0', '0', '0', '', '', '', '2018-08-09 14:52:48', '2018-08-09 14:52:48', '2018-08-09 15:05:08', null);
INSERT INTO `cms_posts` VALUES ('98', '97', '3', '土耳其面临危机，黄金成为了风险资产  ', '&lt;p&gt;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;&lt;/p&gt;\n&lt;p&gt;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;土耳其面临危机，黄金成为了风险资产 &amp;nbsp;&lt;/p&gt;', 'zh_CN', '0', '2', '2', '0', '土耳其面临危机，黄金成为了风险资产  ', '土耳其面临危机，黄金成为了风险资产  ', '土耳其面临危机，黄金成为了风险资产  ', '2018-08-09 14:56:54', '2018-08-09 14:56:54', '2018-08-14 09:57:32', null);
INSERT INTO `cms_posts` VALUES ('99', '0', '19', '3453', '&lt;p&gt;5345&lt;/p&gt;', 'zh_HK', '1', '0', '0', '0', '', '', '', '2018-08-09 15:09:39', '2018-08-09 15:09:39', null, '2018-08-09 15:14:11');
INSERT INTO `cms_posts` VALUES ('100', '0', '3', '4646', '&lt;p&gt;456&lt;/p&gt;', 'zh_CN', '1', '0', '0', '0', '', '', '', '2018-08-14 15:53:14', '2018-08-14 15:53:14', null, null);
INSERT INTO `cms_posts` VALUES ('101', '0', '3', '4646', '&lt;p&gt;&lt;img src=&quot;/Uploads/cms_upload_images/2018-08-14/5b728b7e8114f.jpg&quot; alt=&quot;&quot; width=&quot;1143&quot; height=&quot;327&quot; /&gt;456&lt;/p&gt;', 'zh_CN', '1', '0', '0', '0', '', '', '', '2018-08-14 15:53:22', '2018-08-14 15:53:22', '2018-08-14 15:57:56', null);

-- ----------------------------
-- Table structure for cms_posts_revision_history
-- ----------------------------
DROP TABLE IF EXISTS `cms_posts_revision_history`;
CREATE TABLE `cms_posts_revision_history` (
  `ROW_ID` int(11) NOT NULL AUTO_INCREMENT,
  `POST_ID` int(11) DEFAULT NULL COMMENT '文章id',
  `POST_AUTHOR_ID` int(11) DEFAULT NULL COMMENT '修改作者',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ROW_ID`),
  KEY `POST_ID` (`POST_ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='文章修改历史记录';

-- ----------------------------
-- Records of cms_posts_revision_history
-- ----------------------------
INSERT INTO `cms_posts_revision_history` VALUES ('1', '71', '1', '2018-08-07 11:52:28');
INSERT INTO `cms_posts_revision_history` VALUES ('2', '71', '1', '2018-08-07 11:54:01');
INSERT INTO `cms_posts_revision_history` VALUES ('3', '85', '0', '2018-08-08 17:50:15');
INSERT INTO `cms_posts_revision_history` VALUES ('4', '85', '0', '2018-08-08 17:50:25');
INSERT INTO `cms_posts_revision_history` VALUES ('5', '85', '0', '2018-08-08 17:50:33');
INSERT INTO `cms_posts_revision_history` VALUES ('6', '97', '1', '2018-08-09 14:57:59');
INSERT INTO `cms_posts_revision_history` VALUES ('7', '97', '1', '2018-08-09 14:59:10');
INSERT INTO `cms_posts_revision_history` VALUES ('8', '97', '1', '2018-08-09 14:59:34');
INSERT INTO `cms_posts_revision_history` VALUES ('9', '97', '1', '2018-08-09 15:04:07');
INSERT INTO `cms_posts_revision_history` VALUES ('10', '97', '1', '2018-08-09 15:04:16');
INSERT INTO `cms_posts_revision_history` VALUES ('11', '97', '1', '2018-08-09 15:04:59');
INSERT INTO `cms_posts_revision_history` VALUES ('12', '97', '1', '2018-08-09 15:05:03');
INSERT INTO `cms_posts_revision_history` VALUES ('13', '97', '1', '2018-08-09 15:05:08');
INSERT INTO `cms_posts_revision_history` VALUES ('14', '98', '0', '2018-08-14 09:53:01');
INSERT INTO `cms_posts_revision_history` VALUES ('15', '98', '0', '2018-08-14 09:57:32');
INSERT INTO `cms_posts_revision_history` VALUES ('18', '101', '1', '2018-08-14 15:57:56');

-- ----------------------------
-- Table structure for cms_posts_tags_relation
-- ----------------------------
DROP TABLE IF EXISTS `cms_posts_tags_relation`;
CREATE TABLE `cms_posts_tags_relation` (
  `ROW_ID` int(11) NOT NULL AUTO_INCREMENT,
  `POST_ID` int(11) DEFAULT NULL COMMENT '文章id',
  `TAG_ID` int(11) DEFAULT NULL COMMENT '标签id',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ROW_ID`),
  KEY `POST_ID` (`POST_ID`) USING BTREE,
  KEY `TAG_ID` (`TAG_ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='保存文章和标签的对应关系';

-- ----------------------------
-- Records of cms_posts_tags_relation
-- ----------------------------
INSERT INTO `cms_posts_tags_relation` VALUES ('1', '65', null, '2018-07-24 18:03:08');
INSERT INTO `cms_posts_tags_relation` VALUES ('2', '65', null, '2018-07-24 18:03:08');
INSERT INTO `cms_posts_tags_relation` VALUES ('3', '66', null, '2018-07-24 18:03:08');
INSERT INTO `cms_posts_tags_relation` VALUES ('4', '66', null, '2018-07-24 18:03:08');
INSERT INTO `cms_posts_tags_relation` VALUES ('5', '67', null, '2018-07-24 18:03:08');
INSERT INTO `cms_posts_tags_relation` VALUES ('6', '67', null, '2018-07-24 18:03:08');
INSERT INTO `cms_posts_tags_relation` VALUES ('11', '68', '0', '2018-07-30 15:55:42');
INSERT INTO `cms_posts_tags_relation` VALUES ('13', '70', '79', '2018-08-06 17:22:02');
INSERT INTO `cms_posts_tags_relation` VALUES ('14', '70', '101', '2018-08-06 17:22:02');
INSERT INTO `cms_posts_tags_relation` VALUES ('15', '71', '102', '2018-08-06 18:01:01');
INSERT INTO `cms_posts_tags_relation` VALUES ('16', '81', '79', '2018-08-08 17:46:44');
INSERT INTO `cms_posts_tags_relation` VALUES ('17', '82', '79', '2018-08-08 17:47:05');
INSERT INTO `cms_posts_tags_relation` VALUES ('18', '83', '79', '2018-08-08 17:47:07');
INSERT INTO `cms_posts_tags_relation` VALUES ('19', '84', '79', '2018-08-08 17:47:13');
INSERT INTO `cms_posts_tags_relation` VALUES ('20', '85', '79', '2018-08-08 17:47:18');
INSERT INTO `cms_posts_tags_relation` VALUES ('22', '86', '79', '2018-08-08 17:47:38');
INSERT INTO `cms_posts_tags_relation` VALUES ('23', '86', '89', '2018-08-08 17:47:38');
INSERT INTO `cms_posts_tags_relation` VALUES ('24', '97', '104', '2018-08-09 15:04:07');
INSERT INTO `cms_posts_tags_relation` VALUES ('25', '99', '105', '2018-08-09 15:09:39');

-- ----------------------------
-- Table structure for cms_tags
-- ----------------------------
DROP TABLE IF EXISTS `cms_tags`;
CREATE TABLE `cms_tags` (
  `TAG_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TAG_NAME` varchar(30) DEFAULT NULL COMMENT '标签名称',
  `TAG_SLUG` varchar(30) DEFAULT NULL COMMENT '标签别名',
  `TAG_LANG` varchar(10) DEFAULT NULL COMMENT '标签所属语言',
  `TAG_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT '标签描述',
  `SEO_TITLE` varchar(50) DEFAULT NULL COMMENT 'seo标题',
  `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
  `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`TAG_ID`),
  KEY `TAG_NAME` (`TAG_NAME`) USING BTREE,
  KEY `TAG_SLUG` (`TAG_SLUG`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COMMENT='存放文章标签信息';

-- ----------------------------
-- Records of cms_tags
-- ----------------------------
INSERT INTO `cms_tags` VALUES ('75', '242444', 'sdfsdf', null, '23424226565', '边个', '现货黄金，操作建议', '现货黄金市场2018年7月23日14点收盘于1230.9美元/盎司，金价在早间冲击重压1235美元/盎司一线后回撤，目前维持与1230-1233区间窄幅震荡。现货黄金在短期内可能面临小幅调整，在调整过后依然有机会继续上涨。后市关注1225-1230区间能否成为上涨后的回踩支点，为后市', '2018-07-22 01:10:52', null);
INSERT INTO `cms_tags` VALUES ('78', '112', null, null, '', '', '', '', '2018-07-22 18:52:52', null);
INSERT INTO `cms_tags` VALUES ('79', '123', null, null, '13', '131', '31', '313', '2018-07-22 19:06:20', null);
INSERT INTO `cms_tags` VALUES ('80', '1', null, null, '', '', '', '', '2018-07-24 16:27:26', null);
INSERT INTO `cms_tags` VALUES ('81', '23432242', '424', null, '2424', '24', '24', '424', '2018-07-24 17:09:39', null);
INSERT INTO `cms_tags` VALUES ('82', '1313', '1313', null, '', '', '', '', '2018-07-24 17:24:25', null);
INSERT INTO `cms_tags` VALUES ('83', '13123', '13123', null, '', '', '', '', '2018-07-24 17:56:36', null);
INSERT INTO `cms_tags` VALUES ('84', '1312344', '1312344', null, '', '', '', '', '2018-07-24 17:56:37', null);
INSERT INTO `cms_tags` VALUES ('85', 'asdsad', 'asdsad', null, '', '', '', '', '2018-07-24 17:56:58', null);
INSERT INTO `cms_tags` VALUES ('86', 'asdsadasd', 'asdsadasd', null, '', '', '', '', '2018-07-24 17:57:03', null);
INSERT INTO `cms_tags` VALUES ('87', 'asds', 'asds', null, '', '', '', '', '2018-07-24 17:58:10', null);
INSERT INTO `cms_tags` VALUES ('88', 'asdsd', 'asdsd', null, '', '', '', '', '2018-07-24 17:58:11', null);
INSERT INTO `cms_tags` VALUES ('89', '1234', '1234', null, '', '', '', '', '2018-07-24 23:27:51', null);
INSERT INTO `cms_tags` VALUES ('90', '12346', '12346', null, '', '', '', '', '2018-07-24 23:36:46', null);
INSERT INTO `cms_tags` VALUES ('91', '12347', '12347', null, '', '', '', '', '2018-07-24 23:36:57', null);
INSERT INTO `cms_tags` VALUES ('92', '123476', '123476', null, '', '', '', '', '2018-07-24 23:37:21', null);
INSERT INTO `cms_tags` VALUES ('93', '12345679', '12345679', null, '', '', '', '', '2018-07-24 23:38:02', null);
INSERT INTO `cms_tags` VALUES ('94', '66666', '66666', null, '', '', '', '', '2018-07-24 23:50:47', null);
INSERT INTO `cms_tags` VALUES ('95', '123444', '123444', null, '', '', '', '', '2018-07-24 23:53:45', null);
INSERT INTO `cms_tags` VALUES ('96', '12313123', '12313123', null, '', '', '', '', '2018-07-24 23:54:15', null);
INSERT INTO `cms_tags` VALUES ('97', '456546456', '456546456', null, '', '', '', '', '2018-07-24 23:54:24', null);
INSERT INTO `cms_tags` VALUES ('98', '1231', '1231', null, null, null, null, null, '2018-07-30 16:05:15', null);
INSERT INTO `cms_tags` VALUES ('99', '123144', '1231', null, '3131', '1', '2131', '31', '2018-07-30 16:19:33', null);
INSERT INTO `cms_tags` VALUES ('100', '345', '435', null, '', '', '', '', '2018-07-30 16:23:19', null);
INSERT INTO `cms_tags` VALUES ('101', 'kama', 'kama', null, null, null, null, null, '2018-08-06 16:49:38', null);
INSERT INTO `cms_tags` VALUES ('102', '213', '213', null, null, null, null, null, '2018-08-06 18:00:20', null);
INSERT INTO `cms_tags` VALUES ('103', '4234', '4234', null, null, null, null, null, '2018-08-07 11:08:03', null);
INSERT INTO `cms_tags` VALUES ('104', '345', '345', 'zh_HK', null, null, null, null, '2018-08-09 15:03:59', null);
INSERT INTO `cms_tags` VALUES ('105', '13213', '13213', 'zh_HK', null, null, null, null, '2018-08-09 15:09:28', null);
INSERT INTO `cms_tags` VALUES ('106', '34535', '34535', 'zh_CN', null, null, null, null, '2018-08-09 15:09:47', null);
INSERT INTO `cms_tags` VALUES ('107', '4234242', '42', 'zh_HK', '4242', '4', '242', '424', '2018-08-09 15:21:12', null);
INSERT INTO `cms_tags` VALUES ('108', '234242', '42', 'zh_CN', '4242', '42', '42', '44', '2018-08-09 15:21:27', null);
INSERT INTO `cms_tags` VALUES ('109', '4234242', '42', 'zh_CN', '4242', '42', '42', '44', '2018-08-09 15:22:35', null);
INSERT INTO `cms_tags` VALUES ('110', '现货黄金', 'xianhuohuangjin', 'zh_CN', '上周五美国CPI数据符合预期，美元持续冲高，然而由于国际局势持续动荡导致市场出现避险情绪，黄金受到的美元打压并不强烈，只是轻微回落后便冲高至1217.0美元/盎司，但是依然...', '现货黄金现货黄金|现货黄金', '现货黄金', '上周五美国CPI数据符合预期，美元持续冲高，然而由于国际局势持续动荡导致市场出现避险情绪，黄金受到的美元打压并不强烈，只是轻微回落后便冲高至1217.0美元/盎司，但是依然...', '2018-08-09 15:26:56', null);
INSERT INTO `cms_tags` VALUES ('111', '345', '345', 'zh_CN', null, null, null, null, '2018-08-14 11:56:45', null);
INSERT INTO `cms_tags` VALUES ('112', 'aaa', 'aaa', 'zh_CN', null, null, null, null, '2018-08-14 14:10:03', null);
INSERT INTO `cms_tags` VALUES ('113', 'aaaa', 'aaaa', 'zh_CN', null, null, null, null, '2018-08-14 14:10:41', null);
INSERT INTO `cms_tags` VALUES ('114', '4564', '4564', 'zh_CN', null, null, null, null, '2018-08-14 15:54:00', null);
INSERT INTO `cms_tags` VALUES ('115', '567', '567', 'zh_CN', null, null, null, null, '2018-08-14 15:54:28', null);
