<?php
include "config/db.php";

$msg = "";

if (isset($_POST['send'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $pdfName = NULL;

    // Handle PDF upload
    if (!empty($_FILES['pdf']['name'])) {

        $folder = "uploads/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $pdfName = time() . "_" . basename($_FILES['pdf']['name']);
        $target = $folder . $pdfName;

        move_uploaded_file($_FILES['pdf']['tmp_name'], $target);
    }

    mysqli_query($conn,
        "INSERT INTO contact_messages (name, email, message, pdf_file)
         VALUES ('$name', '$email', '$message', '$pdfName')"
    );

    $msg = "Your message has been sent successfully ✔";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Contact Us</title>
<link rel="stylesheet" href="css/style.css">

<style>
.contact-box {
    width: 600px;
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

<div class="container contact-box">
    <h2>Share / Contact / Feedback</h2>

    <p>
        Use this page to:
        <ul>
            <li>Report mistakes in MCQs</li>
            <li>Share additional AWS questions</li>
            <li>Share additional AWS Material's</li>
            <li>Upload PDF question sets</li>
        </ul>
    </p>

    <?php if ($msg) { ?>
        <p style="color:green;text-align:center;">
            <?php echo $msg; ?>
        </p>
    <?php } ?>

    <form method="post" enctype="multipart/form-data">

        <input type="text" name="name"
               placeholder="Your Name" required>

        <input type="email" name="email"
               placeholder="Your Email" required>

        <textarea name="message"
                  placeholder="Describe the mistake, share feedback, any additional questions or materials you want to share..."
                  rows="5" required></textarea>

        <label>Upload PDF (optional)</label>
        <input type="file" name="pdf" accept=".pdf">

        <button type="submit" name="send">
            Send Message
        </button>
        <br>
        <a href="index.php" class="btn-cancel">Cancel</a>

    </form>
</div>

</body>
</html>
