<?php
include 'db.php';
session_start();

// Generate CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment History</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        /* Button Styles */
        .btn-update {
            background-color: #ffc107;
            color: #212529;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
            margin-right: 5px;
        }

        .btn-update:hover {
            background-color: #e0a800;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .actions {
            display: flex;
            gap: 5px;
        }
    </style>
</head>
<body>
    <?php include 'navigation.php'; ?>
    
    <div class="container">
        <h1>Enrollment History</h1>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert error"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>
        
        <form method="GET" class="search-form">
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="text" id="student_id" name="student_id" 
                       value="<?= htmlspecialchars($_GET['student_id'] ?? '') ?>" 
                       placeholder="Enter student ID">
                <button type="submit" class="btn2">Search</button>
            </div>
        </form>
        
        <?php
        if (isset($_GET['student_id']) && !empty($_GET['student_id'])) {
            $student_id = $_GET['student_id'];
            
            // Get student info
            $stmt = $conn->prepare("SELECT name FROM students WHERE student_id = :student_id");
            $stmt->bindParam(':student_id', $student_id);
            $stmt->execute();
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($student) {
                echo "<h2>Enrollment History for: " . htmlspecialchars($student['name']) . " (ID: $student_id)</h2>";
                
                // Get enrollments
                $stmt = $conn->prepare("SELECT e.id, e.course_code, c.course_title, e.semester, e.grade 
                                      FROM enrollments e
                                      JOIN courses c ON e.course_code = c.course_code
                                      WHERE e.student_id = :student_id
                                      ORDER BY e.semester DESC, c.course_code");
                $stmt->bindParam(':student_id', $student_id);
                $stmt->execute();
                $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (count($enrollments) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Title</th>
                                <th>Semester</th>
                                <th>Grade</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($enrollments as $enrollment): ?>
                                <tr>
                                    <td><?= htmlspecialchars($enrollment['course_code']) ?></td>
                                    <td><?= htmlspecialchars($enrollment['course_title']) ?></td>
                                    <td><?= htmlspecialchars($enrollment['semester']) ?></td>
                                    <td><?= $enrollment['grade'] ? htmlspecialchars($enrollment['grade']) : 'N/A' ?></td>
                                    <td class="actions">
                                        <!-- Update Button -->
                                        <button class="btn-update" 
                                                onclick="openUpdateModal(
                                                    '<?= $enrollment['id'] ?>',
                                                    '<?= htmlspecialchars($enrollment['course_code']) ?>',
                                                    '<?= htmlspecialchars($enrollment['semester']) ?>',
                                                    '<?= htmlspecialchars($enrollment['grade'] ?? '') ?>'
                                                )">
                                            Update
                                        </button>
                                        
                                        <!-- Delete Button -->
                                        <form method="POST" action="delete_enrollment.php" style="display:inline;">
                                            <input type="hidden" name="enrollment_id" value="<?= $enrollment['id'] ?>">
                                            <input type="hidden" name="student_id" value="<?= htmlspecialchars($_GET['student_id']) ?>">
                                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this enrollment?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-data">No data available for this student</p>
                <?php endif;
            } else {
                echo "<p class='error'>Student ID not found</p>";
            }
        }
        ?>
    </div>
    
    <!-- Update Enrollment Modal -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeUpdateModal()">&times;</span>
            <h2>Update Enrollment</h2>
            <form id="updateForm" action="update_enrollment.php" method="POST">
                <input type="hidden" id="update_enrollment_id" name="enrollment_id">
                <input type="hidden" name="student_id" value="<?= htmlspecialchars($_GET['student_id'] ?? '') ?>">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                
                <div class="form-group">
                    <label for="update_course_code">Course Code</label>
                    <input type="text" id="update_course_code" name="course_code" readonly>
                </div>
                
                <div class="form-group">
                    <label for="update_semester">Semester</label>
                    <select id="update_semester" name="semester">
                        <option value="Spring 2023">Spring 2023</option>
                        <option value="Summer 2023">Summer 2023</option>
                        <option value="Fall 2023">Fall 2023</option>
                        <option value="Spring 2024">Spring 2024</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="update_grade">Grade</label>
                    <select id="update_grade" name="grade">
                        <option value="">No grade</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="F">F</option>
                        <option value="W">W (Withdrawn)</option>
                    </select>
                </div>
                
                <button type="submit" class="btn2">Update Enrollment</button>
            </form>
        </div>
    </div>
    
    <script>
       
        function openUpdateModal(id, courseCode, semester, grade) {
            const modal = document.getElementById('updateModal');
            document.getElementById('update_enrollment_id').value = id;
            document.getElementById('update_course_code').value = courseCode;
            document.getElementById('update_semester').value = semester;
            document.getElementById('update_grade').value = grade;
            modal.style.display = 'block';
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').style.display = 'none';
        }

    
        window.onclick = function(event) {
            const modal = document.getElementById('updateModal');
            if (event.target == modal) {
                closeUpdateModal();
            }
        }
    </script>
</body>
</html>