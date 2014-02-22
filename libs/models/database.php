<?php

require_once "connection.php";

class database {

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

    function getCount($sql, $array) {
        $query = connection::getConnection()->prepare($sql);
        $query->execute($array);
        $rows = $query->fetchColumn();

        return $rows;
    }

}

