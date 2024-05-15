

// A "noteForm" űrlap elküldésének eseménykezelője
document.getElementById('noteForm').addEventListener('submit', async (e) => {
    // Az alapértelmezett esemény megszakítása (az űrlap elküldésének megakadályozása)
    e.preventDefault();

    // Az űrlap adatainak kinyerése a FormData objektumból
    const formData = new FormData(e.target);

    try {
        // Aszinkron kérést indít a jegyzet hozzáadásához a szerverhez
        const response = await fetch('http://localhost:80/delocal-test/backend/add_note.php', {
            method: 'POST', // A kérés típusa: POST
            body: formData, // Az űrlap adatainak tartalma
        });

        // A válasz JSON formátumban érkezik, így várunk a válasz feldolgozására
        const data = await response.json();

        // Ellenőrizzük, hogy a jegyzet hozzáadása sikeres volt-e
        if (data.success) {
            // Ha sikeres, megjelenítjük az üzenetet a felhasználónak
            document.getElementById('message').innerHTML = '<div class="message">A jegyzet sikeresen hozzá lett adva!</div>';
            // Az űrlap mezőinek ürítése
            document.getElementById('noteForm').reset();
        } else {
            // Ha sikertelen volt a jegyzet hozzáadása, megjelenítjük a kapott hibaüzenetet
            document.getElementById('message').innerHTML = '<div class="message">' + data.message + '</div>';
        }
    } catch (error) {
        // Hibakezelés: Ha bármi hiba történik a kérés során, a hibát kiírjuk a konzolra
        console.error('Hiba:', error);
    }
});
