<?php

namespace config;
/*
 * INFORMACIÓN IMPORTANTE, LEER:
 * SE USA LA DB ACTUAL, NO SE MODIFICA YA QUE AHORRAMOS TIEMPO PARA EL TRABAJO GRUPAL.
 * SI TENÍAIS UNA DB ANTIGUA, EXPORTARLA Y LUEGO LA IMPORTÁIS EN LA ACTUAL.
 * LA CONEXIÓN ACTUAL SÓLO SE USARÁ PARA ESTE PROYECTO.
 * PENSAR QUE SI SEGUÍS USANDO OTRA, OS VA A TOCAR PASARLO IGUALMENTE,
 * LA BASE DE DATOS EN EL INSTI VA A ESTAR CENTRALIZADA.
 * AHORRÁOS TRABAJO PARA DENTRO DE DOS SEMANAS :)
 */
class Config
{

    const MAIL_SERVER = "smtp.gmail.com";
    const MAIL_USER = "alumno1@iesquevedo.es";
    const MAIL_PASSWORD = "alumnodam2";
    const MAIL_PORT = 587;

    /*const DB_SERVER_NAME = "db4free.net:3307";
    const DB_USER_NAME = "appbanco";
    const DB_PASSWORD = "appbanco";
    const DB_DATABASE = "appbanco";*/
    
    const DB_SERVER_NAME = "localhost:3306";
    const DB_USER_NAME = "root";
    const DB_PASSWORD = "b0cX1n1v";
    const DB_DATABASE = "proyectofinal";

}
