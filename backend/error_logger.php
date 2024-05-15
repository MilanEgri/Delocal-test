<?php
// Error Logger
function errorLogger($errorMessage) {
    // Aktuális dátum meghatározása
    $currentDate = date('Y-m-d');

    // Error log mappa elérési útjának meghatározása
    $errorLogDir = __DIR__ . '/error_log';

    // Ha nem létezik az error_log mappa, létrehozzuk
    if (!is_dir($errorLogDir)) {
        mkdir($errorLogDir);
    }

    // Error log fájl elérési útjának meghatározása
    $errorLogFile = $errorLogDir . '/' . $currentDate . '_error_log.txt';

    // Hibaüzenet kiírása a fájlba
    file_put_contents($errorLogFile, date('Y-m-d H:i:s') . ' - ' . $errorMessage . "\n", FILE_APPEND);
}

// Tesztelés
errorLogger('Ez egy teszt hibaüzenet.');
?>
