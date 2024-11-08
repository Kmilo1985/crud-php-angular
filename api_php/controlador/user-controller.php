<?php
// controller/UserController.php
include_once('../conex/db.php');
    
class UserController {

    // Crear un nuevo usuario
    public function create($name, $email) {
        $db = new Database();
        $conn = $db->conn;

        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO users (name, email) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $email);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Usuario creado con éxito"]);
        } else {
            echo json_encode(["message" => "Error al crear usuario"]);
        }

        $stmt->close();
        $db->close();
    }

    // Obtener todos los usuarios
    public function getAll() {
        $db = new Database();
        $conn = $db->conn;

        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        $users = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            echo json_encode($users);
        } else {
            echo json_encode(["message" => "No se encontraron usuarios"]);
        }

        $db->close();
    }

    // Obtener un usuario por ID
    public function getById($id) {
        $db = new Database();
        $conn = $db->conn;

        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo json_encode($result->fetch_assoc());
        } else {
            echo json_encode(["message" => "Usuario no encontrado"]);
        }

        $stmt->close();
        $db->close();
    }

    // Actualizar un usuario
    public function update($id, $name, $email) {
        $db = new Database();
        $conn = $db->conn;

        $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $email, $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Usuario actualizado con éxito"]);
        } else {
            echo json_encode(["message" => "Error al actualizar usuario"]);
        }

        $stmt->close();
        $db->close();
    }

    // Eliminar un usuario
    public function delete($id) {
        $db = new Database();
        $conn = $db->conn;

        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Usuario eliminado con éxito"]);
        } else {
            echo json_encode(["message" => "Error al eliminar usuario"]);
        }

        $stmt->close();
        $db->close();
    }
}
?>
