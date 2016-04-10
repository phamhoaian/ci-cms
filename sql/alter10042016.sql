
-- Date: 10/04/2016
-- Commit message: DB - create new table for Blog tags

CREATE TABLE IF NOT EXISTS `blog_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `published` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `blog_tags_xref` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tagID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY (`tagID`),
  KEY (`itemID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;