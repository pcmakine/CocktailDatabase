<?php

require_once "connection.php";

class ingredient {

    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function addIngredient() {
        if (!$this->ingredientExist()) {
            $sql = "insert into ingredient(ingname) values(?)";

            $query = connection::getConnection()->prepare($sql);
            $ok = $query->execute(array($this->name));
            return $ok;
        }
    }

    public function linkIngredientWithCocktail($cocktailId) {
        if (!($this->linkExist($cocktailId))) {
            $sql = "insert into cocktail_ingredient_link(ingname, cocktailid) values(?,?)";

            $query = connection::getConnection()->prepare($sql);
            $query->execute(array($this->name, $cocktailId));
        }
    }

    public function removeIngredientCocktailLink($cocktailId) {
        if (($this->linkExist($cocktailId))) {
            $sql = "delete from cocktail_ingredient_link where cocktailid = ? and ingname = ?";

            $query = connection::getConnection()->prepare($sql);
            $query->execute(array($cocktailId, $this->name));
        }
    }

    public static function removeAllIngredientCocktailLinks($ingnames, $cocktailId) {
        foreach ($ingnames as $name) {
            if ($name != '') {
                $ingredient = new ingredient(htmlspecialchars($name));
                $ingredient->removeIngredientCocktailLink($cocktailId);
            }
        }
    }

    public static function getIngredientsForCocktail($cocktailId) {
        $sql = "select ingname from cocktail_ingredient_link where cocktailid = ?";

        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($cocktailId));

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $results[] = $result->ingname;
        }
        return $results;
    }

    public function ingredientExist() {
        $sql = "select count(ingname) from ingredient where ingname = ?";
        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($this->name));

        $result = $query->fetchColumn();
        if ($result > 0) {
            return true;
        }
        return false;
    }

    public function linkExist($cocktailId) {
        $sql = "select count(*) from cocktail_ingredient_link where ingname = ? and cocktailid = ?";
        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($this->name, $cocktailId));

        $result = $query->fetchColumn();
        if ($result > 0) {
            return true;
        }
        return false;
    }

    public static function addAndLinkIngredients($ingnames, $cocktailId) {
        foreach ($ingnames as $name) {
            if ($name != '') {
                $ingredient = new ingredient(htmlspecialchars($name));
                $ingredient->addIngredient();
                $ingredient->linkIngredientWithCocktail($cocktailId);
            }
        }
    }

    public function getName() {
        return $this->name;
    }

}

