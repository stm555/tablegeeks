CREATE TABLE `tablegeeks`.`tags` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tag` VARCHAR(256),
  `created` DATETIME COMMENT 'std. field',
  PRIMARY KEY (`id`)
)
CHARACTER SET utf8
COMMENT = 'keywords / tags';
