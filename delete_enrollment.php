<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $enrollment_id = $_POST['enrollment_id'];
    $student_id = $_POST['student_id'];

    try {
       
        $stmt = $conn->prepare("DELETE FROM enrollments WHERE id = :id");
        $stmt->bindParam(':id', $enrollment_id);
        $stmt->execute();

        
        header("Location: enrollment_history.php?student_id=$student_id&success=Enrollment deleted successfully");
        exit();
    } catch(PDOException $e) {
       
        header("Location: enrollment_history.php?student_id=$student_id&error=Failed to delete enrollment");
        exit();
    }
} else {

    header("Location: enrollment_history.php");
    exit();
}
?>