CREATE TABLE IF NOT EXISTS `wp_gc_game` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`author`  varchar(255) NOT NULL  COMMENT '作者',
`school`  varchar(255) NOT NULL  COMMENT '学校',
`title`  varchar(255) NOT NULL  COMMENT '游戏名称',
`cover_url`  varchar(255) NOT NULL  COMMENT '游戏图标',
`desc`  varchar(255) NOT NULL  COMMENT '游戏描述',
`game_url`  varchar(255) NOT NULL  COMMENT '游戏url地址',
`jump_url`  varchar(255) NOT NULL  COMMENT '跳转地址',
`likes_count`  int(10) NOT NULL  DEFAULT 0 COMMENT '赞数',
`comment_count`  int(10) NOT NULL  DEFAULT 0 COMMENT '评论数',
`share_count`  int(10) NOT NULL  DEFAULT 0 COMMENT '分享数',
`create_time`  int(10) NOT NULL  COMMENT '添加时间',
`modify_time`  int(10) NOT NULL  COMMENT '修改时间',
`content`  text NOT NULL  COMMENT '游戏详细说明',
`sort`  int(10) NOT NULL  DEFAULT 0 COMMENT '排序号',
`cate_id`  int(10) UNSIGNED NULL  DEFAULT 0 COMMENT '所属类别',
`token`  varchar(255) NOT NULL  COMMENT 'Token',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES ('gc_game','游戏学院游戏列表','0','','1','{"1":["title","author","school","cover_url","desc","content","game_url","jump_url","sort","cate_id"]}','1:基础','','','','','','10','','','1408591676','1408611350','1','InnoDB');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('author','作者','varchar(255) NOT NULL','string','','游戏开发作者','1','','0','1','1','1408592286','1408592286','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('school','学校','varchar(255) NOT NULL','string','','所属的学校','1','','0','1','1','1408603266','1408594504','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('title','游戏名称','varchar(255) NOT NULL','string','','游戏名称','1','','0','1','1','1408594538','1408594538','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('cover_url','游戏图标','varchar(255) NOT NULL','picture','','游戏应用的图标','1','','0','1','1','1408596400','1408594595','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('desc','游戏描述','varchar(255) NOT NULL','textarea','','游戏描述','1','','0','1','1','1408603788','1408594943','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('game_url','游戏url地址','varchar(255) NOT NULL','string','','游戏url地址','1','','0','0','1','1408595273','1408595273','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('jump_url','跳转地址','varchar(255) NOT NULL','string','','若游戏是外链，需要跳转的url地址','1','','0','0','1','1408595333','1408595333','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('likes_count','赞数','int(10) NOT NULL','num','0','点赞的个数','3','','0','0','1','1408595525','1408595464','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('comment_count','评论数','int(10) NOT NULL','num','0','评论数目','3','','0','0','1','1408595514','1408595514','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('share_count','分享数','int(10) NOT NULL','num','0','分享数','3','','0','0','1','1408595551','1408595551','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('create_time','添加时间','int(10) NOT NULL','datetime','','','0','','0','0','1','1408603685','1408603685','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('modify_time','修改时间','int(10) NOT NULL','datetime','','','0','','0','0','1','1408603708','1408603708','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('content','游戏详细说明','text NOT NULL','editor','','','1','','0','1','1','1408603884','1408603884','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('sort','排序号','int(10) NOT NULL','num','0','数值越小越靠前','1','','0','0','1','1408604193','1408604193','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('cate_id','所属类别','int(10) UNSIGNED NULL','select','0','要先在微官网分类里配置好分类才可选择','1','0:请选择分类','0','1','1','1408611273','1408604306','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('token','Token','varchar(255) NOT NULL','string','','','0','','0','0','1','1408605561','1408605561','','3','','regex','','3','function');
UPDATE `wp_attribute` SET model_id= (SELECT MAX(id) FROM `wp_model`) WHERE model_id=0;

CREATE TABLE IF NOT EXISTS `wp_gc_study` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`title`  varchar(255) NOT NULL  COMMENT '课程标题',
`desc`  text NOT NULL  COMMENT '课程描述',
`cover_url`  varchar(255) NOT NULL  COMMENT '封面图片',
`video_url`  varchar(255) NOT NULL  COMMENT '视频地址',
`jump_url`  varchar(255) NOT NULL  COMMENT '跳转地址',
`likes_count`  int(10) NOT NULL  DEFAULT 0 COMMENT '赞数',
`comment_count`  int(10) NOT NULL  DEFAULT 0 COMMENT '评论数',
`share_count`  int(10) NOT NULL  DEFAULT 0 COMMENT '分享数',
`cate_id`  int(10) UNSIGNED NULL  DEFAULT 0 COMMENT '所属类别',
`sort`  int(10) UNSIGNED NOT NULL  DEFAULT 0 COMMENT '排序号',
`token`  varchar(255) NOT NULL  COMMENT 'Token',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;
INSERT INTO `wp_model` (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES ('gc_study','游戏学院学习列表','0','','1','','1:基础','','','','','','10','','','1408591696','1408591696','1','InnoDB');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('title','课程标题','varchar(255) NOT NULL','string','','课程标题','1','','0','1','1','1408595751','1408595751','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('desc','课程描述','text NOT NULL','editor','','课程描述','1','','0','1','1','1408596564','1408595777','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('cover_url','封面图片','varchar(255) NOT NULL','picture','','封面图片地址','1','','0','1','1','1408596446','1408595816','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('video_url','视频地址','varchar(255) NOT NULL','string','','视频地址','1','','0','0','1','1408595854','1408595854','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('jump_url','跳转地址','varchar(255) NOT NULL','string','','点击跳转的地址','1','','0','0','1','1408595902','1408595902','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('likes_count','赞数','int(10) NOT NULL','num','0','点赞数','3','','0','0','1','1408595943','1408595943','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('comment_count','评论数','int(10) NOT NULL','num','0','评论数目','3','','0','0','1','1408595971','1408595971','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('share_count','分享数','int(10) NOT NULL','num','0','分享数目','3','','0','0','1','1408595998','1408595998','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('cate_id','所属类别','int(10) UNSIGNED NULL','select','0','要先在微官网分类里配置好分类才可选择','1','0:请选择分类','0','0','1','1408604396','1408604396','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('sort','排序号','int(10) UNSIGNED NOT NULL','num','0','数值越小越靠前','1','','0','0','1','1408604446','1408604446','','3','','regex','','3','function');
INSERT INTO `wp_attribute` (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES ('token','Token','varchar(255) NOT NULL','string','','','0','','0','0','1','1408605621','1408605621','','3','','regex','','3','function');
UPDATE `wp_attribute` SET model_id= (SELECT MAX(id) FROM `wp_model`) WHERE model_id=0;