<?php

// CORS fejlécek beállítása
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Adatbázis kapcsolat beállítása
include 'config.php';
//Error logger hozzáadása
include 'error_logger.php';

// Session indítása
session_start();

// Jegyzet hozzáadása
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Jegyzet szövegének és címének lekérdezése az űrlapról
    $noteTitle = mysqli_real_escape_string($conn, $_POST['noteTitle']);
    $noteText = mysqli_real_escape_string($conn, $_POST['noteText']);
    $noteLink = mysqli_real_escape_string($conn, $_POST['noteLink']);
    $userSerial = isset($_SESSION['serial']) ? $_SESSION['serial'] : null;

    // Kép feldolgozása és mentése (ha van)
    $noteImage = ''; // Alapértelmezés: nincs kép
    if (isset($_FILES['noteImage']) && $_FILES['noteImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['noteImage']['tmp_name'];
        $fileName = $_FILES['noteImage']['name'];
        $fileSize = $_FILES['noteImage']['size'];
        $fileType = $_FILES['noteImage']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadPath = 'uploads/' . $newFileName;

        // Kép áthelyezése az upload mappába
        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
            $noteImage = $uploadPath;
        } else {
            // Hiba esetén visszatérünk hibaüzenettel
            echo json_encode(array('success' => false, 'message' => 'A kép feltöltése sikertelen.'));
            errorLogger("[Backend]add_note.php: sikertelen képfeltöltés");
            exit;
        }
    }

    // Jegyzet hozzáadása az adatbázishoz
    $insert = mysqli_query($conn, "INSERT INTO notes (title, text, link, image, user_serial) VALUES ('$noteTitle', '$noteText', '$noteLink', '$noteImage', '$userSerial')") or die('Az adatok hozzáadása sikertelen.');

    // Sikeres művelet esetén visszatérünk a frontend felé
    echo json_encode(array('success' => true));
} else {
    // Ha nem POST kérés érkezett, visszautasítjuk a kérést
    echo json_encode(array('success' => false, 'message' => 'Csak POST kéréseket fogadunk el.'));
    errorLogger("[Backend]add_note.php: nem post requestet küldtek");
}
?>
