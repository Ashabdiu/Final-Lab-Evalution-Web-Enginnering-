<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $course_code = $_POST['course_code'];
    $semester = $_POST['semester'] ?? 'Spring 2026';

    
    if (empty($student_id) || empty($course_code)) {
        die("Student ID and Course Code are required fields.");
    }

    try {
        
        $stmt = $conn->prepare("SELECT 1 FROM students WHERE student_id = :student_id");
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();
        
        if (!$stmt->fetch()) {
            header("Location: enroll_course.php?error=Student ID not found");
            exit();
        }
        
        
        $stmt = $conn->prepare("SELECT 1 FROM courses WHERE course_code = :course_code");
        $stmt->bindParam(':course_code', $course_code);
        $stmt->execute();
        
        if (!$stmt->fetch()) {
            header("Location: enroll_course.php?error=Course Code not found");
            exit();
        }
        
        
        $stmt = $conn->prepare("SELECT 1 FROM enrollments WHERE student_id = :student_id AND course_code = :course_code AND semester = :semester");
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':course_code', $course_code);
        $stmt->bindParam(':semester', $semester);
        $stmt->execute();
        
        if ($stmt->fetch()) {
            header("Location: enroll_course.php?error=Student already enrolled in this course for the selected semester");
            exit();
        }
        
        
        $stmt = $conn->prepare("INSERT INTO enrollments (student_id, course_code, semester) 
                              VALUES (:student_id, :course_code, :semester)");
        
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':course_code', $course_code);
        $stmt->bindParam(':semester', $semester);
        
        $stmt->execute();
        
        header("Location: enroll_course.php?success=Enrollment successful");
        exit();
    } catch(PDOException $e) {
        header("Location: enroll_course.php?error=Enrollment failed: " . $e->getMessage());
        exit();
    }
} else {
    header("Location: enroll_course.php");
    exit();
}
?>