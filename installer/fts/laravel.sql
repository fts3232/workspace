/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-07-20 18:13:13
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='存放banner信息';

-- ----------------------------
-- Records of banner
-- ----------------------------
INSERT INTO `banner` VALUES ('3', '12345', '2018-07-20 16:06:10', '2018-07-20 18:02:32');
INSERT INTO `banner` VALUES ('4', '12312', '2018-07-20 16:06:11', null);
INSERT INTO `banner` VALUES ('5', '12312', '2018-07-20 16:06:11', null);
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

-- ----------------------------
-- Table structure for banner_item
-- ----------------------------
DROP TABLE IF EXISTS `banner_item`;
CREATE TABLE `banner_item` (
  `ITEM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BANNER_ID` int(11) DEFAULT NULL COMMENT '所属banner id',
  `ITEM_IMG` varchar(255) DEFAULT NULL COMMENT 'banner 项图片',
  `ITEM_URL` varchar(255) DEFAULT NULL COMMENT 'banner 项url',
  `ITEM_ORDER` tinyint(3) DEFAULT NULL,
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`ITEM_ID`),
  KEY `BANNER_ID` (`BANNER_ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='banner 项表';

-- ----------------------------
-- Records of banner_item
-- ----------------------------

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(50) DEFAULT NULL COMMENT '栏目名称',
  `CATEGORY_PARENT` int(11) DEFAULT NULL COMMENT '栏目父类',
  `CATEGORY_ORDER` tinyint(3) DEFAULT NULL,
  `CATEGORY_DESCRIPTION` varchar(255) DEFAULT NULL,
  `SEO_TITLE` varchar(255) DEFAULT NULL,
  `SEO_KEYWORD` varchar(255) DEFAULT NULL,
  `SEO_DESCRIPTION` varchar(255) DEFAULT NULL,
  `CRAETED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`CATEGORY_ID`),
  KEY `CATEGORY_NAME` (`CATEGORY_NAME`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '黄金', '0', '1', null, null, null, null, '2018-07-19 17:03:20', '2018-07-19 17:52:24');
