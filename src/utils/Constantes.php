<?php

namespace utils;

class Constantes
{
    //put your code here
    const TWIG_FOLDER = "vista";

    const PARAMETER_NAME_CONTROLLER = "c";

    const PARAMETER_NAME_ACTION = "a";
    /**
     * Controladores
     */
    const TEST_CONTROLLER = "test";
    const HOME_CONTROLLER = "index";
    const MAINTENANCE_CONTROLLER = "maintenance";
    const BOLSA_TRABAJO_CONTROLLER = "bolsa_trabajo";
    const VENTA_LIBROS_CONTROLLER = "venta_libros";
    const TAREAS_CONTROLLER = "tareas";
    const CRUD_CONTROLLER = "crud_users";
    const LOGIN_CONTROLLER = "login_users";
    const PROGRAMACIONES_CONTROLLER = "programaciones";
    const DOCUMENTOS_CONTROLLER = "documentos";
    const CONTABILIDAD_CONTROLLER = "contabilidad";
    const DISCONNECT_CONTROLLER = "disconnect";
    const DEPARTMENTS_CONTROLLER = "departments";
    const TIC_USERS_CONTROLLER = "tic_users";

    /**
     * Variables de sesión.
     */
    const SESS_USER = "USER_ID";
    
    /**
     * Palabras clave.
     */
    const PERMISO_ALUMNO = "alumno";
    const PERMISO_PROFESOR = "profesor";
    const PERMISO_ADMIN = "admin";
    const PERMISO_INCIDENCIAS_TIC = "incidencias tic";
    const PERMISO_EMPRESA = "EMPRESA";
    
    /**
     * id_rol.
     */
    const ID_ROL_ALUMNO = 1;
    const ID_ROL_PROFESOR = 2;
    const ID_ROL_ADMIN = 3;
    const ID_INCIDENCIAS_TIC = 4;
    const ID_ROL_EMPRESA = 5;
    
    const CARPETA_DOCUMENTOS_DIRECCION  = "DocumentosDireccion";
    const SEGUIMIENTO_PROGRAMACIONES_CONTROLLER = "seguimiento_programaciones";
}
