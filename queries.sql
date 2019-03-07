INSERT INTO users
(email, password, name) VALUES
('kokokok@mail.ru', 'sekretic', 'kokokokouser'),
('user2@mail.ru', 'qwerty', 'kkouser'),
('user3@mail.ru', 'adad-23dzc-adasd', 'kokkouser'),
('user4@mail.ru', 'lkjdfbvjkhdzf', 'kokokuser');


INSERT INTO category
(category) VALUES
('Доски и лыжи'),
('Крепления'),
('Ботинки'),
('Одежда'),
('Инструменты'),
('Разное');

INSERT INTO lots
(name_lot, url_picture, start_price, user_id, category_id, date_creation, date_finish) VALUES
('2014 Rossignol District Snowboard', 'img/lot-1.jpg', '10999', 1, 3, '2019-03-13', '2019-10-12'),
('DC Ply Mens 2016/2017 Snowboard', 'img/lot-2.jpg', '159999', 1, 2, '2019-03-13', '2019-10-12'),
('Крепления Union Contact Pro 2015 года размер L/XL', 'img/lot-3.jpg', '8000', 1, 4, '2019-03-13', '2019-10-12'),
('Ботинки для сноуборда DC Mutiny Charocal', 'img/lot-4.jpg', '10999', 1, 5, '2019-03-13', '2019-10-12'),
('Куртка для сноуборда DC Mutiny Charocal', 'img/lot-5.jpg', '7500', 1, 2, '2019-03-13', '2019-10-12'),
('Маска Oakley Canopy', 'img/lot-6.jpg', '5400', 1, 2, '2019-03-13', '2019-10-12');

INSERT INTO bids
(bid_date, bid_amount, user_id, lot_id)  VALUES
('2019-03-11', '1488', 1, 6),
('2019-03-13', '282', 1, 1),
('2019-03-14', '10323', 1, 4);

SELECT * FROM category;

SELECT * FROM lots l
JOIN category c
ON l.category_id = c.id
WHERE date_finish > NOW()
ORDER BY l.id DESC;

SELECT * FROM lots WHERE lot_id = 2;

UPDATE lots SET name_lot = 'Новое название лота' WHERE id = 2;

SELECT * FROM bids WHERE lot_id = 2 ORDER BY bid_date DESC;



