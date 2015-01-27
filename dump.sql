CREATE TABLE IF NOT EXISTS `models` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `vendor` varchar(250) NOT NULL COMMENT 'Марка автомобиля',
  `model` varchar(250) NOT NULL COMMENT 'Модель автомобиля',
  `price` varchar(250) NOT NULL COMMENT 'Цена',
  `type` varchar(250) NOT NULL COMMENT 'Тип кузова',
  `colors` varchar(250) NOT NULL COMMENT 'Цвета автомобиля',
  `description` text NOT NULL COMMENT 'Описание',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `colors` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL COMMENT 'Цвет',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;