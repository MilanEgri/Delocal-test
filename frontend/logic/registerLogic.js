
// Az űrlap elküldésének eseménykezelője
document.getElementById('registrationForm').addEventListener('submit', async (e) => {
    // Az alapértelmezett esemény (űrlap elküldése) megszakítása
    e.preventDefault();

    // Az űrlap adatainak kinyerése a FormData objektumból
    const formData = new FormData(e.target);

    try {
        // Aszinkron kérés küldése a regisztrációhoz a szerverhez
        const response = await fetch('http://localhost:80/delocal-test/backend/register.php', {
            method: 'POST', // A kérés típusa: POST
            body: formData, // Az űrlap adatai
        });

        // A válasz JSON formátumban érkezik, így várunk a válasz feldolgozására
        const data = await response.json();

        // Ellenőrizzük, hogy a regisztráció sikeres volt-e
        if (data.success) {
            // Ha igen, megjelenítjük a sikeres regisztrációs üzenetet
            document.getElementById('message').innerHTML = '<div class="message">Sikeres regisztráció!</div>';

            // Várunk 2 másodpercet, majd átirányítjuk a felhasználót a bejelentkező oldalra
            setTimeout(() => {
                window.location.href = 'login.html';
            }, 2000);
        } else {
            // Ha a regisztráció sikertelen, megjelenítjük a kapott hibaüzenetet
            document.getElementById('message').innerHTML = '<div class="message">' + data.message + '</div>';
        }
    } catch (error) {
        // Hibakezelés: Ha bármi hiba történik a kérés során, a hibát kiírjuk a konzolra
        console.error('Hiba:', error);
    }
});

// Az oldal betöltődésének eseménykezelője
window.addEventListener('load', () => {
    // Ellenőrizzük, hogy van-e felhasználói sorszám a localStorage-ban
    const userSerial = localStorage.getItem('userSerial');
    // Ha van, átirányítjuk a felhasználót az index.html oldalra
    if (userSerial) {
        window.location.href = 'index.html';
    }
});
