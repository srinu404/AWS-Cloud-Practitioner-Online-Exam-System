<?php
session_start();
include "../config/db.php";

/* ADMIN SECURITY CHECK */
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

/* FETCH ALL FEEDBACK */
$feedbacks = mysqli_query($conn,
    "SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>View Feedback</title>
<link rel="stylesheet" href="../css/style.css">

<style>
.table-box {
    width: 1000px;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}
th {
    background: #232f3e;
    color: #fff;
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

<div class="container table-box">
    <h2>User Feedback & MCQ Issues</h2>

    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>PDF</th>
            <th>Date</th>
            <th>Action</th> <!-- Added -->
        </tr>

        <?php 
        if (mysqli_num_rows($feedbacks) == 0) {
            echo "<tr><td colspan='6' align='center'>No feedback found</td></tr>";
        }

        while ($row = mysqli_fetch_assoc($feedbacks)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
            <td>
                <?php if ($row['pdf_file']) { ?>
                    <a href="../uploads/<?php echo $row['pdf_file']; ?>" target="_blank">
                        Download
                    </a>
                <?php } else { ?>
                    No File
                <?php } ?>
            </td>
            <td><?php echo $row['created_at']; ?></td>

            <!-- Added Delete Button -->
            <td>
                <a href="delete_feedback.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Delete this feedback?');"
                   style="color:red;font-weight:bold;">
                   Delete
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <br>
    <button type="button" onclick="window.history.back();" class="btn-cancel">
    Cancel
</button>
</div>
</body>
</html>
