<?php

namespace controllers;

use servicios\users\UsersServicios;
use utils\bolsaTrabajo\BuzonCorreo;
use utils\Constantes;
use utils\loginUsers\ConstantesLoginUsers;
use utils\PasswordStorage;
use utils\TwigViewer;


/**
 * Description of LoginUsers
 *
 * @author Erasto
 */
class LoginUsers
{

    public function login()
    {

        $page = ConstantesLoginUsers::START_PAGE;
        $usersSevicios = new UsersServicios();
        $parameters = array();

        $action = $_REQUEST[Constantes::PARAMETER_NAME_ACTION];

        if (isset($action)) {

            $PasswordStorage = new PasswordStorage();
            $user = new \stdClass;
            $user->pass = filter_input(INPUT_POST, ConstantesLoginUsers::PARAM_PASS);
            $user->nick = filter_input(INPUT_POST, ConstantesLoginUsers::PARAM_NICK);
            $user->nombre = filter_input(INPUT_POST, ConstantesLoginUsers::PARAM_NOMBRE);
            $user->apellidos = filter_input(INPUT_POST, ConstantesLoginUsers::PARAM_APELLIDOS);
            $user->telefono = filter_input(INPUT_POST, ConstantesLoginUsers::PARAM_TELEFONO);
            $user->email = filter_input(INPUT_POST, ConstantesLoginUsers::PARAM_EMAIL);
            $palabra_clave = filter_input(INPUT_POST, ConstantesLoginUsers::PARAM_PALABRA_CLAVE);

            switch ($action) {
                case ConstantesLoginUsers::LOGIN_USER:

                    $userChecked = $usersSevicios->getUserByNick($user);

                    if ($userChecked) {
                        $pass = $user->pass;
                        $hash = $PasswordStorage->create_hash($pass);

                        if ($PasswordStorage->verify_password($pass, $userChecked->pass)) {

                            if ($userChecked->activado === "1") {

                                $usersSevicios->updateFechaUser($userChecked);//Actualiza la fecha de logueo

                                $userChecked = $usersSevicios->getPermisoUser($userChecked);
                                $_SESSION[Constantes::SESS_USER] = $userChecked;
                                $parameters['mensaje'] = $userChecked->nombre . " " . $userChecked->apellidos;
                                $page = ConstantesLoginUsers::LOGIN_PAGE;

                            } else {
                                $parameters['mensaje'] = ConstantesLoginUsers::ACTIVO_NO;
                            }
                        } else {
                            $parameters['mensaje'] = ConstantesLoginUsers::LOGIN_NO;
                        }
                    } else {
                        $parameters['mensaje'] = ConstantesLoginUsers::LOGIN_ERROR;
                    }
                    break;

                case ConstantesLoginUsers::REGISTER_USER:


                    BuzonCorreo::getInstance()->setRemitenteNombre("REGISTRO");

                    if ($user->nick != null) {

                        $userChecked = $usersSevicios->getUserByNick($user);

                        if (!$userChecked) {

                            $user->pass = $PasswordStorage->create_hash($user->pass);
                            $user->activado = 0;

                            switch ($palabra_clave) {

                                case Constantes::PERMISO_ALUMNO:
                                    $user->id_rol = Constantes::ID_ROL_ALUMNO;
                                    break;

                                case Constantes::PERMISO_PROFESOR:
                                    $user->id_rol = Constantes::ID_ROL_PROFESOR;
                                    break;

                                case Constantes::PERMISO_ADMIN:
                                    $user->id_rol = Constantes::ID_ROL_ADMIN;
                                    break;
                                default:
                                    $parameters['mensaje'] = ConstantesLoginUsers::PERMISO_FAIL;
                                    break;
                            }
                            $user->codigo_activacion = $usersSevicios->random_code(ConstantesLoginUsers::TAMAÑO_RANDOM);
                            $userChecked = $usersSevicios->addUser($user);

                            if ($userChecked) {

                                $cod_act = $usersSevicios->random_code(ConstantesLoginUsers::TAMAÑO_RANDOM);

                                BuzonCorreo::getInstance()->enviarCorreo($user->email, "probando", "registro", "correo de prueba");

                                //$user->nombre . " " . $user->apellidos
                                //"<a href='localhost:8000/index.php?c=login_users?a=activar?cod_act='.$cod_act.'?nick='.$user->nick'>Pulsa aqui</a>"
                                //ttp://localhost:8000/index.php?c=login_users?a=activar?cod_act=".$cod_act."?nick=".$user->nick
                                $parameters['mensaje'] = ConstantesLoginUsers::SENT_EMAIL;

                            } else {
                                $parameters['mensaje'] = ConstantesLoginUsers::REGISTRO_ERROR;
                            }

                        } else {
                            $parameters['mensaje'] = ConstantesLoginUsers::INVALID_USER;
                        }

                        $page = ConstantesLoginUsers::REGISTRO_PAGE;

                    } else {
                        $page = ConstantesLoginUsers::REGISTRO_PAGE;
                    }

                    break;

                case ConstantesLoginUsers::ACTIVATE_USER:

                    $user->cod_act = $_REQUEST[ConstantesLoginUsers::COD_ACT];

                    $cod_ok = $usersSevicios->getCodAct($user);

                    if ($cod_ok) {

                        $user->activado = 1;

                        $activar = $usersSevicios->activarCuenta($user);

                        if ($activar) {
                            $parameters['mensaje'] = ConstantesLoginUsers::CUENTA_ACTIVADA;
                        } else {
                            $parameters['mensaje'] = ConstantesLoginUsers::ACTIVAR_FAIL;
                        }

                    } else {
                        $parameters['mensaje'] = ConstantesLoginUsers::INVALID_COD;

                    }

                    break;

                case ConstantesLoginUsers::RECUPERATE_PASS:

                    if ($user->nick != null) {
                        $userChecked = $usersSevicios->getUserByNick($user);

                        if ($userChecked) {
                            $pass_created = $usersSevicios->random_code(ConstantesLoginUsers::TAMAÑO_GENERAR_PASS);
                            $user->pass = $PasswordStorage->create_hash($pass_created);
                            $updateOk = $usersSevicios->updatePass($user);

                            if ($updateOk) {
                                //envia pass al cliente
                                $parameters['mensaje'] = ConstantesLoginUsers::EMAIL_SENT;

                            } else {
                                $parameters['mensaje'] = "fallo update";
                            }


                        } else {
                            $parameters['mensaje'] = "usuario no existe";
                        }
                    }

                    $page = ConstantesLoginUsers::RECUPERAR_PAGE;

                    break;

                case ConstantesLoginUsers::CHANGE_PASS:

                    $user->nuevo_pass = filter_input(INPUT_POST, ConstantesLoginUsers::NEW_PASS);

                    $userChecked = $usersSevicios->getUserByNick($user);

                    if ($userChecked) {

                        if ($PasswordStorage->verify_password($user->pass, $userChecked->pass)) {

                            $user->pass = $PasswordStorage->create_hash($user->nuevo_pass);
                            $passUpdated = $usersSevicios->updatePass($user);

                            if ($passUpdated) {
                                $parameters['mensaje'] = ConstantesLoginUsers::PASS_UP_YES;

                            } else {
                                $parameters['mensaje'] = ConstantesLoginUsers::PASS_UP_NO;
                            }

                        } else {
                            $parameters['mensaje'] = ConstantesLoginUsers::LOGIN_NO;
                        }
                    }
                    $page = ConstantesLoginUsers::SETTINGS_PAGE;
                    break;


            }
        }
        TwigViewer::getInstance()->viewPage($page, $parameters);
    }

}
