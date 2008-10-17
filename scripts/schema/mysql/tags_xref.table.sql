CREATE TABLE `tablegeeks`.`tags_xref` (
  `tag` INT UNSIGNED NOT NULL COMMENT 'fk to tags',
  `type` INT UNSIGNED NOT NULL COMMENT 'type of entity that is tagged',
  `entity` INT UNSIGNED NOT NULL COMMENT 'fk to thing that is tagged',
  `created` DATETIME NOT NULL COMMENT 'std. field',
  PRIMARY KEY (`tag`, `type`, `entity`)
)
ENGINE = InnoDB
CHARACTER SET utf8
COMMENT = 'ties tags to things';
