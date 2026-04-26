<?php
$errors = [];
$success = false;
$data = [];

if (isset($_POST['register'])) {
    $fullName       = trim($_POST['fullName'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $userName       = trim($_POST['userName'] ?? '');
    $password       = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $age            = trim($_POST['age'] ?? '');
    $gender         = $_POST['gender'] ?? '';
    $course         = $_POST['course'] ?? '';
    $terms          = isset($_POST['terms']);

    // 1. All fields must not be empty
    if (empty($fullName))        $errors[] = "Full Name is required.";
    if (empty($email))           $errors[] = "Email is required.";
    if (empty($userName))        $errors[] = "Username is required.";
    if (empty($password))        $errors[] = "Password is required.";
    if (empty($confirmPassword)) $errors[] = "Confirm Password is required.";
    if ($age === '')             $errors[] = "Age is required.";
    if (empty($gender))          $errors[] = "Gender must be selected.";
    if (empty($course))          $errors[] = "Course must be selected.";
    if (!$terms)                 $errors[] = "You must agree to the Terms & Conditions.";

    // 2. Full Name must contain only letters and spaces
    if (!empty($fullName) && !preg_match('/^[a-zA-Z ]+$/', $fullName))
        $errors[] = "Full Name must contain only letters and spaces.";

    // 3. Valid email format
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "Email must be a valid email address.";

    // 4. Username must be at least 5 characters
    if (!empty($userName) && strlen($userName) < 5)
        $errors[] = "Username must be at least 5 characters long.";

    // 5. Password must be at least 6 characters
    if (!empty($password) && strlen($password) < 6)
        $errors[] = "Password must be at least 6 characters long.";

    // 6. Passwords must match
    if (!empty($password) && !empty($confirmPassword) && $password !== $confirmPassword)
        $errors[] = "Password and Confirm Password do not match.";

    // 7. Age must be 18 or above
    if ($age !== '' && (!is_numeric($age) || (int)$age < 18))
        $errors[] = "Age must be 18 or above.";

    if (empty($errors)) {
        $success = true;
        $data = [
            'Full Name' => $fullName,
            'Email'     => $email,
            'Username'  => $userName,
            'Age'       => $age,
            'Gender'    => $gender,
            'Course'    => $course,
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
</head>
<body>

    <?php if (!empty($errors)): ?>
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
            <strong>Please fix the following errors:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div style="color: green; border: 1px solid green; padding: 10px; margin-bottom: 15px;">
            <strong>Registration Successful!</strong>
            <ul>
                <?php foreach ($data as $field => $value): ?>
                    <li><strong><?= $field ?>:</strong> <?= htmlspecialchars($value) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <fieldset>
            <legend>Online Student Registration</legend>

            <div>
                <label for="fullName">Full Name:</label>
                <input type="text" name="fullName" id="fullName"
                       value="<?= htmlspecialchars($_POST['fullName'] ?? '') ?>">
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div>
                <label for="userName">Username:</label>
                <input type="text" name="userName" id="userName"
                       value="<?= htmlspecialchars($_POST['userName'] ?? '') ?>">
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
            </div>

            <div>
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" name="confirmPassword" id="confirmPassword">
            </div>

            <div>
                <label for="age">Age:</label>
                <input type="number" name="age" id="age"
                       value="<?= htmlspecialchars($_POST['age'] ?? '') ?>">
            </div>

            <fieldset style="max-width: 200px;">
                <legend>Gender</legend>
                <input type="radio" name="gender" id="Male" value="Male"
                       <?= (($_POST['gender'] ?? '') === 'Male') ? 'checked' : '' ?>>
                <label for="Male">Male</label>

                <input type="radio" name="gender" id="Female" value="Female"
                       <?= (($_POST['gender'] ?? '') === 'Female') ? 'checked' : '' ?>>
                <label for="Female">Female</label>
            </fieldset>

            <div>
                <select name="course" id="course">
                    <option value="" selected hidden>Select your course</option>
                    <option value="Data Structure"  <?= (($_POST['course'] ?? '') === 'Data Structure')  ? 'selected' : '' ?>>Data Structure</option>
                    <option value="Algorithm"       <?= (($_POST['course'] ?? '') === 'Algorithm')       ? 'selected' : '' ?>>Algorithm</option>
                    <option value="Compiler"        <?= (($_POST['course'] ?? '') === 'Compiler')        ? 'selected' : '' ?>>Compiler</option>
                    <option value="Operating System"<?= (($_POST['course'] ?? '') === 'Operating System')? 'selected' : '' ?>>Operating System</option>
                </select>
            </div>

            <div>
                <input type="checkbox" name="terms" id="terms"
                       <?= isset($_POST['terms']) ? 'checked' : '' ?>>
                <label for="terms">I agree to the Terms & Conditions</label>
            </div>

            <button type="submit" name="register">Register</button>
        </fieldset>
    </form>
</body>
</html>












<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form>
        <fieldset>
            <legend>Online student registration</legend>

            <div>
                <label for="fullName">Full Name: </label>
                <input type="text" name="" id="fullName">
            </div>

           
            <div>
                <label for="email">Email: </label>
                <input type="email" name="" id="email">
            </div>

            <div>
                <label for="userName">User Name:</label>
                <input type="text" name="" id="userName">
            </div>

            <div>
                <label for="password">Password: </label>
                <input type="password" name="" id="password">
            </div>

         
            <div>
                <label for="confirmPassword">Confirm Password: </label>
                <input type="password" name="" id="confirmPassword">
            </div>

            <div>
                <label for="age">Age: </label>
                <input type="number" name="" id="age">
            </div>

            
            <fieldset style="max-width: 200px;">
                <legend>Gender</legend>
                
                <input type="radio" name="gender" id="Male">
                <label for="Male">Male</label>

                
                <input type="radio" name="gender" id="Female">
                <label for="Female">Female</label>
            </fieldset>
           

            <div>
                <select name="" id="">
                    <option value="" selected hidden>Select your course</option>
                    <option value="">Data Structure</option>
                    <option value="">Algorithm</option>
                    <option value="">Compiler</option>
                    <option value="">Operating System</option>
                </select>
            </div>

            <div>
                
                <input type="checkbox" name="" id="terms">
                <label for="terms">Are you agree to the terms and condition?</label>
            </div>
            
            <button>Register</button>
        </fieldset>
    </form>
</body>
</html> -->