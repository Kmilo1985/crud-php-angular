<?php
// db/Database.php
class Database {
    private $servername = "localhost";
    private $username = "root"; // Tu usuario de la base de datos
    private $password = ""; // Tu contraseña de la base de datos
    private $dbname = "crud_php_kmilo"; // Nombre de la base de datos
    public $conn;

    // Constructor: establecer la conexión a la base de datos
    public function __construct() {
        $this->connect();
    }

    // Establecer la conexión con la base de datos
    public function connect() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Verificar la conexión
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    // Método para cerrar la conexión
    public function close() {
        $this->conn->close();
    }
}
?>
