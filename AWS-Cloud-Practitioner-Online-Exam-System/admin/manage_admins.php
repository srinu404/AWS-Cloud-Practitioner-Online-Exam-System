<?php
session_start();
include "../config/db.php";

/* STRONG ADMIN SECURITY */
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

/* MAKE DEFAULT ADMIN */
if (isset($_GET['make_default'])) {

    $id = intval($_GET['make_default']);

    // Remove old default
    mysqli_query($conn,
        "UPDATE admins SET is_default=0");

    // Set new default
    mysqli_query($conn,
        "UPDATE admins SET is_default=1 WHERE id='$id'");

    header("Location: manage_admins.php");
    exit();
}

/* FETCH ADMINS */
$admins = mysqli_query($conn,
    "SELECT * FROM admins ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Admins</title>
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
.protected {
    color: green;
    font-weight: bold;
}
.delete-link {
    color: red;
    font-weight: bold;
}
.default-btn {
    color: blue;
    font-weight: bold;
}
</style>
</head>

<body>

<div class="container table-box">
    <h2>Manage Admins</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Created Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

<?php
if (mysqli_num_rows($admins) == 0) {
    echo "<tr><td colspan='5' align='center'>No admins found</td></tr>";
}

while ($row = mysqli_fetch_assoc($admins)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>

    <td><?php echo htmlspecialchars($row['username']); ?></td>

    <td>
        <?php echo date("d-m-Y h:i:s A",
            strtotime($row['created_at'])); ?>
    </td>

    <td>
        <?php if ($row['is_default'] == 1) { ?>
            <span class="protected">Default Admin</span>
        <?php } else { ?>
            Normal Admin
        <?php } ?>
    </td>

    <td>
        <?php if ($row['is_default'] == 1) { ?>

            <span class="protected">
                Protected (No Edit / Delete)
            </span>

        <?php } else { ?>

            <a href="edit_admin.php?id=<?php echo $row['id']; ?>">
                Edit
            </a> |

            <a href="delete_admin.php?id=<?php echo $row['id']; ?>"
               onclick="return confirm('Delete this admin?');"
               class="delete-link">
                Delete
            </a> |

            <a href="manage_admins.php?make_default=<?php echo $row['id']; ?>"
               onclick="return confirm('Make this admin Default?');"
               class="default-btn">
                Make Default
            </a>

        <?php } ?>
    </td>
</tr>
<?php } ?>

    </table>

    <br><br>
    <button type="button" onclick="window.history.back();" class="btn-cancel">
    Cancel
</button>

</div>

</body>
</html>
