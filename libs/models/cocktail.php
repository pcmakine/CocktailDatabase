<?php

require_once "connection.php";

class cocktail {

    private $id;
    private $name;
    private $recipe;
    private $price;
    private $rating;

    public function __construct($id, $name, $recipe, $price) {
        $this->id = $id;
        $this->name = $name;
        $this->recipe = $recipe;
        $this->price = $price;
        $this -> setAvgRating();
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getRecipe() {
        return $this->recipe;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getRating() {
        return $this->rating;
    }

    public function getCocktails() {
        $sql = "SELECT id, cocktailname, recipe, price from cocktail";

        $query = connection::getConnection()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $cocktail = new cocktail($result->id, $result->cocktailname, $result->recipe, $result->price);
            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $results[] = $cocktail;
        }
        return $results;
    }
    
    public function numofCocktails(){
        $sql = "SELECT COUNT(id) FROM cocktail";
        
        $query = connection::getConnection()->prepare($sql);
        $query->execute();
        
        $result = $query->fetchObject();
        return $result -> count;
        
    }

    public function setAvgRating() {
        $sql = "SELECT cocktailid, rating from rating where cocktailid = ?";
        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($this->id));

        $rows = 0;
        $sumofratings = 0;
        foreach ($query->fetchAll(PDO::FETCH_OBJ) AS $result) {
            $sumofratings = $sumofratings + $result->rating;
            $rows++;
        }
        if($rows == 0){
            $this -> rating = "no ratings yet";
        }else{
            $this->rating = ($sumofratings / $rows);
        }
    }
    
    
}

?>
