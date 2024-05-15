
// Az eseménykezelő hozzáadása az ablak betöltődéséhez
window.addEventListener('DOMContentLoaded', async () => {
    try {
        // Aszinkron kérés küldése a szervernek a bejelentkezés ellenőrzésére
        const response = await fetch('http://localhost:80/delocal-test/backend/check_login.php');

        // A válasz JSON formátumban érkezik, így várunk a válasz feldolgozására
        const data = await response.json();

        // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
        if (data.loggedIn) {
            // Ha be van jelentkezve, rejtjük el a bejelentkezési részt és megjelenítjük a bejelentkezett részt
            document.getElementById('index-say-login').style.display = 'none';
            document.getElementById('index-logined').style.display = 'flex';
        } else {
            // Ha nincs bejelentkezve, megjelenítjük a bejelentkezési részt és elrejtjük a bejelentkezett részt
            document.getElementById('index-say-login').style.display = 'flex';
            document.getElementById('index-logined').style.display = 'none';
        }
    } catch (error) {
        // Hibakezelés: Ha bármi hiba történik a kérés során, a hibát kiírjuk a konzolra
        console.error('Hiba:', error);
    }
});
