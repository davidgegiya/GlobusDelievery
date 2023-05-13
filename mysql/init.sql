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
