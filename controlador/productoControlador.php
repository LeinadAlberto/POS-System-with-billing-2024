<?php

$ruta = parse_url($_SERVER["REQUEST_URI"]);

if ( isset($ruta["query"]) ) {
    if ( $ruta["query"] == "ctrRegProducto" || 
         $ruta["query"] == "ctrEditProducto" || 
         $ruta["query"] == "ctrEliProducto" ) {

        $metodo = $ruta["query"];
        $producto = new ControladorProducto();
        $producto->$metodo();
    }
}

class ControladorProducto 
{
    static public function ctrInfoProductos()
    {
        $respuesta = ModeloProducto::mdlInfoProductos();

        return $respuesta;
    }

    static public function ctrRegUsuario()
    {
        require "../modelo/usuarioModelo.php";

        /* Encriptación con password_hash (https://www.php.net/manual/es/function.password-hash.php) */
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $data = array(
            "loginUsuario" => $_POST["login"],
            "password" => $password,
            "perfil" => "Moderador"
        );

        $respuesta = ModeloUsuario::mdlRegUsuario($data);

        echo $respuesta;
    }

    static public function ctrInfoUsuario($id)
    {
        $respuesta = ModeloUsuario::mdlInfoUsuario($id);

        return $respuesta;
    }

    static public function ctrEditUsuario()
    {
        require "../modelo/usuarioModelo.php";

        if ($_POST["password"] == $_POST["passActual"]) {
            $password = $_POST["password"];
        } else {
            /* Encriptación con password_hash (https://www.php.net/manual/es/function.password-hash.php) */
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        }

        $data = array(
            "id" => $_POST["idUsuario"], 
            "password" => $password,
            "perfil" => $_POST["perfil"],
            "estado" => $_POST["estado"]
        );

        $respuesta = ModeloUsuario::mdlEditUsuario($data);

        echo $respuesta; 
    }

    static public function ctrEliUsuario()
    {
        require "../modelo/usuarioModelo.php";
        $id = $_POST["id"];

        $respuesta = ModeloUsuario::mdlEliUsuario($id);

        echo $respuesta;
    }

    

    


}