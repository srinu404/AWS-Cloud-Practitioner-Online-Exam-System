<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>AWS Cloud Practitioner Exam</title>
<link rel="stylesheet" href="css/style.css">

<style>
.dashboard {
    width: 100%;
    max-width: 1000px;
    margin: auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    padding: 20px;
}

.card {
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(0,0,0,0.2);
}

.card h3 {
    margin-bottom: 15px;
    color: #232f3e;
    font-size: 20px;
}

.card p {
    font-size: 15px;
    margin-bottom: 20px;
    line-height: 1.6;
}

.card a {
    display: block;
    padding: 10px;
    margin: 8px 0;
    background: #ff9900;
    color: #232f3e;
    font-weight: bold;
    border-radius: 6px;
    text-decoration: none;
    transition: 0.3s;
}

.card a:hover {
    background: #e68a00;
}

.contact-btn {
    background: #555 !important;
    color: #fff !important;
}

.logout-btn {
    background: #d3d3d3 !important;
    color: #000 !important;
}

.logout-btn:hover {
    background: #bcbcbc !important;
}
</style>
</head>
<!-- Live Orange Particle Background -->
<canvas id="bgCanvas" style="position:fixed;top:0;left:0;z-index:-1;"></canvas>

<script>
const canvas = document.getElementById("bgCanvas");
const ctx = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let particles = [];

class Particle {
    constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.size = Math.random() * 3 + 1;
        this.speedX = (Math.random() - 0.5) * 0.5;
        this.speedY = (Math.random() - 0.5) * 0.5;
    }

    update() {
        this.x += this.speedX;
        this.y += this.speedY;

        if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
        if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
    }

    draw() {
        ctx.fillStyle = "rgba(255,153,0,0.4)";
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fill();
    }
}

function init() {
    for (let i = 0; i < 70; i++) {
        particles.push(new Particle());
    }
}

function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particles.forEach(p => {
        p.update();
        p.draw();
    });
    requestAnimationFrame(animate);
}

init();
animate();

window.addEventListener("resize", function() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});

/* Soft Pulse Glow on Cards */
const cards = document.querySelectorAll(".card");
cards.forEach(card => {
    setInterval(() => {
        card.style.boxShadow = "0 10px 25px rgba(255,153,0,0.5)";
        setTimeout(() => {
            card.style.boxShadow = "0 10px 25px rgba(0,0,0,0.15)";
        }, 1000);
    }, 4000);
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const cards = document.querySelectorAll(".card");

    /* Smooth Stagger Entrance */
    cards.forEach((card, index) => {
        card.style.opacity = "0";
        card.style.transform = "translateY(60px) scale(0.95)";
        
        setTimeout(() => {
            card.style.transition = "all 0.8s cubic-bezier(.17,.67,.83,.67)";
            card.style.opacity = "1";
            card.style.transform = "translateY(0) scale(1)";
        }, index * 250);
    });

    /* 3D Tilt Effect */
    cards.forEach(card => {

        card.addEventListener("mousemove", (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = -(y - centerY) / 15;
            const rotateY = (x - centerX) / 15;

            card.style.transform =
                `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05)`;
        });

        card.addEventListener("mouseleave", () => {
            card.style.transition = "all 0.5s ease";
            card.style.transform =
                "perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)";
        });

    });

    /* Soft Floating Effect */
    cards.forEach((card, index) => {
        let direction = 1;
        setInterval(() => {
            card.style.transition = "transform 3s ease-in-out";
            card.style.transform = `translateY(${direction * 10}px)`;
            direction *= -1;
        }, 3000 + (index * 500));
    });

    /* Glow Pulse Effect */
    cards.forEach(card => {
        setInterval(() => {
            card.style.boxShadow = "0 20px 40px rgba(255,153,0,0.6)";
            setTimeout(() => {
                card.style.boxShadow = "0 10px 25px rgba(0,0,0,0.15)";
            }, 1000);
        }, 4000);
    });

});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const plate = document.querySelector(".container");

    let position = 0;
    let direction = 1;

    function animatePlate() {

        /* Fast Smooth Floating */
        position += direction * 0.6;

        if (position > 15 || position < -15) {
            direction *= -1;
        }

        plate.style.transform = `translateY(${position}px)`;

        /* Dynamic Lighting Effect */
        const glowIntensity = 40 + Math.abs(position) * 2;
        plate.style.boxShadow =
            `0 ${glowIntensity}px 80px rgba(255,153,0,0.7),
             0 0 40px rgba(255,153,0,0.5)`;

        requestAnimationFrame(animatePlate);
    }

    animatePlate();

});
</script>

<body>

<div class="container dashboard">

    <!-- Exam Information -->
    <div class="card">
        <h3>Exam Information</h3>
        <p>
            Exam Name: AWS Cloud Practitioner<br>
            Total Questions: 65<br>
            Time Duration: 90 Minutes<br>
            Total Score: 1000<br>
            Passing Score: 700
        </p>

        <a href="contact.php" class="contact-btn">
            Contact / Feedback
        </a>
    </div>

    <!-- Student Section -->
    <div class="card">
        <h3>Student Access</h3>
        <p>
            New students must register first.  
            Registered students can login and attend the exam.
        </p>

        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
    </div>

    <!-- Admin Panel -->
    <div class="card">
        <h3>Admin Panel</h3>
<br>
        <?php if (isset($_SESSION['admin'])) { ?>
            <p>Admin authenticated. You can manage questions.</p>

            <a href="admin/add_question.php">Upload Questions</a>
            <a href="admin/bulk_upload.php">Bulk Upload Questions</a>
            <a href="admin/view_feedback.php">View Feedback</a>
            <a href="admin/manage_questions.php">Manage Questions</a>
            <a href="admin/manage_students.php">Manage Students</a>
            <a href="admin/view_results.php">View Results</a>
            <a href="admin/admin_register.php">Admin Register</a>
            <a href="admin/manage_materials.php">Manage Materials</a>

            <a href="admin/logout.php" class="logout-btn">
                Logout
            </a>

        <?php } else { ?>
            <p>Only Admin are allowed to Add (or) Update</p><br>
            <a href="admin/admin_login.php">Admin Login</a>
        <?php } ?>
    </div>

</div>

</body>
</html>
