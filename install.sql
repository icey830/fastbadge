BEGIN;
CREATE TABLE `__PREFIX__badge` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '勋章名称',
  `shuoming` varchar(255) NOT NULL COMMENT '说明',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '勋章图片',
  `jifen` int(4) NOT NULL COMMENT '所需积分',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='勋章设置表';
COMMIT;

BEGIN;
CREATE TABLE `__PREFIX__badge_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `badge_id` int(10) unsigned NOT NULL COMMENT '勋章ID',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='会员勋章分配表';
COMMIT;

BEGIN;
CREATE TABLE `__PREFIX__badge_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `badges` text NOT NULL COMMENT '会员勋章列表',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='会员勋章明细表';
COMMIT;
