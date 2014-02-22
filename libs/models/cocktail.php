<?php

require_once "connection.php";
require_once "database.php";

class cocktail {

    private $id;
    private $name;
    private $recipe;
    private $price;
    private $rating;
    private $suggestion;

    public function __construct($id, $name, $recipe, $price, $suggestion) {
        $this->id = $id;
        $this->name = trim($name);
        $this->recipe = trim($recipe);
        $this->price = $price;
        if (is_numeric($suggestion)) {
            $this->suggestion = cocktail::suggestionbitToBoolean($suggestion);
        } else {
            $this->suggestion = $suggestion;
        }

        $this->setAvgRating();
        $this->fixEmptyAttributes();
    }

    private function fixEmptyAttributes() {
        if ($this->price == '') {
            $this->price = null; //the user might give an empty string for price
        }
    }

    public function getCocktails($searchterm, $orderby, $orderdir, $limit, $page) {

        $sql = "SELECT id, cocktailname, recipe, price, suggestion::int from cocktail where lower(cocktailname) like lower(?) order by " .
                $orderby . " " . $orderdir . " LIMIT ? OFFSET ?";
        $searchterm = "%" . $searchterm . "%";

        if ($orderby == 'rating') {
            //get all the cocktails and order them by rating. return the right ones from the list
        }

        $array = array($searchterm, $limit, ($page - 1) * $limit);
        return database::getList($sql, $array, 'cocktail');
    }

    public function getApprovedCocktails($searchterm, $orderby, $orderdir, $limit, $page) {
        $sql = "SELECT id, cocktailname, recipe, price, suggestion::int from cocktail where suggestion = ? and lower(cocktailname) like lower(?) order by " .
                $orderby . " " . $orderdir . " LIMIT ? OFFSET ?";
        $searchterm = "%" . $searchterm . "%";
        $array = array(0, $searchterm, $limit, ($page - 1) * $limit);

        $results = database::getList($sql, $array, 'cocktail');

        return $results;
    }

    public function getSuggestions($searchterm, $orderby, $orderdir, $limit, $page) {
        $sql = "SELECT id, cocktailname, recipe, price, suggestion::int from cocktail where suggestion = ? and lower(cocktailname) like lower(?) order by " .
                $orderby . " " . $orderdir . " LIMIT ? OFFSET ?";
        $searchterm = "%" . $searchterm . "%";
        $array = array(1, $searchterm, $limit, ($page - 1) * $limit);

        $results = database::getList($sql, $array, 'cocktail');

        return $results;
    }

    public function getSingleCocktail($id) {
        $sql = "SELECT * from cocktail where id = ?";
        $array = array($id);
        return database::getSingle($sql, $array, 'cocktail');

    }

    public function addCocktail() {
        $sql = "insert into cocktail(cocktailname, recipe, price, suggestion) values(?,?,?,?) returning id";

        $query = connection::getConnection()->prepare($sql);
        $ok = $query->execute(array($this->name, $this->recipe, $this->price, cocktail::booleanToSuggestionBit($this->suggestion)));

        if ($ok) {
            $this->id = $query->fetchColumn();
        }
        return $ok;
    }

    public static function removeCocktail($id) {
        $sql = "delete from cocktail where id = ?";

        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($id));
    }

    public function updateCocktail($id, $name, $recipe, $price, $suggestion) {
        $sql = "UPDATE cocktail SET cocktailname = ?, recipe = ?, price = ?, suggestion = ? WHERE id = ?";
        if ($price == '') {
            $price = null;
        }
        $query = connection::getConnection()->prepare($sql);

        $ok = $query->execute(array($name, $recipe, $price, cocktail::booleanToSuggestionBit($suggestion), $id));
    }

    public function addRating($username, $rating) {
        if ($rating != '') {
            $sql = "insert into rating(rating, username, cocktailid) values(?,?,?)";
            $array = array($rating, $username, $this->getId());
            if($this->ratingExists($username)){
                $sql = "update rating set rating = ? where username = ? and cocktailid = ?";
            }
            
            database::nonReturningExecution($sql, $array);
        }
    }

    public static function removeRatings($id) {
        $sql = "delete from rating where cocktailid = ?";
        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($id));
    }

    public static function removeIngredients($id) {
        $sql = "delete from cocktail_ingredient_link where cocktailid = ?";
        $array = array($id);
        database::nonReturningExecution($sql, $array);
    }

    public function numofCocktails($searchterm) {
        $sql = "SELECT COUNT(id) FROM cocktail where lower(cocktailname) like lower(?)";
        $searchterm = "%" . $searchterm . "%";
        $array = array($searchterm);

        return database::getCount($sql, $array);
    }

    public function numofApprovedCocktails($searchterm) {

        $sql = "SELECT COUNT(id) FROM cocktail where suggestion =? and lower(cocktailname) like lower(?)";
        $searchterm = "%" . $searchterm . "%";
        $array = array(0, $searchterm);

        return database::getCount($sql, $array);
    }

    public function numofSuggestions($searchterm) {

        $sql = "SELECT COUNT(id) FROM cocktail where suggestion =? and lower(cocktailname) like lower(?)";
        $searchterm = "%" . $searchterm . "%";
        $array = array(1, $searchterm);

        return database::getCount($sql, $array);
    }

    private function setAvgRating() {
        $sql = "SELECT cocktailid, rating from rating where cocktailid = ?";
        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($this->id));

        $rows = 0;
        $sumofratings = 0;
        foreach ($query->fetchAll(PDO::FETCH_OBJ) AS $result) {
            $sumofratings = $sumofratings + $result->rating;
            $rows++;
        }
        if ($rows == 0) {
            $this->rating = "ei vielä arvosteltu";
        } else {
            $this->rating = ($sumofratings / $rows);
        }
    }

    public function ratingExists($username){
        $sql = "SELECT count (cocktailid) from rating where username = ? and cocktailid = ?";
        return database::getCount($sql, array($username, $this->getId())) > 0;
        
    }

    public static function createNewOne($result) {
        $cocktail = new cocktail($result->id, $result->cocktailname, $result->recipe, $result->price, $result->suggestion);
        return $cocktail;
    }

    public static function suggestionbitToBoolean($bit) {
        if ($bit == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function booleanToSuggestionBit($suggestion) {
        if ($suggestion) {
            return 1;
        } else {
            return 0;
        }
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

    public function getSuggestion() {
        return $this->suggestion;
    }
}

?>
