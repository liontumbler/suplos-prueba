<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'prueba_suplos';
    private $username = 'root';
    private $password = '';
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }

    public function crearOferta($objeto, $actividad, $descripcion, $moneda, $presupuesto) {
        $sql = "INSERT INTO ofertas (creador_oferta, objeto, actividad, descripcion, moneda, presupuesto, fecha_inicio, hora_inicio, fecha_cierre, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        $creador = 'any';
        $fecha_inicio = '2025-04-01';
        $hora_inicio = '08:00:00';
        $fecha_cierre = '2025-04-01'; 
        $estado = 'ACTIVO';

        return $stmt->execute([$creador, $objeto, $actividad, $descripcion, $moneda, intval($presupuesto), $fecha_inicio, $hora_inicio, $fecha_cierre, $estado]);
    }

    public function obtenerOfertas() {
        $sql = "SELECT * FROM ofertas";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerOferta($id, $objeto, $creador, $estado) {
        $query = "SELECT * FROM ofertas WHERE ";
        $arrayConsulta = [];
        if (!empty($id)) {
            $query .= 'id_oferta = ? and ';
            array_push($arrayConsulta, intval($id));
        }

        if (!empty($objeto)) {
            $query .= 'objeto = ? and ';
            array_push($arrayConsulta, $objeto);
        }

        if (!empty($creador)) {
            $query .= 'creador_oferta = ? and ';
            array_push($arrayConsulta, $creador);
        }

        if (!empty($estado)) {
            $query .= 'estado = ? and ';
            array_push($arrayConsulta, $estado);
        }

        $sql = rtrim($query, "and ");

        $stmt = $this->pdo->prepare($sql);
        if (!empty($arrayConsulta)) {
            $res = $stmt->execute($arrayConsulta);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return 'error';
        }
        
    }

    public function actualizarOferta($id, $estado) {
        $sql = "UPDATE ofertas SET estado = ? WHERE id_oferta = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$estado, $id]);
    }

    public function eliminarOferta($id) {
        $sql = "DELETE FROM ofertas WHERE id_oferta = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>