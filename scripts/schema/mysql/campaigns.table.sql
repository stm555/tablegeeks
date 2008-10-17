CREATE TABLE `tablegeeks`.`campaigns` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255),
  `created` DATETIME NOT NULL COMMENT 'std. field',
  PRIMARY KEY (`id`)
)
CHARACTER SET utf8
COMMENT = 'gaming campaigns';
