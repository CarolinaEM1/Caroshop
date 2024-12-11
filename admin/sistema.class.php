<?php
require __DIR__ . "/config.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Sistema extends Config
{
    var $conn;
    var $count;
    function conect()
    {
        $this->conn = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PASS);
    }
    function setCount($count)
    {
        $this->count = $count;
    }
    function getCount()
    {
        return $this->count;
    }
    function upload($carpeta)
    {
        if (in_array($_FILES['fotografia']['type'], $this->getImageType())) {
            if ($_FILES['fotografia']['size'] <= $this->getImageSize()) {
                $n = rand(1, 100000);
                $nombre_archivo = $n . $_FILES['fotografia']['size'] . $_FILES['fotografia']['name'];
                $nombre_archivo = md5($nombre_archivo);
                $extension = explode('.', $_FILES['fotografia']['name']);
                $extension = $extension[sizeof($extension) - 1];
                $nombre_archivo = $nombre_archivo . "." . $extension;
                if (!file_exists('../uploads/' . $carpeta . '/' . $nombre_archivo)) {
                    $ruta = $_FILES['fotografia']['tmp_name'];
                    $nombre = $nombre_archivo;
                    move_uploaded_file($ruta, '../uploads/' . $carpeta . '/' . $nombre);
                    return $nombre;
                }
            }
        }
        return false;
    }
    function query($sql)
    {
        $this->conect();
        $stm = $this->conn->prepare($sql);
        $stm->execute();
        $datos = array();
        $result = $stm->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stm->fetchAll();
        return $datos;
    }
    function getRol($correo)
    {
        $sql = "select r.rol from usuario u
        join usuario_rol ur on u.id_usuario = ur.id_usuario
        join rol r on ur.id_rol = r.id_rol
        where u.correo='$correo';";
        $datos = $this->query($sql);
        $i = array();
        foreach ($datos as $dato)
            array_push($i, $dato['rol']);

        return $i;
    }
    function getPrivilegio($correo)
    {
        $sql = "select p.privilegio from usuario u
        join usuario_rol ur on u.id_usuario = ur.id_usuario
        join rol r on ur.id_rol = r.id_rol
        join rol_privilegio rp on r.id_rol = rp.id_rol
        join privilegio p on rp.id_privilegio = p.id_privilegio
        where u.correo='$correo';";
        $datos = $this->query($sql);
        $i = array();
        foreach ($datos as $dato)
            array_push($i, $dato['privilegio']);
        return $i;
    }
    function login($correo, $password)
    {
        $password = md5($password);
        $this->conect();
        $sql = "select * from usuario where correo= :correo and password= :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        $datos = array();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        if (isset($datos[0])) {
            $roles = array();
            $roles = $this->getRol($correo);
            $privilegios = array();
            $privilegios = $this->getPrivilegio($correo);
            $_SESSION['validado'] = true;
            $_SESSION['correo'] = $correo;
            $_SESSION['roles'] = $roles;
            $_SESSION['privilegios'] = $privilegios;
            $_SESSION['id_usuario']=$datos[0]['id_usuario'];
            return $datos[0];
        } else {
            $this->logout();
        }
        return false;
    }
    function logout()
    {
        unset($_SESSION);
        session_destroy();
    }
    function checkRol($rol, $kill = false)
    {
        if (isset($_SESSION['roles'])) {
            if ($_SESSION['validado']) {
                if (in_array($rol, $_SESSION['roles'])) {
                    return true;
                }
            }
        }
        if ($kill) {
            $this->logout();
            $this->alert('danger', 'Permiso denegado');
            die();
        }
        return false;
    }
    function checkPrivilegio($privilegio, $kill = false)
    {
        if (isset($_SESSION['privilegios'])) {
            if ($_SESSION['validado']) {
                if (in_array($privilegio, $_SESSION['privilegios'])) {
                    return true;
                }
            }
        }
        if ($kill) {
            $this->logout();
            $this->alert('danger', 'Permiso denegado');
            die();
        }
        return false;

    }
    function reset($correo)
    {
        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->conect();
            $sql = "SELECT * FROM usuario WHERE correo =:correo";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->execute();
            $datos = array();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos = $stmt->fetchAll();
            if (isset($datos[0])) {
                $token1 = md5($correo . 'Jair52');
                $token2 = md5($correo . date('Y-m-d H:i:s') . rand(1, 100000));
                $token = $token1 . $token2;
                $sql = "UPDATE usuario SET token=:token WHERE correo=:correo";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':token', $token, PDO::PARAM_STR);
                $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
                $stmt->execute();
                $destinatario = $correo;
                $nombre = "Juanito Bananas";
                $asunto = "Cambio de contraseña";
                $mensaje = "<html><body style='font-family: Arial, sans-serif;'>";
                $mensaje .= "<div style='background-color: #f4f4f4; padding: 20px; border-radius: 5px;'>";
                $mensaje .= "<h2 style='color: #333;'>Hola $nombre,</h2>";
                $mensaje .= "<p style='color: #333;'>Hemos recibido una solicitud para restablecer tu contraseña.</p>";
                $mensaje .= "<p style='color: #333;'> Por favor, haz clic en el siguiente botón para continuar:</p>";
                $mensaje .= "<p><a href='http://localhost/ferreteria/admin/login.php?action=recovery&token=$token' style='background-color: #007bff; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px;'>Restablecer Contraseña</a></p>";
                $mensaje .= "<p style='color: #333;'>Si no solicitaste este cambio, puedes ignorar este mensaje.</p>";
                $mensaje .= "</div>";
                $mensaje .= "</body></html>";
                if ($this->sendMail($destinatario, $nombre, $asunto, $mensaje)) {
                    return true;
                } else {
                    return false;
                }

            }
        }
    }
    function recovery($token, $contrasena = null)
    {
        $this->conect();
        $sql = "SELECT * FROM usuario where token =:token";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':token', $token, pdo::PARAM_STR);
        $stmt->execute();
        $datos = array();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();

        if (isset($datos[0])) {
            if (!is_null($contrasena)) {
                $contrasena = md5($contrasena);
                $sql = "UPDATE usuario SET password=:contra , token=null  WHERE correo=:correo";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':correo', $datos[0]['correo'], pdo::PARAM_STR);
                $stmt->bindParam(':contra', $contrasena, pdo::PARAM_STR);
                $stmt->execute();
            }
            return true;
        }
    }
    function alert($type, $mensaje)
    {
        $alert = array();
        $alert['tipo'] = $type;
        $alert['mensaje'] = $mensaje;
        include __DIR__ . '/views/alert.php';
    }
    function sendMail($destinario, $nombre, $asunto, $mensaje)
    {

        require '../vendor/autoload.php';
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth = true;
        $mail->Username = '20030039@itcelaya.edu.mx';
        $mail->Password = 'yxvojfkpjiipnqhd';
        $mail->setFrom('20030039@itcelaya.edu.mx', 'Jair velazquez reyes');
        $mail->addAddress($destinario, $nombre);
        $mail->Subject = $asunto;
        $mail->msgHTML($mensaje);
        if (!$mail->send()) {
            return false;
        } else {
            return true;
        }

    }
    function register($datos)
    {
        if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        $this->conect();
        try {
            $this->conn->beginTransaction();
            $sql = "select * from usuario where correo=:correo";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetchAll();
            if ($usuario[0]) {
                $this->conn->rollBack();
                return false;
            }
            $contra = md5($datos['password']);
            $sql = "INSERT INTO usuario (correo, password) VALUES (:correo, :password)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
            $stmt->bindParam(':password', $contra, PDO::PARAM_STR);
            $stmt->execute();
            $sql = "select * from usuario where correo =:correo";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetchAll();
            if ($usuario[0]) {
                $id_usuario = $usuario[0]['id_usuario'];
                $sql = "INSERT INTO usuario_rol (id_usuario, id_rol) VALUES (:id_usuario, 2)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt->execute();
                $sql = "insert into cliente (nombre, primer_apellido, segundo_apellido, rfc) values(:nombre, :primer_apellido, :segundo_apellido, rfc, id_usuario)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
                $stmt->bindParam(':primer_apellido', $datos['primer_apellido'], PDO::PARAM_STR);
                $stmt->bindParam(':segundo_apellido', $datos['segundo_apellido'], PDO::PARAM_STR);
                $stmt->bindParam(':rfc', $datos['rfc'], PDO::PARAM_STR);
                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt->execute();
                $sql = "select * from cliente c join usuario u on c.id_usuario = u.id_usuario where c.id_usuario = :id_usuario";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt->execute();
                $cliente = $stmt->fetchAll();
                if (isset($client[0])) {
                    $this->conn->commit();
                    return true;
                }
                $this->conn->rollBack();
                return false;
            } else {
                $this->conn->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }
    function checkRole($rol, $kill=false) {
        if (isset($_SESSION['roles']) && isset($_SESSION['validado'])) {
            if (in_array($rol, $_SESSION['roles'])) {
                return true;
            }
        }
        if ($kill) {
            $this->logout();
            $this->alert('danger', 'Permiso Denegado de Rol');
            die;
        }
        return false;
    }
    function validateEmail($email) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true; 
        } else {
            return false; 
        }
    }


}