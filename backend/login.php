<?php

// Az Access-Control-Allow-Origin fejléc beállítása engedélyezi a CORS (Cross-Origin Resource Sharing) kéréseket a megadott eredet(ek)ről.
header("Access-Control-Allow-Origin: http://localhost");
// Engedélyezett HTTP metódusok megadása a POST kérésekhez.
header("Access-Control-Allow-Methods: POST");
// Engedélyezett HTTP fejlécek megadása, amelyeket a kliens elküldhet a kérésben.
header("Access-Control-Allow-Headers: Content-Type");

// Adatbázis kapcsolat beállítása
include 'config.php';
//Error logger hozzáadása
include 'error_logger.php';
// PHP munkamenet indítása vagy folytatása.
session_start();

// Ellenőrzi, hogy a kérés típusa POST-e.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Az e-mail cím és a jelszó a kérésből.
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    // Az adatbázisból lekéri az e-mail címhez és jelszóhoz tartozó felhasználót.
    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'") or die('query failed');

    // Ellenőrzi, hogy talált-e felhasználót az adatbázisban.
    if(mysqli_num_rows($select) > 0){
        // Ha talált, beállítja a felhasználó sorozatszámát a munkamenetben.
        $row = mysqli_fetch_assoc($select);
        $_SESSION['serial'] = $row['serial'];
        // Visszatér az eredménnyel JSON formátumban a kliens számára.
        echo json_encode(array('success' => true, 'userSerial' => $row['serial']));
    } else {
        // Ha nem talált, sikertelen választ küld JSON formátumban.
        echo json_encode(array('success' => false));
    }
}else{
    // Ha a kérés típusa nem POST, sikertelen választ küld JSON formátumban.
    echo json_encode(array('success' => false));
    errorLogger("[Backend]login.php: Nem Post Requestet küldtek");
}
?>
