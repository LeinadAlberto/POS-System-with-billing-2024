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

    static public function mdlInfoUsuarios()
    {
        $stmt = Conexion::conectar()->prepare("select * from usuario");
        $stmt->execute();

        return $stmt->fetchAll();

        $stmt->close();
        $stmt->null;
    }

    static public function mdlRegUsuario($data)
    {
        $loginUsuario = $data["loginUsuario"];
        $password = $data["password"];
        $perfil = $data["perfil"];

        $stmt = Conexion::conectar()->prepare("insert into usuario(login_usuario, password, perfil) values('$loginUsuario', '$password', '$perfil')");

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt->null;
    }

    static public function mdlActualizarAcceso($fechaHora, $id)
    {
        $stmt = Conexion::conectar()->prepare("update usuario set ultimo_login = '$fechaHora' where id_usuario = '$id'");

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt->null;
    }

    static public function mdlInfoUsuario($id)
    {
        $stmt = Conexion::conectar()->prepare("select * from usuario where id_usuario = '$id'");
        $stmt->execute();

        return $stmt->fetch();

        $stmt->close();
        $stmt->null;
    }

    static public function mdlEditUsuario($data)
    {
        $id = $data["id"];
        $password = $data["password"];
        $perfil = $data["perfil"];
        $estado = $data["estado"];

        $stmt = Conexion::conectar()->prepare("update usuario set password = '$password', perfil = '$perfil', estado = '$estado' where id_usuario = '$id'");

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt->null;
    }

    static public function mdlEliUsuario($id)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM usuario WHERE id_usuario = '$id'");

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt->null;
    }
}