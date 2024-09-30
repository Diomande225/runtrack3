document.addEventListener('DOMContentLoaded', function() {
    const timeDisplay = document.getElementById('timeDisplay');
    const timerBtn = document.getElementById('timerBtn');
    const stopwatchBtn = document.getElementById('stopwatchBtn');
    const alarmBtn = document.getElementById('alarmBtn');
    const timerControls = document.getElementById('timerControls');
    const stopwatchControls = document.getElementById('stopwatchControls');
    const alarmControls = document.getElementById('alarmControls');

    // Horloge
    function updateClock() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        timeDisplay.textContent = `${hours}:${minutes}:${seconds}`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Navigation
    timerBtn.addEventListener('click', () => {
        timerControls.style.display = 'block';
        stopwatchControls.style.display = 'none';
        alarmControls.style.display = 'none';
    });

    stopwatchBtn.addEventListener('click', () => {
        timerControls.style.display = 'none';
        stopwatchControls.style.display = 'block';
        alarmControls.style.display = 'none';
    });

    alarmBtn.addEventListener('click', () => {
        timerControls.style.display = 'none';
        stopwatchControls.style.display = 'none';
        alarmControls.style.display = 'block';
    });

    // Minuteur
    let timerInterval;
    let timerTime = 0;

    document.getElementById('startStopTimer').addEventListener('click', function() {
        if (this.textContent === 'Démarrer') {
            const input = document.getElementById('timerInput').value;
            const [hours, minutes, seconds] = input.split(':').map(Number);
            timerTime = hours * 3600 + minutes * 60 + seconds;
            
            timerInterval = setInterval(() => {
                if (timerTime > 0) {
                    timerTime--;
                    updateTimerDisplay();
                } else {
                    clearInterval(timerInterval);
                    alert("Le temps est écoulé !");
                    this.textContent = 'Démarrer';
                }
            }, 1000);
            
            this.textContent = 'Arrêter';
        } else {
            clearInterval(timerInterval);
            this.textContent = 'Démarrer';
        }
    });

    document.getElementById('resetTimer').addEventListener('click', () => {
        clearInterval(timerInterval);
        timerTime = 0;
        updateTimerDisplay();
        document.getElementById('startStopTimer').textContent = 'Démarrer';
    });

    function updateTimerDisplay() {
        const hours = Math.floor(timerTime / 3600).toString().padStart(2, '0');
        const minutes = Math.floor((timerTime % 3600) / 60).toString().padStart(2, '0');
        const seconds = (timerTime % 60).toString().padStart(2, '0');
        timeDisplay.textContent = `${hours}:${minutes}:${seconds}`;
    }

    // Chronomètre
    let stopwatchInterval;
    let stopwatchTime = 0;
    let isRunning = false;

    document.getElementById('startStopStopwatch').addEventListener('click', function() {
        if (!isRunning) {
            stopwatchInterval = setInterval(() => {
                stopwatchTime++;
                updateStopwatchDisplay();
            }, 1000);
            this.textContent = 'Arrêter';
            isRunning = true;
        } else {
            clearInterval(stopwatchInterval);
            this.textContent = 'Démarrer';
            isRunning = false;
        }
    });

    document.getElementById('lapStopwatch').addEventListener('click', () => {
        if (isRunning) {
            const lapItem = document.createElement('li');
            lapItem.textContent = timeDisplay.textContent;
            document.getElementById('lapTimes').appendChild(lapItem);
        }
    });

    document.getElementById('resetStopwatch').addEventListener('click', () => {
        clearInterval(stopwatchInterval);
        stopwatchTime = 0;
        updateStopwatchDisplay();
        document.getElementById('startStopStopwatch').textContent = 'Démarrer';
        isRunning = false;
        document.getElementById('lapTimes').innerHTML = '';
    });

    function updateStopwatchDisplay() {
        const hours = Math.floor(stopwatchTime / 3600).toString().padStart(2, '0');
        const minutes = Math.floor((stopwatchTime % 3600) / 60).toString().padStart(2, '0');
        const seconds = (stopwatchTime % 60).toString().padStart(2, '0');
        timeDisplay.textContent = `${hours}:${minutes}:${seconds}`;
    }

    // Réveil
    document.getElementById('setAlarm').addEventListener('click', () => {
        const alarmTime = document.getElementById('alarmTime').value;
        const alarmMessage = document.getElementById('alarmMessage').value;
        
        if (alarmTime && alarmMessage) {
            const now = new Date();
            const alarm = new Date(now.toDateString() + ' ' + alarmTime);
            
            if (alarm < now) {
                alarm.setDate(alarm.getDate() + 1);
            }
            
            const timeDiff = alarm - now;
            const hoursLeft = Math.floor(timeDiff / (1000 * 60 * 60));
            const minutesLeft = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
            
            const alarmItem = document.createElement('li');
            alarmItem.textContent = `${alarmTime} - ${alarmMessage} (dans ${hoursLeft}h ${minutesLeft}m)`;
            document.getElementById('alarmList').appendChild(alarmItem);
            
            setTimeout(() => {
                alert(alarmMessage);
                alarmItem.textContent += ' (passée)';
            }, timeDiff);
        }
    });
});
