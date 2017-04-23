CREATE TABLE IF NOT EXISTS `sdBlocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreate` datetime NOT NULL,
  `dateUpdate` datetime NOT NULL,
  `orderKey` int(11) NOT NULL,
  `content` text CHARACTER SET utf8,
  `data` text CHARACTER SET utf8 NOT NULL,
  `bannerId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `sdDocuments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size` text NOT NULL,
  `userId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `dateRender` datetime NOT NULL,
  `dateUpdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
