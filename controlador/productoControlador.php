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
    /* Metodo para obtener todos los Productos */
    static public function ctrInfoProductos()
    {
        $respuesta = ModeloProducto::mdlInfoProductos();

        return $respuesta;
    }

    static public function ctrRegProducto()
    {
        require "../modelo/productoModelo.php";
        /* Obtiene el archivo de imagen cargado de los datos del formulario ($_FILES) bajo la clave "imgProducto". */
        $imagen = $_FILES["imgProducto"];
        /* Obtiene el nombre de la imagen cargada en el formulario */
        $imgNombre = $imagen["name"];
        /* Obtiene la ruta temporal de la imagen cargada en el formulario */
        $imgTmp = $imagen["tmp_name"];
        /* Mueve el archivo de imagen cargado desde su ubicación temporal a un directorio designado 
        para imágenes de productos ("assets/dist/img/productos/") con el nombre de archivo original */
        move_uploaded_file($imgTmp, "../assets/dist/img/productos/" . $imgNombre);

        $data = array(
            "codProducto" => $_POST["codProducto"],
            "codProductoSIN" => $_POST["codProductoSIN"],
            "desProducto" => $_POST["desProducto"],
            "preProducto" => $_POST["preProducto"],
            "unidadMedida" => $_POST["unidadMedida"],
            "unidadMedidaSIN" => $_POST["unidadMedidaSIN"],
            "imgProducto" => $imgNombre
        );

        $respuesta = ModeloProducto::mdlRegProducto($data);

        echo $respuesta;
    }

    static public function ctrInfoProducto($id)
    {
        $respuesta = ModeloProducto::mdlInfoProducto($id);

        return $respuesta;
    }

    static public function ctrEditProducto()
    {
        require "../modelo/productoModelo.php";

        /* Obtiene el archivo de imagen cargado de los datos del formulario ($_FILES) bajo la clave "imgProducto". */
        $imagen = $_FILES["imgProducto"];

        if ($imagen["name"] == "") {
            $imgNombre = $_POST["imgActual"];
        } else {
            /* Obtiene el nombre de la imagen cargada en el formulario */
            $imgNombre = $imagen["name"];
            /* Obtiene la ruta temporal de la imagen cargada en el formulario */
            $imgTmp = $imagen["tmp_name"];
            /* Mueve el archivo de imagen cargado desde su ubicación temporal a un directorio designado 
            para imágenes de productos ("assets/dist/img/productos/") con el nombre de archivo original */
            move_uploaded_file($imgTmp, "../assets/dist/img/productos/" . $imgNombre);
        }

        $data = array(
            "idProducto" => $_POST["idProducto"],
            "codProductoSIN" => $_POST["codProductoSIN"],
            "desProducto" => $_POST["desProducto"],
            "preProducto" => $_POST["preProducto"],
            "unidadMedida" => $_POST["unidadMedida"],
            "unidadMedidaSIN" => $_POST["unidadMedidaSIN"],
            "imgProducto" => $imgNombre,
            "estado" => $_POST["estado"]
        );

        $respuesta = ModeloProducto::mdlEditProducto($data);

        echo $respuesta; 
    }

    static public function ctrEliProducto()
    {
        require "../modelo/productoModelo.php";

        $id = $_POST["id"];

        $respuesta = ModeloProducto::mdlEliProducto($id);

        echo $respuesta;
    }

    

    


}