/*Внесение строк в таблицы*/
INSERT INTO categories
(category_name, category_value) VALUES
('Доски и лыжи','boards'),
('Крепления','attachment'),
('Ботинки','boots'),
('Одежда','clothing'),
('Инструменты ','tools'),
('Разное','other');

INSERT INTO users
(user_registration_date, user_email, user_name, user_password, user_contacts) VALUES
(NOW(),'youlka@gmail.com','Yulia Queen','qween','ул. Советская, 17-8'),
(NOW(),'ya@gmail.com','Ya-ya','qwerty','ул. Некрасова, 12-9'),
(NOW(),'gelly@yandex.ru','Gelick','qqqqqqqq','ул. Гайдара, 20-16');

INSERT INTO lots
(lot_name, lot_category, lot_start_price, lot_picture, lot_creation_date, lot_end_date, lot_author, lot_bet_step) VALUES
('2014 Rossignol District Snowboard',1,10999,'img/lot-1.jpg','2019-08-20','2019-08-28', 1, 500),
('DC Ply Mens 2016/2017 Snowboard',1,159999,'img/lot-2.jpg','2019-08-20','2019-08-28', 1, 500),
('Крепления Union Contact Pro 2015 года размер L/XL',2,8000,'img/lot-3.jpg','2019-08-20','2019-08-27', 3, 500),
('Ботинки для сноуборда DC Mutiny Charocal',3,10999,'img/lot-4.jpg','2019-08-20','2019-08-28', 2, 500),
('Куртка для сноуборда DC Mutiny Charocal',4,7500,'img/lot-5.jpg','2019-08-20','2019-08-29', 2, 500),
('Маска Oakley Canopy',6,5400,'img/lot-6.jpg','2019-08-20','2019-08-30', 2, 500);

INSERT INTO bids
(bid_date, bid_user, bid_amount, bid_lot ) VALUES ('2019-08-20',1,9000,3), ('2019-08-22',1,12000,4);

/*Запросы
1-Получить все категории*/
SELECT * FROM categories;

/*2-Получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение,
цену, название категории*/
SELECT lot_name, lot_start_price, lot_picture, bids.bid_amount, lot_category FROM lots
JOIN bids
ON lot_id = bids.bid_lot
WHERE CURRENT_TIMESTAMP < lots.lot_end_date
ORDER BY lots.lot_creation_date DESC;

/*3-показать лот по его id. Получите также название категории, к которой принадлежит лот*/
SELECT l.*, c.category_name FROM  lots AS l
JOIN categories AS c ON c.category_name = l.lot_category
WHERE l.lot_id = '1';

//4-обновить название лота по его идентификатору
UPDATE users SET user_password = '369852147'
WHERE user_id = '2';

/*Получить список ставок
для лота по его идентификатору с сортировкой по дате*/
SELECT * FROM bids AS b
JOIN lots AS l
ON b.bid_lot = l.lot_id
WHERE l.lot_id = '32'
ORDER BY b.bid_date DESC
LIMIT 10;


