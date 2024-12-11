<?php
///modelo
require_once (__DIR__ . '/sistema.class.php');
class Empleado extends Sistema
{
    function getAll()
    {
        $this->conect();
        $stmt = $this->conn->prepare("select *
        from empleado");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }
    function getOne($id_empleado)
    {
        $this->conect();
        $stmt = $this->conn->prepare("select *
        from empleado where id_empleado = :id_empleado");
        $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = array();
        $datos = $stmt->fetchAll();
        if (isset ($datos[0])) {
            $this->setCount(count($datos));
            return $datos[0];
        }
        return array($datos);
    }
    function insert($datos)
    {
        $this->conect();

        if (isset ($datos['listaDeDispositivos'])) {
            // Obtener la imagen codificada
            $imagenCodificada = $datos['listaDeDispositivos'];
            // Verificar si hay un encabezado y eliminarlo si existe
            $encabezado = "data:image/png;base64,";
            if (strpos($imagenCodificada, $encabezado) === 0) {
                $imagenCodificada = substr($imagenCodificada, strlen($encabezado));
            }
            // Decodificar la imagen
            $imagenDecodificada = base64_decode($imagenCodificada);
        } else {
            exit ("No se recibió ninguna imagen");
        }

        if ($this->validateEmpleado($datos)) {
            $stm = $this->conn->prepare("INSERT INTO empleado (primer_apellido, segundo_apellido, nombre, rfc, curp, fotografia) VALUES
            (:primer_apellido, :segundo_apellido, :nombre, :rfc, :curp, :fotografia)");
            $stm->bindParam(":primer_apellido", $datos['primer_apellido'], PDO::PARAM_STR);
            $stm->bindParam(":segundo_apellido", $datos['segundo_apellido'], PDO::PARAM_STR);
            $stm->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
            $stm->bindParam(":rfc", $datos['rfc'], PDO::PARAM_STR);
            $stm->bindParam(":curp", $datos['curp'], PDO::PARAM_STR);
            $stm->bindParam(":fotografia", $imagenDecodificada, PDO::PARAM_LOB);
            $stm->execute();
            return $stm->rowCount();
        }

        return 0;
    }


    function delete($id_empleado)
    {
        $this->conect();
        $stm = $this->conn->prepare("DELETE FROM empleado  WHERE id_empleado= :id_empleado");
        $stm->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        $stm->execute();
        return $stm->rowCount();
    }
    function update($id_empleado, $datos)
    {
        $this->conect();

        $stm = $this->conn->prepare("UPDATE empleado SET primer_apellido= :primer_apellido, 
        segundo_apellido=:segundo_apellido, nombre=:nombre, rfc=:rfc, curp=:curp
        WHERE id_empleado=:id_empleado");
        $stm->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        $stm->bindParam(':primer_apellido', $datos['primer_apellido'], PDO::PARAM_STR);
        $stm->bindParam(':segundo_apellido', $datos['segundo_apellido'], PDO::PARAM_STR);
        $stm->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stm->bindParam(':rfc', $datos['rfc'], PDO::PARAM_STR);
        $stm->bindParam(':curp', $datos['curp'], PDO::PARAM_STR);
        $stm->execute();
        return $stm->rowCount();
    }
    function validarRFC($rfc)
    {
        $regex = '/^[A-Z]{4}[0-9]{6}[A-Z0-9]{3}$/';
        return preg_match($regex, $rfc);
    }
    function validarCURP($curp)
    {
        $regex = '/^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9]{2}$/';
        return preg_match($regex, $curp);
    }

    function validateEmpleado($dato)
    {
        if (empty ($dato['nombre'])) {
            return false;
        }
        if (empty ($dato['rfc'])) {
            return false;
        }
        if (empty ($dato['curp'])) {
            return false;
        }
        if (!$this->validarRFC($dato['rfc'])) {
            return false;
        }
        if (!$this->validarCURP($dato['curp'])) {
            return false;
        }
        return true;
    }
}