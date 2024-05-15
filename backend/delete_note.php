<?php
// CORS fejlécek beállítása
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Adatbázis kapcsolat beállítása
include 'config.php';
//Error logger hozzáadása
include 'error_logger.php';

// Törlési kérés fogadása
if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    // Ellenőrizzük, hogy az id paraméter meg van-e adva
    if (!isset($_GET['id'])) {
        echo json_encode(array('success' => false, 'message' => 'Az id paraméter hiányzik.'));
        errorLogger("[Backend]delete_note.php: Nem küldtek idt");
        exit;
    }

    // Jegyzet azonosítójának lekérdezése
    $noteId = $_GET['id'];

    // Jegyzet törlése az adatbázisból
    $delete = mysqli_query($conn, "DELETE FROM notes WHERE id = '$noteId'");

    if ($delete) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => 'A jegyzet törlése sikertelen.'));
        errorLogger("[Backend]delete_note.php: Nem sikerült törölni a jegyzetet");

    }
} else {
    // Ha nem DELETE kérés érkezett, visszautasítjuk a kérést
    echo json_encode(array('success' => false, 'message' => 'Csak DELETE kéréseket fogadunk el.'));
    errorLogger("[Backend]delete_note.php: Nem Delete requestet küldtek");

}
?>
