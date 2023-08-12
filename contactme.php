<?php
$Name = $_POST['Name'];
$Email = $_POST['Email'];
$Message = $_POST['Message'];

// Validate and sanitize inputs
$Name = htmlspecialchars($Name);
$Email = filter_var($Email, FILTER_VALIDATE_EMAIL);
$Message = htmlspecialchars($Message);

if (!$Email) {
    echo "Invalid email address.";
    exit();
}

 
$host = "localhost";
$username = "root";
$password = "";
$database = "PORTFOLIO";

 
$con = new mysqli($host, $username, $password, $database);
if ($con->connect_error) {
    die("Failed to connect: " . $con->connect_error);
} else {
    $SELECT = "SELECT Email FROM register WHERE Email = ?";
    $INSERT = "INSERT INTO register (Name, Email, Message) VALUES (?, ?, ?)";

    $stmt = $con->prepare($SELECT);
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $stmt->store_result();
    $rnum = $stmt->num_rows;

    if ($rnum == 0) {
        $stmt->close();
        $stmt = $con->prepare($INSERT);
        $stmt->bind_param("sss", $Name, $Email, $Message);
        $stmt->execute();

        echo "You have successfully sent a message.";
        exit();
    } else {
        echo "Sorry, you've already submitted a message with this email.";
    }
    $stmt->close();
    $con->close();
}
?>
