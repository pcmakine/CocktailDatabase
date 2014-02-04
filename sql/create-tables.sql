create table users(username varchar(30) primary key not null,
                      password varchar(20) not null,
                       accessrights varchar(1) not null);

create table cocktail(id serial primary key,
                        cocktailname varchar(20) not null,
                        recipe text,
                        price decimal);

create table rating(username varchar(30) not null references users(username),
                    cocktailid integer not null references cocktail(id),
                    rating integer,
                    primary key(username, cocktailid));

create table ingredient(ingname varchar(40) primary key not null);

create table cocktail_ingredient_link(ingname varchar(30) not null references ingredient(ingname),
                                        cocktailid integer not null references cocktail(id),
                                        primary key(ingname, cocktailid));
