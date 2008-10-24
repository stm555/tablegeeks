CREATE TABLE `tablegeeks`.`media` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(512) NOT NULL,
  `size` INT UNSIGNED DEFAULT NULL,
  `mimetype` VARCHAR(50) DEFAULT NULL COMMENT 'Mimetype of media file',
  `duration` INT UNSIGNED DEFAULT NULL COMMENT 'duration in seconds of media',
  `created` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB
CHARACTER SET utf8
COMMENT = 'media files';
