<?php
session_start(); // Start or resume the session

require_once ('includes/load.php');
require_once "../group3/dbcon.php";

if (isset($_SESSION['attendanceID'])) {
    try {
        $attendanceID = $_SESSION['attendanceID'];

        $stmt = $pdo->prepare('UPDATE attendance SET clockOutTime = NOW() WHERE attendanceID = ? AND clockOutTime IS NULL');
        $stmt->execute([$attendanceID]);

        if ($stmt->rowCount() > 0) {
            echo "Clock-out time updated successfully.";
        } else {
            echo "No attendance record found for the current session.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No attendance ID found in session.";
}

// Log the user out
if (!$session->logout()) {
    echo "Error: Logout failed.";
    redirect("../group2/index.php");
}
?>
