<?php
include 'db.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM students WHERE id = $id";
    mysqli_query($conn, $sql);
    header("Location: index.php?msg=deleted");
    exit();
}

// Fetch all students
$result = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Management System</title>
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
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        /* Message */
        .msg {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .msg.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        /* Add Student Form */
        .card {
            background: white;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 30px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .card h2 {
            margin-bottom: 18px;
            font-size: 18px;
            color: #2c3e50;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 8px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
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

        .btn-primary { background: #2c3e50; color: white; margin-top: 14px; }
        .btn-primary:hover { background: #3d5166; }
        .btn-edit { background: #f39c12; color: white; padding: 6px 14px; font-size: 13px; }
        .btn-edit:hover { background: #d68910; }
        .btn-delete { background: #e74c3c; color: white; padding: 6px 14px; font-size: 13px; }
        .btn-delete:hover { background: #c0392b; }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        th {
            background: #2c3e50;
            color: white;
            padding: 12px 14px;
            text-align: left;
            font-size: 14px;
        }

        td {
            padding: 11px 14px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f9f9f9; }

        .actions { display: flex; gap: 8px; }

        .no-records {
            text-align: center;
            padding: 30px;
            color: #888;
            font-size: 15px;
        }
    </style>
</head>
<body>

<header>🎓 Student Management System</header>

<div class="container">

    <!-- Success Messages -->
    <?php if (isset($_GET['msg'])): ?>
        <?php
            $messages = [
                'added'   => '✅ Student record added successfully!',
                'deleted' => '🗑️ Student record deleted successfully!',
                'updated' => '✏️ Student record updated successfully!',
            ];
            $msg = $messages[$_GET['msg']] ?? '';
        ?>
        <?php if ($msg): ?>
            <div class="msg success"><?= $msg ?></div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Add Student Form -->
    <div class="card">
        <h2>➕ Add New Student</h2>
        <form action="add.php" method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label>Student Name</label>
                    <input type="text" name="name" placeholder="Enter full name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter email address" required>
                </div>
                <div class="form-group">
                    <label>Registration Number</label>
                    <input type="text" name="registration_no" placeholder="e.g. REG-2024-001" required>
                </div>
                <div class="form-group">
                    <label>Department</label>
                    <input type="text" name="department" placeholder="e.g. Computer Science" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
    </div>

    <!-- Student Records Table -->
    <div class="card">
        <h2>📋 Student Records</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registration No</th>
                    <th>Department</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['registration_no']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td>
                        <div class="actions">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-edit">✏️ Edit</a>
                            <a href="index.php?delete=<?= $row['id'] ?>"
                               class="btn btn-delete"
                               onclick="return confirm('Are you sure you want to delete this record?')">
                               🗑️ Delete
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <div class="no-records">No student records found. Add your first student above.</div>
        <?php endif; ?>
    </div>

</div>
</body>
</html>
