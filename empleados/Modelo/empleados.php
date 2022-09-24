<?php
    
    require_once(__DIR__.'/../../db.php');
    if(!isset($_SESSION)) { 
        session_start(); 
    } 

    class Empleados extends Conexion{
        
        public function __construct(){
            $this->db = parent::__construct();
        }

        public function login($correo){
            // $rows = null;
            $statement = $this->db->prepare("SELECT * FROM empleados WHERE correo = :correo LIMIT 1");
            $statement->bindParam(':correo',$correo);
            if ($statement->execute()) {
                $empleado = $statement->fetch();
                if($empleado!=null){
                    if ($empleado['desactivado'] == FALSE) {
                        $_SESSION["userId"] = $empleado['id'];
                        return(1);
                        //header('Location:../../home.php');    
                    } else {
                        header('Location: ../../index.php');
                    }
                }else{
                    header('Location: ../../index.php');
                }
            }else{
                header('Location: ../../index.php');
            }
        }

        public function addEmpleado($nombre,$apellidos,$direccion,$telefono,$correo){
            $statement = $this->db->prepare("INSERT INTO empleados (nombre, apellidos, direccion, telefono, correo) VALUES (:nombre, :apellidos, :direccion, :telefono, :correo)");
            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':apellidos', $apellidos);
            $statement->bindParam(':direccion', $direccion);
            $statement->bindParam(':telefono', $telefono);
            $statement->bindParam(':correo', $correo);
            if ($statement->execute()) {
                $id = $this->db->lastInsertId();
                $statement = $this->db->prepare("SELECT * FROM empleados WHERE id = :id");
                $statement = $this->db->prepare("UPDATE empleados SET tabla_id = :id WHERE id = :id");
                $statement->bindParam(':id',$id);
                $statement->execute();
                header('Location: ../../empleados.php');
            }else{
                header('Location: ../Vista/add.php');
            }
        }

        public function get(){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM empleados");
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
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

        public function setEmpleado($id,$nombre,$apellidos,$direccion,$telefono,$correo,$desactivado){
            $rows = null;
            $statement = $this->db->prepare("UPDATE empleados SET nombre=:nombre, apellidos=:apellidos, direccion=:direccion, telefono=:telefono, correo=:correo, desactivado=:desactivado WHERE id = :id");
            $statement->bindParam(':id',$id);
            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':apellidos', $apellidos);
            $statement->bindParam(':direccion', $direccion);
            $statement->bindParam(':telefono', $telefono);
            $statement->bindParam(':correo', $correo);
            $statement->bindParam(':desactivado', $desactivado);
            $statement->execute();
            if ($statement->execute()) {
                header('Location: ../../empleados.php');
            }else{
                header('Location: ../../empleados.php');
            }
        }

        public function getActivos(){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM empleados WHERE desactivado = 0 OR desactivado is NULL");
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

    }

?>