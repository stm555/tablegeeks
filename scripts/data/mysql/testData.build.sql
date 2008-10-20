INSERT INTO campaigns ( `id`, `name`, `created` ) VALUES ( '1', 'Grand Campaign', now(  ) );
INSERT INTO media ( `id`, `path`, `size`, `mimetype`, `duration`, `created` ) VALUES ( '1', '12345.m4a', '3000000', 'audio/x-m4a', '360000', now( ) );
INSERT INTO users ( `id`, `name`, `created` ) VALUES ( '1', 'stm', now( ) );
INSERT INTO sessions ( `id`, `description`, `synopsis`, `date`, `campaign`, `author`, `media`, `created` ) VALUES ( '1', 'Wherein Grand Things Happen to our Heroes', 'Lots of interesting things hapen to our heroes in this episode', '2008-10-28', '1', '1', '1', now( ) );
