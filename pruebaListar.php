<?php
require_once 'conexion.php';
$connect = Database::ConectarDB();

$stmt = $connect->prepare("EXEC ListarEstudiantes");
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: {$row['ID']} - Nombre: {$row['Nombre']} - Edad: {$row['Edad']}<br>";
}
$stmt->closeCursor();
?>