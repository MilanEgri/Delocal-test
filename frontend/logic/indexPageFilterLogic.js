// Egy függvény, ami a jegyzeteket szűri a filterInput-ban megadott érték alapján
function filterNotes() {
    // Az input mezőből kinyert szűrőérték kisbetűsítve
    const filterValue = document.getElementById('filterInput').value.toLowerCase();

    // Az összes jegyzet elem kiválasztása
    const noteElements = document.querySelectorAll('.note');

    // A jegyzetek szűrése
    noteElements.forEach(noteElement => {
        // A jegyzet címe
        const title = noteElement.querySelector('h3').innerText.toLowerCase();
        // A jegyzet szövege
        const text = noteElement.querySelector('p').innerText.toLowerCase();

        // Ha a jegyzet címe vagy szövege tartalmazza a szűrőértéket, akkor megjelenítjük a jegyzetet, egyébként elrejtjük
        if (title.includes(filterValue) || text.includes(filterValue)) {
            noteElement.style.display = 'flex';
        } else {
            noteElement.style.display = 'none';
        }
    });
}
