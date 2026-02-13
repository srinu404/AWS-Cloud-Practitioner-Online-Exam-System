<?php
/* FORCE HTTPS FOR CAMERA ACCESS */
if (
    (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] !== 'https'
) {
    $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirect");
    exit();
}

session_start();
include "config/db.php";

/* LOGIN CHECK */
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

/* STORE EXAM START TIME FOR THIS ATTEMPT */
$_SESSION['exam_start_time'] = time();

/* FETCH QUESTIONS */
$questions = mysqli_query($conn,
    "SELECT * FROM questions ORDER BY RAND() LIMIT 65");
?>

<!DOCTYPE html>
<html>
<head>
<title>AWS Cloud Practitioner Exam</title>
<link rel="stylesheet" href="css/style.css">

<style>

/* FULL SCREEN EXAM */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f4f6f9;
}

.exam-box {
    width: 100%;
    min-height: 100vh;
    background: #ffffff;
    padding: 40px 80px;
    box-sizing: border-box;
}

.exam-box h2 {
    text-align: center;
    color: #232f3e;
}

.timer {
    text-align: right;
    font-weight: bold;
    color: #e53935;
    font-size: 18px;
    margin-bottom: 25px;
}

.question-box {
    display: none;
    padding: 30px;
    background: #f9fafc;
    border-radius: 12px;
    border-left: 6px solid #ff9900;
}

.question-box.active {
    display: block;
}

.question-box p {
    font-size: 18px;
    margin-bottom: 20px;
}

.options label {
    display: block;
    padding: 14px 18px;
    margin: 12px 0;
    border-radius: 8px;
    background: #ffffff;
    border: 1px solid #ddd;
    cursor: pointer;
    transition: 0.3s ease;
}

.options label:hover {
    background: #fff4e5;
    border-color: #ff9900;
}

.options input {
    margin-right: 10px;
}

.nav-btns {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 35px;
}

button {
    padding: 12px 30px;
    font-size: 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s ease;
}

.nav-btns button:first-child {
    background: #ccc;
}

.nav-btns button:first-child:hover {
    background: #999;
}

.nav-btns button:last-child {
    background: #ff9900;
}

.nav-btns button:last-child:hover {
    background: #e68900;
}

#submitBtn {
    width: 100%;
    margin-top: 25px;
    background: #2e7d32;
    color: #fff;
}

#submitBtn:hover {
    background: #1b5e20;
}



#proctor-box {
    position: fixed;
    top: 20px;
    right: 20px;
    width: 260px;
    height: 200px;
    background: #000;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.4);
    z-index: 9999;
    overflow: hidden;
    resize: both;
}

#proctor-header {
    background: #232f3e;
    color: #fff;
    padding: 6px 10px;
    font-size: 13px;
    cursor: move;
    user-select: none;
}

#video {
    width: 100%;
    height: calc(100% - 40px);
    object-fit: cover;
}

#camera-status {
    position: absolute;
    bottom: 5px;
    left: 5px;
    font-size: 11px;
    font-weight: bold;
    color: #00ff00;
}
#examForm {
    display: none;
}
h5 {
    background-color: #ffff00;
    color: #000;
    padding: 5px 10px;
    display: inline-block; /* Keeps the highlight tight to the text */
    border-radius: 4px;
}
</style>
</head>

<body>

<div class="container exam-box">
    <h2>AWS Cloud Practitioner Exam</h2>
    <h5>Note:- Don't Refresh or Close the Tab During the Exam</h5>
    <div class="timer" id="timer">Time Left: 90:00</div>

<form method="post" action="submit_exam.php" id="examForm">

