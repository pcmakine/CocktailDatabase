insert into users(username, password, accessrights) values('pete', 'admin', 'a'), 
                                                            ('mickey mouse', 'regular', 'r');
insert into cocktail(id, cocktailname, recipe, price) values(default, 'water', null, 0.05),
                                                                (default, 'orange juice', null, 0.3);
insert into ingredient(ingname) values('water'),
                                        ('orange');
insert into cocktail_ingredient_link(ingname, cocktailid) values('orange', 2);


