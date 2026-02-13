<?php
include "../config/db.php";

$msg = "";
$error = "";

if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check duplicate
    $check = mysqli_query($conn,
        "SELECT id FROM admins WHERE username='$username'");

    if (mysqli_num_rows($check) > 0) {
        $error = "Username already exists";
    } else {

        mysqli_query($conn,
            "INSERT INTO admins (username, password)
             VALUES ('$username', '$password')");

        $msg = "Admin registered successfully ✔";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Registration</title>
<link rel="stylesheet" href="../css/style.css">
<style>
.admin-link-btn {
    display: block;
    width: 100%;
    background: #ff9900;
    color: #232f3e;
    padding: 12px;
    text-align: center;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    margin-top: 12px;
    transition: 0.3s ease;
}

.admin-link-btn:hover {
    background: #e68900;
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

<div class="container">
    <h2>Admin Registration</h2>

    <?php if ($error) { ?>
        <p style="color:red;text-align:center;"><?php echo $error; ?></p>
    <?php } ?>

    <?php if ($msg) { ?>
        <p style="color:green;text-align:center;"><?php echo $msg; ?></p>
    <?php } ?>

    <form method="post">
        <input type="text" name="username"
               placeholder="Admin Username" required>

        <input type="password" name="password"
               placeholder="Admin Password" required>
<br>
        <button type="submit" name="register">Register</button>

        <a href="manage_admins.php" class="admin-link-btn">
    Manage Admin's
</a>
<br>
        <button type="button" onclick="window.history.back();" class="btn-cancel">
    Cancel
</button>
    </form>
</div>

</body>
</html>
