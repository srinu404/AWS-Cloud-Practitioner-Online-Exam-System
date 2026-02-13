<?php
session_start();
include "config/db.php";

/* STUDENT LOGIN CHECK */
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

/* FETCH STUDY MATERIALS */
$materials = mysqli_query($conn,
    "SELECT * FROM study_materials ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Prepare for Exam</title>
<link rel="stylesheet" href="css/style.css">

<style>

/* BACKGROUND */
body {
    margin: 0;
    font-family: 'Segoe UI', Arial, sans-serif;
    background: linear-gradient(135deg, #2c3e50, #f39c12);
}

/* MAIN CONTAINER */
.prepare-container {
    width: 95%;
    max-width: 1200px;
    margin: 50px auto;
    background: #ffffff;
    padding: 40px;
    border-radius: 18px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.25);
}

/* HEADING */
.prepare-container h2 {
    text-align: center;
    color: #232f3e;
    margin-bottom: 30px;
    font-size: 28px;
}

/* GRID LAYOUT */
.material-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
}

/* CARD */
.material-card {
    background: #f9fafc;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    transition: 0.3s ease;
    border-left: 6px solid #ff9900;
}

.material-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

/* TITLE */
.material-card h4 {
    margin: 0 0 10px 0;
    color: #232f3e;
    font-size: 18px;
}

/* DATE */
.material-card .date {
    font-size: 13px;
    color: #666;
    margin-bottom: 15px;
}

/* BUTTONS */
.material-card a {
    display: inline-block;
    padding: 10px 18px;
    margin-right: 10px;
    border-radius: 8px;
    font-weight: bold;
    text-decoration: none;
    transition: 0.3s ease;
}

/* READ BUTTON */
.read-btn {
    background: #ff9900;
    color: #232f3e;
}

.read-btn:hover {
    background: #e68900;
}

/* DOWNLOAD BUTTON */
.download-btn {
    background: #2e7d32;
    color: #ffffff;
}

.download-btn:hover {
    background: #1b5e20;
}

/* BACK BUTTON */
.back-btn {
    display: block;
    width: 200px;
    margin: 40px auto 0 auto;
    text-align: center;
    padding: 12px;
    background: #ccc;
    color: #000;
    border-radius: 8px;
    font-weight: bold;
    text-decoration: none;
    transition: 0.3s ease;
}

.back-btn:hover {
    background: #999;
}

.no-material {
    text-align: center;
    font-size: 16px;
    color: #555;
    margin-top: 20px;
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

<div class="prepare-container">
    <h2>Preparation Materials</h2>

    <?php if (mysqli_num_rows($materials) == 0) { ?>
        <div class="no-material">
            No study materials available yet.
        </div>
    <?php } else { ?>

    <div class="material-grid">

        <?php while ($row = mysqli_fetch_assoc($materials)) { ?>

        <div class="material-card">
            <h4><?php echo htmlspecialchars($row['title']); ?></h4>

            <div class="date">
                Uploaded on:
                <?php echo date("d-m-Y h:i A",
                    strtotime($row['uploaded_at'])); ?>
            </div>

            <a href="uploads/<?php echo $row['file_name']; ?>"
               target="_blank"
               class="read-btn">
               Read
            </a>

            <a href="uploads/<?php echo $row['file_name']; ?>"
               download
               class="download-btn">
               Download
            </a>
        </div>

        <?php } ?>

    </div>

    <?php } ?>

    <a href="student_dashboard.php" class="back-btn">
        Back
    </a>

</div>

</body>
</html>
