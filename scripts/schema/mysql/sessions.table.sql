CREATE TABLE `tablegeeks`.`sessions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(255),
  `synopsis` TEXT,
  `date` DATE,
  `campaign` INT UNSIGNED NOT NULL COMMENT 'fk to campaigns',
  `author` INT UNSIGNED NOT NULL COMMENT 'fk to users',
  `media` INT UNSIGNED COMMENT 'fk to media',
  `created` DATETIME,
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB
CHARACTER SET utf8
COMMENT = 'gaming sessions';
