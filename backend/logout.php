<?php
// PHP munkamenet indítása vagy folytatása.
session_start();

// Ellenőrzi, hogy a felhasználó be van-e jelentkezve.
if (!isset($_SESSION['serial'])) {
    // Ha nincs bejelentkezve, visszatér egy sikertelen válasszal és egy üzenettel.
    echo json_encode(array('success' => false, 'message' => 'Nincs bejelentkezve felhasználó.'));
    exit; // Kilépés a kód végrehajtásából.
}

// A munkamenet változók törlése.
$_SESSION = array();

// A munkamenet törlése a szerverről.
session_destroy();

// Visszatér egy sikeres válasszal és egy üzenettel.
echo json_encode(array('success' => true, 'message' => 'Sikeres kijelentkezés.'));
?>
