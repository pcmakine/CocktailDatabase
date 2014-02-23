<?php

require_once "connection.php";

/**
 * Tarjoaa yleiskäyttöisiä funktioita tietokannan käyttämiseen
 */
class database {

    /**
     * Palauttaa listan tietokannastaan hakemia olioita. Tyyppi määräytyy parametrina saatavan luokan nimen mukaan
     * @param type $sql     suoritettava sql komento
     * @param type $array   sql komentoon upotettavat muuttujat
     * @param type $class   luokka jonka ilmentymiä palautetaan
     * @return type         lista palautettavista olioista
     */
    function getList($sql, $array, $class) {
        $query = connection::getConnection()->prepare($sql);
        $query->execute($array);

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $thing = $class::createNewOne($result);

            $results[] = $thing;
        }
        return $results;
    }

    /**
     * Palauttaa tietokannasta löytyvien rivien määrän
     * @param type $sql     suoritettava sql komento
     * @param type $array   sql komentoon upotettavat muuttujat
     * @return type         rivien määrä
     */
    function getCount($sql, $array) {
        $query = connection::getConnection()->prepare($sql);
        $query->execute($array);
        $rows = $query->fetchColumn();

        return $rows;
    }

    /**
     * Suorittaa tietokantaoperaation jonka ei tarvitse palautta mitään.
     * @param type $sql     suoritettava sql komento
     * @param type $array   sql komentoon upotettavat muuttujat
     */
    function nonReturningExecution($sql, $array) {
        $query = connection::getConnection()->prepare($sql);
        $query->execute($array);
    }

    /**
     * Palauttaa yhden tietokannasta haetun tiedon perusteella luodun olion
     * @param type $sql     suoritettava sql komento
     * @param type $array   sql komentoon upotettavat muuttujat
     * @param type $class   luokka jonka ilmentymäksi tietokannasta saadut tiedot luodaan
     * @return null         olio jonka funktio loi
     */
    function getSingle($sql, $array, $class) {
        $query = connection::getConnection()->prepare($sql);
        $query->execute($array);

        $result = $query->fetchObject();

        if ($result == null) {
            return null;
        }

        return $class::createNewOne($result);
    }

}

