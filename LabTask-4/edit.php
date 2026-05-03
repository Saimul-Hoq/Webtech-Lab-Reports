<?php
include 'db.php';

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = intval($_POST['id']);
    $name       = mysqli_real_escape_string($conn, $_POST['name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);

    $sql = "UPDATE students SET name='$name', email='$email', department='$department' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?msg=updated");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    exit();
}

// Fetch student to edit
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id     = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM students WHERE id = $id");
$student = mysqli_fetch_assoc($result);

if (!$student) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student - Student Management System</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            color: #333;
        }

        header {
            background: #2c3e50;
            color: white;
            padding: 16px 30px;
            font-size: 22px;
            font-weight: bold;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            border-radius: 8px;
            padding: 28px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .card h2 {
            margin-bottom: 20px;
            font-size: 18px;
            color: #2c3e50;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 8px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 14px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: bold;
            color: #555;
        }

        .form-group input {
            padding: 9px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2c3e50;
        }

        .form-group input[readonly] {
            background: #f5f5f5;
            color: #888;
            cursor: not-allowed;
        }

        .note {
            font-size: 12px;
            color: #888;
            margin-top: 2px;
        }

        .btn-row {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 22px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-primary { background: #f39c12; color: white; }
        .btn-primary:hover { background: #d68910; }
        .btn-back { background: #ccc; color: #333; }
        .btn-back:hover { background: #bbb; }
    </style>
</head>
<body>

<header>🎓 Student Management System</header>

<div class="container">
    <div class="card">
        <h2>✏️ Edit Student Record</h2>

        <form action="edit.php" method="POST">
            <input type="hidden" name="id" value="<?= $student['id'] ?>">

            <div class="form-group">
                <label>Student Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required>
            </div>

            <div class="form-group">
                <label>Registration Number</label>
                <input type="text" value="<?= htmlspecialchars($student['registration_no']) ?>" readonly>
                <span class="note">Registration number cannot be changed.</span>
            </div>

            <div class="form-group">
                <label>Department</label>
                <input type="text" name="department" value="<?= htmlspecialchars($student['department']) ?>" required>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn btn-primary">💾 Update Student</button>
                <a href="index.php" class="btn btn-back">← Back to List</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
