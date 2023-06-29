<?php

    require_once "../modelos/Provincia.php";//Llamo al modelo para poder usar los métodos declarados en el modelo

    //Instanciamos un objeto de clase Provincia
    $provincia = new Provincia();
    
    $idprovincia = isset($_POST["idprovincia"])? limpiarCadena($_POST["idprovincia"]):"";
    $nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $distritos = isset($_POST["distritos"])? limpiarCadena($_POST["distritos"]):"";

    switch ($_GET["op"]){
        case 'guardaryeditar':
            if (empty($idprovincia)){
                $rspta=$provincia->insertar($nombre,$distritos);
                echo $rspta ? "Provincia registrada" : "Provincia no se pudo registrar";
            }else{
                $rspta=$provincia->editar($idprovincia,$nombre,$distritos);
                echo $rspta ? "Provincia actualizada" : "Provincia no se pudo actualizar";
            }
        break;

        case 'desactivar':
            $rspta=$provincia->desactivar($idprovincia);
            echo $rspta ? "Provincia desactivada" : "Provincia no se pudo desactivar";
        break;

        case 'activar':
            $rspta=$provincia->activar($idprovincia);
            echo $rspta ? "Provincia activada" : "Provincia no se pudo activar";
        break;

        case 'mostrar':
            $rspta=$provincia->mostrar($idprovincia);
            //Codificamos el resultado utilizando json
            echo json_encode($rspta);
        break;

        case 'listar':

            $respuesta=$provincia->listar();

            $data=Array();

            while($respt=$respuesta->fetch_object()){

                $data[]=array(

                    "0"=>($respt->estado) ?'<button class="btn btn-warning" onclick="mostrar('.$respt->idprovincia.')"><i class="fa fa-pencil"></i></button>'.
                                        ' <button class="btn btn-danger" onclick="desactivar('.$respt->idprovincia.')"><i class="fa fa-close"></i></button>':
                                        '<button class="btn btn-warning" onclick="mostrar('.$respt->idprovincia.')"><i class="fa fa-pencil"></i></button>'.
                                        ' <button class="btn btn-primary" onclick="activar('.$respt->idprovincia.')"><i class="fa fa-check"></i></button>',
                    "1"=>$respt->nombre,
                    "2"=>$respt->distritos,
                    "3"=>($respt->estado)?'<spam class="label bg-green">Activado</spam>':'<spam class="label bg-red">Desactivado</spam>',
                );
            }
 
            $result=array(

                "echo"=>1,
                "totalrecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);

                echo json_encode($result);


        break;
    }

?>