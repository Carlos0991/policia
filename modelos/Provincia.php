<?php

    //Llamamos a la conexion de base de datos
    require "../config/conexion.php";

    Class Provincia{
        //Implementamos el constructor
        public function __construct(){
            
        }

        //Implementamos método para insertar registros
        public function insertar($nombre, $distritos){
            $sql="INSERT INTO provincia (nombre,distritos,estado)
            VALUES ('$nombre','$distritos','1')";
            return ejecutarConsulta($sql);
        }

        //Implementamos un método para editar registros
        public function editar($idprovincia, $nombre, $distritos){
            $sql="UPDATE provincia SET nombre='$nombre', distritos='$distritos'
            WHERE idprovincia='$idprovincia'";
            return ejecutarConsulta($sql);
        }

        //Implementamos un metodo para desactivar categorias
        public function desactivar($idprovincia){
            $sql="UPDATE provincia SET estado='0' WHERE idprovincia='$idprovincia'";
            return ejecutarConsulta($sql);
        }

         //Implementamos un metodo para activar categorias
         public function activar($idprovincia){
            $sql="UPDATE provincia SET estado='1' WHERE idprovincia='$idprovincia'";
            return ejecutarConsulta($sql);
        }

        //Implementar un metodo para mostrar los datos de un registro a modificar
        public function mostrar($idprovincia){
            $sql="SELECT * FROM provincia WHERE idprovincia='$idprovincia'";
            return ejecutarConsultaSimpleFila($sql);
        }

        //Implementar un método para listar registros
        public function listar(){
            $sql="SELECT * FROM provincia";
            return ejecutarConsulta($sql);
        }

    }
?>