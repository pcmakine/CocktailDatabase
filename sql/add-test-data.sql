insert into users(username, password, accessrights) values('pete', 'admin', true), 
                                                            ('mickey mouse', 'regular', false);
insert into cocktail(id, cocktailname, recipe, price, suggestion) values(default, 'water', null, 0.05, false),
                                                            (default, 'orange juice', 'Ravista mehupurkkia ja kaada mehu lasiin!', 0.3, false),
                                                            (default, 'apple juice', null, 0.3, false),
                                                            (default, 'pineapple juice', null, 0.3, false);
insert into ingredient(ingname) values('water'),
                                        ('orange');
insert into cocktail_ingredient_link(ingname, cocktailid) values('orange', 2),
                                                                ('water', 1);
insert into rating(username, cocktailid, rating) values('pete', 1, 5),
                                                        ('mickey mouse',1, 2),
                                                        ('pete', 2, 3),
                                                        ('mickey mouse', 2, 5);