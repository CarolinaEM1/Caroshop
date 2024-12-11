<?php
///modelo
require_once(__DIR__ .'/sistema.class.php');
class Tienda extends Sistema
{
    function getAll()
    {
        $this->conect();
        $stmt = $this->conn->prepare("select id_tienda, tienda, fotografia, latitud, longitud
        from tienda");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }
    function getOne($id_tienda)
    {
        $this->conect();
        $stmt = $this->conn->prepare("select id_tienda, tienda, fotografia, latitud, longitud
        from tienda where id_tienda = :id_tienda");
        $stmt->bindParam(':id_tienda', $id_tienda, PDO::PARAM_INT);
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
        $nombre_archivo = $this->upload('tiendas');
        if ($nombre_archivo) {
            if ($this->validateTienda($datos)) {
                $stm = $this->conn->prepare("insert into tienda(tienda,latitud,longitud,fotografia) VAlUES
            (:tienda,:latitud,:longitud, :fotografia)");
                $stm->bindParam(":tienda", $datos['tienda'], PDO::PARAM_STR);
                $stm->bindParam(":latitud", $datos['latitud'], pdo::PARAM_STR);
                $stm->bindParam(":longitud", $datos['longitud'], pdo::PARAM_STR);
                $stm->bindParam(":fotografia", $nombre_archivo, pdo::PARAM_STR);
                $stm->execute();
                return $stm->rowCount();
            }
        } else {
            if ($this->validateTienda($datos)) {
                $stm = $this->conn->prepare("insert into tienda(tienda,latitud,longitud) VAlUES
                (:tienda,:latitud,:longitud)");
                $stm->bindParam(":tienda", $datos['tienda'], PDO::PARAM_STR);
                $stm->bindParam(":latitud", $datos['latitud'], pdo::PARAM_STR);
                $stm->bindParam(":longitud", $datos['longitud'], pdo::PARAM_STR);
                $stm->execute();
                return $stm->rowCount();
            }
        }
        return 0;

    }

    function delete($id_tienda)
    {
        $this->conect();
        $stm = $this->conn->prepare("DELETE FROM tienda  WHERE id_tienda= :id_tienda");
        $stm->bindParam(':id_tienda', $id_tienda, PDO::PARAM_INT);
        $stm->execute();
        return $stm->rowCount();
    }
    function update($id_tienda, $datos)
    {
        $this->conect();

        $nombre_archivo = $this->upload('tiendas');
        if ($nombre_archivo) {
            $stm = $this->conn->prepare("UPDATE tienda SET tienda=:tienda,
            latitud=:latitud, longitud=:longitud, fotografia=:fotografia
             WHERE id_tienda=:id_tienda");
            $stm->bindParam(':fotografia', $nombre_archivo, PDO::PARAM_STR);
            $stm->bindParam(':id_tienda', $id_tienda, PDO::PARAM_INT);
            $stm->bindParam(':tienda', $datos['tienda'], PDO::PARAM_STR);
            $stm->bindParam(':latitud', $datos['latitud'], PDO::PARAM_STR);
            $stm->bindParam(':longitud', $datos['longitud'], PDO::PARAM_STR);
        } else {
            $stm = $this->conn->prepare("UPDATE tienda SET tienda=:tienda,
            latitud=:latitud, longitud=:longitud WHERE id_tienda=:id_tienda");
              $stm->bindParam(':id_tienda', $id_tienda, PDO::PARAM_INT);
              $stm->bindParam(':tienda', $datos['tienda'], PDO::PARAM_STR);
              $stm->bindParam(':latitud', $datos['latitud'], PDO::PARAM_STR);
              $stm->bindParam(':longitud', $datos['longitud'], PDO::PARAM_STR);
        }
      

        $stm->execute();
        return $stm->rowCount();
    }

    function validateTienda($datos)
    {
        if (empty($datos['tienda'])) {
            return false;
        }


        return true;
    }
}