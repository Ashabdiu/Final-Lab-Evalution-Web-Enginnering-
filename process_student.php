<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $student_id = $_POST['student_id'] ?? null;
    $department = $_POST['department'] ?? null;
    $major = $_POST['major'] ?? null;
    $dob = $_POST['dob'] ?? null;
    $address = $_POST['address'] ?? null;

    
    if (empty($name) || empty($email)) {
        die("Name and Email are required fields.");
    }

    try {
        $stmt = $conn->prepare("INSERT INTO students (name, email, student_id, department, major, date_of_birth, address) 
                              VALUES (:name, :email, :student_id, :department, :major, :dob, :address)");
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':major', $major);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':address', $address);
        
        $stmt->execute();
        
        header("Location: student_list.php?success=Student registered successfully");
        exit();
    } catch(PDOException $e) {
        if ($e->getCode() == 23000) {
            
            header("Location: add_student.php?error=Email or Student ID already exists");
        } else {
            header("Location: add_student.php?error=Registration failed: " . $e->getMessage());
        }
        exit();
    }
} else {
    header("Location: add_student.php");
    exit();
}
?>