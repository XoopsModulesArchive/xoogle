# phpMyAdmin SQL Dump
# version 2.5.6-rc1
# http://www.phpmyadmin.net
#
# Generation Time: Mar 21, 2004 at 07:39 PM
# Server version: 4.0.18
# PHP Version: 4.2.3
# 

# --------------------------------------------------------

#
# Table structure for table `xoogle_config`
#

CREATE TABLE `xoogle_config` (
    `xoogleid`    INT(11) NOT NULL AUTO_INCREMENT,
    `google_key`  VARCHAR(255) DEFAULT NULL,
    `google_lr`   VARCHAR(255) DEFAULT NULL,
    `lrinblock`   VARCHAR(255) DEFAULT NULL,
    `xoopsactive` VARCHAR(255) DEFAULT NULL,
    `sldefault`   VARCHAR(255) DEFAULT NULL,
    `siteactive`  VARCHAR(255) DEFAULT NULL,
    `webactive`   VARCHAR(255) DEFAULT NULL,
    `slinblock`   VARCHAR(255) DEFAULT NULL,
    `sitelabel`   VARCHAR(255) DEFAULT NULL,
    `weblabel`    VARCHAR(255) DEFAULT NULL,
    `xoopslabel`  VARCHAR(255) DEFAULT NULL,
    UNIQUE KEY `xoogleid` (`xoogleid`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 2;

#
# Dumping data for table `xoogle_config`
#

INSERT INTO `xoogle_config`
VALUES (1, '000000000000000000000000', 'show_form', '1', '1', 'web', '1', '1', '1', 'this site (google)', 'the web (google)', 'this site (xoops)');
