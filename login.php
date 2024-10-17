<?php
session_start();

// Simulated user data (User's username and password)
$users = [
    'admin' => password_hash('password123', PASSWORD_DEFAULT) ];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists in the simulated user data
    if (isset($users[$username]) && password_verify($password, $users[$username])) {
        $_SESSION['loggedin'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
