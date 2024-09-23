document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les onglets Materialize
    const tabs = document.querySelectorAll('.tabs');
    M.Tabs.init(tabs);

    loadUsers();
    // Ajouter d'autres fonctions de chargement pour les autres onglets si nécessaire

    document.getElementById('logoutBtn').addEventListener('click', logout);
});

async function loadUsers() {
    try {
        const response = await fetch('/api/backoffice/users', {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        if (response.ok) {
            const users = await response.json();
            displayUsers(users);
        } else {
            throw new Error('Échec du chargement des utilisateurs');
        }
    } catch (error) {
        M.toast({html: error.message});
    }
}

function displayUsers(users) {
    const tbody = document.getElementById('usersList');
    tbody.innerHTML = '';
    users.forEach(user => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${user.id}</td>
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td>
                <a class="waves-effect waves-light btn-small" onclick="editUser(${user.id})">
                    <i class="material-icons">edit</i>
                </a>
                <a class="waves-effect waves-light btn-small red" onclick="deleteUser(${user.id})">
                    <i class="material-icons">delete</i>
                </a>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

async function editUser(id) {
    // Implémenter la logique d'édition d'utilisateur
    console.log(`Édition de l'utilisateur ${id}`);
}

async function deleteUser(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        try {
            const response = await fetch(`/api/backoffice/users/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            });
            if (response.ok) {
                M.toast({html: 'Utilisateur supprimé avec succès'});
                loadUsers();
            } else {
                throw new Error('Échec de la suppression de l\'utilisateur');
            }
        } catch (error) {
            M.toast({html: error.message});
        }
    }
}

function logout() {
    localStorage.removeItem('token');
    window.location.href = '/page/login.html';
}

// Ajouter d'autres fonctions pour gérer les offres d'emploi, les entreprises et les rapports