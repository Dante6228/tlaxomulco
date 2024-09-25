<?php

require_once __DIR__ . '/config.php';

class Conexion {

    private static $pdo = null;

    public static function connection() {
        if (self::$pdo !== null) {
            return self::$pdo;
        }
        try {
            self::$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASSWORD);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$pdo;
        } catch (PDOException $e) {
            print "Error de conexión a la base de datos: " . $e->getMessage() . "<br>";
            return null;
        }
    }
}
