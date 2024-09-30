document.addEventListener('DOMContentLoaded', function() {
    const timeDisplay = document.getElementById('time');
    const secondsDisplay = document.getElementById('seconds');
    const modeDisplay = document.getElementById('mode');
    const statusDisplay = document.getElementById('status');

    function updateClock() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        timeDisplay.textContent = `${hours}:${minutes}`;
        secondsDisplay.textContent = seconds;
    }

    setInterval(updateClock, 1000);
    updateClock();

    // Ici, vous pouvez ajouter la logique pour les autres fonctionnalités
    // comme le chronomètre, le minuteur et le réveil
});