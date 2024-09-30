document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        locale: 'fr',
        events: '/api/rendez-vous',
        dateClick: function(info) {
            ouvrirModalRendezVous(info.date);
        }
    });
    calendar.render();

    // Initialiser les éléments Materialize
    const elems = document.querySelectorAll('.modal');
    M.Modal.init(elems);

    const datepicker = M.Datepicker.init(document.getElementById('dateRendezVous'), {
        format: 'yyyy-mm-dd',
        onClose: () => M.updateTextFields()
    });

    const timepicker = M.Timepicker.init(document.getElementById('heureRendezVous'), {
        defaultTime: '09:00',
        onCloseEnd: () => M.updateTextFields()
    });

    document.getElementById('sauvegarderRendezVous').addEventListener('click', sauvegarderRendezVous);
});

function ouvrirModalRendezVous(date) {
    const dateRendezVous = document.getElementById('dateRendezVous');
    dateRendezVous.value = date.toISOString().split('T')[0];
    M.updateTextFields();
    const modalRendezVous = M.Modal.getInstance(document.getElementById('modalRendezVous'));
    modalRendezVous.open();
}

async function sauvegarderRendezVous() {
    const utilisateur = JSON.parse(localStorage.getItem('utilisateur'));
    const date = document.getElementById('dateRendezVous').value;
    const heure = document.getElementById('heureRendezVous').value;
    const description = document.getElementById('descriptionRendezVous').value;

    if (!utilisateur || !date || !heure || !description) {
        M.toast({html: 'Tous les champs sont requis'});
        return;
    }

    try {
        const reponse = await fetch('/api/rendez-vous', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify({ utilisateur: utilisateur.id, date, heure, description })
        });

        if (!reponse.ok) {
            const texteErreur = await reponse.text();
            console.error('Réponse du serveur:', texteErreur);
            throw new Error(`Échec de l'enregistrement du rendez-vous: ${reponse.status} ${reponse.statusText}`);
        }

        const data = await reponse.json();
        M.toast({html: 'Rendez-vous enregistré avec succès!'});
        const modalRendezVous = M.Modal.getInstance(document.getElementById('modalRendezVous'));
        modalRendezVous.close();
        calendar.refetchEvents();
    } catch (erreur) {
        console.error('Erreur lors de la sauvegarde du rendez-vous:', erreur);
        M.toast({html: erreur.message});
    }
}

// Fonction pour se déconnecter
function deconnexion() {
    localStorage.removeItem('token');
    window.location.href = '/page/connexion.html';
}

// Ajouter un écouteur d'événement pour le bouton de déconnexion
document.addEventListener('DOMContentLoaded', function() {
    const boutonDeconnexion = document.getElementById('boutonDeconnexion');
    if (boutonDeconnexion) {
        boutonDeconnexion.addEventListener('click', deconnexion);
    }
});