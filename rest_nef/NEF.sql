CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

INSERT INTO `customer` (`id`, `name`) VALUES
(1, 'British Airways'),
(2, 'British Gas');

CREATE TABLE `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `ue` varchar(255) NOT NULL,
  `imsi` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

INSERT INTO `data` (`id`, `customer_id`, `ue`, `imsi`, `profile`) VALUES
(1, 1, 'Smart meter1 pipeline2 - 2343132768A1', '2343104175', 'app1-011'),
(2, 1, 'smart signal2 runway1 - 2343132768A17', '2343127445', 'app1-011'),
(3, 2, 'pressure guage1 pipeline3 - 2343132768A5', '2343158037', 'app5-001'),
(4, 2, 'pressure guage7 pipeline1 - 2343132768A25', '2343118083', 'app5-001'),
(5, 1, 'unmanned baggage buggy1 - 2343132768A17', '2343199470', 'app1-011'),
(6, 1, 'unmanned baggage buggy2 - 2343132768A2', '2343124802', 'app1-011'),
(7, 2, 'temperature guage pipeline1 - 2343132768A2', '2343139547', 'app5-001'),
(8, 2, 'temperature guage pipeline2 - 2343132768A2', '2343145750', 'app5-002'),
(9, 2, 'temperature guage pipeline1 - 2343132768A2', '2343100855', 'app5-002'),
(10, 2, 'temperature guage pipeline2 - 2343132768A2', '2343174604', 'app5-001');