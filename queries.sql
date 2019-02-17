INSERT INTO users \\ Добавляем новых пользователей а базу users
(email, password) VALUES
('kokokok@mail.ru', 'sekretic'),
('user2@mail.ru', 'qwerty'),
('user3@mail.ru', 'adad-23dzc-adasd'),
('user4@mail.ru', 'lkjdfbvjkhdzf');


INSERT INTO category \\ Добавляем список категорий в базу category
(category) VALUES
('Доски и лыжи'),
('Крепления'),
('Ботинки'),
('Одежда'),
('Инструменты'),
('Разное');

INSERT INTO lots \\ Добавляем лоты
(name_lot, url_picture, start_price) VALUES
('2014 Rossignol District Snowboard', 'img/lot-1.jpg', '10999'),
('DC Ply Mens 2016/2017 Snowboard', 'img/lot-2.jpg', '159999'),
('Крепления Union Contact Pro 2015 года размер L/XL', 'img/lot-3.jpg', '8000'),
('Ботинки для сноуборда DC Mutiny Charocal', 'img/lot-4.jpg', '10999'),
('Куртка для сноуборда DC Mutiny Charocal', 'img/lot-5.jpg', '7500'),
('Маска Oakley Canopy', 'img/lot-6.jpg', '5400');

INSERT INTO bids \\ Добавим несколько ставок
(bid_date, bid_amount)  VALUES
('20.04.1994', '1488'),
('14.04.1991', '282'),
('14.02.2019', '10323');

SELECT * FROM category; \\Получаем все категории

SELECT * FROM lots LIMIT 200; \\Получаем все лоты

SELECT * FROM lots WHERE lot_id = 2; \\Показать лот с определенным id

UPDATE lots SET name_lot = 'Новое название лота' WHERE id = 2; \\ обновить название лота по его идентификатору

SELECT * FROM bids WHERE lot_id = 2 ORDER BY bid_date ASC; \\ получить список самых свежих ставок для лота по его идентификатору

