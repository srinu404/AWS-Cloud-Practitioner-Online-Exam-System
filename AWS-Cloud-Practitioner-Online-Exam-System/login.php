<?php
session_start();
include "config/db.php";

$error = "";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $res = mysqli_query($conn,
        "SELECT * FROM students WHERE email='$email'");

    $row = mysqli_fetch_assoc($res);

    if ($row && password_verify($password, $row['password'])) {

        $_SESSION['student_id'] = $row['id'];

        // 🔐 ONE-TIME EXAM LOGIC
        if ($row['has_attempted'] == 1) {
            header("Location: student_dashboard.php");
        } else {
            header("Location: student_dashboard.php");

        }
        exit();

    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <link rel="stylesheet" href="css/style.css">
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

    const plate = document.querySelector(".container");

    /* Faster Floating Animation */
    let direction = 1;
    setInterval(() => {
        plate.style.transition = "transform 1.8s ease-in-out";
        plate.style.transform = `translateY(${direction * 12}px)`;
        direction *= -1;
    }, 1800);

    /* Faster Glow Pulse */
    setInterval(() => {
        plate.style.boxShadow = "0 30px 70px rgba(255,153,0,0.6)";
        setTimeout(() => {
            plate.style.boxShadow = "0 15px 35px rgba(0,0,0,0.3)";
        }, 700);
    }, 2500);

});
</script>

<body>

<div class="container">
    <h2>Student Login</h2>

    <?php if ($error) { ?>
        <p style="color:red;text-align:center;">
            <?php echo $error; ?>
        </p>
    <?php } ?>

    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>  <br>

    <a href="index.php" class="btn-cancel">Cancel</a>

    <div class="link">
        <a href="register.php">New user? Register</a>
    </div>
    
</div>

</body>
</html>
