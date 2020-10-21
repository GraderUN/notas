<?php
include_once("../conexion/conexion.php");
class TipoNota{
    private $tipoNotasId;
    private $tipoNotaNombre;
    private $tipoNotaclase;

    public function __construct($tipoNotasId,$tipoNotaNombre,$tipoNotaclase){
        $this->tipoNotasId = $tipoNotasId;
        $this->tipoNotaNombre = $tipoNotaNombre;
        $this->tipoNotaclase = $tipoNotaclase;
    }
    // setters  
    public function settipoNotasId($tipoNotasId){
        $this->tipoNotasId = $tipoNotasId;
        return $this;
    }
    
    public function settipoNotaNombre($tipoNotaNombre){
        $this->tipoNotaNombre = $tipoNotaNombre;
        return $this;
    }
    public function settipoNotaclase($tipoNotaclase){
        $this->tipoNotaclase = $tipoNotaclase;
        return $this;
    }
    
    // getters
    public function gettipoNotasId(){
        return $this->tipoNotasId;
    }
    public function gettipoNotaNombre(){
        return $this->tipoNotaNombre;
    }
    public function gettipoNotaclase(){
        return $this->tipoNotaclase;
    }
    public function __toString(){
       return $this->tipoNotasId." ".$this->tipoNotaNombre." ".$this->tipoNotaclase." "; 
    }
    //--------- CRUD  -----------------//
    //----------Create ----------------//
    public function guardarTipoNota(){
        try{
            $ps=Conexion::conexionbd()->prepare("INSERT INTO tablaTipoNotas (tipoNotasId,tipoNotasNombre,tipoNotasIdClase) VALUES(?,?,?)");
            $ps->bindParam(1,$this->tipoNotasId);
            $ps->bindParam(2,$this->tipoNotaNombre);
            $ps->bindParam(3,$this->tipoNotaclase);  
            $ps->execute();
            //Return last id
            $id=Conexion::conexionbd()->prepare("SELECT MAX(tipoNotasId) AS id FROM tablaTipoNotas");
            $id->execute();
            $li=$id->fetch();
            $ps = null;
		} catch (Exception $e) {
        echo "Error al consultar".$e;
        }
        $this->tipoNotasId = $li['id'];
        $li = null;
        return $this->tipoNotasId;
    }
    //---------- Read all ----------------//
    public function obtenerTipoNotas(){
        try{
            $ps=Conexion::conexionbd()->prepare('Select * from tablaTipoNotas');
            $ps->execute();
           while ($fila = $ps->fetch(PDO::FETCH_ASSOC)) {
                $tipoNotasId  = $fila['tipoNotasId'];
                $tipoNotasNombre  = $fila['tipoNotasNombre'];
                $tipoNotasIdClase  = $fila['tipoNotasIdClase'];
                $datos[]=array('tipoNotasId'=>$tipoNotasId,'tipoNotasNombre'=>$tipoNotasNombre,'tipoNotasIdClase'=>$tipoNotasIdClase);
            }
		} catch (Exception $e) {
        echo "Error al consultar".$e;
        }
        //obtener las notas y devolverlas
        echo json_encode($datos);
        
    }
    //---------- Read one ----------------//   
    public static function obtenerTipoNotasId ($tipoNotasId){
        try {
            $ps=Conexion::conexionbd()->prepare('Select * from tablaTipoNotas where tipoNotasId=?');
            $ps->bindParam(1,$tipoNotasId);
            $ps->execute();
            $datos=$ps->fetch(PDO::FETCH_ASSOC);
            $ps = null;
        } catch (Exeption $e) {
            echo "Error al consultar".$e;
        }
        echo json_encode($datos);
     }
    //---------- update ---------------//  
    public function actualizarTipoNota($tipoNotasId){
        try{
            $ps=Conexion::conexionbd()->prepare("UPDATE tablaTipoNotas SET tipoNotasNombre=?, tipoNotasIdClase=? WHERE tipoNotasId=?");
            $ps->bindParam(1,$this->tipoNotaNombre);
            $ps->bindParam(2,$this->tipoNotaclase);
            $ps->bindParam(3,$tipoNotasId);  
            if($ps->execute())
            {
                $ps=Conexion::conexionbd()->prepare('Select * from tablaTipoNotas where tipoNotasId=?');
                $ps->bindParam(1, $tipoNotasId);
                $ps->execute();
                $datos=$ps->fetch(PDO::FETCH_ASSOC);
            }
            else
            {
                $datos= 0;
            }
            $ps = null;
        } catch (Exception $e) {
            echo "Error al insertar ".$e;
        }
        return $datos;
    }
    //---------- delete ----------------//
    public static function eliminarTipoNota($tipoNotasId){
        try{
            $ps=Conexion::conexionbd()->prepare("DELETE FROM tablaTipoNotas WHERE tipoNotasId=?");
            $ps->bindParam(1,$tipoNotasId);
            if($ps->execute()){
                $borrado["id"] = $tipoNotasId;
                $json_string = json_encode($borrado);
            }
            $ps = null;
        } catch (Exception $e){
            echo "Error al Eliminar ".$e;
        }
        echo $json_string;
    }
}
?>