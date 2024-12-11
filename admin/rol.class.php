<?php
///modelo
require_once (__DIR__ . '/sistema.class.php');
class Rol extends Sistema
{
    function getAll()
    {
        $this->conect();
        $stmt = $this->conn->prepare("select id_rol, rol from rol");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }
    function getPrivilegios()
    {
        $this->conect();
        $stmt = $this->conn->prepare("SELECT * from privilegio");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }
    function getRolesPrivileges($id_rol)
    {
        $this->conect();
        $stmt = $this->conn->prepare("SELECT r.id_rol, r.rol, p.id_privilegio, p.privilegio
                                      FROM rol r
                                      JOIN rol_privilegio rp ON r.id_rol = rp.id_rol
                                      JOIN privilegio p ON rp.id_privilegio = p.id_privilegio
                                      where r.id_rol = :id_rol");

        $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }
    function getOne($id_rol)
    {
        $this->conect();
        $stmt = $this->conn->prepare("select id_rol, rol from rol
         where id_rol = :id_rol");
        $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
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
        if ($this->validateRol($datos)) {
            $stm = $this->conn->prepare("insert into rol(rol) VAlUES
            (:rol)");
            $stm->bindParam(":rol", $datos['rol'], PDO::PARAM_STR);
            $stm->execute();
            $stmt = $this->conn->query("SELECT LAST_INSERT_ID()");
            $id_rol = $stmt->fetch(PDO::FETCH_COLUMN);
            foreach ($datos['privilegios'] as $id_privilegio) {
                $stmt = $this->conn->prepare("INSERT INTO rol_privilegio (id_rol, id_privilegio) VALUES (:id_rol, :id_privilegio)");
                $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                $stmt->bindParam(':id_privilegio', $id_privilegio, PDO::PARAM_INT);
                $stmt->execute();
            }
            return $stm->rowCount();
        }

        return 0;
    }

    function delete($id_rol)
    {
        $this->conect();
        $stmt = $this->conn->prepare("DELETE FROM rol_privilegio WHERE id_rol = :id_rol");
        $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $stmt->execute();
        $stm = $this->conn->prepare("DELETE FROM rol  WHERE id_rol= :id_rol");
        $stm->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $stm->execute();
      
        return $stm->rowCount();
    }
    function update($id_rol, $datos)
    {
        
        $this->conect();
        $stm = $this->conn->prepare("UPDATE rol SET rol=:rol
         WHERE id_rol=:id_rol");
        $stm->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $stm->bindParam(':rol', $datos['rol'], PDO::PARAM_STR);
        $stm->execute();
        // Elimina los privilegios asociados al rol
        $stmt = $this->conn->prepare("DELETE FROM rol_privilegio WHERE id_rol = :id_rol");
        $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $stmt->execute();
        // Inserta los nuevos privilegios seleccionados
        foreach ($datos['privilegios'] as $id_privilegio) {
            $stmt = $this->conn->prepare("INSERT INTO rol_privilegio (id_rol, id_privilegio) VALUES (:id_rol, :id_privilegio)");
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $stmt->bindParam(':id_privilegio', $id_privilegio, PDO::PARAM_INT);
            $stmt->execute();
        }
        return 1;

    }

    function validateRol($datos)
    {
        if (empty($datos['rol'])) {
            return false;
        }

        return true;
    }
}