<?php

require_once "conexion.php";

class ModeloUsuario
{
    /*======================
        ACCESO AL SISTEMA
    ========================*/
    static public function mdlAccesoUsuario($usuario)
    {
        $stmt = Conexion::conectar()->prepare("select * from usuario where login_usuario='$usuario'");
        $stmt->execute();

        return $stmt->fetch();

        $stmt->close();
        $stmt->null;
    }
}