<?php
///modelo
require_once (__DIR__ . '/sistema.class.php');
class Producto extends Sistema
{
    function getAll()
    {
        $this->conect();
        $stmt = $this->conn->prepare("select p.id_producto, producto,precio,marca, m.id_marca, p.fotografia
        from producto p
        left join marca m on m.id_marca= p.id_marca");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }
    function getOne($id_producto)
    {
        $this->conect();
        $stmt = $this->conn->prepare("select id_producto, producto,precio,m.marca, m.id_marca, p.fotografia
        from producto p
        left join marca m on m.id_marca= p.id_marca
         where id_producto = :id_producto");
        $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
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
        $nombre_archivo = $this->upload('productos');
        if ($nombre_archivo) {
            if ($this->validateproducto($datos)) {
                $stm = $this->conn->prepare("insert into producto(producto,precio, id_marca, fotografia) VAlUES
            (:producto,:precio,:id_marca, :fotografia)");
                $stm->bindParam(":id_marca", $datos['id_marca'], PDO::PARAM_INT);
                $stm->bindParam(":producto", $datos['producto'], PDO::PARAM_STR);
                $stm->bindParam(":precio", $datos['precio']);
                $stm->bindParam(":fotografia", $nombre_archivo, pdo::PARAM_STR);
                $stm->execute();
                return $stm->rowCount();
            }
        } else {
            if ($this->validateproducto($datos)) {
                $stm = $this->conn->prepare("insert into producto(producto,precio, id_marca) VAlUES
            (:producto,:precio,:id_marca)");
                $stm->bindParam(":id_marca", $datos['id_marca'], PDO::PARAM_INT);
                $stm->bindParam(":producto", $datos['producto'], PDO::PARAM_STR);
                $stm->bindParam(":precio", $datos['precio']);
                $stm->execute();
                return $stm->rowCount();
            }
        }
        return 0;

    }

    function delete($id_producto)
    {
        $this->conect();
        $stm = $this->conn->prepare("DELETE FROM producto  WHERE id_producto= :id_producto");
        $stm->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        $stm->execute();
        return $stm->rowCount();
    }

    function getProductsByIds($ids)
    {
        $this->conect();
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->conn->prepare("SELECT id_producto, producto, precio, marca, m.id_marca, p.fotografia
        FROM producto p
        LEFT JOIN marca m ON m.id_marca = p.id_marca
        WHERE id_producto IN ($placeholders)");
        foreach ($ids as $index => $id) {
            $stmt->bindValue($index + 1, $id, PDO::PARAM_INT);
        }
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        return $datos;
    }
    function bosch()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ferreteriajair.000webhostapp.com/productos.api.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYPEER => false, // añade esta línea
        )
        );

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'Error:' . curl_error($curl);
        }

        curl_close($curl);
        $data=json_decode($response);
        return $data;
    }
    function update($id_producto, $datos)
    {
        $this->conect();

        $nombre_archivo = $this->upload('productos');
        if ($nombre_archivo) {
            $stm = $this->conn->prepare("UPDATE producto SET producto=:producto,
            precio=:precio, id_marca=:id_marca, fotografia=:fotografia
             WHERE id_producto=:id_producto");
            $stm->bindParam(':fotografia', $nombre_archivo, PDO::PARAM_STR);
        } else {
            $stm = $this->conn->prepare("UPDATE producto SET producto=:producto,
        precio=:precio, id_marca=:id_marca
         WHERE id_producto=:id_producto");
        }
        $stm->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        $stm->bindParam(':producto', $datos['producto'], PDO::PARAM_STR);
        $stm->bindParam(':precio', $datos['precio']);
        $stm->bindParam(':id_marca', $datos['id_marca'], PDO::PARAM_INT);

        $stm->execute();
        return $stm->rowCount();
    }

    function validateproducto($datos)
    {
        if (empty($datos['producto'])) {
            return false;
        }
        if (empty($datos['precio'])) {
            return false;
        }
        if (empty($datos['id_marca'])) {
            return false;
        }

        return true;
    }
}