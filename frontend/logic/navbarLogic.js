
// A navigációs sáv HTML tartalmának beállítása dinamikusan
document.getElementById('navbar').innerHTML = `
    <ul>
        <li><a href="index.html">Home</a></li>
        <li id="loginLink" style="display: none;"><a href="login.html">Belépés</a></li>
        <li id="registerLink" style="display: none;"><a href="register.html">Regisztráció</a></li>
        <li id="logoutLink" style="display: none;"><a href="index.html">Kilépés</a></li>
    </ul>
`;

// Az oldal betöltődésének eseménykezelője
window.addEventListener('DOMContentLoaded', async () => {
    try {
        // Aszinkron kérés küldése a bejelentkezési állapot ellenőrzésére a szerverhez
        const response = await fetch('http://localhost:80/delocal-test/backend/check_login.php');

        // A válasz JSON formátumban érkezik, így várunk a válasz feldolgozására
        const data = await response.json();

        // A kijelentkezés, bejelentkezés és regisztráció linkjeinek lekérése az HTML-ből
        const logoutLink = document.getElementById('logoutLink');
        const loginLink = document.getElementById('loginLink');
        const registerLink = document.getElementById('registerLink');

        // A bejelentkezett állapot függvényében a navigációs sáv linkjeinek megjelenítése vagy elrejtése
        if (data.loggedIn) {
            logoutLink.style.display = 'block';
            loginLink.style.display = 'none';
            registerLink.style.display = 'none';
        } else {
            logoutLink.style.display = 'none';
            loginLink.style.display = 'block';
            registerLink.style.display = 'block';
        }
    } catch (error) {
        // Hibakezelés: Ha bármi hiba történik a kérés során, a hibát kiírjuk a konzolra
        console.error('Hiba:', error);
    }
});

// A kijelentkezés linkjének eseménykezelője
document.getElementById('logoutLink').addEventListener('click', async (e) => {
    // Az alapértelmezett esemény (link követés) megakadályozása
    e.preventDefault();

    try {
        // Aszinkron kérés küldése a kijelentkezéshez a szerverhez
        const response = await fetch('http://localhost:80/delocal-test/backend/logout.php', {
            method: 'GET', // A kérés típusa: GET
        });

        // Ellenőrizzük, hogy a kijelentkezés sikeres volt-e
        if (response.ok) {
            // Ha igen, eltávolítjuk a felhasználó sorszámát a localStorage-ból
            localStorage.removeItem('userSerial');
            // Átirányítjuk a felhasználót a bejelentkező oldalra
            window.location.href = 'login.html';
        } else {
            // Ha a kijelentkezés sikertelen, hibaüzenetet írunk ki a konzolra
            console.error('Kijelentkezés sikertelen.');
        }
    } catch (error) {
        // Hibakezelés: Ha bármi hiba történik a kérés során, a hibát kiírjuk a konzolra
        console.error('Hiba:', error);
    }
});
