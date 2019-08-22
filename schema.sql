CREATE DATABASE IF NOT EXISTS yeti_cave
    DEFAULT CHARACTER SET 'utf8'
    DEFAULT COLLATE 'utf8_general_ci';

USE yeti_cave;

CREATE TABLE IF NOT EXISTS users (
                                     user_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                     user_registration_date DATETIME NOT NULL,
                                     user_email VARCHAR(128) NOT NULL UNIQUE ,
                                     user_name VARCHAR(128) NOT NULL,
                                     user_password VARCHAR(255) NOT NULL,
                                     user_avatar VARCHAR(512),
                                     user_contacts VARCHAR(512),
                                     PRIMARY KEY (user_id)
);

CREATE TABLE IF NOT EXISTS categories (
                                          category_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                          category_value VARCHAR(128),
                                          category_name VARCHAR(128),
                                          PRIMARY KEY (category_id)
);

CREATE TABLE IF NOT EXISTS lots (
                                    lot_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                    lot_name VARCHAR(512) NOT NULL,
                                    lot_description TEXT,
                                    lot_picture VARCHAR(512),
                                    lot_creation_date DATETIME NOT NULL,
                                    lot_end_date DATETIME NOT NULL,
                                    lot_start_price INT UNSIGNED NOT NULL,
                                    lot_bet_step MEDIUMINT UNSIGNED NOT NULL,
                                    lot_author INT UNSIGNED NOT NULL,
                                    lot_winner INT UNSIGNED,
                                    lot_category TINYINT UNSIGNED NOT NULL,
                                    PRIMARY KEY (lot_id),
                                    FOREIGN KEY (lot_author) REFERENCES users(user_id),
                                    FOREIGN KEY (lot_winner) REFERENCES users(user_id),
                                    FOREIGN KEY (lot_category) REFERENCES categories(category_id)
);

CREATE TABLE IF NOT EXISTS bids (
                                    bid_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                    bid_date DATETIME NOT NULL,
                                    bid_amount INT UNSIGNED NOT NULL,

                                    bid_user INT UNSIGNED NOT NULL,
                                    bid_lot BIGINT UNSIGNED NOT NULL,
                                    PRIMARY KEY (bid_id),
                                    FOREIGN KEY (bid_user) REFERENCES users(user_id),
                                    FOREIGN KEY (bid_lot) REFERENCES lots(lot_id)
);
