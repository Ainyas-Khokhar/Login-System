

<?php
session_start(); // Start the session

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve and sanitize form data
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Validate username and password
    if (empty($email) || empty($password)) {
        die("Email and password are required.");
    }

    try {
        require_once "dbh.inc.php"; // Include the database connection file

        // Prepare the SQL query to fetch the user data
        $query = "SELECT id, username, password_hash FROM users WHERE email = ? LIMIT 1;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);

        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "User found with email: " . $email . "<br>";
            echo "Stored password hash: " . $user['password_hash'] . "<br>";

            if (password_verify($password, $user['password_hash'])) {
                echo "Password matches.<br>";
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $email;

                // Redirect to the content page
                header("Location: content.php");
                exit();
            } else {
                echo "Password does not match.<br>";
                header("Location: login.php?error=invalid_credentials");
                exit();
            }
        } else {
            echo "User not found.<br>";
            header("Location: login.php?error=invalid_credentials");
            exit();
        }

    } catch (PDOException $e) {
        // Handle the exception if there's a database error
        die("Query Failed: " . $e->getMessage());
    }
} else {
    // If the form wasn't submitted, redirect to the login page
    header("Location: login.php");
    exit();
}
