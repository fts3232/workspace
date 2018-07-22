/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-07-22 23:14:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for banner
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `BANNER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BANNER_NAME` varchar(50) DEFAULT NULL COMMENT 'banner名称',
  `CREATED_TIEM` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`BANNER_ID`),
  KEY `BANNER_NAME` (`BANNER_NAME`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='存放banner信息';

-- ----------------------------
-- Records of banner
-- ----------------------------
INSERT INTO `banner` VALUES ('6', '12312', '2018-07-20 16:06:12', null);
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

-- ----------------------------
-- Table structure for banner_item
-- ----------------------------
DROP TABLE IF EXISTS `banner_item`;
CREATE TABLE `banner_item` (
  `ITEM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BANNER_ID` int(11) DEFAULT NULL COMMENT '所属banner id',
  `ITEM_IMG` varchar(255) DEFAULT NULL COMMENT 'banner 项图片',
  `ITEM_URL` varchar(255) DEFAULT NULL COMMENT 'banner 项url',
  `ITEM_ORDER` tinyint(3) DEFAULT NULL COMMENT '图片排序',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`ITEM_ID`),
  KEY `BANNER_ID` (`BANNER_ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='保存banner图片项信息';

-- ----------------------------
-- Records of banner_item
-- ----------------------------
INSERT INTO `banner_item` VALUES ('2', '6', '/Uploads/cms_banner/2018-07-22/5b547c1988fa2.jpg', '234234', '0', '2018-07-22 20:44:34', '2018-07-22 20:44:45');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(50) DEFAULT NULL COMMENT '栏目名称',
  `CATEGORY_SLUG` varchar(50) DEFAULT NULL COMMENT '栏目别名',
  `CATEGORY_PARENT` int(11) DEFAULT NULL COMMENT '栏目父类',
  `CATEGORY_ORDER` tinyint(3) DEFAULT NULL COMMENT '栏目排序',
  `CATEGORY_DESCRIPTION` varchar(255) DEFAULT NULL COMMENT '栏目描述',
  `SEO_TITLE` varchar(255) DEFAULT NULL COMMENT 'seo标题',
  `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
  `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
  `CRAETED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`CATEGORY_ID`),
  KEY `CATEGORY_NAME` (`CATEGORY_NAME`),
  KEY `CATEGORY_SLUG` (`CATEGORY_SLUG`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='文章栏目信息';

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '黄金', 'null', '0', '1', 'null', 'null', 'null', 'null', '2018-07-19 17:03:20', '2018-07-22 21:32:31');
INSERT INTO `category` VALUES ('2', '黄金112312', 'null', '7', '1', 'null', 'null', 'null', 'null', '2018-07-19 17:03:20', '2018-07-22 21:32:31');
INSERT INTO `category` VALUES ('3', '黄金2', 'hj', '0', '0', 'null', 'null', 'null', 'null', '2018-07-19 17:03:20', '2018-07-22 21:32:31');
INSERT INTO `category` VALUES ('4', '黄金3', 'null', '3', '0', 'null', 'null', 'null', 'null', '2018-07-19 17:03:20', '2018-07-22 21:32:31');
INSERT INTO `category` VALUES ('7', '23424', 'null', '0', '2', 'null', 'null', 'null', 'null', '2018-07-19 17:51:39', '2018-07-22 21:32:31');
INSERT INTO `category` VALUES ('8', 'rtre', 'null', '7', '0', 'null', 'null', 'null', 'null', '2018-07-19 17:51:59', '2018-07-22 21:32:31');
INSERT INTO `category` VALUES ('9', '123', 'null', '0', '3', '1231t', '31t', '313t', '1231t', '2018-07-22 00:50:10', '2018-07-22 21:32:31');
INSERT INTO `category` VALUES ('11', '123', 'null', '0', '4', '313', '131', '31', '313', '2018-07-22 21:30:26', '2018-07-22 21:32:31');
INSERT INTO `category` VALUES ('12', '1232', '123213', '0', '5', '131', '3213', '131', '131', '2018-07-22 21:30:50', '2018-07-22 21:32:31');

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `MENU_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_NAME` varchar(50) DEFAULT NULL COMMENT '菜单名',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL,
  PRIMARY KEY (`MENU_ID`),
  KEY `NAME` (`MENU_NAME`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='保存菜单信息';

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', 'test', '2018-07-18 15:36:55', null);
INSERT INTO `menu` VALUES ('18', 'sa12', '2018-07-19 16:59:23', '2018-07-20 15:05:23');

-- ----------------------------
-- Table structure for menu_item
-- ----------------------------
DROP TABLE IF EXISTS `menu_item`;
CREATE TABLE `menu_item` (
  `ITEM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_ID` int(11) DEFAULT NULL COMMENT '所属菜单id',
  `ITEM_NAME` varchar(50) DEFAULT NULL COMMENT '菜单项名字',
  `ITEM_URL` varchar(255) DEFAULT NULL COMMENT '菜单项url',
  `ITEM_PARENT` int(11) DEFAULT NULL COMMENT '所属父类id',
  `ITEM_ORDER` tinyint(3) DEFAULT NULL COMMENT '排序',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`ITEM_ID`),
  KEY `MENU_ID` (`MENU_ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='保存菜单项信息';

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

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `POST_ID` int(11) NOT NULL AUTO_INCREMENT,
  `POST_TRANSLATE_ID` int(11) DEFAULT '0' COMMENT '翻译的文章ID',
  `POST_CATEGORY_ID` int(11) DEFAULT NULL COMMENT '文章所属栏目',
  `POST_TITLE` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `POST_CONTENT` text COMMENT '文章正文',
  `POST_LANG` varchar(10) DEFAULT NULL COMMENT '文章语言',
  `POST_AUTHOR_ID` int(11) DEFAULT NULL COMMENT '作者用户ID',
  `POST_TAGS_ID` varchar(255) DEFAULT NULL COMMENT '文章标签',
  `POST_STATUS` tinyint(3) DEFAULT NULL COMMENT '文章状态 0:草稿 1:等待发布 2:发布',
  `SEO_TITLE` varchar(255) DEFAULT NULL COMMENT 'seo标题',
  `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
  `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `PUBLISHED_TIME` datetime DEFAULT NULL COMMENT '发布时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`POST_ID`),
  KEY `POST_TRANSLATE_ID` (`POST_TRANSLATE_ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='存放文章信息';

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES ('31', '0', '3', '3123', '&lt;p&gt;123123&lt;/p&gt;', 'zh_CN', '0', null, '0', '', '', '', '2018-07-22 18:42:36', '2018-07-22 18:42:36', null);
INSERT INTO `posts` VALUES ('32', '0', '3', '3123', '&lt;p&gt;123123&lt;/p&gt;', 'zh_CN', '0', null, '0', '', '', '', '2018-07-22 18:42:37', '2018-07-22 18:42:37', null);
INSERT INTO `posts` VALUES ('33', '0', '3', '123', '&lt;p&gt;213123123&lt;/p&gt;', 'zh_HK', '0', null, '0', '', '', '', '2018-07-22 18:43:34', '2018-07-22 18:43:34', null);
INSERT INTO `posts` VALUES ('35', '0', '3', '123', '&lt;p&gt;1313&lt;/p&gt;', 'zh_CN', '0', null, '0', '', '', '', '2018-07-22 23:06:06', '2018-07-22 23:06:06', null);
INSERT INTO `posts` VALUES ('36', '0', '3', '123', '&lt;p&gt;1313&lt;/p&gt;', 'zh_CN', '0', null, '0', '', '', '', '2018-07-22 23:06:43', '2018-07-22 23:06:43', null);
INSERT INTO `posts` VALUES ('37', '0', '3', '123', '&lt;p&gt;1313&lt;/p&gt;', 'zh_CN', '0', null, '0', '', '', '', '2018-07-22 23:06:47', '2018-07-22 23:06:47', null);
INSERT INTO `posts` VALUES ('38', '0', '3', '123', '&lt;p&gt;1313&lt;/p&gt;', 'zh_CN', '0', null, '2', '', '', '', '2018-07-22 23:06:51', '2018-07-22 23:06:51', null);

-- ----------------------------
-- Table structure for tags
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `TAG_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TAG_NAME` varchar(255) DEFAULT NULL COMMENT '标签名称',
  `TAG_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT '标签描述',
  `SEO_TITLE` varchar(255) DEFAULT NULL COMMENT 'seo标题',
  `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
  `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
  `CRAETED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`TAG_ID`),
  KEY `TAG_NAME` (`TAG_NAME`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COMMENT='存放文章标签信息';

-- ----------------------------
-- Records of tags
-- ----------------------------
INSERT INTO `tags` VALUES ('75', '242', '23424226565', '432', '424', '2424', '2018-07-22 01:10:52', null);
INSERT INTO `tags` VALUES ('76', '12321', '', '', '', '', '2018-07-22 18:51:34', null);
INSERT INTO `tags` VALUES ('77', '11', '', '', '', '', '2018-07-22 18:52:51', null);
INSERT INTO `tags` VALUES ('78', '112', '', '', '', '', '2018-07-22 18:52:52', null);
INSERT INTO `tags` VALUES ('79', '123', '13', '131', '31', '313', '2018-07-22 19:06:20', null);
