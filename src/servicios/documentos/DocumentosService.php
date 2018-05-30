<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace servicios\documentos;

use dao\documentos\DocumentosDAO;

class DocumentosService {
    
    public function getDocumentos($categoria){
        $dao = new DocumentosDAO();
        return $dao->getDocumentoCategoriaDAO($user);
    }
    public function insertDocumento($documento,$ruta,$categoria){
        $dao = new DocumentosDAO();
        return $dao->insertDocumentoDAO($documento,$ruta,$categoria);
    }
    public function updateDocumento($id,$documento,$ruta,$categoria){
        $dao = new DocumentosDAO();
        return $dao->updateDocumentoDAO($id,$documento,$ruta,$categoria);
    }
    public function deleteDocumento($id){
        $dao = new DocumentosDAO();
        return $dao->deleteDocumentoDAO($id);
    }
    
  
    
    
}
