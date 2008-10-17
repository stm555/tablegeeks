ALTER TABLE `tablegeeks`.`sessions` ADD CONSTRAINT `sessions_campaign_fk` FOREIGN KEY `sessions_campaign_fk` (`campaign`)
    REFERENCES `campaigns` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
 ADD CONSTRAINT `sessions_author_fk` FOREIGN KEY `sessions_author_fk` (`author`)
    REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
 ADD CONSTRAINT `sessions_media_fk` FOREIGN KEY `sessions_media_fk` (`media`)
    REFERENCES `media` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
