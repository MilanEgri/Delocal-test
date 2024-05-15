
// Az űrlap elküldésének eseménykezelője
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    // Az alapértelmezett esemény (űrlap elküldése) megszakítása
    e.preventDefault();

    // Az űrlap adatainak kinyerése a FormData objektumból
    const formData = new FormData(e.target);

    try {
        // Aszinkron kérés küldése a bejelentkezéshez a szerverhez
        const response = await fetch('http://localhost:80/delocal-test/backend/login.php', {
            method: 'POST', // A kérés típusa: POST
            body: formData // Az űrlap adatai
        });

        // A válasz JSON formátumban érkezik, így várunk a válasz feldolgozására
        const data = await response.json();

        // Ellenőrizzük, hogy a bejelentkezés sikeres volt-e
        if (data.success) {
            // Ha igen, a felhasználó sorszámát elmentjük a localStorage-ban
            localStorage.setItem('userSerial', data.userSerial);
            // Átirányítjuk a felhasználót az index.html oldalra
            window.location.href = 'index.html';
        } else {
            // Ha a bejelentkezés sikertelen, megjelenítjük a hibaüzenetet
            document.getElementById('message').innerHTML = '<div class="message">Hibás felhasználónév vagy jelszó!</div>';
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
