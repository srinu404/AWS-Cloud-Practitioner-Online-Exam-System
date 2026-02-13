<?php
session_start();
include "../config/db.php";

/* ADMIN SECURITY */
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";

if (isset($_POST['add'])) {

    // Normalize question to avoid duplicates
    $question = strtolower(trim($_POST['question']));
    $question = preg_replace('/\s+/', ' ', $question);

    $type = $_POST['type']; // single | multiple
    $correct = strtoupper(trim($_POST['correct']));

    /* DUPLICATE CHECK */
    $check = mysqli_query($conn,
        "SELECT id FROM questions WHERE question='$question'");

    if (mysqli_num_rows($check) > 0) {

        $message = "❌ This question already exists.";

    } else {

        /* INSERT QUESTION */
        $insert = mysqli_query($conn,
            "INSERT INTO questions (question, type, correct_answer)
             VALUES ('$question', '$type', '$correct')");

        if ($insert) {

            $qid = mysqli_insert_id($conn);

            /* INSERT OPTIONS */
            foreach ($_POST['options'] as $key => $opt) {
                $opt = trim($opt);
                mysqli_query($conn,
                    "INSERT INTO options (question_id, option_text, option_value)
                     VALUES ('$qid','$opt','$key')");
            }

            $message = "✅ Question added successfully.";
        } else {
            $message = "❌ Failed to add question.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Question</title>
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
<h2>Add Exam Question</h2>

<?php if ($message) { ?>
<p style="text-align:center;color:red;"><?php echo $message; ?></p>
<?php } ?>

<form method="post">

<textarea name="question" placeholder="Enter question" required></textarea>

<label>Question Type</label>
<select name="type" required>
    <option value="single">Single Answer</option>
    <option value="multiple">Multiple Answer</option>
</select>

<input type="text" name="options[A]" placeholder="Option A" required>
<input type="text" name="options[B]" placeholder="Option B" required>
<input type="text" name="options[C]" placeholder="Option C" required>
<input type="text" name="options[D]" placeholder="Option D" required>

<input type="text"
       name="correct"
       placeholder="Correct Answer (A or A,B)"
       required>

<button name="add">Add Question</button>
<br>
<button type="button" onclick="window.history.back();" class="btn-cancel">
    Cancel
</button>


</form>
</div>

</body>
</html>