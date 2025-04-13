<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'navigation.php'; ?>
    
    <div class="container">
        <h1>Register New Student</h1>
        
        <form id="studentForm" action="process_student.php" method="POST">
            <div class="form-group">
                <label for="name">Name*</label>
                <input type="text" id="name" name="name" required placeholder="Enter student name">
                <span class="error-message" id="name-error"></span>
            </div>
            
            <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" required placeholder="Enter email address">
                <span class="error-message" id="email-error"></span>
            </div>
            
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="text" id="student_id" name="student_id" placeholder="Enter student ID">
            </div>
            
            <div class="form-group">
                <label for="department">Department</label>
                <select id="department" name="department">
                    <option value="">Select department</option>
                    <option value="CSE">Computer Science & Engineering</option>
                    <option value="ENG">Civil Engineering</option>
                    <option value="EEE">Electrical & Electronic Engineering</option>
                    <option value="BBA">Business Administration</option>
                
                </select>
            </div>
            
            <div class="form-group">
                <label for="major">Major</label>
                <select id="major" name="major">
                    <option value="">Select major</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Software Engineering">Software Engineering</option>
                    <option value="Electrical Engineering">Electrical Engineering</option>
                    <option value="Business Management">Business Management</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob">
            </div>
            
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" placeholder="Enter address"></textarea>
            </div>
            
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>