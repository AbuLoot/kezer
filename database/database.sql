
INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, 'Admin', '2018-06-25 03:49:32', '2018-06-25 03:49:32'),
(2, 'user', NULL, 'User', '2018-06-25 03:49:42', '2018-06-25 03:49:42');

INSERT INTO `languages` (`id`, `sort_id`, `slug`, `title`, `created_at`, `updated_at`) VALUES
(1, 1, 'ru', 'Русский', '2017-05-09 07:52:32', '2017-05-09 07:52:32'),
(2, 2, 'en', 'English', '2018-06-21 08:17:43', '2018-06-21 08:17:43'),
(3, 3, 'kz', 'Қазақша', '2018-06-21 08:18:17', '2018-06-21 08:18:17'),
(4, 4, 'tr', 'Turkey', '2018-06-21 08:18:17', '2018-06-21 08:20:17');

INSERT INTO `currencies` (`country`, `currency`, `code`, `symbol`, `lang`) VALUES
('America', 'Dollars', 'USD', '$', 'en'),
('Euro', 'Euro', 'EUR', '€', 'eu'),
('Kazakhstan', 'Tenge', 'KZT', '₸', 'kz'),
('Kyrgyzstan', 'Soms', 'KGS', '⊆', 'kg'),
('Russia', 'Rubles', 'RUB', 'руб', 'ru'),
('Saudi Arabia', 'Riyals', 'SAR', '﷼', 'sa'),
('Turkey', 'Lira', 'TRY', 'TL', 'try'),
('Turkey', 'Liras', 'TRL', '£', 'tr'),
('Uzbekistan', 'Sums', 'UZS', 'som', 'uz');

INSERT INTO `modes` (`id`, `sort_id`, `slug`, `title`, `data`, `lang`, `status`) VALUES
(1, 1, 'new', 'Новинки', NULL, 'ru', 1),
(2, 2, 'top', 'Популярные', NULL, 'ru', 0),
(3, 3, 'last', 'Последние', NULL, 'ru', 1),
(4, 4, 'budgetary', 'Бюджетные', NULL, 'ru', 1),
(5, 5, 'default', 'По умолчанию', NULL, 'ru', 1),
(6, 6, 'trend', 'В тренде', NULL, 'ru', 1),
(7, 7, 'slide', 'Слайд', NULL, 'ru', 1),
(8, 8, 'best-price', 'Лучшая цена', NULL, 'ru', 1),
(9, 9, 'stock', 'Акция', NULL, 'ru', 1),
(10, 10, 'novelty', 'Новинка', NULL, 'ru', 1),
(11, 11, 'plus-gift', '+ Подарок', NULL, 'ru', 1);

