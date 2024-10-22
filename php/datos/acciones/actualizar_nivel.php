<?php

require_once __DIR__ . "/../../conexion.php";

session_start();

if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header("Location: ../../../Index.php?mensaje=error");
    exit();
}

$pdo = Conexion::connection();

if (!$pdo) {
    throw new UnexpectedValueException("Error de conexión a la base de datos");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../../Index.php?mensaje=err1");
    exit();
}

$id = $_POST["id"];
$descripcion = $_POST["descripcion"];

$stmt = $pdo->prepare("UPDATE nivel_educativo SET descripcion = :descripcion WHERE id = :id");
$stmt->bindParam(":descripcion", $descripcion);
$stmt->bindParam(":id", $id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header("Location: ../../../datos.php?mensaje=actualizacion");
    exit();
} else {
    header("Location: ../../../datos.php?mensaje=error");
    exit();
}

