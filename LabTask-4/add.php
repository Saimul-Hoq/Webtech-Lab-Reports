<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name            = mysqli_real_escape_string($conn, $_POST['name']);
    $email           = mysqli_real_escape_string($conn, $_POST['email']);
    $registration_no = mysqli_real_escape_string($conn, $_POST['registration_no']);
    $department      = mysqli_real_escape_string($conn, $_POST['department']);

    $sql = "INSERT INTO students (name, email, registration_no, department)
            VALUES ('$name', '$email', '$registration_no', '$department')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?msg=added");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
}
exit();
?>
