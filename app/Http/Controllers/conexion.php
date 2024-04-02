<?php

namespace App\Http\Controllers;
use MongoDB\Client;

class ClaseConexion {
    public static $mongoClient;
    public static $mongoDB;

    public function __construct()
    {
        if (!isset(self::$mongoClient)) {
            self::$mongoClient = new Client('mongodb://localhost:27017');
        }

        if (!isset(self::$mongoDB)) {
            self::$mongoDB = self::$mongoClient->selectDatabase('ped_biblioteca');
        }
    }
}
