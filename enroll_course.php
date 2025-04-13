<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Enrollment</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'navigation.php'; ?>
    
    <div class="container">
        <h1>Course Enrollment</h1>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert error"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>
        
        <form id="enrollmentForm" action="process_enrollment.php" method="POST">
            <div class="form-group">
                <label for="student_id">Student ID*</label>
                <input type="text" id="student_id" name="student_id" required placeholder="Enter student ID">
                <span class="error-message" id="student_id-error"></span>
            </div>
            
            <div class="form-group">
                <label for="course_code">Course Code*</label>
                <input type="text" id="course_code" name="course_code" required placeholder="Enter course code">
                <span class="error-message" id="course_code-error"></span>
            </div>
            
            <div class="form-group">
                <label for="course_title">Course Title</label>
                <select id="course_title" name="course_title">
                    <option value="">Select course</option>
                    <?php
                    $stmt = $conn->query("SELECT * FROM courses");
                    while ($course = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$course['course_title']}' data-code='{$course['course_code']}'>{$course['course_code']} - {$course['course_title']}</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="semester">Semester</label>
                <select id="semester" name="semester">
                    <option value="Spring 2023">Spring 2023</option>
                    <option value="Summer 2023">Summer 2023</option>
                    <option value="Fall 2023">Fall 2023</option>
                    <option value="Spring 2024">Spring 2024</option>
                    <option value="Summer 2024">Summer 2024</option>
                    <option value="Fall 2024">Fall 2024</option>
                    <option value="Spring 2025">Spring 2025</option>
                    <option value="Summer 2025">Summer 2025</option>
                    <option value="Fall 2025">Fall 2025</option>
                    <option value="Spring 2026">Spring 2026</option>
                    <option value="Summer 2026">Summer 2026</option>
                    <option value="Fall 2026">Fall 2026</option>
                </select>
            </div>
            
            <button type="submit" class="btn">Enroll</button>
        </form>
    </div>
    
    <script src="js/script.js"></script>
    <script>
        
        document.getElementById('course_title').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.dataset.code) {
                document.getElementById('course_code').value = selectedOption.dataset.code;
            }
        });
    </script>
</body>
</html>