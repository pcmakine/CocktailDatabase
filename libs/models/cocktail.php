<?php

require_once "connection.php";
require_once "database.php";

/**
 * Cocktail taulun malli, joka tarjoaa palveluita drinkkien lisäämiseen, poistamiseen ja muokkaamiseen.
 * Myös drinkkien arvosanoja voi luokata tämän luokan metodien avulla.
 */
class cocktail {

    private $id;
    private $name;
    private $recipe;
    private $price;
    private $rating;
    private $suggestion;

    /**
     * Tekee cocktail -olion, joka mallintaa drinkkiä tietokannassa
     * @param type $id  Drinkin id, juokseva numerointi
     * @param type $name    Drinkin nimi
     * @param type $recipe  Drinkin valmistusohje
     * @param type $price   Drinkin hinta
     * @param type $suggestion   Onko drinkki ehdotus vai ei. Tallennetaan boolean tyyppisenä. Arvo true tarkoittaa että drinkki on ehdotus
     * @param type $rating  Drinkin keskimääräinen arvosana
     */
    public function __construct($id, $name, $recipe, $price, $suggestion, $rating) {
        $this->id = $id;
        $this->name = trim($name);
        $this->recipe = trim($recipe);
        $this->price = $price;
        if (is_numeric($suggestion)) {
            $this->suggestion = cocktail::suggestionbitToBoolean($suggestion);
        } else {
            $this->suggestion = $suggestion;
        }

        $this->rating = $rating;
        $this->fixEmptyAttributes();
    }

    /**
     * Apufunktio joka antaa hinnalle arvon null jos sen arvona on tyhjä merkkijono
     */
    private function fixEmptyAttributes() {
        if ($this->price == '') {
            $this->price = null; //the user might give an empty string for price
        }
    }

    /**
     * Hakee drinkkejä tietokannasta hakutermin ja muiden parametrien perusteella
     * @param string $searchterm    Käyttäjän antama hakutermi
     * @param type $orderby         Järjestys jossa drinkit haetaan
     * @param type $orderdir        Järjestyksen suunta (asc tai desc)
     * @param type $limit           Kuinka monta tulosta palautetaan
     * @param type $page            Millä sivulla ollaan selaamassa drinkkejä. Vaikuttaa siihen mistä kohdasta listaa tuloksia aletaan palauttaa
     * @return type                 Palauttaa listan drinkeistä
     */
    public function getCocktails($searchterm, $orderby, $orderdir, $limit, $page) {

        $sql = "SELECT cocktail.id, cocktail.cocktailname, recipe, price, suggestion::int, round(avg(rating.rating), 2) as rating" .
                " from cocktail left join rating on cocktail.id = rating.cocktailid" .
                " where lower(cocktail.cocktailname) like lower(?)" .
                " group by cocktail.id, cocktail.cocktailname, recipe, price, suggestion" .
                " order by " . $orderby . " " . $orderdir . " nulls last LIMIT ? OFFSET ?";

        $searchterm = "%" . $searchterm . "%";

        $array = array($searchterm, $limit, ($page - 1) * $limit);
        return database::getList($sql, $array, 'cocktail');
    }

    /**
     * Hakee drinkkejä tietokannasta hakutermin ja muiden parametrien perusteella. Hakee vain drinkit, jotka eivät ole pelkkiä ehdotuksia
     * @param string $searchterm    Käyttäjän antama hakutermi
     * @param type $orderby         Järjestys jossa drinkit haetaan
     * @param type $orderdir        Järjestyksen suunta (asc tai desc)
     * @param type $limit           Kuinka monta tulosta palautetaan
     * @param type $page            Millä sivulla ollaan selaamassa drinkkejä. Vaikuttaa siihen mistä kohdasta listaa tuloksia aletaan palauttaa
     * @return type                 Palauttaa listan drinkeistä
     */
    public function getApprovedCocktails($searchterm, $orderby, $orderdir, $limit, $page) {

        return cocktail::getApprovedOrSuggestions($searchterm, $orderby, $orderdir, $limit, $page, 0);
    }

