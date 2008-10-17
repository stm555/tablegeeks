CREATE TABLE `tablegeeks`.`tags_xref` (
  `tag` INT UNSIGNED NOT NULL COMMENT 'fk to tags',
  `type` INT UNSIGNED NOT NULL COMMENT 'type of entity that is tagged',
  `entity` INT UNSIGNED NOT NULL COMMENT 'fk to thing that is tagged',
  PRIMARY KEY (`tag`, `type`, `entity`)
)
CHARACTER SET utf8
COMMENT = 'ties tags to things';
