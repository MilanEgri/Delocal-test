
// Lekéri a felhasználó jegyzeteit és megjeleníti azokat az oldalon
async function fetchAndDisplayNotes() {
    try {
        // Jegyzetek lekérése a szerverről
        const response = await fetch('http://localhost:80/delocal-test/backend/get_notes.php');
        // Válasz feldolgozása JSON formátumban
        const notes = await response.json();

        // Jegyzetek megjelenítésére szolgáló konténer elem kiválasztása
        const notesContainer = document.getElementById('notesContainer');
        // Előző jegyzetek törlése a konténerből
        notesContainer.innerHTML = '';

        // Ha nincsenek jegyzetek
        if (notes.length === 0) {
            notesContainer.innerHTML = '<p>Nincsenek jegyzetek</p>';
        } else {
            // Minden jegyzet megjelenítése
            notes.forEach(note => {
                // Jegyzet elem létrehozása és formázása
                const noteElement = document.createElement('div');
                noteElement.classList.add('note');
                noteElement.innerHTML = `
                    <div class="note-in">
                    <h3>${note.title}</h3>
                    <p>${note.text}</p>
                    <a href="${note.text.startsWith('http') ? note.link : 'http://' + note.link}" target="_blank">${note.link}</a>
                    <div class="index-photo">
                        ${note.image ? `<img src="${note.image}" alt="Note Image">` : ''}
                    </div>
                    </div>
                    <button class="delete-btn" data-note-id="${note.id}">Törlés</button>
                `;
                // Jegyzet elem hozzáadása a konténerhez
                notesContainer.appendChild(noteElement);

                // Törlés gomb eseménykezelője
                const deleteButton = noteElement.querySelector('.delete-btn');
                deleteButton.addEventListener('click', async () => {
                    try {
                        // Jegyzet törléséhez kérés küldése a szervernek
                        const deleteResponse = await fetch(`http://localhost:80/delocal-test/backend/delete_note.php?id=${note.id}`, {
                            method: 'DELETE',
                        });
                        // Ha a törlés sikeres volt
                        if (deleteResponse.ok) {
                            // Jegyzetek újra betöltése
                            fetchAndDisplayNotes();
                        } else {
                            console.error('A jegyzet törlése sikertelen.');
                        }
                    } catch (error) {
                        console.error('Hiba:', error);
                    }
                });
            });
        }
    } catch (error) {
        console.error('Hiba:', error);
    }
}

// Oldal betöltésekor lekéri és megjeleníti a felhasználó jegyzeteit
window.addEventListener('DOMContentLoaded', fetchAndDisplayNotes);
