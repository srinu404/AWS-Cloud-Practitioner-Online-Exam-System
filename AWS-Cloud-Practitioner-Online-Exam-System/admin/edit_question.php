<?php
session_start();
include "../config/db.php";

/* ADMIN SECURITY */
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];

/* FETCH QUESTION */
$q = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM questions WHERE id='$id'"));

/* FETCH OPTIONS */
$opts = mysqli_query($conn,
    "SELECT * FROM options WHERE question_id='$id'");

$message = "";

if (isset($_POST['update'])) {

    // Normalize question
    $question = strtolower(trim($_POST['question']));
    $question = preg_replace('/\s+/', ' ', $question);

    $type = $_POST['type'];
    $correct = strtoupper(trim($_POST['correct']));

    /* DUPLICATE CHECK (EXCLUDE CURRENT QUESTION) */
    $check = mysqli_query($conn,
        "SELECT id FROM questions
         WHERE question='$question' AND id!='$id'");

    if (mysqli_num_rows($check) > 0) {

        $message = "❌ Duplicate question detected.";

    } else {

        /* UPDATE QUESTION */
        mysqli_query($conn,
            "UPDATE questions
             SET question='$question',
                 type='$type',
                 correct_answer='$correct'
             WHERE id='$id'");

        /* UPDATE OPTIONS */
        foreach ($_POST['options'] as $oid => $optText) {
            mysqli_query($conn,
                "UPDATE options
                 SET option_text='$optText'
                 WHERE id='$oid'");
        }

        header("Location: manage_questions.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Question</title>
<link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="container">
<h2>Edit Question</h2>

<?php if ($message) { ?>
<p style="color:red;text-align:center;"><?php echo $message; ?></p>
<?php } ?>

<form method="post">

<textarea name="question" required><?php echo htmlspecialchars($q['question']); ?></textarea>

<label>Question Type</label>
<select name="type">
    <option value="single" <?php if($q['type']=='single') echo 'selected'; ?>>Single</option>
    <option value="multiple" <?php if($q['type']=='multiple') echo 'selected'; ?>>Multiple</option>
</select>

<?php while ($o = mysqli_fetch_assoc($opts)) { ?>
<input type="text"
       name="options[<?php echo $o['id']; ?>]"
       value="<?php echo htmlspecialchars($o['option_text']); ?>"
       required>
<?php } ?>

<input type="text"
       name="correct"
       value="<?php echo $q['correct_answer']; ?>"
       placeholder="Correct Answer (A or A,B)"
       required>

<button name="update">Update Question</button>

</form>
</div>

</body>
</html>
