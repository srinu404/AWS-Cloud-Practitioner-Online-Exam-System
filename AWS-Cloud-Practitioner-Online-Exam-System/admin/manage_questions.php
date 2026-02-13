<?php
session_start();
include "../config/db.php";

/* ADMIN CHECK */
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

/* SEARCH LOGIC */
$search = "";
$where = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where = "WHERE question LIKE '%$search%' OR id LIKE '%$search%'";
}

/* FETCH QUESTIONS */
$questions = mysqli_query($conn,
    "SELECT * FROM questions $where ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Questions</title>
<link rel="stylesheet" href="../css/style.css">

<style>
.table-box { width: 1100px; }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 10px; border: 1px solid #ccc; }
th { background:#232f3e; color:#fff; }
a.btn {
    padding: 5px 10px;
    background:#ff9900;
    color:#000;
    text-decoration:none;
    border-radius:4px;
}
a.del { background:red; color:#fff; }
.search-box {
    margin-bottom: 15px;
}
.search-box input {
    width: 300px;
    padding: 8px;
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
<h2>Manage Exam Questions</h2>

<!-- 🔍 SEARCH BAR -->
<form method="get" class="search-box">
    
    <input type="text"
           name="search"
           placeholder="Search by question or ID"
           value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Search</button>
    <button type="button" onclick="window.history.back();" class="btn-cancel">
    Cancel
</button>
    
    <a href="manage_questions.php">Reset</a>
    
</form>

<table>
<tr>
    <th>ID</th>
    <th>Question</th>
    <th>Type</th>
    <th>Correct</th>
    <th>Actions</th>
</tr>

<?php
if (mysqli_num_rows($questions) == 0) {
    echo "<tr><td colspan='5' style='text-align:center;'>No questions found</td></tr>";
}

while ($q = mysqli_fetch_assoc($questions)) {
?>
<tr>
    <td><?php echo $q['id']; ?></td>
    <td><?php echo htmlspecialchars($q['question']); ?></td>
    <td><?php echo $q['type']; ?></td>
    <td><?php echo $q['correct_answer']; ?></td>
    <td>
        <a class="btn" href="edit_question.php?id=<?php echo $q['id']; ?>">Edit</a>
        <a class="btn del"
           href="delete_question.php?id=<?php echo $q['id']; ?>"
           onclick="return confirm('Delete this question?')">
           Delete
        </a>
    </td>
</tr>
<?php } ?>

</table>
</div>

</body>
</html>
