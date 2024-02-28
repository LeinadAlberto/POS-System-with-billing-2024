<?php

$ruta = parse_url($_SERVER["REQUEST_URI"]);

if (isset($ruta["query"])) {
    if ($ruta["query"] == "ctrRegUsuario" || $ruta["query"] == "ctrEditUsuario") {
        $metodo = $ruta["query"];
        $usuario = new ControladorUsuario();
        $usuario->$metodo();
    }
}

class ControladorUsuario 
{

    static public function ctrIngresoUsuario()
    {
        if (isset($_POST["usuario"])) {
            $usuario = $_POST["usuario"];
            $password = $_POST["password"];

            $resultado = ModeloUsuario::mdlAccesoUsuario($usuario);

            /* var_dump($resultado); */

            /* En el condicional se usa password_verify (https://www.php.net/manual/en/function.password-verify.php) */
            if ($resultado["login_usuario"] == $usuario && password_verify($password, $resultado["password"]) && $resultado["estado" == 1]) {
                /* Creando variables de sesión */
                $_SESSION["ingreso"] = "ok";
                $_SESSION["loginUsuario"] = $resultado["login_usuario"];
                $_SESSION["perfil"] = $resultado["perfil"];
                $_SESSION["idUsuario"] = $resultado["id_usuario"];

                date_default_timezone_set("America/La_Paz");
                $fecha = date("Y-m-d");
                $hora = date("H-i-s");
                $fechaHora = $fecha . " " . $hora;
                $id = $resultado["id_usuario"];

                $ultimoLogin = ModeloUsuario::mdlActualizarAcceso($fechaHora, $id);

                if ($ultimoLogin == "ok") {
                    echo "<script>
                        window.location = 'inicio';
                    </script>";
                }

            }
        }
    }

    static public function ctrInfoUsuarios()
    {
        $respuesta = ModeloUsuario::mdlInfoUsuarios();

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

    


}