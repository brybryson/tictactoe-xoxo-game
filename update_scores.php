<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the input
    $winningPlayer = isset($_POST['winningPlayer']) ? $_POST['winningPlayer'] : '';

    // Perform database operation to update the scores table
    require_once 'database.php'; // Include the database connection

    $updateQuery = "UPDATE scores SET score = score + 1 WHERE player = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 's', $winningPlayer);
    mysqli_stmt_execute($stmt);

    // Check if the query was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $response = 'Scores updated successfully';
    } else {
        $response = 'Error updating scores';
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Send the response back to the client
    echo $response;
} else {
    // If the request method is not POST, return an error response
    http_response_code(405); // Method Not Allowed
    echo 'Invalid request method';
}
?>