INSERT INTO `category` VALUES ('2', '黄金112312', '7', '1', null, null, null, null, '2018-07-19 17:03:20', '2018-07-19 17:52:24');
INSERT INTO `category` VALUES ('3', '黄金2', '0', '0', null, null, null, null, '2018-07-19 17:03:20', '2018-07-19 17:52:24');
INSERT INTO `category` VALUES ('4', '黄金3', '3', '0', null, null, null, null, '2018-07-19 17:03:20', '2018-07-19 17:52:24');
INSERT INTO `category` VALUES ('7', '23424', '0', '2', null, null, null, null, '2018-07-19 17:51:39', '2018-07-19 17:52:24');
INSERT INTO `category` VALUES ('8', 'rtre', '7', '0', null, null, null, null, '2018-07-19 17:51:59', '2018-07-19 17:52:24');

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='菜单表';

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
  `MENU_ID` int(11) NOT NULL COMMENT '所属菜单id',
  `ITEM_NAME` varchar(50) DEFAULT NULL COMMENT '菜单项名字',
  `ITEM_URL` varchar(255) DEFAULT NULL COMMENT '菜单项url',
  `ITEM_PARENT` int(11) DEFAULT NULL COMMENT '所属父类id',
  `ITEM_ORDER` tinyint(3) DEFAULT NULL COMMENT '排序',
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`ITEM_ID`),
  KEY `MENU_ID` (`MENU_ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='菜单项表';

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

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `POST_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TRANSLATE_ID` int(11) DEFAULT '0',
  `TITLE` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `CATEGORY_ID` int(11) DEFAULT NULL,
  `CONTENT` text CHARACTER SET latin1,
  `SEO_TITLE` varchar(255) DEFAULT NULL,
  `SEO_KEYWORD` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `SEO_DESCRIPTION` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `AUTHOR` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `LANG` varchar(255) DEFAULT NULL,
  `POST_STATUS` tinyint(3) DEFAULT NULL COMMENT '文章状态 0:草稿 1:等待发布 2:发布',
  `TAGS_ID` varchar(255) DEFAULT NULL,
  `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP,
  `PUBLISHED_TIME` datetime DEFAULT NULL,
  `MODIFIED_TIME` datetime DEFAULT NULL,
  PRIMARY KEY (`POST_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES ('2', null, '31', '3', '', null, '1231', '', null, null, null, null, null, null, null);
INSERT INTO `posts` VALUES ('3', '0', '123', '3', '', null, '131', '313', null, 'zh_CN', null, null, null, null, null);
INSERT INTO `posts` VALUES ('4', '0', '123', '7', '&lt;p&gt;1313&lt;/p&gt;', null, '131', '313', null, 'zh_CN', null, null, null, null, null);
INSERT INTO `posts` VALUES ('5', '0', '31', '1', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n&lt;/head&gt;\n&lt;body&gt;\n&lt;p&gt;asds&lt;/p&gt;\n&lt;/body&gt;\n&lt;/html&gt;', null, '1231', '', null, 'zh_CN', null, null, null, null, null);
INSERT INTO `posts` VALUES ('6', '0', '31', '3', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n&lt;/head&gt;\n&lt;body&gt;\n&lt;p&gt;sdfsf&lt;/p&gt;\n&lt;/body&gt;\n&lt;/html&gt;', null, '1231', '', null, 'zh_CN', null, null, null, null, null);
INSERT INTO `posts` VALUES ('7', null, 'ada', '1', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n&lt;/head&gt;\n&lt;body&gt;\n&lt;p&gt;dadad&lt;/p&gt;\n&lt;/body&gt;\n&lt;/html&gt;', null, 'sdasd', 'ada', '1', '', null, null, null, '2018-07-20 10:43:46', null);
INSERT INTO `posts` VALUES ('8', null, 'ada', '1', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n&lt;/head&gt;\n&lt;body&gt;\n&lt;p&gt;dadad&lt;/p&gt;\n&lt;/body&gt;\n&lt;/html&gt;', null, 'sdasd', 'ada', '1', '', '0', null, null, '2018-07-20 10:45:02', null);
INSERT INTO `posts` VALUES ('9', null, '424', '3', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n&lt;/head&gt;\n&lt;body&gt;\n&lt;p&gt;24&lt;/p&gt;\n&lt;/body&gt;\n&lt;/html&gt;', null, '242', '2343', '1', 'zh_CN', '0', null, null, '2018-07-20 10:45:11', null);
INSERT INTO `posts` VALUES ('10', null, '424', '3', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n&lt;/head&gt;\n&lt;body&gt;\n&lt;p&gt;24&lt;/p&gt;\n&lt;/body&gt;\n&lt;/html&gt;', null, '242', '2343', '1', 'zh_CN', '0', null, '2018-07-20 10:45:52', '2018-07-20 10:45:52', null);
INSERT INTO `posts` VALUES ('11', null, '424', '3', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n&lt;/head&gt;\n&lt;body&gt;\n&lt;p&gt;24&lt;/p&gt;\n&lt;/body&gt;\n&lt;/html&gt;', null, '242', '2343', '1', 'zh_CN', '0', null, '2018-07-20 10:46:02', '2018-07-20 10:46:02', null);
INSERT INTO `posts` VALUES ('12', null, '424', '3', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n&lt;/head&gt;\n&lt;body&gt;\n&lt;p&gt;24&lt;/p&gt;\n&lt;/body&gt;\n&lt;/html&gt;', null, '242', '2343', '1', 'zh_CN', '0', null, '2018-07-20 10:46:12', '2018-07-20 10:46:12', null);
INSERT INTO `posts` VALUES ('13', null, '313', '3', '&lt;p&gt;234324&lt;/p&gt;', null, '131', '213', '1', 'zh_CN', '0', null, '2018-07-20 10:46:59', '2018-07-20 10:46:59', null);
INSERT INTO `posts` VALUES ('14', null, '12313', '3', '&lt;p&gt;13&lt;/p&gt;', null, '131', '31', '1', 'zh_CN', '0', null, '2018-07-20 10:47:15', '2018-07-20 10:47:15', null);
INSERT INTO `posts` VALUES ('15', null, '313', '3', '&lt;p&gt;313&lt;/p&gt;', null, '21', '131', '1', 'zh_CN', '0', null, '2018-07-20 10:48:50', '2018-07-20 09:48:00', null);
INSERT INTO `posts` VALUES ('16', null, '234', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_CN', '0', null, '2018-07-20 10:52:23', '2018-07-20 10:52:23', null);
INSERT INTO `posts` VALUES ('17', null, '234', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_CN', '0', null, '2018-07-20 10:52:24', '2018-07-20 10:52:24', null);
INSERT INTO `posts` VALUES ('18', null, '234', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_CN', '0', null, '2018-07-20 10:52:24', '2018-07-20 10:52:24', null);
INSERT INTO `posts` VALUES ('19', null, '234', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_CN', '0', null, '2018-07-20 10:52:25', '2018-07-20 10:52:25', null);
INSERT INTO `posts` VALUES ('20', null, '234', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_CN', '0', null, '2018-07-20 10:52:25', '2018-07-20 10:52:25', null);
INSERT INTO `posts` VALUES ('21', null, '234', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_CN', '0', null, '2018-07-20 10:52:25', '2018-07-20 10:52:25', null);
INSERT INTO `posts` VALUES ('22', null, '234', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_CN', '0', null, '2018-07-20 10:52:25', '2018-07-20 10:52:25', null);
INSERT INTO `posts` VALUES ('23', null, '234', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_CN', '0', null, '2018-07-20 10:52:26', '2018-07-20 10:52:26', null);
INSERT INTO `posts` VALUES ('24', null, '234', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_CN', '0', null, '2018-07-20 10:52:26', '2018-07-20 10:52:26', null);
INSERT INTO `posts` VALUES ('25', null, '234', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_CN', '0', null, '2018-07-20 10:52:26', '2018-07-20 10:52:26', null);
INSERT INTO `posts` VALUES ('26', null, '234', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_CN', '0', null, '2018-07-20 10:52:26', '2018-07-20 10:52:26', null);
INSERT INTO `posts` VALUES ('27', '28', '234', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_CN', '0', null, '2018-07-20 10:52:26', '2018-07-20 10:52:26', null);
INSERT INTO `posts` VALUES ('28', '31', '英文', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_CN', '0', null, '2018-07-20 10:52:26', '2018-07-20 01:24:00', '2018-07-20 12:24:56');
INSERT INTO `posts` VALUES ('31', '0', '简体中文', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_CN', '0', '70,71,72', '2018-07-20 10:52:27', '2018-07-20 11:49:18', null);
INSERT INTO `posts` VALUES ('32', '31', '繁体中文', '3', '&lt;p&gt;2423423&lt;/p&gt;', null, '24', '24', '1', 'zh_HK', '0', null, '2018-07-20 10:52:27', '2018-07-20 10:52:27', null);
INSERT INTO `posts` VALUES ('35', '0', 'asd', '3', '&lt;p&gt;dsa&lt;/p&gt;', null, 'ada', 'dad', '1', 'zh_CN', '0', null, '2018-07-20 12:31:17', '2018-07-20 12:31:17', null);
INSERT INTO `posts` VALUES ('36', '31', '1231', '3', '&lt;p&gt;1313&lt;/p&gt;', null, '313', '1313', '1', 'zh_CN', '0', null, '2018-07-20 12:32:10', '2018-07-20 12:32:10', null);

-- ----------------------------
-- Table structure for tags
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `TAG_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TAG_NAME` varchar(255) DEFAULT NULL,
  `SEO_TITLE` varchar(255) DEFAULT NULL,
  `SEO_KEYWORD` varchar(255) DEFAULT NULL,
  `SEO_DESCRIPTION` varchar(255) DEFAULT NULL,
  `CRAETED_TIME` datetime DEFAULT CURRENT_TIMESTAMP,
  `MODIFIED_TIME` datetime DEFAULT NULL,
  PRIMARY KEY (`TAG_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tags
-- ----------------------------
INSERT INTO `tags` VALUES ('2', 'sdfs', '123', '131', '3', '2018-07-20 11:16:41', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('3', 'adasd', null, null, null, '2018-07-20 11:16:55', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('4', 'adasd', null, null, null, '2018-07-20 11:16:57', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('5', 'adasd', null, null, null, '2018-07-20 11:16:57', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('6', 'adasd', null, null, null, '2018-07-20 11:16:58', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('7', 'adasd', null, null, null, '2018-07-20 11:16:58', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('8', 'adasd', null, null, null, '2018-07-20 11:16:59', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('9', 'adasd', null, null, null, '2018-07-20 11:17:00', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('10', 'adasd', null, null, null, '2018-07-20 11:17:01', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('11', 'adasd', null, null, null, '2018-07-20 11:17:01', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('12', 'adasd', null, null, null, '2018-07-20 11:17:02', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('13', '23424', null, null, null, '2018-07-20 11:18:10', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('14', '23424234', null, null, null, '2018-07-20 11:18:12', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('15', '23424234', null, null, null, '2018-07-20 11:18:25', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('16', '23424234', null, null, null, '2018-07-20 11:18:25', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('17', '23424234', null, null, null, '2018-07-20 11:18:26', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('18', '23424234', null, null, null, '2018-07-20 11:18:27', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('19', '23424234', null, null, null, '2018-07-20 11:18:27', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('20', '23424234', null, null, null, '2018-07-20 11:18:35', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('21', '234', null, null, null, '2018-07-20 11:20:12', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('22', '234', null, null, null, '2018-07-20 11:20:13', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('23', '234', null, null, null, '2018-07-20 11:20:13', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('24', '234', null, null, null, '2018-07-20 11:20:14', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('25', '234', null, null, null, '2018-07-20 11:20:14', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('26', '234', null, null, null, '2018-07-20 11:20:15', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('27', '234', null, null, null, '2018-07-20 11:20:15', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('28', '234', null, null, null, '2018-07-20 11:20:15', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('29', '234', null, null, null, '2018-07-20 11:20:15', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('30', '234', null, null, null, '2018-07-20 11:20:15', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('31', '234', null, null, null, '2018-07-20 11:20:16', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('32', '2343', null, null, null, '2018-07-20 11:21:13', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('33', '2343', null, null, null, '2018-07-20 11:21:13', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('34', '2343', null, null, null, '2018-07-20 11:21:13', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('35', '2343', null, null, null, '2018-07-20 11:21:13', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('36', '2343', null, null, null, '2018-07-20 11:21:14', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('37', '2343', null, null, null, '2018-07-20 11:21:14', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('38', '2343', null, null, null, '2018-07-20 11:21:14', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('39', '2343', null, null, null, '2018-07-20 11:21:14', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('40', '2343', null, null, null, '2018-07-20 11:21:14', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('41', '2343', null, null, null, '2018-07-20 11:21:15', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('42', '2343', null, null, null, '2018-07-20 11:21:15', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('43', '2343', null, null, null, '2018-07-20 11:21:15', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('44', '2343', null, null, null, '2018-07-20 11:21:16', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('45', 'sadsa', null, null, null, '2018-07-20 11:21:50', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('46', 'sadsa', null, null, null, '2018-07-20 11:21:50', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('47', 'sadsa', null, null, null, '2018-07-20 11:21:51', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('48', 'sadsa', null, null, null, '2018-07-20 11:21:51', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('49', 'sadsa', null, null, null, '2018-07-20 11:21:51', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('50', 'sadsa', null, null, null, '2018-07-20 11:21:52', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('51', 'sadsa', null, null, null, '2018-07-20 11:21:52', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('52', 'sadsa', null, null, null, '2018-07-20 11:21:52', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('53', '2424', null, null, null, '2018-07-20 11:23:56', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('54', '2424', null, null, null, '2018-07-20 11:23:57', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('55', '2424', null, null, null, '2018-07-20 11:23:57', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('56', '2424', null, null, null, '2018-07-20 11:23:57', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('57', '2424', null, null, null, '2018-07-20 11:23:57', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('58', '2424', null, null, null, '2018-07-20 11:23:58', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('59', '2424', null, null, null, '2018-07-20 11:23:58', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('60', '2424', null, null, null, '2018-07-20 11:23:58', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('61', '2424', null, null, null, '2018-07-20 11:23:59', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('62', '2424', null, null, null, '2018-07-20 11:23:59', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('63', '2424', null, null, null, '2018-07-20 11:23:59', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('64', '2424', null, null, null, '2018-07-20 11:23:59', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('65', '2424', null, null, null, '2018-07-20 11:24:00', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('66', '2424', null, null, null, '2018-07-20 11:24:00', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('67', '2424', null, null, null, '2018-07-20 11:24:00', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('68', '2323', null, null, null, '2018-07-20 11:29:36', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('69', '242444', null, null, null, '2018-07-20 11:41:45', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('70', '24', null, null, null, '2018-07-20 11:42:41', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('71', '244', null, null, null, '2018-07-20 11:42:47', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('72', '2445', null, null, null, '2018-07-20 11:42:53', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('73', '2342', null, null, null, '2018-07-20 14:35:06', '2018-07-20 14:45:22');
INSERT INTO `tags` VALUES ('74', '111', null, null, null, '2018-07-20 14:35:18', '2018-07-20 14:45:22');
