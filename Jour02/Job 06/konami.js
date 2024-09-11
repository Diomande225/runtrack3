// konami.js

(function() {
    // Code Konami : ↑ ↑ ↓ ↓ ← → ← → B A
    const konamiCode = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'KeyB', 'KeyA'];
    let konamiCodeIndex = 0;

    function checkKonamiCode(event) {
        if (event.code === konamiCode[konamiCodeIndex]) {
            konamiCodeIndex++;
            if (konamiCodeIndex === konamiCode.length) {
                activateKonamiMode();
                konamiCodeIndex = 0;
            }
        } else {
            konamiCodeIndex = 0;
        }
    }

    function activateKonamiMode() {
        document.body.classList.add('konami-mode');
    }

    window.addEventListener('keydown', checkKonamiCode);
})();
