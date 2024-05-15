<?php

// CORS fejlécek beállítása
header("Access-Control-Allow-Origin: http://localhost/");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Adatbázis kapcsolat beállítása
include 'config.php';
//Error logger hozzáadása
include 'error_logger.php';

// Ellenőrzi, hogy a kérés típusa POST-e.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Aadatok kinyerése a requestből
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $confirmPassword = mysqli_real_escape_string($conn, md5($_POST['confirmPassword']));

    // Ellenőrzi, hogy az e-mail cím már létezik-e az adatbázisban.
    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        // Ha az e-mail cím már létezik, visszatér egy sikertelen válasszal és egy üzenettel.
        $response = array('success' => false, 'message' => 'A Felhasználónév Vagy Email foglalt');
    } else {
        if ($password != $confirmPassword) {
            // Ha a jelszavak nem egyeznek meg, visszatér egy sikertelen válasszal és egy üzenettel.
            $response = array('success' => false, 'message' => 'Jelszók nem egyeznek!');
        } else {
            // Ha minden adat helyes, az új felhasználót hozzáadja az adatbázishoz.
            $insert = mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES('$name', '$email', '$password')") or die('query failed');

            if ($insert) {
                // Sikeres regisztráció esetén visszatér egy sikeres válasszal.
                $response = array('success' => true);
            } else {
                // Ha a regisztráció nem sikerült, visszatér egy sikertelen válasszal és egy üzenettel.
                $response = array('success' => false, 'message' => 'Regisztráció nem sikerült!');
                errorLogger("[Backend]register.php: regisztráció nem sikerült");

            }
        }
    }
    // JSON formátumban visszatér a válasszal.
    echo json_encode($response);
}
?>
