<?php

require_once './database/DBHandler.php'; // Incluir la clase DBHandler

class UsuariosModel {
    // ATRIBUTOS DE CLASE
    private $dbHandler; // INSTANCIA DE LA CLASE DBHANDLER
    private $conexion;  // LA CONEXIÓN A LA BDD
    private $tabla = "usuarios"; // Nombre de la tabla

    public function __construct() {
        // iNICIALIZAR DBHANDLER
        $this->dbHandler = new DBHandler("localhost","root","","tattoos_bd","3306");
    }

    public function getUsuario($idUsuario) {
        // 1º Realizar la conexión
        $this->conexion = $this->dbHandler->connect();

        // a) CREAR LA QUERY
        $sql = "SELECT * FROM $this->tabla WHERE id = ?";
        // b) preparar la statement
        $stmt = $this->conexion->prepare($sql);
        // c) cambiar ? por los valores
        $stmt->bind_param("i", $idUsuario);

        // EJECUTAR LA SENTENCIA SQL
        $stmt->execute();   // Ejecutamos la query
        $resultado = $stmt->get_result(); // extraemos el resultado obtenido -> una "lista" de registros de la BD
        $usuarios = [];
        while($fila = $resultado->fetch_assoc()) {
            $usuarios[] = $fila;
        }
        print_r($usuarios);

    }

    public function login($email, $password)
    {
        // 1º Realizar la conexión
        $this->conexion = $this->dbHandler->connect();

        // a) CREAR LA QUERY
        $sql = "SELECT email, password FROM $this->tabla WHERE email = ? AND password = ?";
        // b) preparar la statement
        $stmt = $this->conexion->prepare($sql);
        // c) cambiar ? por los valores
        $stmt->bind_param("ss",$email, $password);

        // EJECUTAR LA SENTENCIA SQL
        $stmt->execute();   // Ejecutamos la query
        $resultado = $stmt->get_result(); // extraemos el resultado obtenido -> una "lista" de registros de la BD
        $usuarios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = $fila;
        }

        if(!empty($usuarios)) {
            echo "Bienvenid@".$email;
        } else {
            echo "ACCESO DENEGADO";
        }
    }

    public function insertUsuario($email, $password)
    {
        // 1º Realizar la conexión
        $this->conexion = $this->dbHandler->connect();

        // a) CREAR LA QUERY
        $sql = "INSERT INTO $this->tabla (email, password) VALUES (?,?)";
        // b) preparar la statement
        $stmt = $this->conexion->prepare($sql);
        // c) cambiar ? por los valores
        $stmt->bind_param("ss", $email, $password);

        // EJECUTAR LA SENTENCIA SQL
        $stmt->execute();   // Ejecutamos la query -> DEVUELVE TRUE O FALSE
        
    }

}