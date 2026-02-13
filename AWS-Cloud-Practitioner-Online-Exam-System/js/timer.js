let totalTime = 90 * 60; // 90 minutes in seconds

function startTimer() {
    let timerDisplay = document.getElementById("timer");

    let interval = setInterval(function () {
        let minutes = Math.floor(totalTime / 60);
        let seconds = totalTime % 60;

        seconds = seconds < 10 ? "0" + seconds : seconds;

        timerDisplay.innerHTML = "Time Left: " + minutes + ":" + seconds;

        if (totalTime <= 0) {
            clearInterval(interval);
            alert("Time is up! Exam will be submitted.");
            document.getElementById("examForm").submit();
        }

        totalTime--;
    }, 1000);
}

window.onload = startTimer;
