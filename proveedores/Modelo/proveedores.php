<?php
    
    require_once(__DIR__.'/../../db.php');
    if(!isset($_SESSION)) { 
        session_start(); 
    } 

    class Proveedores extends Conexion{
        
        public function __construct(){
            $this->db = parent::__construct();
        }

        public function getEmpleado($id){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM empleados WHERE id = :id");
            $statement->bindParam(':id',$id);
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getEstatusEmpleado($id){
            $rows = null;
            $statement = $this->db->prepare("SELECT desactivado FROM empleados WHERE id = :id");
            $statement->bindParam(':id',$id);
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function get(){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM proveedores");
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getProveedor($id){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM proveedores WHERE id = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function addProveedor($nombre, $correo, $direccion){
            $statement = $this->db->prepare("INSERT INTO proveedores (nombre, correo, direccion) VALUES (:nombre, :correo, :direccion)");
            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':correo', $correo);
            $statement->bindParam(':direccion', $direccion);
            if ($statement->execute()) {
                $id = $this->db->lastInsertId();
                $statement = $this->db->prepare("SELECT * FROM proveedores WHERE id = :id");
                $statement = $this->db->prepare("UPDATE proveedores SET tabla_id = :id WHERE id = :id");
                $statement->bindParam(':id',$id);
                $statement->execute();
                header('Location: ../../proveedores.php');
            }else{
                header('Location: ../../proveedores.php');
            }
        }
        
        public function setProveedor($id, $nombre, $correo, $direccion, $desactivado){
            $rows = null;
            $statement = $this->db->prepare("UPDATE proveedores SET nombre=:nombre, correo=:correo, direccion=:direccion, desactivado=:desactivado WHERE id = :id");
            $statement->bindParam(':id', $id);
            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':correo', $correo);
            $statement->bindParam(':direccion', $direccion);
            $statement->bindParam(':desactivado', $desactivado);
            if ($statement->execute()) {
                header('Location: ../../proveedores.php');
            }else{
                header('Location: ../../proveedores.php');
            }
        }

        public function getActivos(){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM proveedores WHERE desactivado = 0 OR desactivado is NULL");
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getEstatus($id){
            $rows = null;
            $statement = $this->db->prepare("SELECT desactivado FROM proveedores WHERE id = :id");
            $statement->bindParam(':id',$id);
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        
    }

?>