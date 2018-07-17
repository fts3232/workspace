/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-07-17 18:17:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `MENU_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_NAME` varchar(255) DEFAULT NULL COMMENT '菜单名',
  `CREATED_TIME` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`MENU_ID`),
  KEY `NAME` (`MENU_NAME`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='菜单表';
