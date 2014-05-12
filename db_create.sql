CREATE TABLE IF NOT EXISTS `video_views` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `file` varchar(250) NOT NULL,
  `stamp` datetime NOT NULL, -- I prefer to use a readable date format over timestamp
  PRIMARY KEY (`id`),
  KEY `file` (`file`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- an upgrade would have a separate table for the video data to avoid data duplication
-- but there's not really enough data being saved right now to warrent it

-- CREATE TABLE IF NOT EXISTS `videos` (
-- 	`id` int(9) NOT NULL AUTO_INCREMENT,
-- 	`file` varchar(250) NOT NULL, 
-- 	`created_at` datetime NOT NULL,
-- 	`updated_at` datetime NOT NULL,
-- 	  PRIMARY KEY (`id`),
-- 	  KEY `file` (`file`)
-- 	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	
-- CREATE TABLE IF NOT EXISTS `video_views` (
-- 	`id` int(9) NOT NULL AUTO_INCREMENT,
-- 	`video_id` int(9) NOT NULL,
-- 	`stamp` datetime NOT NULL,
--   PRIMARY KEY (`id`),
--   KEY `video_id` (`video_id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	
-- ALTER TABLE `video_views`
-- 	ADD CONSTRAINT `video_views_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
	