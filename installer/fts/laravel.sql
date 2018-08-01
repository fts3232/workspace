/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-08-01 16:41:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for banner
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `BANNER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BANNER_NAME` varchar(30) DEFAULT NULL COMMENT 'banner名称',
  `CREATED_TIEM` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`BANNER_ID`),
  KEY `BANNER_NAME` (`BANNER_NAME`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='存放banner信息';

-- ----------------------------
-- Records of banner
-- ----------------------------
INSERT INTO `banner` VALUES ('6', '124', '2018-07-20 16:06:12', '2018-07-24 09:55:36');
INSERT INTO `banner` VALUES ('7', '12312', '2018-07-20 16:06:13', null);
INSERT INTO `banner` VALUES ('8', '12312', '2018-07-20 16:06:13', null);
INSERT INTO `banner` VALUES ('9', '12312', '2018-07-20 16:06:13', null);
INSERT INTO `banner` VALUES ('10', '12312', '2018-07-20 16:06:14', null);
INSERT INTO `banner` VALUES ('11', '12312', '2018-07-20 16:06:14', null);
INSERT INTO `banner` VALUES ('12', '12312', '2018-07-20 16:06:14', null);
INSERT INTO `banner` VALUES ('13', '12312', '2018-07-20 16:06:14', null);
INSERT INTO `banner` VALUES ('14', '12312', '2018-07-20 16:06:15', null);
INSERT INTO `banner` VALUES ('15', '12312', '2018-07-20 16:06:15', null);
INSERT INTO `banner` VALUES ('16', '12312', '2018-07-20 16:06:15', null);
INSERT INTO `banner` VALUES ('17', '12312', '2018-07-20 16:06:15', null);
INSERT INTO `banner` VALUES ('18', '12312', '2018-07-20 16:06:15', null);
INSERT INTO `banner` VALUES ('19', '12312', '2018-07-20 16:06:15', null);
INSERT INTO `banner` VALUES ('20', '12312', '2018-07-20 16:06:16', null);
INSERT INTO `banner` VALUES ('21', '12312', '2018-07-20 16:06:16', null);
INSERT INTO `banner` VALUES ('22', '345', '2018-07-20 18:02:35', null);
INSERT INTO `banner` VALUES ('23', '123', '2018-07-22 20:07:57', null);
INSERT INTO `banner` VALUES ('24', '111', '2018-07-22 20:08:07', null);
INSERT INTO `banner` VALUES ('25', '3242', '2018-07-22 20:46:13', null);
INSERT INTO `banner` VALUES ('26', '复旦复华具体化服返回', '2018-07-24 10:36:14', null);
INSERT INTO `banner` VALUES ('27', '复旦复华具体化服返回', '2018-07-24 10:36:21', null);
INSERT INTO `banner` VALUES ('28', '复旦复华具体化服返回', '2018-07-24 10:36:56', null);
INSERT INTO `banner` VALUES ('29', '现货黄金', '2018-07-24 16:48:26', null);
INSERT INTO `banner` VALUES ('31', '123456', '2018-07-30 14:55:44', '2018-07-30 14:55:51');
INSERT INTO `banner` VALUES ('32', '12', '2018-07-30 14:59:43', null);
INSERT INTO `banner` VALUES ('33', '455', '2018-07-30 14:59:47', '2018-07-30 14:59:51');

-- ----------------------------
-- Table structure for banner_item
-- ----------------------------
DROP TABLE IF EXISTS `banner_item`;
CREATE TABLE `banner_item` (
  `ITEM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BANNER_ID` int(11) DEFAULT NULL COMMENT '所属banner id',
  `ITEM_IMG` varchar(255) DEFAULT NULL COMMENT 'banner 项图片',
  `ITEM_URL` varchar(255) DEFAULT NULL COMMENT 'banner 项url',
  `ITEM_STATUS` tinyint(1) DEFAULT NULL COMMENT '项状态',
  `ITEM_ORDER` tinyint(3) DEFAULT NULL COMMENT '图片排序',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`ITEM_ID`),
  KEY `BANNER_ID` (`BANNER_ID`) USING BTREE,
  KEY `ITEM_STATUS` (`ITEM_STATUS`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='保存banner图片项信息\r\n状态\r\n0：下架\r\n1：上架';

-- ----------------------------
-- Records of banner_item
-- ----------------------------
INSERT INTO `banner_item` VALUES ('2', '6', '/Uploads/cms_banner/2018-07-22/5b547c1988fa2.jpg', '234234', '1', '0', '2018-07-22 20:44:34', '2018-07-28 17:27:40');
INSERT INTO `banner_item` VALUES ('5', '31', '/Uploads/cms_banner/2018-07-30/5b5eb68293a44.png', '', '0', '1', '2018-07-30 14:58:07', '2018-07-30 15:01:38');
INSERT INTO `banner_item` VALUES ('7', '31', '/Uploads/cms_banner/2018-07-30/5b5eb708b4084.png', '', '0', '2', '2018-07-30 14:58:24', '2018-07-30 15:01:38');
INSERT INTO `banner_item` VALUES ('8', '31', '/Uploads/cms_banner/2018-07-30/5b5eb70d9e20d.png', '312', '1', '0', '2018-07-30 14:58:24', '2018-07-30 15:01:38');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(30) DEFAULT NULL COMMENT '栏目名称',
  `CATEGORY_SLUG` varchar(30) DEFAULT NULL COMMENT '栏目别名',
  `CATEGORY_PARENT` int(11) DEFAULT NULL COMMENT '栏目父类',
  `CATEGORY_ORDER` tinyint(3) DEFAULT NULL COMMENT '栏目排序',
  `CATEGORY_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT '栏目描述',
  `SEO_TITLE` varchar(150) DEFAULT NULL COMMENT 'seo标题',
  `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
  `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
  `CRAETED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`CATEGORY_ID`),
  KEY `CATEGORY_NAME` (`CATEGORY_NAME`),
  KEY `CATEGORY_SLUG` (`CATEGORY_SLUG`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='文章栏目信息';

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '新闻咨询', 'news', '0', '0', 'null', 'null', 'null', 'null', '2018-07-19 17:03:20', '2018-08-01 11:02:14');
INSERT INTO `category` VALUES ('2', '每日金评', 'comment', '1', '0', '描述', '标题', '现货黄金，操作建议', '现货黄金市场2018年7月23日14点收盘于1230.9美元/盎司，金价在早间冲击重压1235美元/盎司一线后回撤，目前维持与1230-1233区间窄幅震荡。现货黄金在短期内可能面临小幅调整，在调整过后依然有机会继续上涨。后市关注1225-1230区间能否成为上涨后的回踩支点，为后市', '2018-07-19 17:03:20', '2018-08-01 11:02:14');
INSERT INTO `category` VALUES ('3', '黄金头条', 'headline', '1', '1', 'null', 'null', 'null', 'null', '2018-07-19 17:03:20', '2018-08-01 11:02:14');
INSERT INTO `category` VALUES ('4', '汇市新闻', 'market', '1', '2', 'null', 'null', 'null', 'null', '2018-07-19 17:03:20', '2018-08-01 11:02:14');
INSERT INTO `category` VALUES ('7', '行业资讯', 'information', '1', '3', 'null', 'null', 'null', 'null', '2018-07-19 17:51:39', '2018-08-01 11:02:14');
INSERT INTO `category` VALUES ('8', '即时数据', 'data', '1', '4', 'null', 'null', 'null', 'null', '2018-07-19 17:51:59', '2018-08-01 11:02:14');
INSERT INTO `category` VALUES ('9', '财经日历', 'calendar', '1', '5', '1231t', '31t', '313t', '1231t', '2018-07-22 00:50:10', '2018-08-01 11:02:14');
INSERT INTO `category` VALUES ('11', '学院', 'college', '0', '1', '313', '131', '31', '313', '2018-07-22 21:30:26', '2018-08-01 11:02:14');
INSERT INTO `category` VALUES ('12', '新手入门', 'novice', '11', '0', '131', '3213', '131', '131', '2018-07-22 21:30:50', '2018-08-01 11:02:14');
INSERT INTO `category` VALUES ('13', '实战技巧', 'skill', '11', '1', '2424', '24', '24', '2424', '2018-07-24 10:56:17', '2018-08-01 11:02:14');
INSERT INTO `category` VALUES ('14', '名师指路', 'teacher', '11', '2', 'null', 'null', 'null', 'null', '2018-08-01 10:58:02', '2018-08-01 11:02:14');
INSERT INTO `category` VALUES ('15', '黄金法则', 'rule', '11', '3', 'null', 'null', 'null', 'null', '2018-08-01 10:58:02', '2018-08-01 11:02:14');
INSERT INTO `category` VALUES ('16', '外汇投资', 'investment', '11', '4', 'null', 'null', 'null', 'null', '2018-08-01 10:58:02', '2018-08-01 11:02:14');
INSERT INTO `category` VALUES ('17', '投资百科', 'wiki', '11', '5', 'null', 'null', 'null', 'null', '2018-08-01 10:58:22', '2018-08-01 11:02:14');

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `MENU_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_NAME` varchar(30) DEFAULT NULL COMMENT '菜单名',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL,
  PRIMARY KEY (`MENU_ID`),
  KEY `NAME` (`MENU_NAME`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='保存菜单信息';

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', 'test', '2018-07-18 15:36:55', null);
INSERT INTO `menu` VALUES ('18', 'sa12', '2018-07-19 16:59:23', '2018-07-20 15:05:23');
INSERT INTO `menu` VALUES ('19', '111', '2018-07-24 10:00:59', null);
INSERT INTO `menu` VALUES ('22', '复旦复华具体化服返回', '2018-07-24 10:39:59', null);
INSERT INTO `menu` VALUES ('23', '23411', '2018-07-30 14:27:51', '2018-07-30 14:31:54');
INSERT INTO `menu` VALUES ('25', '44', '2018-07-30 14:31:56', null);
INSERT INTO `menu` VALUES ('26', '444', '2018-07-30 14:45:26', null);
INSERT INTO `menu` VALUES ('27', '4444', '2018-07-30 14:46:04', null);

-- ----------------------------
-- Table structure for menu_item
-- ----------------------------
DROP TABLE IF EXISTS `menu_item`;
CREATE TABLE `menu_item` (
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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='保存菜单项信息';

-- ----------------------------
-- Records of menu_item
-- ----------------------------
INSERT INTO `menu_item` VALUES ('18', '1', '2342', '23424', '0', '0', '2018-07-18 18:13:02', null);
INSERT INTO `menu_item` VALUES ('20', '1', '11', '123', '0', '1', '2018-07-19 12:21:58', null);
INSERT INTO `menu_item` VALUES ('21', '1', '11', '123', '20', '0', '2018-07-19 12:21:58', '2018-07-19 16:44:25');
INSERT INTO `menu_item` VALUES ('22', '1', '11', '123', '0', '3', '2018-07-19 12:21:58', '2018-07-20 16:04:24');
INSERT INTO `menu_item` VALUES ('23', '1', '11', '123', '22', '0', '2018-07-19 12:21:58', null);
INSERT INTO `menu_item` VALUES ('24', '1', '11', '123', '0', '2', '2018-07-19 12:21:58', '2018-07-20 16:04:24');
INSERT INTO `menu_item` VALUES ('25', '1', '11', '123', '0', '5', '2018-07-19 12:21:58', '2018-07-20 16:04:22');
INSERT INTO `menu_item` VALUES ('26', '1', '11', '123', '0', '4', '2018-07-19 12:21:58', '2018-07-20 16:04:17');
INSERT INTO `menu_item` VALUES ('27', '1', '3453455435', '5435', '0', '6', '2018-07-20 16:04:30', null);
INSERT INTO `menu_item` VALUES ('28', '18', '1231', '231', '0', '0', '2018-07-22 20:43:34', null);
INSERT INTO `menu_item` VALUES ('29', '18', '1231', '231', '0', '1', '2018-07-22 20:43:34', null);
INSERT INTO `menu_item` VALUES ('30', '1', '撒大声地撒奥所', '23424234', '0', '7', '2018-07-24 10:47:25', null);
INSERT INTO `menu_item` VALUES ('33', '23', '244', '2242', '0', '0', '2018-07-30 14:34:25', null);

-- ----------------------------
-- Table structure for pages
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
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
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES ('1', '关于我们', 'about', '', '0', 'zh_CN', null, null, null, '2018-07-29 09:37:07', null);
INSERT INTO `pages` VALUES ('2', '集团概况', 'introduction', 'AboutController@introduction', '1', 'zh_CN', '5435t', '5435t', '3543t', '2018-07-29 09:37:14', null);
INSERT INTO `pages` VALUES ('5', '优势', 'advantage', 'AboutController@advantage', '1', 'zh_CN', 'tt', 'tt', 'tt', '2018-07-30 16:36:33', null);
INSERT INTO `pages` VALUES ('6', '集团认证', 'authentication', 'AboutController@authentication', '1', 'zh_CN', null, null, null, '2018-07-31 12:21:10', null);
INSERT INTO `pages` VALUES ('7', '投资者保障', 'guarantee', 'AboutController@guarantee', '1', 'zh_CN', null, null, null, '2018-07-31 12:21:10', null);
INSERT INTO `pages` VALUES ('8', '公告', 'notice', 'AboutController@notice', '1', 'zh_CN', null, null, null, '2018-07-31 12:21:10', null);
INSERT INTO `pages` VALUES ('9', '联系我们', 'contact', 'AboutController@contact', '1', 'zh_CN', null, null, null, '2018-07-31 12:21:10', null);
INSERT INTO `pages` VALUES ('10', '开户交易', 'transaction', '', '0', 'zh_CN', null, null, null, '2018-07-31 12:21:11', null);
INSERT INTO `pages` VALUES ('11', '真实账户', 'real', 'TransactionController@real', '10', 'zh_CN', null, null, null, '2018-07-31 12:21:11', null);
INSERT INTO `pages` VALUES ('12', '模拟账户', 'simulation', 'TransactionController@simulation', '10', 'zh_CN', null, null, null, '2018-07-31 12:21:11', null);
INSERT INTO `pages` VALUES ('13', '合约细则', 'rule', 'TransactionController@rule', '10', 'zh_CN', null, null, null, '2018-07-31 12:21:11', null);
INSERT INTO `pages` VALUES ('14', '合约利息', 'interest', 'TransactionController@interest', '10', 'zh_CN', null, null, null, '2018-07-31 12:21:12', null);
INSERT INTO `pages` VALUES ('15', '交易指南', 'guide', 'TransactionController@guide', '10', 'zh_CN', null, null, null, '2018-07-31 12:21:12', null);
INSERT INTO `pages` VALUES ('16', '平台下载', 'platform', '', '0', 'zh_CN', null, null, null, '2018-07-31 12:22:52', null);
INSERT INTO `pages` VALUES ('17', '电脑交易平台', 'pc', 'PlatformController@pc', '16', 'zh_CN', null, null, null, '2018-07-31 12:22:52', null);
INSERT INTO `pages` VALUES ('18', '手机交易平台', 'mobile', 'PlatformController@mobile', '16', 'zh_CN', null, null, null, '2018-07-31 12:22:52', null);
INSERT INTO `pages` VALUES ('19', '新闻咨询', 'news', null, '0', 'zh_CN', null, null, null, '2018-07-31 12:22:52', null);
INSERT INTO `pages` VALUES ('20', '每日金评', 'comment', 'NewsController@comment', '19', 'zh_CN', null, null, null, '2018-07-31 12:22:52', null);
INSERT INTO `pages` VALUES ('21', '黄金头条', 'headline', 'NewsController@headline', '19', 'zh_CN', null, null, null, '2018-07-31 12:22:53', null);
INSERT INTO `pages` VALUES ('22', '汇市新闻', 'market', 'NewsController@market', '19', 'zh_CN', null, null, null, '2018-07-31 12:22:53', null);
INSERT INTO `pages` VALUES ('23', '行业资讯', 'information', 'NewsController@information', '19', 'zh_CN', null, null, null, '2018-07-31 12:22:53', null);
INSERT INTO `pages` VALUES ('24', '即时数据', 'data', 'NewsController@data', '19', 'zh_CN', null, null, null, '2018-07-31 12:23:27', null);
INSERT INTO `pages` VALUES ('25', '财经日历', 'calendar', 'NewsController@calendar', '19', 'zh_CN', null, null, null, '2018-07-31 12:23:27', null);
INSERT INTO `pages` VALUES ('26', '学院', 'college', null, '0', 'zh_CN', null, null, null, '2018-07-31 12:23:27', null);
INSERT INTO `pages` VALUES ('27', '新手入门', 'novice', 'CollegeController@novice', '26', 'zh_CN', null, null, null, '2018-07-31 12:23:48', null);
INSERT INTO `pages` VALUES ('28', '实战技巧', 'skill', 'CollegeController@skill', '26', 'zh_CN', null, null, null, '2018-07-31 12:23:48', null);
INSERT INTO `pages` VALUES ('29', '名师指路', 'teacher', 'CollegeController@teacher', '26', 'zh_CN', null, null, null, '2018-07-31 12:23:48', null);
INSERT INTO `pages` VALUES ('30', '黄金法则', 'rule', 'CollegeController@rule', '26', 'zh_CN', null, null, null, '2018-07-31 12:24:02', null);
INSERT INTO `pages` VALUES ('31', '外汇投资', 'investment', 'CollegeController@investment', '26', 'zh_CN', null, null, null, '2018-07-31 12:24:03', null);
INSERT INTO `pages` VALUES ('32', '投资百科', 'wiki', 'CollegeController@wiki', '26', 'zh_CN', null, null, null, '2018-07-31 12:24:18', null);

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `POST_ID` int(11) NOT NULL AUTO_INCREMENT,
  `POST_TRANSLATE_ID` int(11) DEFAULT '0' COMMENT '翻译的文章ID',
  `POST_CATEGORY_ID` int(11) DEFAULT NULL COMMENT '文章所属栏目',
  `POST_TITLE` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COMMENT='存放文章信息\r\n状态\r\n0：草稿\r\n1：等待发布\r\n2：发布\r\n3：删除';

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES ('31', '0', '3', '3123', '&lt;p&gt;123123&lt;/p&gt;', 'zh_CN', '0', '0', null, '0', '', '', '', '2018-07-22 18:42:36', '2018-07-22 18:42:36', null, null);
INSERT INTO `posts` VALUES ('32', '0', '3', '3123', '&lt;p&gt;123123&lt;/p&gt;', 'zh_CN', '0', '0', null, '0', '', '', '', '2018-07-22 18:42:37', '2018-07-22 18:42:37', null, null);
INSERT INTO `posts` VALUES ('33', '0', '3', '123', '&lt;p&gt;213123123&lt;/p&gt;', 'zh_HK', '0', '2', null, '0', '', '', '', '2018-07-22 18:43:34', '2018-07-22 18:43:34', null, null);
INSERT INTO `posts` VALUES ('35', '0', '3', '123', '&lt;p&gt;1313&lt;/p&gt;', 'zh_CN', '0', '0', null, '0', '', '', '', '2018-07-22 23:06:06', '2018-07-22 23:06:06', null, null);
INSERT INTO `posts` VALUES ('36', '0', '3', '123', '&lt;p&gt;1313&lt;/p&gt;', 'zh_CN', '0', '2', null, '0', '', '', '', '2018-07-22 23:06:43', '2018-07-22 23:06:43', null, null);
INSERT INTO `posts` VALUES ('37', '0', '3', '123', '&lt;p&gt;1313&lt;/p&gt;', 'zh_CN', '0', '2', null, '0', '', '', '', '2018-07-22 23:06:47', '2018-07-22 23:06:47', null, null);
INSERT INTO `posts` VALUES ('38', '0', '3', '123', '&lt;p&gt;1313&lt;/p&gt;', 'zh_CN', '0', '2', null, '0', '', '', '', '2018-07-22 23:06:51', '2018-07-22 23:06:51', null, null);
INSERT INTO `posts` VALUES ('39', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:48', '2018-07-23 10:27:48', null, null);
INSERT INTO `posts` VALUES ('40', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:49', '2018-07-23 10:27:49', null, null);
INSERT INTO `posts` VALUES ('41', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:49', '2018-07-23 10:27:49', null, null);
INSERT INTO `posts` VALUES ('42', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:50', '2018-07-23 10:27:50', null, null);
INSERT INTO `posts` VALUES ('43', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:50', '2018-07-23 10:27:50', null, null);
INSERT INTO `posts` VALUES ('44', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:50', '2018-07-23 10:27:50', null, null);
INSERT INTO `posts` VALUES ('45', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:50', '2018-07-23 10:27:50', null, null);
INSERT INTO `posts` VALUES ('46', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:51', '2018-07-23 10:27:51', null, null);
INSERT INTO `posts` VALUES ('47', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:51', '2018-07-23 10:27:51', null, null);
INSERT INTO `posts` VALUES ('48', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:51', '2018-07-23 10:27:51', null, null);
INSERT INTO `posts` VALUES ('49', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:52', '2018-07-23 10:27:52', null, null);
INSERT INTO `posts` VALUES ('50', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:52', '2018-07-23 10:27:52', null, null);
INSERT INTO `posts` VALUES ('51', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:52', '2018-07-23 10:27:52', null, null);
INSERT INTO `posts` VALUES ('52', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:52', '2018-07-23 10:27:52', null, null);
INSERT INTO `posts` VALUES ('53', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:52', '2018-07-23 10:27:52', null, null);
INSERT INTO `posts` VALUES ('54', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:53', '2018-07-23 10:27:53', null, null);
INSERT INTO `posts` VALUES ('55', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:53', '2018-07-23 10:27:53', null, null);
INSERT INTO `posts` VALUES ('56', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:53', '2018-07-23 10:27:53', null, null);
INSERT INTO `posts` VALUES ('57', '0', '3', '13', '&lt;p&gt;1231&lt;/p&gt;', 'zh_CN', '1', '0', null, '0', '', '', '', '2018-07-23 10:27:53', '2018-07-23 10:27:53', null, null);
INSERT INTO `posts` VALUES ('68', '0', '3', 'asdasd', '&lt;p&gt;asdsad1313&lt;/p&gt;', 'zh_CN', '1', '3', '0', '0', '13', '131', '31', '2018-07-24 18:00:21', '2018-07-24 18:00:21', '2018-07-30 15:55:42', '2018-07-30 15:59:39');
INSERT INTO `posts` VALUES ('69', '0', '3', 'asdasd', '&lt;p&gt;asdsad&lt;/p&gt;', 'zh_CN', '1', '2', '2', '0', '', '', '', '2018-07-24 18:00:42', '2018-07-24 18:00:42', '2018-07-28 19:10:22', '2018-07-28 19:10:32');
INSERT INTO `posts` VALUES ('70', '0', '3', '24', '&lt;p&gt;fsdsdf&lt;/p&gt;', 'zh_CN', '1', '0', '0', '0', 'fsdf', 'fsdf', 'sf', '2018-07-30 16:00:55', '2018-07-30 16:00:55', '2018-07-30 16:19:10', null);

-- ----------------------------
-- Table structure for posts_tags_relation
-- ----------------------------
DROP TABLE IF EXISTS `posts_tags_relation`;
CREATE TABLE `posts_tags_relation` (
  `ROW_ID` int(11) NOT NULL AUTO_INCREMENT,
  `POST_ID` int(11) DEFAULT NULL COMMENT '文章id',
  `TAG_ID` int(11) DEFAULT NULL COMMENT '标签id',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ROW_ID`),
  KEY `POST_ID` (`POST_ID`) USING BTREE,
  KEY `TAG_ID` (`TAG_ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='保存文章和标签的对应关系';

-- ----------------------------
-- Records of posts_tags_relation
-- ----------------------------
INSERT INTO `posts_tags_relation` VALUES ('1', '65', null, '2018-07-24 18:03:08');
INSERT INTO `posts_tags_relation` VALUES ('2', '65', null, '2018-07-24 18:03:08');
INSERT INTO `posts_tags_relation` VALUES ('3', '66', null, '2018-07-24 18:03:08');
INSERT INTO `posts_tags_relation` VALUES ('4', '66', null, '2018-07-24 18:03:08');
INSERT INTO `posts_tags_relation` VALUES ('5', '67', null, '2018-07-24 18:03:08');
INSERT INTO `posts_tags_relation` VALUES ('6', '67', null, '2018-07-24 18:03:08');
INSERT INTO `posts_tags_relation` VALUES ('11', '68', '0', '2018-07-30 15:55:42');
INSERT INTO `posts_tags_relation` VALUES ('12', '70', '98', '2018-07-30 16:05:17');

-- ----------------------------
-- Table structure for tags
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `TAG_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TAG_NAME` varchar(30) DEFAULT NULL COMMENT '标签名称',
  `TAG_SLUG` varchar(30) DEFAULT NULL COMMENT '标签别名',
  `TAG_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT '标签描述',
  `SEO_TITLE` varchar(50) DEFAULT NULL COMMENT 'seo标题',
  `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
  `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
  `CRAETED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`TAG_ID`),
  KEY `TAG_NAME` (`TAG_NAME`) USING BTREE,
  KEY `TAG_SLUG` (`TAG_SLUG`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COMMENT='存放文章标签信息';

-- ----------------------------
-- Records of tags
-- ----------------------------
INSERT INTO `tags` VALUES ('75', '242444', 'sdfsdf', '23424226565', '边个', '现货黄金，操作建议', '现货黄金市场2018年7月23日14点收盘于1230.9美元/盎司，金价在早间冲击重压1235美元/盎司一线后回撤，目前维持与1230-1233区间窄幅震荡。现货黄金在短期内可能面临小幅调整，在调整过后依然有机会继续上涨。后市关注1225-1230区间能否成为上涨后的回踩支点，为后市', '2018-07-22 01:10:52', null);
INSERT INTO `tags` VALUES ('78', '112', null, '', '', '', '', '2018-07-22 18:52:52', null);
INSERT INTO `tags` VALUES ('79', '123', null, '13', '131', '31', '313', '2018-07-22 19:06:20', null);
INSERT INTO `tags` VALUES ('80', '1', null, '', '', '', '', '2018-07-24 16:27:26', null);
INSERT INTO `tags` VALUES ('81', '23432242', '424', '2424', '24', '24', '424', '2018-07-24 17:09:39', null);
INSERT INTO `tags` VALUES ('82', '1313', '1313', '', '', '', '', '2018-07-24 17:24:25', null);
INSERT INTO `tags` VALUES ('83', '13123', '13123', '', '', '', '', '2018-07-24 17:56:36', null);
INSERT INTO `tags` VALUES ('84', '1312344', '1312344', '', '', '', '', '2018-07-24 17:56:37', null);
INSERT INTO `tags` VALUES ('85', 'asdsad', 'asdsad', '', '', '', '', '2018-07-24 17:56:58', null);
INSERT INTO `tags` VALUES ('86', 'asdsadasd', 'asdsadasd', '', '', '', '', '2018-07-24 17:57:03', null);
INSERT INTO `tags` VALUES ('87', 'asds', 'asds', '', '', '', '', '2018-07-24 17:58:10', null);
INSERT INTO `tags` VALUES ('88', 'asdsd', 'asdsd', '', '', '', '', '2018-07-24 17:58:11', null);
INSERT INTO `tags` VALUES ('89', '1234', '1234', '', '', '', '', '2018-07-24 23:27:51', null);
INSERT INTO `tags` VALUES ('90', '12346', '12346', '', '', '', '', '2018-07-24 23:36:46', null);
INSERT INTO `tags` VALUES ('91', '12347', '12347', '', '', '', '', '2018-07-24 23:36:57', null);
INSERT INTO `tags` VALUES ('92', '123476', '123476', '', '', '', '', '2018-07-24 23:37:21', null);
INSERT INTO `tags` VALUES ('93', '12345679', '12345679', '', '', '', '', '2018-07-24 23:38:02', null);
INSERT INTO `tags` VALUES ('94', '66666', '66666', '', '', '', '', '2018-07-24 23:50:47', null);
INSERT INTO `tags` VALUES ('95', '123444', '123444', '', '', '', '', '2018-07-24 23:53:45', null);
INSERT INTO `tags` VALUES ('96', '12313123', '12313123', '', '', '', '', '2018-07-24 23:54:15', null);
INSERT INTO `tags` VALUES ('97', '456546456', '456546456', '', '', '', '', '2018-07-24 23:54:24', null);
INSERT INTO `tags` VALUES ('98', '1231', '1231', null, null, null, null, '2018-07-30 16:05:15', null);
INSERT INTO `tags` VALUES ('99', '123144', '1231', '3131', '1', '2131', '31', '2018-07-30 16:19:33', null);
INSERT INTO `tags` VALUES ('100', '345', '435', '', '', '', '', '2018-07-30 16:23:19', null);
