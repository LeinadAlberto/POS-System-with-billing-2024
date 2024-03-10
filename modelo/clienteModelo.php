<?php

require_once "conexion.php";

class ModeloCliente
{
    
    static public function mdlInfoClientes()
    {
        $stmt = Conexion::conectar()->prepare("select * from cliente");
        $stmt->execute();

        return $stmt->fetchAll();

        $stmt->close();
        $stmt->null;
    }

    static public function mdlRegCliente($data)
    {
        $rsCliente = $data["rsCliente"];
        $nitCI = $data["nitCI"];
        $dirCliente = $data["dirCliente"];
        $nomCliente = $data["nomCliente"];
        $telCliente = $data["telCliente"];
        $emailCliente = $data["emailCliente"];

        $stmt = Conexion::conectar()->prepare("insert into cliente(razon_social_cliente, nit_ci_cliente, direccion_cliente, nombre_cliente, telefono_cliente, email_cliente) values('$rsCliente', '$nitCI', '$dirCliente', '$nomCliente', '$telCliente', '$emailCliente')");

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