<?php
$qno = 1;
while ($q = mysqli_fetch_assoc($questions)) {

    /* MULTI-SELECT DETECTION */
    $isMultiple =
        (strpos($q['correct_answer'], ",") !== false ||
         strlen($q['correct_answer']) > 1);

    $inputType = $isMultiple ? 'checkbox' : 'radio';

    $nameAttr  = $isMultiple
        ? "ans[{$q['id']}][]"
        : "ans[{$q['id']}]";
?>

<div class="question-box <?php echo ($qno === 1) ? 'active' : ''; ?>">

    <p>
        <strong>Question <?php echo $qno; ?>:</strong>
        <?php echo htmlspecialchars($q['question']); ?>
    </p>

    <div class="options">
        <?php
        $opts = mysqli_query($conn,
            "SELECT * FROM options WHERE question_id='{$q['id']}'");
        while ($op = mysqli_fetch_assoc($opts)) {
        ?>
            <label>
                <input type="<?php echo $inputType; ?>"
                       name="<?php echo $nameAttr; ?>"
                       value="<?php echo $op['option_value']; ?>">
                <?php echo htmlspecialchars($op['option_text']); ?>
            </label>
        <?php } ?>
    </div>

</div>

<?php
    $qno++;
}
?>

<div id="proctor-box">
    <div id="proctor-header">
        Live Proctor
        <span id="resize-handle"></span>
    </div>

    <video id="video" autoplay muted></video>
    <p id="camera-status"></p>
</div>


<div class="nav-btns">
    <button type="button" onclick="prevQuestion()">Previous</button>
    <button type="button" onclick="nextQuestion()">Next</button>
</div>

<button type="submit"
        id="submitBtn"
        style="display:none;margin-top:20px;">
    Submit Exam
</button>

<br>

<a href="student_dashboard.php" class="btn-cancel">Cancel</a>

</form>
</div>

<script src="js/timer.js"></script>

<script>
let current = 0;
let questions = document.querySelectorAll(".question-box");

function showQuestion(i) {
    questions.forEach(q => q.classList.remove("active"));
    questions[i].classList.add("active");

    document.getElementById("submitBtn").style.display =
        (i === questions.length - 1) ? "block" : "none";
}

function nextQuestion() {
    if (current < questions.length - 1) {
        current++;
        showQuestion(current);
    }
}

function prevQuestion() {
    if (current > 0) {
        current--;
        showQuestion(current);
    }
}
</script>
<script>
let video = document.getElementById("video");
let statusText = document.getElementById("camera-status");
let examForm = document.getElementById("examForm");

examForm.style.display = "none";

/* CHECK HTTPS */
if (location.protocol !== "https:") {
    statusText.innerHTML = "HTTPS Required for Camera Access";
    statusText.style.color = "red";
    alert("Camera requires HTTPS connection.");
} else {

    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        statusText.innerHTML = "Camera Not Supported in This Browser";
        statusText.style.color = "red";
        alert("Please use Chrome or Edge browser.");
    } else {

        navigator.mediaDevices.getUserMedia({
            video: true,
            audio: true
        })
        .then(function(stream) {

            video.srcObject = stream;

            statusText.innerHTML = "Camera & Microphone Active";
            statusText.style.color = "lime";

            examForm.style.display = "block";

            /* AUTO SUBMIT IF CAMERA OR MIC STOPS */
            stream.getTracks().forEach(track => {
                track.onended = function() {
                    alert("Camera or Microphone disconnected. Exam will be submitted.");
                    examForm.submit();
                };
            });

        })
        .catch(function(error) {

            statusText.innerHTML = "Camera & Microphone Required";
            statusText.style.color = "red";

            alert("Please allow camera and microphone access to start the exam.");
        });
    }
}
</script>




<script>
const proctorBox = document.getElementById("proctor-box");
const header = document.getElementById("proctor-header");

let offsetX, offsetY, isDragging = false;

header.addEventListener("mousedown", function(e) {
    isDragging = true;
    offsetX = e.clientX - proctorBox.offsetLeft;
    offsetY = e.clientY - proctorBox.offsetTop;
});

document.addEventListener("mousemove", function(e) {
    if (isDragging) {
        proctorBox.style.left = (e.clientX - offsetX) + "px";
        proctorBox.style.top = (e.clientY - offsetY) + "px";
        proctorBox.style.right = "auto";
    }
});

document.addEventListener("mouseup", function() {
    isDragging = false;
});
</script>


</body>
</html>
