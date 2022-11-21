CREATE database if not exists GlobusDelievery;
use GlobusDelievery;
# create table if not exists users(
#     id varchar(100) not null PRIMARY KEY,
#     email varchar(100) not null unique,
#     password text not null,
#     current_order varchar(100),
#     rememberToken text,
#     phone text,
#     username text,
#     address text,
#     created_at datetime,
#     updated_at datetime,
#     foreign key (current_order) references orders(id)
# );
# create table if not exists orders(
#     id varchar(100) not null primary key,
#     user_id varchar(100) not null,
#     total_price float,
#     delivery_time text,
#     status text not null,
#     created_at datetime,
#     updated_at datetime,
#     foreign key (user_id) references users(id)
# );
#
# create table if not exists restaurants(
#     id varchar(100) not null primary key,
#     name text not null,
#     image text,
#     delivery_time text,
#     delivery_price text,
#     rating float,
#     created_at datetime,
#     updated_at datetime
# );
#
# create table if not exists categories(
#     id varchar(100) not null primary key,
#     restaurant_id varchar(100) not null,
#     name text not null,
#     restaurant_name varchar(100),
#     image text,
#     created_at datetime,
#     updated_at datetime,
#     foreign key (restaurant_id) references restaurants(id)
# );
#
# create table if not exists meals(
#     id varchar(100) not null primary key,
#     category_id varchar(100),
#     restaurant_id varchar(100) not null,
#     restaurant_name varchar(100),
#     category_name varchar(100),
#     name text not null,
#     image text,
#     price float,
#     created_at datetime,
#     updated_at datetime,
#     foreign key (category_id) references categories(id),
#     foreign key (restaurant_id) references restaurants(id)
# );
#
# create table if not exists order_items(
#     id varchar(100) not null primary key,
#     order_id varchar(100) not null,
#     user_id varchar(100) not null,
#     meal_id varchar(100) not null,
#     count int not null,
#     created_at datetime,
#     updated_at datetime,
#     foreign key (order_id) references orders(id),
#     foreign key (user_id) references users(id),
#     foreign key (meal_id) references meals(id)
# );
#
# insert into users (id, email, password) values ("1", "test@gmail.com", "1");
# insert into restaurants (id, name) values ("1", "rest1");
# insert into categories (id, restaurant_id, name) values ("1", "1", "cat1");
# insert into meals (id, restaurant_id, category_id, name) values ("1", "1", "1", "meal1");
# insert into meals (id, restaurant_id, name) values ("2", "1", "meal2");
# insert into orders (id, user_id) values ("1", "1");
# insert into order_items (id, user_id, order_id, meal_id, count) values ("1", "1", "1", "1", 1);
# insert into order_items (id, user_id, order_id, meal_id, count) values ("2", "1", "1", "2", 5);

delimiter |
create trigger `link_with_restaurant` before insert on `categories`
for each row begin
    declare uid text;
    set NEW.restaurant_name = trim(NEW.restaurant_name);
    select id into uid from restaurants where name=NEW.restaurant_name;
    set NEW.restaurant_id = uid;
end;|
delimiter ;

delimiter |
create trigger `link_with_restaurant_and_category` before insert on `meals`
    for each row begin
    declare uid_rest text;
    declare uid_cat text;
    select id into uid_rest from restaurants where name=NEW.restaurant_name;
    select id into uid_cat from categories where name=NEW.category_name and restaurant_name=NEW.restaurant_name;
    set NEW.restaurant_id = uid_rest;
    set NEW.category_id = uid_cat;
end;|
delimiter ;

delimiter |
create trigger `count_total_price` before insert on `order_items`
for each row begin
    declare _price float;
    select price into _price from meals where id=NEW.meal_id;
    update orders set total_price = total_price + _price where id=NEW.order_id;
end;|
delimiter ;

delimiter |
create trigger `count_total_price_update` before update on `order_items`
    for each row begin
    declare _price float;
    select price into _price from meals where id=NEW.meal_id;
    update orders set total_price = (total_price - OLD.count*_price) + (NEW.count*_price) where id=NEW.order_id;
end;|
delimiter ;

delimiter |
create trigger `count_total_price_delete` before delete on `order_items`
    for each row begin
    declare _price float;
    select price into _price from meals where id=OLD.meal_id;
    update orders set total_price = total_price-_price where id=OLD.order_id;
end;|
delimiter ;



load data local infile
    'meals.csv'
    into table meals
    fields terminated by ';'
    enclosed by '"'
    lines terminated by '\n'
    (id, category_name, name, restaurant_name, image, price);

load data local infile
    'categories.csv'
    into table categories
    fields terminated by ';'
    enclosed by '"'
    lines terminated by '\n'
    (restaurant_name, name, id);

load data local infile
    'restaurants.csv'
    into table restaurants
    fields terminated by ';'
    enclosed by '"'
    lines terminated by '\n'
    (id, name, image, delivery_time, delivery_price, rating);

