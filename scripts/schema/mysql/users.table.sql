CREATE TABLE `tablegeeks`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) COMMENT 'common / login name',
  `created` datetime NOT NULL COMMENT 'std. field',
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB
CHARACTER SET utf8;
