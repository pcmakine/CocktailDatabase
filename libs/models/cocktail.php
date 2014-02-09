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

    public function getCocktails($limit, $page) {
        $sql = "SELECT * from cocktail  order by cocktailname LIMIT ? OFFSET ?";

        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($limit, ($page-1)*$limit));

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $cocktail = new cocktail($result->id, $result->cocktailname, $result->recipe, $result->price);
            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $results[] = $cocktail;
        }
        return $results;
    }
    
    public function getSingleCocktail($id){
        $sql = "SELECT * from cocktail where id = ?";
        
        $query = connection::getConnection()->prepare($sql);
        $query -> execute(array($id));
        
        $result = $query->fetchObject();
        $cocktail = new cocktail($result->id, $result->cocktailname, $result->recipe, $result->price);
        
        return $cocktail;
    }
    
    public function addCocktail(){
        $sql = "insert into cocktail(cocktailname, recipe, price) values(?,?,?) returning id";
        
        $query = connection::getConnection()-> prepare($sql);
        $ok = $query-> execute(array($this->name, $this->recipe, $this->price));
        
        if($ok){
            $this->id = $query->fetchColumn();
        }
        
        return $ok;
    }

    public function addRating($username, $rating){
        if($rating != ''){
            $sql = "insert into rating(username, cocktailid, rating) values(?,?,?)";
            $query = connection::getConnection()-> prepare($sql);
            $query-> execute(array($username, $this->getId(), $rating));
        }
    }
    
    public function numofCocktails(){
        $sql = "SELECT COUNT(*) FROM cocktail";
        
        $query = connection::getConnection()->prepare($sql);
        $query->execute();
        $rows = $query -> fetchColumn();
        
        return $rows;
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
            $this -> rating = "ei vielä arvosteltu";
        }else{
            $this->rating = ($sumofratings / $rows);
        }
    }
}

?>
