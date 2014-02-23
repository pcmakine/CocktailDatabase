create table users(username varchar(30) primary key not null,
                      password varchar(20) not null,
                       accessrights boolean not null);

create table cocktail(id serial primary key,
                        cocktailname varchar(20) not null,
                        recipe text,
                        price decimal,
                        suggestion boolean);

create table rating(username varchar(30) not null references users(username) on delete cascade,
                    cocktailid integer not null references cocktail(id) on delete cascade,
                    rating integer,
                    primary key(username, cocktailid));

create table ingredient(ingname varchar(40) primary key not null);

create table cocktail_ingredient_link(ingname varchar(30) not null references ingredient(ingname) on delete cascade,
                                        cocktailid integer not null references cocktail(id) on delete cascade,
                                        primary key(ingname, cocktailid));
