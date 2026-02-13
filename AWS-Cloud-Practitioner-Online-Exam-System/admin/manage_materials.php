<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$msg = "";

/* UPLOAD MATERIAL */
if (isset($_POST['upload'])) {

    $title = trim($_POST['title']);

    if (!empty($_FILES['pdf']['name'])) {

        $folder = "../uploads/";

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['pdf']['name']);
        $target = $folder . $fileName;

        if (move_uploaded_file($_FILES['pdf']['tmp_name'], $target)) {

            mysqli_query($conn,
                "INSERT INTO study_materials (title, file_name)
                 VALUES ('$title','$fileName')");

            $msg = "Material uploaded successfully ✔";
        }
    }
}

/* FETCH MATERIALS */
$materials = mysqli_query($conn,
    "SELECT * FROM study_materials ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Study Materials</title>
<link rel="stylesheet" href="../css/style.css">

<style>

.material-box {
    width: 1000px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: #ffffff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

th {
    background: #232f3e;
    color: #fff;
    padding: 14px;
    text-align: left;
}

td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

tr:hover {
    background: #f9fafc;
}

.view-link {
    color: #2e7d32;
    font-weight: bold;
    text-decoration: none;
}

.delete-link {
    color: #e53935;
    font-weight: bold;
    text-decoration: none;
}

.upload-box {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 25px;
}

.upload-box input {
    margin-bottom: 10px;
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

<div class="container material-box">

<h2>Manage Study Materials</h2>

<?php if ($msg) { ?>
<p style="color:green;text-align:center;font-weight:bold;">
    <?php echo $msg; ?>
</p>
<?php } ?>

<div class="upload-box">
<form method="post" enctype="multipart/form-data">

    <input type="text" name="title"
           placeholder="Material Title" required>

    <input type="file" name="pdf"
           accept=".pdf" required>

    <button name="upload">Upload</button>

</form>
</div>

<table>
<tr>
    <th>Title</th>
    <th>Uploaded Date</th>
    <th>File</th>
    <th>Action</th>
</tr>

<?php
if (mysqli_num_rows($materials) == 0) {
    echo "<tr><td colspan='4' align='center'>No materials uploaded yet</td></tr>";
}

while ($row = mysqli_fetch_assoc($materials)) {
?>
<tr>
    <td><?php echo htmlspecialchars($row['title']); ?></td>

    <td>
        <?php echo date("d-m-Y h:i A",
            strtotime($row['uploaded_at'])); ?>
    </td>

    <td>
        <a href="../uploads/<?php echo $row['file_name']; ?>"
           target="_blank"
           class="view-link">
           View PDF
        </a>
    </td>

    <td>
        <a href="delete_material.php?id=<?php echo $row['id']; ?>"
           onclick="return confirm('Delete this material?');"
           class="delete-link">
           Delete
        </a>
    </td>
</tr>
<?php } ?>

</table>

<br><br>
<a href="../index.php" class="btn-cancel">Back</a>

</div>

</body>
</html>
