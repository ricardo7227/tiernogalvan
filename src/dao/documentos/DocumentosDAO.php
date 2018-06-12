<?php

namespace dao\documentos;

use dao\DBConnection;
use PDO;
use \utils\documentos;
use utils\Constantes;
class DocumentosDAO{
   
    public function getDocumentosDAO(){         
        $dbConnection = new DBConnection();      
        try{       
            $documentos = (object)[];
            $db = $dbConnection->getConnection();           
            $sql = documentos\ConstantesDocumentos::GET_DOCUMENTS;
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $documentos = $stmt->fetchAll(PDO::FETCH_OBJ); 
            return $documentos;
        } catch (\Exception $exception) {   
            return -1;
        } finally {  
            $dbConnection->disconnect();
        }

    }
    
      public function getDocumentoCategoriaDAO($categoria){
        $dbConnection = new DBConnection();
        try{
            $documentos_categoria = (object)[];
            $db = $dbConnection->getConnection();
            $sql = documentos\ConstantesDocumentos::GET_DOCUMENT_CATEGORY;
            $stmt = $db->prepare($sql);
            $stmt->execute(array($categoria));
            $documentos_categoria = $stmt->fetchAll(PDO::FETCH_OBJ);  
            return $documentos_categoria; 
        } catch (\Exception $exception) {   
            return -1;
        } finally {  
            $dbConnection->disconnect();
        }
       
    }
    
    public function insertDocumentoDAO($documento,$idcategoria,$categoria) {
        $dbConnection = new DBConnection();
        $db = $dbConnection->getConnection();
        try{
            $sql = documentos\ConstantesDocumentos::INSERT_DOCUMENT;
            $db->beginTransaction();
            $stmt = $db->prepare($sql);
            $stmt->execute(array($documento['name'],$idcategoria));
            if(move_uploaded_file($documento['tmp_name'],Constantes::CARPETA_DOCUMENTOS_DIRECCION."/".$categoria ."/". $documento['name'])){
                $db->commit();
            }else{
                $db->rollback();
                return -1;;
            }
            return true;
        } catch (\Exception $exception) {   
            $db->rollback();
            return -1;
        } finally {  
            $dbConnection->disconnect();
        }
        
    }
   
    public function updateDocumentoDAO($id,$documento,$categoria,$old,$idcategoria){
        $dbConnection = new DBConnection();
        $db = $dbConnection->getConnection();
        $new = "";
        
        try{
            $sql = documentos\ConstantesDocumentos::UPDATE_DOCUMENT; 
            $db->beginTransaction();
            $stmt = $db->prepare($sql);
            $stmt->execute(array($documento,$id,$idcategoria));
            
            $old= Constantes::CARPETA_DOCUMENTOS_DIRECCION.'/'.$categoria.'/'.$old;
            if (strpos($documento, '.') !== false){
                $new = Constantes::CARPETA_DOCUMENTOS_DIRECCION.'/'.$categoria.'/'.$documento;
            }else{
                $pos = strpos($old,".",0);
                $extension = substr($old,$pos);
                $new = Constantes::CARPETA_DOCUMENTOS_DIRECCION.'/'.$categoria.'/'.$documento.'.'.$extension;
            }
            if (rename($old,$new)){
               $db->commit();
            }else{
               $db->rollback();
               return -1;
            }
            return $filas;
        } catch (\Exception $exception) {   
            return -1;
        } finally {  
            $dbConnection->disconnect();
        }
        
    } 
    
    public function deleteDocumentoDAO($id,$categoria,$documento) {
        $dbConnection = new DBConnection();
        $db = $dbConnection->getConnection();
        try{
            $sql = documentos\ConstantesDocumentos::DELETE_DOCUMENT;
            $db->beginTransaction();
            $stmt = $db->prepare($sql);
            $stmt->execute(array($id));
            $filas = $stmt->rowCount();
            $path= Constantes::CARPETA_DOCUMENTOS_DIRECCION.'/'.$categoria.'/'.$documento;
            if (unlink($path)){
                $db->commit();
                return $filas;
            }else{
                $db->rollback();
                return -1;
            }
        } catch (\Exception $exception) { 
            $db->rollback();
            return -1;
        } finally {  
            $dbConnection->disconnect();
        }
        
    }
}
