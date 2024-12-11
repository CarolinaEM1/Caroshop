<?php
///modelo
require_once(__DIR__ . '/sistema.class.php');
class Cliente extends Sistema
{
    function getAll()
    {
        $this->conect();
        $stmt = $this->conn->prepare("select *
        from cliente");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }
    function getOne($id_cliente)
    {
        $this->conect();
        $stmt = $this->conn->prepare("select *
        from cliente where id_cliente = :id_cliente");
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
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

        if ($this->validatecliente($datos)) {
            $stm = $this->conn->prepare("insert into cliente(primer_apellido, segundo_apellido, nombre, rfc) values
                (:primer_apellido,:segundo_apellido,:nombre, :rfc)");
            $stm->bindParam(":primer_apellido", $datos['primer_apellido'], PDO::PARAM_STR);
            $stm->bindParam(":segundo_apellido", $datos['segundo_apellido'], pdo::PARAM_STR);
            $stm->bindParam(":nombre", $datos['nombre'], pdo::PARAM_STR);
            $stm->bindParam(":rfc", $datos['rfc'], PDO::PARAM_STR);

            $stm->execute();
            return $stm->rowCount();
        }

        return 0;

    }

    function delete($id_cliente)
    {
        $this->conect();
        $stm = $this->conn->prepare("DELETE FROM cliente  WHERE id_cliente= :id_cliente");
        $stm->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stm->execute();
        return $stm->rowCount();
    }
    function update($id_cliente, $datos)
    {
        $this->conect();

        $stm = $this->conn->prepare("UPDATE cliente SET primer_apellido= :primer_apellido, 
        segundo_apellido=:segundo_apellido, nombre=:nombre, rfc=:rfc
        WHERE id_cliente=:id_cliente");
        $stm->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stm->bindParam(':primer_apellido', $datos['primer_apellido'], PDO::PARAM_STR);
        $stm->bindParam(':segundo_apellido', $datos['segundo_apellido'], PDO::PARAM_STR);
        $stm->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stm->bindParam(':rfc', $datos['rfc'], PDO::PARAM_STR);
        $stm->execute();
        return $stm->rowCount();
    }

    function validatecliente($datos)
    {
        if (empty($datos['nombre'])) {
            return false;
        }


        return true;
    }
}