document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les éléments de date avec la date du jour
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        input.min = new Date().toISOString().split('T')[0];
    });

    // Ajouter une confirmation avant la suppression d'un utilisateur
    const deleteButtons = document.querySelectorAll('button[name="delete_user"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                e.preventDefault();
            }
        });
    });

    // Pré-sélectionner le rôle actuel dans le formulaire de modification
    const roleSelects = document.querySelectorAll('select[name="new_role"]');
    roleSelects.forEach(select => {
        const currentRole = select.closest('tr').querySelector('td:nth-child(3)').textContent;
        select.value = currentRole;
    });

    // Ajouter une classe pour les demandes expirées
    const demandeRows = document.querySelectorAll('table tbody tr');
    demandeRows.forEach(row => {
        const datePresence = new Date(row.querySelector('td:nth-child(2)').textContent);
        if (datePresence < new Date()) {
            row.classList.add('expired');
        }
    });
});