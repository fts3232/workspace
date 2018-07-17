/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-07-17 18:17:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for menu_item
-- ----------------------------
DROP TABLE IF EXISTS `menu_item`;
CREATE TABLE `menu_item` (
  `ITEM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ITEM_NAME` varchar(255) DEFAULT NULL COMMENT '菜单项名字',
  `URL` varchar(255) DEFAULT NULL COMMENT '菜单项url',
  `PARENT_ID` int(11) DEFAULT NULL COMMENT '所属父类id',
  `CREATE_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `UPDATE_TIME` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`ITEM_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='菜单项表';
