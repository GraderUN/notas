 <?php
header("Content-Type: application/json");
include_once("../clases/classTipoNota.php");
switch($_SERVER['REQUEST_METHOD']){
    case 'POST':  //Guardar un tipo nota
        $_POST = json_decode(file_get_contents('php://input'),true);
        $tipoNota = new TipoNota(NULL,$_POST["tipoNotasNombre"],$_POST["tipoNotasIdClase"]);
        $resultado["id"] = $tipoNota->guardarTipoNota();
        echo json_encode($resultado);
    break; 
    case 'GET':  //Obtener tipos de nota/s 
        if(isset($_GET['tipoNotaId'])){  //Tipos de notas por Id
            TipoNota::obtenerTipoNotasId($_GET['tipoNotaId']);
        }else{                      //Todas las notas
            TipoNota::obtenerTipoNotas();
        }
    break;
    case 'PUT':  //Actualizar nota
        $_PUT = json_decode(file_get_contents('php://input'),true);
        $tipoNota = new TipoNota(NULL,$_PUT["tipoNotasNombre"],$_PUT["tipoNotasIdClase"]);
        $resultado = $tipoNota->actualizarTipoNota($_GET['tipoNotaId']);
        echo json_encode($resultado);
    break;
    case 'DELETE': //Eliminar una nota
       if(isset($_GET['tipoNotaId'])){
        TipoNota::eliminarTipoNota($_GET['tipoNotaId']);
       }else{
        echo "0";
       }   
    break;
}
?>
