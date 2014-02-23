<?php
/**
 * Tietokantayhteyttä mallintava luokka
 */
class connection {

    /**
     * Ottaa yhteyden tietokantaan
     * @return \PDO 
     */
    public static function getConnection() {
        //create the connection object
        $connection = new PDO("pgsql:");

//make pdo to procue an exception when an error occurs:

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }

}
