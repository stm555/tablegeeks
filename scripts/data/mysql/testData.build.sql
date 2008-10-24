INSERT INTO campaigns ( `id`, `name`, `created` ) VALUES ( '9999', 'Grand Campaign', now(  ) );
INSERT INTO media ( `id`, `path`, `size`, `mimetype`, `duration`, `created` ) VALUES ( '9999', '12345.m4a', '3000000', 'audio/x-m4a', '360000', now( ) );
INSERT INTO users ( `id`, `name`, `created` ) VALUES ( '9999', 'stm', now( ) );
INSERT INTO sessions ( `id`, `description`, `synopsis`, `date`, `campaign`, `author`, `media`, `created` ) VALUES ( '9999', 'Wherein Grand Things Happen to our Heroes', 'Lots of interesting things hapen to our heroes in this episode', '2008-10-28', '9999', '9999', '9999', now( ) );
INSERT INTO tags (`id`, `tag`, `created`) VALUES ('9999', 'grand', now());
INSERT INTO tags_xref (`tag`, `type`, `entity`, `created`) VALUES ('9999', 'session', '9999', now());
