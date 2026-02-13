<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

/* GET SELECTED ATTEMPT */
$selected_attempt = isset($_GET['attempt']) 
    ? intval($_GET['attempt']) 
    : 0;

/* FETCH ALL ATTEMPTS */
$allAttempts = mysqli_query($conn,
    "SELECT attempt_no, score, result, submitted_at
     FROM results
     WHERE student_id='$student_id'
     ORDER BY attempt_no DESC");

/* IF NO ATTEMPT SELECTED → GET LATEST */
if ($selected_attempt == 0) {
    $latest = mysqli_fetch_assoc($allAttempts);
    if ($latest) {
        $selected_attempt = $latest['attempt_no'];
    }
}

/* FETCH SELECTED RESULT */
$res = mysqli_query($conn,
    "SELECT * FROM results
     WHERE student_id='$student_id'
     AND attempt_no='$selected_attempt'");
$result = mysqli_fetch_assoc($res);

/* FETCH ANSWERS FOR SELECTED ATTEMPT */
$answers = mysqli_query($conn,
    "SELECT a.question_id,
            a.answer AS user_answer,
            q.question,
            q.correct_answer
     FROM answers a
     JOIN questions q ON a.question_id = q.id
     WHERE a.student_id='$student_id'
     AND a.attempt_no='$selected_attempt'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Exam Result</title>
<link rel="stylesheet" href="css/style.css">

<style>

.review { width: 900px; }

.correct { color: green; font-weight: bold; }
.wrong { color: red; font-weight: bold; }

.attempt-list {
    background: #f5f5f5;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.attempt-list ul {
    list-style: none;
    padding: 0;
}

.attempt-list li {
    margin: 8px 0;
}

.attempt-list a {
    text-decoration: none;
    font-weight: bold;
    color: #ff9900;
}

.attempt-list a:hover {
    text-decoration: underline;
}

.question-card {
    background: #f9fafc;
    padding: 20px;
    margin-bottom: 20px;
    border-left: 6px solid #ff9900;
    border-radius: 10px;
}

hr {
    margin: 20px 0;
}

</style>
</head>
<canvas id="bgCanvas" style="position:fixed;top:0;left:0;z-index:-1;"></canvas>

<script>
const canvas = document.getElementById("bgCanvas");
const ctx = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let particles = [];
let mouse = { x: null, y: null };

class Particle {
    constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.size = Math.random() * 2 + 1;
        this.speedX = (Math.random() - 0.5) * 0.6;
        this.speedY = (Math.random() - 0.5) * 0.6;
    }

    update() {
        this.x += this.speedX;
        this.y += this.speedY;

        if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
        if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;

        // Mouse interaction glow
        let dx = this.x - mouse.x;
        let dy = this.y - mouse.y;
        let distance = Math.sqrt(dx * dx + dy * dy);

        if (distance < 120) {
            this.size = 4;
        } else {
            this.size = 2;
        }
    }

    draw() {
        ctx.fillStyle = "rgba(255,153,0,0.6)";
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fill();
    }
}

function init() {
    particles = [];
    for (let i = 0; i < 100; i++) {
        particles.push(new Particle());
    }
}

function connectParticles() {
    for (let a = 0; a < particles.length; a++) {
        for (let b = a; b < particles.length; b++) {
            let dx = particles[a].x - particles[b].x;
            let dy = particles[a].y - particles[b].y;
            let distance = dx * dx + dy * dy;

            if (distance < 10000) {
                ctx.strokeStyle = "rgba(255,153,0,0.1)";
                ctx.lineWidth = 1;
                ctx.beginPath();
                ctx.moveTo(particles[a].x, particles[a].y);
                ctx.lineTo(particles[b].x, particles[b].y);
                ctx.stroke();
            }
        }
    }
}

function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particles.forEach(p => {
        p.update();
        p.draw();
    });
    connectParticles();
    requestAnimationFrame(animate);
}

window.addEventListener("mousemove", function(e) {
    mouse.x = e.x;
    mouse.y = e.y;
});

window.addEventListener("resize", function() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    init();
});

