DELETE FROM `wp_attribute` WHERE model_id = (SELECT id FROM wp_model WHERE `name`='gc_game' ORDER BY id DESC LIMIT 1);
DELETE FROM `wp_model` WHERE `name`='gc_game' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_gc_game`;

DELETE FROM `wp_attribute` WHERE model_id = (SELECT id FROM wp_model WHERE `name`='gc_study' ORDER BY id DESC LIMIT 1);
DELETE FROM `wp_model` WHERE `name`='gc_study' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_gc_study`;