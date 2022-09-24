<?php
    
    require_once(__DIR__.'/../../db.php');
    if(!isset($_SESSION)) { 
        session_start(); 
    } 

    class Compras extends Conexion{
        
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
            $statement = $this->db->prepare("SELECT * FROM compras");
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getCompra($id){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM compras WHERE id = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function addCompra($id_proveedor, $id_producto, $importe, $no_pedido){
            $statement = $this->db->prepare("INSERT INTO compras (id_proveedor, id_producto, fecha_pedido, fecha_factura, importe, no_pedido) VALUES (:id_proveedor, :id_producto, NOW(), NOW(), :importe, :no_pedido)");
            $statement->bindParam(':id_proveedor', $id_proveedor);
            $statement->bindParam(':id_producto', $id_producto);
            $statement->bindParam(':importe', $importe);
            $statement->bindParam(':no_pedido', $no_pedido);
            if ($statement->execute()) {
                $id = $this->db->lastInsertId();
                $statement = $this->db->prepare("SELECT * FROM compras WHERE id = :id");
                $statement = $this->db->prepare("UPDATE compras SET tabla_id = :id WHERE id = :id");
                $statement->bindParam(':id',$id);
                $statement->execute();
                header('Location: ../../compras.php');
            }else{
                header('Location: ../../compras.php');
            }
        }
        
        public function setCompra($id, $id_proveedor, $id_producto, $fecha_pedido, $fecha_factura, $importe, $no_pedido){
            $rows = null;
            $statement = $this->db->prepare("UPDATE compras SET id_proveedor=:id_proveedor, id_producto=:id_producto, fecha_pedido=:fecha_pedido, fecha_factura=:fecha_factura, importe=:importe, no_pedido=:no_pedido WHERE id = :id");
            $statement->bindParam(':id', $id);
            $statement->bindParam(':id_proveedor', $id_proveedor);
            $statement->bindParam(':id_producto', $id_producto);
            $statement->bindParam(':fecha_pedido', $fecha_pedido);
            $statement->bindParam(':fecha_factura', $fecha_factura);
            $statement->bindParam(':importe', $importe);
            $statement->bindParam(':no_pedido', $no_pedido);
            if ($statement->execute()) {
                header('Location: ../../compras.php');
            }else{
                header('Location: ../../compras.php');
            }
        }

        public function delete($id){
            $statement = $this->db->prepare("DELETE FROM compras WHERE id = :id");
            $statement->bindParam(':id',$id);
            if ($statement->execute()) {
                header('Location: ../../compras.php');
            }else{
                header('Location: ../../compras.php');
            }
        }
        
    }

?>