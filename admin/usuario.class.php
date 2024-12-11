<?php
///modelo
require_once (__DIR__ . '/sistema.class.php');
class Usuario extends Sistema
{
    function getAll()
    {
        $this->conect();
        $stmt = $this->conn->prepare("select id_usuario, correo from usuario");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }
    function getOne($id_usuario)
    {
        $this->conect();
        $stmt = $this->conn->prepare("select id_usuario, correo from usuario
         where id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
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
    function getRoles(){
        $this->conect();
        $stmt = $this->conn->prepare("select id_rol, rol from rol");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;

    }
    function getRolesOne($id_usuario){
        $this->conect();
        $stmt = $this->conn->prepare("select r.id_rol, r.rol from rol r, usuario_rol ur where r.id_rol = ur.id_rol and ur.id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }
    function insert($datos)
    {
        $this->conect();
        $contra=md5($datos['password']);
        if ($this->validateMarca($datos)) {
            $stm = $this->conn->prepare("insert into usuario(correo, password) VAlUES
            (:correo, :password)");
            $stm->bindParam(":correo", $datos['correo'], PDO::PARAM_STR);
            $stm->bindParam(":password", $contra, PDO::PARAM_STR);
            $stm->execute();
            $stmt = $this->conn->query("SELECT LAST_INSERT_ID()");
            $id_usuario = $stmt->fetch(PDO::FETCH_COLUMN);
            $stm = $this->conn->prepare("insert into usuario_rol(id_usuario, id_rol) VAlUES
            (:id_usuario, :id_rol)");
            $stm->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stm->bindParam(":id_rol", $datos['id_rol'], PDO::PARAM_INT);
            $stm->execute();
            return $stm->rowCount();
        }

        return 0;
    }

    function delete($id_usuario)
    {
        $this->conect();
        $stm=$this->conn->prepare("DELETE FROM usuario_rol WHERE id_usuario=:id_usuario");
        $stm->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stm->execute();
        $stm = $this->conn->prepare("DELETE FROM usuario  WHERE id_usuario= :id_usuario");
        $stm->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stm->execute();
        return $stm->rowCount();
    }
    function update($id_usuario, $datos)
    {
        
        $this->conect();
        $contra=md5($datos['password']);
        $stm = $this->conn->prepare("UPDATE usuario SET correo=:correo, password=:password
         WHERE id_usuario=:id_usuario");
        $stm->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stm->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
        $stm->bindParam(':password', $contra, PDO::PARAM_STR);
        $stm->execute();
        $stm=$this->conn->prepare("UPDATE usuario_rol SET id_rol = :id_rol WHERE id_usuario = :id_usuario;");
        $stm->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stm->bindParam(':id_rol', $datos['id_rol'], PDO::PARAM_INT);
        $stm->execute();
        return $stm->rowCount();
    }

    function validateMarca($datos)
    {
        if (empty($datos['correo'])) {
            return false;
        }

        return true;
    }
}