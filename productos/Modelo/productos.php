<?php
    
    require_once(__DIR__.'/../../db.php');
    if(!isset($_SESSION)) { 
        session_start(); 
    } 

    class Productos extends Conexion{
        
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
            $statement = $this->db->prepare("SELECT * FROM productos");
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getProducto($id){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM productos WHERE id = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function addProducto($codigo, $marca, $estado, $categoria, $precio, $existencia, $id_empleado, $id_proveedor){
            $statement = $this->db->prepare("INSERT INTO productos (codigo, marca, estado, categoria, precio, existencia, id_empleado, id_proveedor) VALUES (:codigo, :marca, :estado, :categoria, :precio, :existencia, :id_empleado, :id_proveedor)");
            $statement->bindParam(':codigo', $codigo);
            $statement->bindParam(':marca', $marca);
            $statement->bindParam(':estado', $estado);
            $statement->bindParam(':categoria', $categoria);
            $statement->bindParam(':precio', $precio);
            $statement->bindParam(':existencia', $existencia);
            $statement->bindParam(':id_empleado', $id_empleado);
            $statement->bindParam(':id_proveedor', $id_proveedor);
            if ($statement->execute()) {
                $id = $this->db->lastInsertId();
                $statement = $this->db->prepare("SELECT * FROM productos WHERE id = :id");
                $statement = $this->db->prepare("UPDATE productos SET tabla_id = :id WHERE id = :id");
                $statement->bindParam(':id',$id);
                $statement->execute();
                header('Location: ../../productos.php');
            }else{
                header('Location: ../../productos.php');
            }
        }
        
        public function setProducto($id, $codigo, $marca, $estado, $categoria, $precio, $existencia, $id_empleado, $id_proveedor, $desactivado){
            $rows = null;
            $statement = $this->db->prepare("UPDATE productos SET codigo=:codigo, marca=:marca, estado=:estado, categoria=:categoria, precio=:precio, existencia=:existencia, id_empleado=:id_empleado, id_proveedor=:id_proveedor, desactivado=:desactivado WHERE id = :id");
            $statement->bindParam(':id', $id);
            $statement->bindParam(':codigo', $codigo);
            $statement->bindParam(':marca', $marca);
            $statement->bindParam(':estado', $estado);
            $statement->bindParam(':categoria', $categoria);
            $statement->bindParam(':precio', $precio);
            $statement->bindParam(':existencia', $existencia);
            $statement->bindParam(':id_empleado', $id_empleado);
            $statement->bindParam(':id_proveedor', $id_proveedor);
            $statement->bindParam(':desactivado', $desactivado);
            if ($statement->execute()) {
                header('Location: ../../productos.php');
            }else{
                header('Location: ../../productos.php');
            }
        }

        public function getActivos(){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM productos WHERE desactivado = 0 OR desactivado is NULL");
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getEstatus($id){
            $rows = null;
            $statement = $this->db->prepare("SELECT desactivado FROM productos WHERE id = :id");
            $statement->bindParam(':id',$id);
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        
    }

?>