<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $enrollment_id = $_POST['enrollment_id'];
    $student_id = $_POST['student_id'];
    $semester = $_POST['semester'];
    $grade = $_POST['grade'] ?? null;

    try {
        // Update the enrollment
        $stmt = $conn->prepare("UPDATE enrollments 
                               SET semester = :semester, 
                                   grade = :grade 
                               WHERE id = :id");
        $stmt->bindParam(':semester', $semester);
        $stmt->bindParam(':grade', $grade);
        $stmt->bindParam(':id', $enrollment_id);
        $stmt->execute();

        // Redirect back with success message
        header("Location: enrollment_history.php?student_id=$student_id&success=Enrollment updated successfully");
        exit();
    } catch(PDOException $e) {
        // Redirect back with error message
        header("Location: enrollment_history.php?student_id=$student_id&error=Failed to update enrollment");
        exit();
    }
} else {
    // If not a POST request, redirect to enrollment history
    header("Location: enrollment_history.php");
    exit();
}
?>