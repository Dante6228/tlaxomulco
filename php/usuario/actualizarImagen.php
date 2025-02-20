<?php

require_once __DIR__ . "/../conexion.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["nuevaImagen"])) {
    $imagen = $_FILES["nuevaImagen"];
    $idUsuario = $_SESSION["idUsuario"];

    $check = getimagesize($imagen["tmp_name"]);
    if ($check !== false) {
        $target_dir = "img/perfiles/";
        $target_file = $target_dir . basename($imagen["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verificar que no sea mayor a 2mb exactamente
        if ($imagen["size"] > 2097152) {
            echo "El archivo es demasiado grande.";
            exit();
        }

        // Permitir solo ciertos formatos de archivo
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Solo se permiten archivos JPG, JPEG y PNG.";
            exit();
        }

        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($imagen["tmp_name"], __DIR__ . "/../../" . $target_file)) {
            $pdo = Conexion::connection();
            $stmt = $pdo->prepare("UPDATE usuario SET imagen_perfil = :imagen WHERE id = :id");
            $stmt->bindParam(":imagen", $target_file);
            $stmt->bindParam(":id", $idUsuario);
            $stmt->execute();

            $_SESSION["picture"] = $target_file;

            header("Location: ../../usuario.php?mensaje=actualizacion");
            exit();
        } else {
            echo "Hubo un error al subir el archivo.";
        }
    } else {
        echo "El archivo no es una imagen.";
    }
} else {
    echo "No se recibió ningún archivo.";
    header("Location: ../../usuario.php?mensaje=error");
    exit();
}
