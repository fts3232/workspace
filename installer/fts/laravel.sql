/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-07-19 23:57:15
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='存放banner信息';

-- ----------------------------
-- Records of banner
-- ----------------------------
INSERT INTO `banner` VALUES ('2', '12313', '2018-07-19 14:36:14', '2018-07-19 16:44:03');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='banner 项表';

-- ----------------------------
-- Records of banner_item
-- ----------------------------
INSERT INTO `banner_item` VALUES ('1', '2', '/Public/images/weixin.png', '1', '0', '2018-07-19 15:21:15', null);
INSERT INTO `banner_item` VALUES ('2', '2', '/Public/images/weixin.png', '2', '1', '2018-07-19 15:21:15', null);
INSERT INTO `banner_item` VALUES ('3', '2', '/Public/images/weixin.png', '3', '3', '2018-07-19 15:21:15', '2018-07-19 16:20:09');
INSERT INTO `banner_item` VALUES ('6', '2', '/Public/images/weixin.png', '6', '5', '2018-07-19 15:21:15', '2018-07-19 16:40:03');
INSERT INTO `banner_item` VALUES ('7', '2', '/Uploads/cms_banner/2018-07-19/5b5049648d5ac.png', '', '2', '2018-07-19 16:18:48', '2018-07-19 16:20:09');
INSERT INTO `banner_item` VALUES ('8', '2', '/Uploads/cms_banner/2018-07-19/5b50496650198.png', '', '4', '2018-07-19 16:18:48', '2018-07-19 16:20:55');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(50) DEFAULT NULL COMMENT '栏目名称',
  `CATEGORY_PARENT` int(11) DEFAULT NULL COMMENT '栏目父类',
  `CATEGORY_ORDER` tinyint(3) DEFAULT NULL,
  `CRAETED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`CATEGORY_ID`),
  KEY `CATEGORY_NAME` (`CATEGORY_NAME`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '黄金', '0', '1', '2018-07-19 17:03:20', '2018-07-19 17:52:24');
INSERT INTO `category` VALUES ('2', '黄金112312', '7', '1', '2018-07-19 17:03:20', '2018-07-19 17:52:24');
INSERT INTO `category` VALUES ('3', '黄金2', '0', '0', '2018-07-19 17:03:20', '2018-07-19 17:52:24');
INSERT INTO `category` VALUES ('4', '黄金3', '3', '0', '2018-07-19 17:03:20', '2018-07-19 17:52:24');
INSERT INTO `category` VALUES ('7', '23424', '0', '2', '2018-07-19 17:51:39', '2018-07-19 17:52:24');
INSERT INTO `category` VALUES ('8', 'rtre', '7', '0', '2018-07-19 17:51:59', '2018-07-19 17:52:24');

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
INSERT INTO `menu` VALUES ('18', 'sa', '2018-07-19 16:59:23', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='菜单项表';

-- ----------------------------
-- Records of menu_item
-- ----------------------------
INSERT INTO `menu_item` VALUES ('18', '1', '2342', '23424', '0', '0', '2018-07-18 18:13:02', null);
INSERT INTO `menu_item` VALUES ('20', '1', '11', '123', '0', '1', '2018-07-19 12:21:58', null);
INSERT INTO `menu_item` VALUES ('21', '1', '11', '123', '20', '0', '2018-07-19 12:21:58', '2018-07-19 16:44:25');
INSERT INTO `menu_item` VALUES ('22', '1', '11', '123', '0', '2', '2018-07-19 12:21:58', '2018-07-19 16:44:25');
INSERT INTO `menu_item` VALUES ('23', '1', '11', '123', '22', '0', '2018-07-19 12:21:58', null);
INSERT INTO `menu_item` VALUES ('24', '1', '11', '123', '0', '3', '2018-07-19 12:21:58', '2018-07-19 16:44:25');
INSERT INTO `menu_item` VALUES ('25', '1', '11', '123', '0', '4', '2018-07-19 12:21:58', '2018-07-19 16:44:25');
INSERT INTO `menu_item` VALUES ('26', '1', '11', '123', '0', '5', '2018-07-19 12:21:58', '2018-07-19 16:44:25');

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `POST_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TRANSLATE_ID` int(11) DEFAULT NULL,
  `TITLE` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `CATEGORY_ID` int(11) DEFAULT NULL,
  `CONTENT` text CHARACTER SET latin1,
  `KEYWORD` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `DESCRIPTION` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `AUTHOR` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `LANG` varchar(255) DEFAULT NULL,
  `CREATED_TIME` datetime DEFAULT NULL,
  `PUBLISHED_TIME` datetime DEFAULT NULL,
  `MODIFIED_TIME` datetime DEFAULT NULL,
  PRIMARY KEY (`POST_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES ('2', null, '31', '3', '', '1231', '', null, null, null, null, null);
INSERT INTO `posts` VALUES ('3', '0', '123', '3', '', '131', '313', null, 'zh_CN', null, null, null);
INSERT INTO `posts` VALUES ('4', '0', '123', '7', '&lt;p&gt;1313&lt;/p&gt;', '131', '313', null, 'zh_CN', null, null, null);
