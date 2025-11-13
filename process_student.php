<?php
// Database configuration
$servername = "localhost";
$username = "root";  // Change this to your MySQL username
$password = "";      // Change this to your MySQL password
$dbname = "db_registra";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: student_form.html?error=invalid_email");
        exit();
    }
    
    // Prepare SQL statement
    $sql = "INSERT INTO tbl_student (first_name, last_name, birth_date, email) 
            VALUES (?, ?, ?, ?)";
    
    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $first_name, $last_name, $birth_date, $email);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Registration Success</title>
            <style>
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    min-height: 100vh;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    padding: 20px;
                }
                .container {
                    background: white;
                    padding: 40px;
                    border-radius: 10px;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                    text-align: center;
                    max-width: 500px;
                }
                h1 { color: #155724; margin-bottom: 20px; }
                p { color: #555; margin-bottom: 10px; line-height: 1.6; }
                .btn {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 12px 30px;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                    font-weight: 600;
                }
                .btn:hover { opacity: 0.9; }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>✓ Registration Successful!</h1>
                <p><strong>Student ID:</strong> " . $stmt->insert_id . "</p>
                <p><strong>Name:</strong> $first_name $last_name</p>
                <p><strong>Birth Date:</strong> $birth_date</p>
                <p><strong>Email:</strong> $email</p>
                <a href='student_form.html' class='btn'>Register Another Student</a>
            </div>
        </body>
        </html>";
    } else {
        // Check for duplicate email error
        if ($conn->errno == 1062) {
            echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Registration Error</title>
                <style>
                    body {
                        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        min-height: 100vh;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        padding: 20px;
                    }
                    .container {
                        background: white;
                        padding: 40px;
                        border-radius: 10px;
                        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                        text-align: center;
                        max-width: 500px;
                    }
                    h1 { color: #721c24; margin-bottom: 20px; }
                    p { color: #555; margin-bottom: 20px; }
                    .btn {
                        display: inline-block;
                        padding: 12px 30px;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                        text-decoration: none;
                        border-radius: 5px;
                        font-weight: 600;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>✗ Registration Failed</h1>
                    <p>This email address is already registered.</p>
                    <a href='student_form.html' class='btn'>Go Back</a>
                </div>
            </body>
            </html>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    
    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>