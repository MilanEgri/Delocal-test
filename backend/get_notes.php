<?php

// CORS fejlécek beállítása
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

// Adatbázis kapcsolat beállítása
include 'config.php';
//Error logger hozzáadása
include 'error_logger.php';

// Session indítása
session_start();

// Ellenőrzés, hogy be van-e jelentkezve a felhasználó
if (isset($_SESSION['serial'])) {
    $userSerial = $_SESSION['serial'];

    // Jegyzetek lekérdezése az adatbázisból
    $query = "SELECT * FROM notes WHERE user_serial = '$userSerial'";
    $result = mysqli_query($conn, $query);

    $notes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Kép bináris adatát olvassuk be és konvertáljuk base64 formátumba
        if ($row['image']) {
            $imageData = base64_encode(file_get_contents($row['image']));
            $row['image'] = 'data:image/jpeg;base64,' . $imageData;
        }
        $notes[] = $row;
    }

    // Jegyzetek visszaküldése JSON formátumban
    echo json_encode($notes);
} else {
    // Ha a felhasználó nincs bejelentkezve, üres választ küldünk vissza
    echo json_encode([]);
}

mysqli_close($conn);
?>
