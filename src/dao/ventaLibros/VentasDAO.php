<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VentasDAO
 *
 * @author Miguel
 */

namespace dao\ventaLibros;

use dao\DBConnection;
use PDO;

class VentasDAO {
    
    public function addVenta($venta){
        $db = new DBConnection();
        $conn = $db->getConnection();
        
        $stmt = $conn->prepare("INSERT INTO venta_libros (id_vendedor, email, titulo, isbn, precio, asignatura, curso, fecha_publicacion, estado) VALUES (?,?,?,?,?,?,?,?,'A la venta')");
        
        $stmt->bindParam(1, $venta->id_vendedor);
        $stmt->bindParam(2, $venta->email);
        $stmt->bindParam(3, $venta->titulo);
        $stmt->bindParam(4, $venta->isbn);
        $stmt->bindParam(5, $venta->precio);
        $stmt->bindParam(6, $venta->asignatura);
        $stmt->bindParam(7, $venta->curso);
        $stmt->bindParam(8, $venta->fecha_publicacion);
        
        $insertado = $stmt->execute();
        
        $db->disconnect();
        return $insertado;
    }
    
    public function getAllVentas($filt_asig, $filt_curso, $orden, $numPag){
        $db = new DBConnection();
        $conn = $db->getConnection();
        
        $sql = "SELECT * FROM venta_libros WHERE estado != 'Reservado'";
        
        if($filt_asig != "cualquiera"){
            $sql = $sql . " AND asignatura = '" . $filt_asig . "'";
        }
        
        if($filt_curso != "cualquiera"){
            $sql = $sql . " AND curso = '" . $filt_curso . "'";
        }
        
        $sql = $sql . " ORDER BY " . $orden . " ASC LIMIT 5 OFFSET " . ($numPag-1)*5;
        
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $ventas = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        $db->disconnect();
        return $ventas;
    }
    
    public function getMisVentas($id){
        $db = new DBConnection();
        $conn = $db->getConnection();
        
        $stmt = $conn->prepare("SELECT * FROM venta_libros WHERE id_vendedor = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        $mis_ventas = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        $db->disconnect();
        return $mis_ventas;
    }
    
    public function resVenta($id_venta, $id_usuario){
        $db = new DBConnection();
        $conn = $db->getConnection();
        
        $actualizado;
        
        $stmt = $conn->prepare("UPDATE venta_libros SET estado = 'Reservado', id_comprador = ? WHERE id = ?");
        $stmt->bindParam(1, $id_usuario);
        $stmt->bindParam(2, $id_venta);
        $stmt->execute();
        
        if (($stmt->rowCount()) > 0){
            $actualizado = true;
        }else{
            $actualizado = false;
        }
        
        $db->disconnect();
        return $actualizado;
    }
    
    public function editVenta($venta){
        $db = new DBConnection();
        $conn = $db->getConnection();
        
        $actualizado;
        
        $stmt = $conn->prepare("UPDATE venta_libros SET titulo = ?, isbn = ?, precio = ?, asignatura = ?, curso = ?, estado = ? WHERE id = ?");
        $stmt->bindParam(1, $venta->titulo);
        $stmt->bindParam(2, $venta->isbn);
        $stmt->bindParam(3, $venta->precio);
        $stmt->bindParam(4, $venta->asignatura);
        $stmt->bindParam(5, $venta->curso);
        $stmt->bindParam(6, $venta->estado);
        $stmt->bindParam(7, $venta->id);
        $stmt->execute();
        
        if (($stmt->rowCount()) > 0){
            $actualizado = true;
        }else{
            $actualizado = false;
        }
        
        $db->disconnect();
        return $actualizado;
    }
    
    public function delVenta($id){
        $db = new DBConnection();
        $conn = $db->getConnection();
        
        $borrado;
        
        $stmt = $conn->prepare("DELETE FROM venta_libros WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        if (($stmt->rowCount()) > 0){
            $borrado = true;
        }else{
            $borrado = false;
        }
        
        $db->disconnect();
        return $borrado;
    }
    
    public function getUser($id){
        $db = new DBConnection();
        $conn = $db->getConnection();
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        $db->disconnect();
        return $user;
    }
    
    public function getNumVentas($filt_asig, $filt_curso){
        $db = new DBConnection();
        $conn = $db->getConnection();
        
        $sql = "SELECT * FROM venta_libros WHERE estado != 'Reservado'";
        
        if($filt_asig != "cualquiera"){
            $sql = $sql . " AND asignatura = '" . $filt_asig . "'";
        }
        
        if($filt_curso != "cualquiera"){
            $sql = $sql . " AND curso = '" . $filt_curso . "'";
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $ventas = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        $db->disconnect();
        return $ventas;
    }
}
