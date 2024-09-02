

<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve and sanitize form data
    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $password  = trim($_POST['password']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Validate username and password (basic example)
    if (empty($username) || empty($password)) {
        die("Username and password are required.");
    }

    // Hash the password for security
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        require_once "dbh.inc.php"; // Include the database connection file

        // Prepare the SQL query to insert the user data
        $query = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?);";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$username, $email, $passwordHash]);

        // Store session variables after successful registration
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;

        // Redirect to the content page or another protected page
        header("Location: login.php");
        exit();

    } catch (PDOException $e) {
        // Handle the exception if there's a database error
        die("Query Failed: " . $e->getMessage());
    }
} else {
    // If the form wasn't submitted, redirect to the signup page
    header("Location: signup.php");
    exit();
}
?>
