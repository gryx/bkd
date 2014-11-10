CREATE TABLE IF NOT EXISTS `username_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;


INSERT INTO `username_list` (`id`, `username`) VALUES
(1, 'addison'),
(2, 'oliver'),
(3, 'joey'),
(4, 'alex'),
(5, 'raju'),
(6, 'aditya'),
(7, 'paul'),
(8, 'sima');
