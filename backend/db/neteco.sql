CREATE DATABASE neteco;
USE neteco;

CREATE TABLE favorites (
	id int AUTO_INCREMENT,
    user varchar(255),
    product varchar(255),
    PRIMARY KEY (id)
);


CREATE TABLE cart (
    id int AUTO_INCREMENT,
    user varchar(255),
    product int,
    units int,
    PRIMARY KEY (id)
);

CREATE TABLE orders (
    id int AUTO_INCREMENT,
    user varchar(255),
    product int,
    units int,
    PRIMARY KEY (id)
);