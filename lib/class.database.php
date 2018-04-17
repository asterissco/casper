<?php

    // se conectara con la base datos

    class database{

        //conecta con la base de datos
        static public function getPDO(){

            global $_database;

            //crea el objeto PDO
            return new PDO('mysql:host='.$_database['host'].';dbname='.$_database['name'], $_database['user'], $_database['pass']);

        }

    }

?>
