<?php
session_start();
include "../config/db.php";

/* ADMIN CHECK */
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

/* Increase execution time for large files */
set_time_limit(300);

error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = "";

if (isset($_POST['upload'])) {

    if (!isset($_FILES['csv']) || $_FILES['csv']['error'] !== 0) {
        $message = "❌ File upload failed.";
    }
    else {

        $fileTmp = $_FILES['csv']['tmp_name'];

        if (($handle = fopen($fileTmp, "r")) !== FALSE) {

            $rowCount = 0;
            $inserted = 0;
            $skipped = 0;

            // Skip header
            fgetcsv($handle);

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $rowCount++;

                if (count($data) < 6) {
                    $skipped++;
                    continue;
                }

                $question = trim($data[0]);
                $A = trim($data[1]);
                $B = trim($data[2]);
                $C = trim($data[3]);
                $D = trim($data[4]);
                $correct = strtoupper(trim($data[5]));

                if (empty($question)) {
                    $skipped++;
                    continue;
                }

                // Normalize question
                $normalized = strtolower(preg_replace('/\s+/', ' ', $question));

                // Escape everything safely
                $normalized = mysqli_real_escape_string($conn, $normalized);
                $A = mysqli_real_escape_string($conn, $A);
                $B = mysqli_real_escape_string($conn, $B);
                $C = mysqli_real_escape_string($conn, $C);
                $D = mysqli_real_escape_string($conn, $D);
                $correct = mysqli_real_escape_string($conn, $correct);

                /* DUPLICATE CHECK */
                $check = mysqli_query($conn,
                    "SELECT id FROM questions WHERE question='$normalized'");

                if ($check === false) {
                    die("Database Error: " . mysqli_error($conn));
                }

                if (mysqli_num_rows($check) > 0) {
                    $skipped++;
                    continue;
                }

                /* Detect question type automatically */
                $type = (strpos($correct, ",") !== false || strlen($correct) > 1)
                    ? 'multi'
                    : 'single';

                /* Insert question */
                $insertQ = mysqli_query($conn,
                    "INSERT INTO questions (question, type, correct_answer)
                     VALUES ('$normalized', '$type', '$correct')");

                if (!$insertQ) {
                    die("Insert Error: " . mysqli_error($conn));
                }

                $qid = mysqli_insert_id($conn);

                /* Insert options */
                mysqli_query($conn,
                    "INSERT INTO options (question_id, option_text, option_value)
                     VALUES ('$qid','$A','A')");

                mysqli_query($conn,
                    "INSERT INTO options (question_id, option_text, option_value)
                     VALUES ('$qid','$B','B')");

                mysqli_query($conn,
                    "INSERT INTO options (question_id, option_text, option_value)
                     VALUES ('$qid','$C','C')");

                mysqli_query($conn,
                    "INSERT INTO options (question_id, option_text, option_value)
                     VALUES ('$qid','$D','D')");

                $inserted++;
            }

            fclose($handle);

            $message = "✅ Upload Complete<br>
                        Total Rows: $rowCount<br>
                        Inserted: $inserted<br>
                        Skipped: $skipped";
        }
        else {
            $message = "❌ Cannot open uploaded file.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Bulk Upload Questions</title>
<link rel="stylesheet" href="../css/style.css">
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

<div class="container">
    <h2>Bulk Upload Questions (CSV)</h2>

    <?php if ($message) { ?>
        <p style="text-align:center;">
            <?php echo $message; ?>
        </p>
    <?php } ?>

    <form method="post" enctype="multipart/form-data">
        <input type="file" name="csv" accept=".csv" required>
        <button type="submit" name="upload">Upload CSV</button> <br>
        <button type="button" onclick="window.history.back();" class="btn-cancel">
    Cancel

</div>

</body>
</html>
