create database if not exists TitoDB;
use TitoDB;
CREATE TABLE TitoTable (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, home VARCHAR(50) NOT NULL, work VARCHAR(50) NOT NULL, hour_home_departure VARCHAR(50) NOT NULL, hour_work_departure VARCHAR(50) NOT NULL)