    /**
     * Hakee drinkkejä tietokannasta hakutermin ja muiden parametrien perusteella. Hakee vain pelkät ehdotukset
     * @param string $searchterm    Käyttäjän antama hakutermi
     * @param type $orderby         Järjestys jossa drinkit haetaan
     * @param type $orderdir        Järjestyksen suunta (asc tai desc)
     * @param type $limit           Kuinka monta tulosta palautetaan
     * @param type $page            Millä sivulla ollaan selaamassa drinkkejä. Vaikuttaa siihen mistä kohdasta listaa tuloksia aletaan palauttaa
     * @return type                 Palauttaa listan drinkeistä
     */
    public function getSuggestions($searchterm, $orderby, $orderdir, $limit, $page) {
        return cocktail::getApprovedOrSuggestions($searchterm, $orderby, $orderdir, $limit, $page, 1);
    }

    /**
     * Apufunktio joita getApprovedCocktails ja getSuggestions käyttävät
     * @param string $searchterm    Käyttäjän antama hakutermi
     * @param type $orderby         Järjestys jossa drinkit haetaan
     * @param type $orderdir        Järjestyksen suunta (asc tai desc)
     * @param type $limit           Kuinka monta tulosta palautetaan
     * @param type $page            Millä sivulla ollaan selaamassa drinkkejä. Vaikuttaa siihen mistä kohdasta listaa tuloksia aletaan palauttaa
     * @return type                 Palauttaa listan drinkeistä
     */
    public static function getApprovedOrSuggestions($searchterm, $orderby, $orderdir, $limit, $page, $suggestion) {
        $sql = "SELECT cocktail.id, cocktail.cocktailname, recipe, price, suggestion::int, round(avg(rating.rating), 2) as rating" .
                " from cocktail left join rating on cocktail.id = rating.cocktailid" .
                " where suggestion = ? and lower(cocktail.cocktailname) like lower(?)" .
                " group by cocktail.id, cocktail.cocktailname, recipe, price, suggestion" .
                " order by " . $orderby . " " . $orderdir . " nulls last LIMIT ? OFFSET ?";

        $searchterm = "%" . $searchterm . "%";
        $array = array($suggestion, $searchterm, $limit, ($page - 1) * $limit);
        $results = database::getList($sql, $array, 'cocktail');

        return $results;
    }

    /**
     * Hakee kannasta yhden drinkin id:n perusteella
     * @param type $id  drinkin id
     * @return type     palauttaa cocktail olion
     */
    public function getSingleCocktail($id) {
        $sql = "SELECT cocktail.id, cocktail.cocktailname, recipe, price, suggestion::int, round(avg(rating.rating), 2) as rating from cocktail left join rating on cocktail.id = rating.cocktailid where id = ?" .
                " group by cocktail.id, cocktail.cocktailname, recipe, price, suggestion";
        $array = array($id);
        return database::getSingle($sql, $array, 'cocktail');
    }

    /**
     * Lisää drinkin kantaan
     * @return type palauttaa onnistuiko lisäys vai ei
     */
    public function addCocktail() {
        $sql = "insert into cocktail(cocktailname, recipe, price, suggestion) values(?,?,?,?) returning id";

        $query = connection::getConnection()->prepare($sql);
        $ok = $query->execute(array($this->name, $this->recipe, $this->price, cocktail::booleanToSuggestionBit($this->suggestion)));

        if ($ok) {
            $this->id = $query->fetchColumn();
        }
        return $ok;
    }

