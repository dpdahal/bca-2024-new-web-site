CREATE DATABASE IF NOT EXISTS bbc;
use bbc;
CREATE TABLE IF NOT EXISTS users(
id int AUTO_INCREMENT PRIMARY key,
name varchar(100),
email varchar(100) UNIQUE,
password varchar(100),
gender ENUM("male","female"),
role set("admin","user") DEFAULT "user",
profile varchar(100),
created_at datetime,
updated_at datetime
);
