
-- Date: 24/02/2016
-- Commit message: DB - create new table for Blog items

CREATE TABLE IF NOT EXISTS `blog_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  `image` tinytext,
  `hits` int(10) NOT NULL,
  `metadesc` varchar(255) NOT NULL,
  `metadata` varchar(255) NOT NULL,
  `metakey` varchar(255) NOT NULL,
  `published` smallint(1) NOT NULL DEFAULT '0',
  `published_date` datetime NOT NULL,
  `access` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `featured` smallint(1) NOT NULL DEFAULT '0',
  `delete_flag` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;