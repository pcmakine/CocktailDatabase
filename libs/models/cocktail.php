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

    public function getCocktails($searchterm, $orderby, $limit, $page) {

        $sql = "SELECT id, cocktailname, recipe, price, suggestion::int from cocktail where cocktailname like ? order by " . $orderby . " LIMIT ? OFFSET ?";
        $searchterm = "%" . $searchterm . "%";
        
        if($orderby == 'rating'){
            //get all the cocktails and order them by rating. return the right ones from the list
        }

        $array = array($searchterm, $limit, ($page - 1) * $limit);
        return database::getList($sql, $array, 'cocktail');
    }

    public function getApprovedCocktails($searchterm, $limit, $page) {
        $sqlEmptySearch = "SELECT id, cocktailname, recipe, price, suggestion::int from cocktail where suggestion = ? order by cocktailname LIMIT ? OFFSET ?";
        $sqlNonEmptySearch = "SELECT id, cocktailname, recipe, price, suggestion::int from cocktail where suggestion = ? and lower(cocktailname) like lower(?) order by cocktailname LIMIT ? OFFSET ?";
        $searchterm = "%" . $searchterm . "%";
        $sqlAndArray = cocktail::getCorrectStatementAndArray($sqlEmptySearch, $sqlNonEmptySearch, $searchterm, array(array(0, $limit, ($page - 1) * $limit), array(0, $searchterm, $limit, ($page - 1) * $limit)));

        $results = database::getList($sqlAndArray['sql'], $sqlAndArray['array'], 'cocktail');

        return $results;
    }

    public function getSuggestions($searchterm, $limit, $page) {
        $sqlEmptySearch = "SELECT id, cocktailname, recipe, price, suggestion::int from cocktail where suggestion = ? order by cocktailname LIMIT ? OFFSET ?";
        $sqlNonEmptySearch = "SELECT id, cocktailname, recipe, price, suggestion::int from cocktail where suggestion = ? and lower(cocktailname) like lower(?) order by cocktailname LIMIT ? OFFSET ?";
        $searchterm = "%" . $searchterm . "%";
        $sqlAndArray = cocktail::getCorrectStatementAndArray($sqlEmptySearch, $sqlNonEmptySearch, $searchterm, array(array(1, $limit, ($page - 1) * $limit), array(1, $searchterm, $limit, ($page - 1) * $limit)));

        $results = database::getList($sqlAndArray['sql'], $sqlAndArray['array'], 'cocktail');

        return $results;
    }

    public function getSingleCocktail($id) {
        $sql = "SELECT * from cocktail where id = ?";

        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($id));

        $result = $query->fetchObject();
        $cocktail = new cocktail($result->id, $result->cocktailname, $result->recipe, $result->price, $result->suggestion);

        return $cocktail;
    }

    public static function searchForCocktail($searchterm, $limit, $page) {
        if ($searchterm == '') {
            return self::getCocktails($limit, $page);
        } else if ($searchterm == '' && $onlysuggestions) {
            return self::getSuggestions($limit, $page);
        }
        $sql;
        $searchterm = "%" . $searchterm . "%";
        $array = array($searchterm, $limit, (($page - 1) * $limit));
        if ($onlysuggestions) {
            $sql = "SELECT * from cocktail where suggestion = ? and lower(cocktailname) like lower(?) order by cocktailname LIMIT ? OFFSET ?";
            $array = array(1, $searchterm, $limit, (($page - 1) * $limit));
        } else {
            $sql = "SELECT * from cocktail where lower(cocktailname) like lower(?) order by cocktailname LIMIT ? OFFSET ?";
        }

        $query = connection::getConnection()->prepare($sql);
        $query->execute($array);

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $cocktail = new cocktail($result->id, $result->cocktailname, $result->recipe, $result->price, $result->suggestion);
            //$array[] = $muuttuja; lisää muuttujan arrayn perään. 
            //Se vastaa melko suoraan ArrayList:in add-metodia.
            $results[] = $cocktail;
        }
        return $results;
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
            $sql = "insert into rating(username, cocktailid, rating) values(?,?,?)";
            $query = connection::getConnection()->prepare($sql);
            $query->execute(array($username, $this->getId(), $rating));
        }
    }

    public static function removeRatings($id) {
        $sql = "delete from rating where cocktailid = ?";
        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($id));
    }

    public static function removeIngredients($id) {
        $sql = "delete from cocktail_ingredient_link where cocktailid = ?";

        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($id));
    }

    public function numofCocktails($searchterm) {
        $sql = "SELECT COUNT(id) FROM cocktail where cocktailname like ?";
        $searchterm = "%" . $searchterm . "%";
        $array = array($searchterm);

        return database::getCount($sql, $array);
    }

    public function numofApprovedCocktails() {

        $sql = "SELECT COUNT(id) FROM cocktail where suggestion =?";

        $query = connection::getConnection()->prepare($sql);
        $query->execute(array(0));
        $rows = $query->fetchColumn();

        return $rows;
    }

    public function numofSuggestions($searchterm) {

        $sql = "SELECT COUNT(id) FROM cocktail where suggestion =? and cocktailname like ?";
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

    public static function getCorrectStatementAndArray($sqlEmptySearch, $sqlNonEmptySearch, $search, $arrays) {
        if ($search == '%%') {
            $array = array('sql' => $sqlEmptySearch, 'array' => $arrays[0]);
            return $array;
        }
        $array = array('sql' => $sqlNonEmptySearch, 'array' => $arrays[1]);
        return $array;
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
