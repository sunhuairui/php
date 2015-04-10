CREATE TABLE IF NOT EXISTS `wp_extensions` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`keyword_type`  tinyint(2) NULL  DEFAULT 0 COMMENT '关键词类型',
`api_token`  varchar(255) NOT NULL  COMMENT 'Token',
`cTime`  int(10) NOT NULL  COMMENT '创建时间',
`api_url`  varchar(255) NOT NULL  COMMENT '第三方URL',
`output_format`  tinyint(1) NULL  DEFAULT 0 COMMENT '数据输出格式',
`keyword_filter`  tinyint(2) NOT NULL  DEFAULT 0 COMMENT '关键词过滤',
`keyword`  varchar(255) NOT NULL  COMMENT '关键词',
`token` varchar(255) NOT NULL COMMENT 'Token',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES ('extensions','融合第三方','0','','1','1:基础','','','','','keyword:关键词\r\nkeyword_filter|get_name_by_status:关键词过滤\r\noutput_format|get_name_by_status:数据输出格式\r\napi_url:第三方地址\r\napi_token:Token\r\ncTime|time_format:增加时间\r\nid:操作:[EDIT]|编辑,[DELETE]|删除','10','keyword','','1393911774','1394267850','1','InnoDB');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('keyword_type','关键词类型','tinyint(2) NULL','select','0','','1','0:完全匹配\r\n1:左边匹配\r\n2:右边匹配\r\n3:模糊匹配','0','0','1','1394268247','1393921586','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('api_token','Token','varchar(255) NOT NULL','string','','','1','','0','0','1','1393922455','1393912408','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('cTime','创建时间','int(10) NOT NULL','datetime','','','0','','0','0','1','1393913608','1393913608','','3','','regex','time','1','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('api_url','第三方URL','varchar(255) NOT NULL','string','','','1','','0','0','1','1393912354','1393912354','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('output_format','数据输出格式','tinyint(1) NULL','select','0','','1','0:标准微信xml\r\n1:json格式','0','0','1','1394268422','1393912288','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('keyword_filter','关键词过滤','tinyint(2) NOT NULL','bool','0','如设置电影为触发词,用户输入 电影 美国派 时，如果启用过滤只将美国派这个词发送到的你的接口，如果不过滤 就是整个 电影 美国派全部发送到的接口','1','0:不过滤\r\n1:过滤','0','0','1','1394268410','1393912057','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('keyword','关键词','varchar(255) NOT NULL','string','','多个关键词请用空格格开','1','','0','1','1','1393912492','1393911842','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('token', 'Token', 'varchar(255) NOT NULL', 'string', '', '', '0', '', '0', '0', '1', '1402454223', '1402454223', '', '3', '', 'regex', 'get_token', '1', 'function');
UPDATE `wp_attribute` SET model_id= (SELECT MAX(id) FROM `wp_model`) WHERE model_id=0;