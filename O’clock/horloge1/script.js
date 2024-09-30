


// Fonctions pour gérer la navigation entre les sections
function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById(sectionId).classList.add('active');
}

document.getElementById('timerBtn').addEventListener('click', () => showSection('timerSection'));
document.getElementById('stopwatchBtn').addEventListener('click', () => showSection('stopwatchSection'));
document.getElementById('clockBtn').addEventListener('click', () => showSection('clockSection'));
document.getElementById('alarmBtn').addEventListener('click', () => showSection('alarmSection'));

// Minuteur
let timerInterval;
let timerTime = 0;

function startTimer() {
    timerInterval = setInterval(() => {
        if (timerTime > 0) {
            timerTime--;
            updateTimerDisplay();
        } else {
            clearInterval(timerInterval);
            alert("Le temps est écoulé !");
        }
    }, 1000);
}

function stopTimer() {
    clearInterval(timerInterval);
}

function resetTimer() {
    stopTimer();
    timerTime = 0;
    updateTimerDisplay();
}

function updateTimerDisplay() {
    const hours = Math.floor(timerTime / 3600);
    const minutes = Math.floor((timerTime % 3600) / 60);
    const seconds = timerTime % 60;
    document.querySelector('.timer-display').textContent = 
        `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

document.getElementById('startStopTimer').addEventListener('click', function() {
    if (this.textContent === 'Démarrer') {
        startTimer();
        this.textContent = 'Arrêter';
    } else {
        stopTimer();
        this.textContent = 'Démarrer';
    }
});

document.getElementById('resetTimer').addEventListener('click', resetTimer);

document.getElementById('timerInput').addEventListener('change', function() {
    const [hours, minutes, seconds] = this.value.split(':').map(Number);
    timerTime = hours * 3600 + minutes * 60 + seconds;
    updateTimerDisplay();
});

// Chronomètre
let stopwatchInterval;
let stopwatchTime = 0;
let isRunning = false;

function startStopwatch() {
    isRunning = true;
    stopwatchInterval = setInterval(() => {
        stopwatchTime++;
        updateStopwatchDisplay();
    }, 1000);
}

function stopStopwatch() {
    isRunning = false;
    clearInterval(stopwatchInterval);
}

function resetStopwatch() {
    stopStopwatch();
    stopwatchTime = 0;
    updateStopwatchDisplay();
    document.getElementById('lapTimes').innerHTML = '';
}

function updateStopwatchDisplay() {
    const hours = Math.floor(stopwatchTime / 3600);
    const minutes = Math.floor((stopwatchTime % 3600) / 60);
    const seconds = stopwatchTime % 60;
    document.querySelector('.stopwatch-display').textContent = 
        `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

function addLap() {
    const lapTime = document.querySelector('.stopwatch-display').textContent;
    const lapItem = document.createElement('li');
    lapItem.textContent = lapTime;
    document.getElementById('lapTimes').appendChild(lapItem);
}

document.getElementById('startStopStopwatch').addEventListener('click', function() {
    if (isRunning) {
        stopStopwatch();
        this.textContent = 'Démarrer';
    } else {
        startStopwatch();
        this.textContent = 'Arrêter';
    }
});

document.getElementById('lapStopwatch').addEventListener('click', addLap);
document.getElementById('resetStopwatch').addEventListener('click', resetStopwatch);

// Horloge
function updateClock() {
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();
    document.querySelector('.clock-display').textContent = 
        `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

setInterval(updateClock, 1000);

// Réveil
let alarms = [];

function setAlarm() {
    const time = document.getElementById('alarmTime').value;
    const message = document.getElementById('alarmMessage').value;
    
    if (time && message) {
        alarms.push({ time, message });
        updateAlarmList();
        checkAlarms();
    }
}

function updateAlarmList() {
    const alarmList = document.getElementById('alarmList');
    alarmList.innerHTML = '';
    
    alarms.forEach((alarm, index) => {
        const li = document.createElement('li');
        const now = new Date();
        const alarmTime = new Date(now.toDateString() + ' ' + alarm.time);
        
        if (alarmTime < now) {
            li.textContent = `${alarm.time} - ${alarm.message} (passée)`;
        } else {
            const timeDiff = alarmTime - now;
            const hours = Math.floor(timeDiff / (1000 * 60 * 60));
            const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
            li.textContent = `${alarm.time} - ${alarm.message} (dans ${hours}h ${minutes}m)`;
        }
        
        alarmList.appendChild(li);
    });
}

function checkAlarms() {
    const now = new Date();
    const currentTime = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
    
    alarms.forEach((alarm, index) => {
        if (alarm.time === currentTime) {
            alert(alarm.message);
            alarms.splice(index, 1);
            updateAlarmList();
        }
    });
}

document.getElementById('setAlarm').addEventListener('click', setAlarm);

setInterval(checkAlarms, 1000);
setInterval(updateAlarmList, 60000); // Mise à jour de la liste des alarmes toutes les minutes