<?php
Class Database{
    public static function ConectarDB(){
$serverName = "localhost"; // o el nombre de tu instancia
$database = "prueba";
$username = "";
$password = "";

try{
    $connect = new PDO("sqlsrv:Server=$serverName; Database=$database", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connect;

} catch (PDOException $e) {
    die(" Error de conexion: " . $e->getMessage());
    }
}
}
?>
