<?php
///modelo
require_once(__DIR__ .'/sistema.class.php');
class Marca extends Sistema
{
    function getAll()
    {
        $this->conect();
        $stmt = $this->conn->prepare("select id_marca, marca, fotografia from marca");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }
    function getOne($id_marca)
    {
        $this->conect();
        $stmt = $this->conn->prepare("select id_marca, marca, fotografia from marca
         where id_marca = :id_marca");
        $stmt->bindParam(':id_marca', $id_marca, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = array();
        $datos = $stmt->fetchAll();
        if (isset($datos[0])) {
            $this->setCount(count($datos));
            return $datos[0];
        }
        return array($datos);
    }
    function insert($datos)
    {
        $this->conect();
        $nombre_archivo = $this->upload('marcas');
        if ($nombre_archivo) {
            if ($this->validateMarca($datos)) {
                $stm = $this->conn->prepare("insert into marca(marca, fotografia) VAlUES
            (:marca, :fotografia)");
                $stm->bindParam(":marca", $datos['marca'], PDO::PARAM_STR);
                $stm->bindParam(":fotografia", $nombre_archivo, PDO::PARAM_STR);
                
                $stm->execute();
                return $stm->rowCount();
            }
        }
        return 0;
    }

    function delete($id_marca)
    {
        $this->conect();
        $stm = $this->conn->prepare("DELETE FROM marca  WHERE id_marca= :id_marca");
        $stm->bindParam(':id_marca', $id_marca, PDO::PARAM_INT);
        $stm->execute();
        return $stm->rowCount();
    }
    function update($id_marca, $datos)
    {
        $this->conect();
        $stm = $this->conn->prepare("UPDATE marca SET marca=:marca
         WHERE id_marca=:id_marca");
        $stm->bindParam(':id_marca', $id_marca, PDO::PARAM_INT);
        $stm->bindParam(':marca', $datos['marca'], PDO::PARAM_STR);

        $stm->execute();
        return $stm->rowCount();
    }

    function validateMarca($datos)
    {
        if (empty($datos['marca'])) {
            return false;
        }

        return true;
    }
}