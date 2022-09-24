<?php

    class Conexion{

        protected $db;
        private $driver = "mysql";
        private $host = "localhost";
        private $dbname = "ejercicio";
        private $empleado = "root";
        private $contrasena = "";

        public function __construct(){
            try {
                $db = new PDO("{$this->driver}:host={$this->host};dbname={$this->dbname}",$this->empleado,$this->contrasena);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $db;
            } catch (PDOException $e) {
                echo "Ha ocurrido un error al conectarse a la base de datos" . $e->getMessage();
            }
        }
    }

?>