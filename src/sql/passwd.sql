CREATE TABLE `passwd` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `group` varchar(32) NOT NULL DEFAULT '' COMMENT '分类',
    `title` varchar(32) NOT NULL DEFAULT '' COMMENT '标题',
    `loginName` varchar(32) NOT NULL DEFAULT '' COMMENT '登录名',
    `passwd` varchar(1024) NOT NULL DEFAULT '' COMMENT '密码',
    `key` varchar(32) NOT NULL DEFAULT '' COMMENT '密钥',
    `url` varchar(128) NOT NULL DEFAULT '' COMMENT '网址',
    `content` varchar(1024) NOT NULL DEFAULT '' COMMENT '备注',
    `creationTime` datetime NOT NULL default current_timestamp,
    `updateTime` datetime NOT NULL default current_timestamp,
    PRIMARY KEY (`id`),
    KEY IDX_TITLE (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT "密码";