    /**
     * Poistaa yhden drinkin kannasta
     * @param type $id drinkin id
     */
    public static function removeCocktail($id) {
        $sql = "delete from cocktail where id = ?";

        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($id));
    }

    /**
     * Päivittää drinkin tiedot
     * @param type $id  drinkin id
     * @param type $name    drinkin nimi
     * @param type $recipe  drinkin valmistusohje
     * @param null $price   drinkin hinta
     * @param type $suggestion  onko drinkki ehdotus vai ei
     */
    public function updateCocktail($id, $name, $recipe, $price, $suggestion) {
        $sql = "UPDATE cocktail SET cocktailname = ?, recipe = ?, price = ?, suggestion = ? WHERE id = ?";
        if ($price == '') {
            $price = null;
        }
        $query = connection::getConnection()->prepare($sql);

        $ok = $query->execute(array($name, $recipe, $price, cocktail::booleanToSuggestionBit($suggestion), $id));
    }

    /**
     * Lisää käyttäjälle arvosanan drinkille jolla on tämän olion id
     * @param type $username    käyttäjänimi joka antoi arvosanan
     * @param type $rating      arvosana
     */
    public function addRating($username, $rating) {
        if ($rating != '') {
            $sql = "insert into rating(rating, username, cocktailid) values(?,?,?)";
            $array = array($rating, $username, $this->getId());
            if ($this->ratingExists($username)) {
                $sql = "update rating set rating = ? where username = ? and cocktailid = ?";
            }

            database::nonReturningExecution($sql, $array);
        }
    }

    /**
     * Poistaa kaikki drinkin arvostelut kannasta
     * @param type $id  drinkin id
     */
    public static function removeRatings($id) {
        $sql = "delete from rating where cocktailid = ?";
        $query = connection::getConnection()->prepare($sql);
        $query->execute(array($id));
    }

    /**
     * Poistaa cocktail_ingredient_link taulusta drinkkiin liittyvät ainesosat
     * @param type $id  drinkin id
     */
    public static function removeIngredients($id) {
        $sql = "delete from cocktail_ingredient_link where cocktailid = ?";
        $array = array($id);
        database::nonReturningExecution($sql, $array);
    }

    /**
     * Palauttaa drinkkien määrän jotka kannasta löytyvät annetulla hakusanalla
     * @param string $searchterm    hakusana
     * @return type     palauttaa drinkkien määrän
     */
    public function numofCocktails($searchterm) {
        $sql = "SELECT COUNT(id) FROM cocktail where lower(cocktailname) like lower(?)";
        $searchterm = "%" . $searchterm . "%";
        $array = array($searchterm);

        return database::getCount($sql, $array);
    }

    /**
    * Palauttaa hyväksyttyjen drinkkien määrän jotka kannasta löytyvät annetulla hakusanalla
     * @param string $searchterm    hakusana
     * @return type     palauttaa drinkkien määrän
     */
    public function numofApprovedCocktails($searchterm) {

        $sql = "SELECT COUNT(id) FROM cocktail where suggestion =? and lower(cocktailname) like lower(?)";
        $searchterm = "%" . $searchterm . "%";
        $array = array(0, $searchterm);

        return database::getCount($sql, $array);
    }

    /**
    * Palauttaa ehdotettujen drinkkien määrän jotka kannasta löytyvät annetulla hakusanalla
     * @param string $searchterm    hakusana
     * @return type     palauttaa drinkkien määrän
     */
    public function numofSuggestions($searchterm) {

        $sql = "SELECT COUNT(id) FROM cocktail where suggestion =? and lower(cocktailname) like lower(?)";
        $searchterm = "%" . $searchterm . "%";
        $array = array(1, $searchterm);

        return database::getCount($sql, $array);
    }


    /**
     * Palauttaa tiedon siitä onko käyttäjä arvostellut jo kyseisen drinkin
     * @param type $username    käyttäjänimi
     * @return type palauttaa true tai false. True jos arvostelu löytyy
     */
    public function ratingExists($username) {
        $sql = "SELECT count (cocktailid) from rating where username = ? and cocktailid = ?";
        return database::getCount($sql, array($username, $this->getId())) > 0;
    }

    /**
     * tekee uuden drinkkiolion
     * @param type $result  olio josta luotavan olion tiedot löytyvät
     * @return palauttaa luomansa olion
     */
    public static function createNewOne($result) {
        $cocktail = new cocktail($result->id, $result->cocktailname, $result->recipe, $result->price, $result->suggestion, $result->rating);
        return $cocktail;
    }

    /**
     * Apufunktio joka muuttaa 1 arvoksi true ja 0 arvoksi false
     * @param type $bit 1 tai 0
     * @return boolean  palautettava totuusarvo
     */
    public static function suggestionbitToBoolean($bit) {
        if ($bit == 1) {
            return true;
        } else {
            return false;
        }
    }

      /**
     * Apufunktio joka muuttaa truen arvoksi 1 ja falsen arvoksi 0
     * @param type $suggestion  false tai true
     * @return boolean  palautettava numero
     */
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
