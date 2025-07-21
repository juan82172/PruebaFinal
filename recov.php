<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';
$conexion = Database::ConectarDB();
header('Content-Type: application/json');

// Validar si se recibió la función
if (!isset($_POST['funcion']) && !isset($_GET['funcion'])) {
    echo json_encode(["error" => "No se recibió ninguna función"]);
    exit;
}

$funcion = $_POST['funcion'] ?? $_GET['funcion'] ?? null;

if ($funcion === 'listarEstudiantes') {
    try {
        $stmt = $conexion->prepare("EXEC ListarEstudiantes");
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado);
    } catch (PDOException $e) {
        echo json_encode([
            "error" => "Error al ejecutar el procedimiento",
            "detalle" => $e->getMessage()
        ]);
    }

} elseif ($funcion === 'eliminarEstudiante') {
    try {
        $id = $_POST['id'] ?? null;
        if ($id === null) {
            echo json_encode(["error" => "ID no proporcionado"]);
            exit;
        }

        $stmt = $conexion->prepare("DELETE FROM Estudiantes WHERE ID = ?");
        $stmt->execute([$id]);
        echo json_encode(["mensaje" => "Estudiante eliminado correctamente"]);
    } catch (PDOException $e) {
        echo json_encode([
            "error" => "Error al eliminar",
            "detalle" => $e->getMessage()
        ]);
    }

} elseif ($funcion === 'editarEstudiante') {
    try {
        $id = $_POST['id'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $edad = $_POST['edad'] ?? null;

        if (!$id || !$nombre || !$edad) {
            echo json_encode(["error" => "Datos incompletos para editar"]);
            exit;
        }

        $stmt = $conexion->prepare("EXEC ActualizarEstudiante ?, ?, ?");
        $stmt->execute([$id, $nombre, $edad]);
        echo json_encode(["mensaje" => "Estudiante actualizado correctamente"]);
    } catch (PDOException $e) {
        echo json_encode([
            "error" => "Error al editar",
            "detalle" => $e->getMessage()
        ]);
    }

} elseif ($funcion === 'crearEstudiante') {
    try {
        $id = $_POST['id'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $edad = $_POST['edad'] ?? null;

        if (!$id || !$nombre || !$edad) {
            echo json_encode(["error" => "Datos incompletos para crear"]);
            exit;
        }

        $stmt = $conexion->prepare("EXEC InsertarEstudiante ?, ?, ?");
        $stmt->execute([$id, $nombre, $edad]);
        echo json_encode(["mensaje" => "Estudiante creado correctamente"]);
    } catch (PDOException $e) {
        echo json_encode([
            "error" => "Error al crear",
            "detalle" => $e->getMessage()
        ]);
    }

} else {
    echo json_encode(["error" => "Función no reconocida"]);
}