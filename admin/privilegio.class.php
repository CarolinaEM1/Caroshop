<?php
///modelo
require_once (__DIR__ . '/sistema.class.php');
class Privilegio extends Sistema
{
    function getAll()
    {
        $this->conect();
        $stmt = $this->conn->prepare("select id_privilegio, privilegio from privilegio");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }
    function getOne($id_privilegio)
    {
        $this->conect();
        $stmt = $this->conn->prepare("select id_privilegio, privilegio from privilegio
         where id_privilegio = :id_privilegio");
        $stmt->bindParam(':id_privilegio', $id_privilegio, PDO::PARAM_INT);
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
        if ($this->validateMarca($datos)) {
            $stm = $this->conn->prepare("insert into privilegio(privilegio) VAlUES
            (:privilegio)");
            $stm->bindParam(":privilegio", $datos['privilegio'], PDO::PARAM_STR);
            $stm->execute();
            return $stm->rowCount();
        }

        return 0;
    }

    function delete($id_privilegio)
    {
        $this->conect();
        $stm = $this->conn->prepare("DELETE FROM privilegio  WHERE id_privilegio= :id_privilegio");
        $stm->bindParam(':id_privilegio', $id_privilegio, PDO::PARAM_INT);
        $stm->execute();
        return $stm->rowCount();
    }
    function update($id_privilegio, $datos)
    {
        $this->conect();
        $stm = $this->conn->prepare("UPDATE privilegio SET privilegio=:privilegio
         WHERE id_privilegio=:id_privilegio");
        $stm->bindParam(':id_privilegio', $id_privilegio, PDO::PARAM_INT);
        $stm->bindParam(':privilegio', $datos['privilegio'], PDO::PARAM_STR);
        $stm->execute();
        return $stm->rowCount();
    }

    function validateMarca($datos)
    {
        if (empty($datos['privilegio'])) {
            return false;
        }

        return true;
    }
}