init();
animate();

/* Smooth Card Entrance */
const cards = document.querySelectorAll(".card");
cards.forEach((card, index) => {
    card.style.opacity = "0";
    card.style.transform = "translateY(40px)";
    setTimeout(() => {
        card.style.transition = "all 0.8s ease";
        card.style.opacity = "1";
        card.style.transform = "translateY(0)";
    }, index * 300);
});
</script>
<body>

<div class="container review">

<h2>Exam Result</h2>

<!-- Attempt History -->
<div class="attempt-list">
    <h3>Your Attempts</h3>
    <ul>
    <?php
    $allAttempts2 = mysqli_query($conn,
        "SELECT attempt_no, score 
         FROM results
         WHERE student_id='$student_id'
         ORDER BY attempt_no DESC");

    while ($att = mysqli_fetch_assoc($allAttempts2)) {
    ?>
        <li>
            <a href="result.php?attempt=<?php echo $att['attempt_no']; ?>">
                Attempt <?php echo $att['attempt_no']; ?>
                (Score: <?php echo $att['score']; ?>)
            </a>
        </li>
    <?php } ?>
    </ul>
</div>

<?php if ($result) { ?>

<p style="text-align:center;font-size:20px;">
    Attempt No: <strong><?php echo $result['attempt_no']; ?></strong>
</p>

<p style="text-align:center;font-size:20px;">
    Score: <strong><?php echo $result['score']; ?> / 1000</strong>
</p>

<p style="text-align:center;font-size:24px;
color:<?php echo ($result['result']=='PASS')?'green':'red'; ?>">
<?php echo $result['result']; ?>
</p>

<p style="text-align:center;">
    Exam Date:
    <?php
    if (!empty($result['submitted_at'])) {
        echo date("d-m-Y h:i:s A",
             strtotime($result['submitted_at']));
    }
    ?>
</p>

<hr>

<?php
$qno = 1;
while ($row = mysqli_fetch_assoc($answers)) {

    $userArr = (strpos($row['user_answer'], ',') !== false)
        ? explode(",", $row['user_answer'])
        : str_split($row['user_answer']);

    $correctArr = (strpos($row['correct_answer'], ',') !== false)
        ? explode(",", $row['correct_answer'])
        : str_split($row['correct_answer']);
?>

<div class="question-card">

<p>
<strong>Q<?php echo $qno++; ?>.</strong>
<?php echo htmlspecialchars($row['question']); ?>
</p>

<p><strong>Your Answer:</strong></p>
<ul>
<?php
foreach ($userArr as $ua) {

    $opt = mysqli_query($conn,
        "SELECT option_text FROM options
         WHERE question_id='{$row['question_id']}'
         AND option_value='$ua'");
    $optRow = mysqli_fetch_assoc($opt);

    if ($optRow) {
        $class = in_array($ua, $correctArr) ? 'correct' : 'wrong';

        echo "<li class='$class'>$ua) "
             . htmlspecialchars($optRow['option_text'])
             . "</li>";
    }
}
?>
</ul>

<p><strong>Correct Answer:</strong></p>
<ul>
<?php
foreach ($correctArr as $ca) {

    $opt = mysqli_query($conn,
        "SELECT option_text FROM options
         WHERE question_id='{$row['question_id']}'
         AND option_value='$ca'");
    $optRow = mysqli_fetch_assoc($opt);

    if ($optRow) {
        echo "<li class='correct'>$ca) "
             . htmlspecialchars($optRow['option_text'])
             . "</li>";
    }
}
?>
</ul>

</div>

<?php } ?>

<?php } else { ?>

<p>No attempt found.</p>

<?php } ?>

<button type="button"
        onclick="window.location.href='student_dashboard.php';"
        class="btn-cancel">
    Back
</button>


</div>

</body>
</html>
