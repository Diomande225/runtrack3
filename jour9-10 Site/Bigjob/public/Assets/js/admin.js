document.addEventListener('DOMContentLoaded', function() {
    loadPendingAppointments();
    loadStatistics();

    document.getElementById('logoutBtn').addEventListener('click', logout);
});

async function loadPendingAppointments() {
    try {
        const response = await fetch('/api/admin/pending-appointments', {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        if (response.ok) {
            const appointments = await response.json();
            displayPendingAppointments(appointments);
        } else {
            throw new Error('Échec du chargement des rendez-vous en attente');
        }
    } catch (error) {
        M.toast({html: error.message});
    }
}

function displayPendingAppointments(appointments) {
    const list = document.getElementById('pendingAppointments');
    list.innerHTML = '';
    appointments.forEach(appointment => {
        const li = document.createElement('li');
        li.className = 'collection-item';
        li.innerHTML = `
            <div>
                ${appointment.date} - ${appointment.time} : ${appointment.description}
                <a href="#!" class="secondary-content" onclick="approveAppointment(${appointment.id})">
                    <i class="material-icons green-text">check</i>
                </a>
                <a href="#!" class="secondary-content" onclick="rejectAppointment(${appointment.id})">
                    <i class="material-icons red-text">close</i>
                </a>
            </div>
        `;
        list.appendChild(li);
    });
}

async function approveAppointment(id) {
    try {
        const response = await fetch(`/api/admin/appointments/${id}/approve`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        if (response.ok) {
            M.toast({html: 'Rendez-vous approuvé'});
            loadPendingAppointments();
        } else {
            throw new Error('Échec de l\'approbation du rendez-vous');
        }
    } catch (error) {
        M.toast({html: error.message});
    }
}

async function rejectAppointment(id) {
    try {
        const response = await fetch(`/api/admin/appointments/${id}/reject`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        if (response.ok) {
            M.toast({html: 'Rendez-vous rejeté'});
            loadPendingAppointments();
        } else {
            throw new Error('Échec du rejet du rendez-vous');
        }
    } catch (error) {
        M.toast({html: error.message});
    }
}

async function loadStatistics() {
    try {
        const response = await fetch('/api/admin/statistics', {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        if (response.ok) {
            const stats = await response.json();
            document.getElementById('totalUsers').textContent = stats.totalUsers;
            document.getElementById('weeklyAppointments').textContent = stats.weeklyAppointments;
        } else {
            throw new Error('Échec du chargement des statistiques');
        }
    } catch (error) {
        M.toast({html: error.message});
    }
}

function logout() {
    localStorage.removeItem('token');
    window.location.href = '/page/login.html';
}