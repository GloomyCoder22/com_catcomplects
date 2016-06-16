CREATE TABLE IF NOT EXISTS `#__catcomplects_complects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `state` tinyint(3) NOT NULL,
  `ordering` int(11) NOT NULL,
  `items` text NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__catcomplects_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article` varchar(20) NOT NULL,
  `catid` int(11) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_desc` varchar(1000) NOT NULL,
  `meta_keywords` varchar(1000) NOT NULL,
  `state` tinyint(3) NOT NULL,
  `ordering` int(11) NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `price_old` int(11) NOT NULL DEFAULT '0',
  `height` varchar(30) NOT NULL,
  `width` varchar(30) NOT NULL,
  `color` set('white','red','pink','blue','green','black','brown') NOT NULL,
  `color_back` tinyint(3) NOT NULL DEFAULT '0',
  `color_word` tinyint(3) NOT NULL DEFAULT '0',
  `address` tinyint(3) NOT NULL DEFAULT '0',
  `time_work` tinyint(3) NOT NULL DEFAULT '0',
  `checked` varchar(30) NOT NULL DEFAULT 'checked',
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__catcomplects_items_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `state` tinyint(1) NOT NULL,
  `ordering` int(11) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

