<?php

$ruta = parse_url($_SERVER["REQUEST_URI"]);

if ( isset($ruta["query"]) ) {
    if ( $ruta["query"] == "ctrRegCliente" || 
         $ruta["query"] == "ctrEditCliente" || 
         $ruta["query"] == "ctrEliCliente" ) {

        $metodo = $ruta["query"];
        $usuario = new ControladorCliente();
        $usuario->$metodo();
    }
}

class ControladorCliente
{

    static public function ctrInfoClientes()
    {
        $respuesta = ModeloCliente::mdlInfoClientes();

        return $respuesta;
    }

    static public function ctrRegCliente()
    {
        require "../modelo/clienteModelo.php";

        $data = array(
            "rsCliente" => $_POST["rsCliente"],
            "nitCI" => $_POST["nitCI"],
            "dirCliente" => $_POST["dirCliente"],
            "nomCliente" => $_POST["nomCliente"],
            "telCliente" => $_POST["telCliente"],
            "emailCliente" => $_POST["emailCliente"]
        );

        $respuesta = ModeloCliente::mdlRegCliente($data);

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