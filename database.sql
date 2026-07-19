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

CREATE TABLE IF NOT EXISTS category(
    id int AUTO_INCREMENT PRIMARY key,
    name varchar(255),
    slug varchar(255) UNIQUE,
    created_at datetime,
    updated_at datetime
);

CREATE TABLE IF NOT EXISTS news(
    id int AUTO_INCREMENT PRIMARY key,
    category_id int,
    user_id int,
    title varchar(255),
    slug varchar(255) UNIQUE,
    image varchar(100),
    description text,
    meta_title varchar(255),
    meta_description varchar(255),
    created_at datetime,
    updated_at datetime,
    FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE RESTRICT ON UPDATE CASCADE,
     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE
);
