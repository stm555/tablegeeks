ALTER TABLE `tablegeeks`.`tags_xref` ADD CONSTRAINT `tags_xref_tag_fk` FOREIGN KEY `tags_xref_tag_fk` (`tag`)
    REFERENCES `tags` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
