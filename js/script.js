document.addEventListener('DOMContentLoaded', function() {
    const studentForm = document.getElementById('studentForm');
    if (studentForm) {
        studentForm.addEventListener('submit', function(e) {
            let valid = true;
            
            
            const name = document.getElementById('name');
            const nameError = document.getElementById('name-error');
            if (!name.value.trim()) {
                nameError.textContent = 'Name is required';
                valid = false;
            } else {
                nameError.textContent = '';
            }
            
            
            const email = document.getElementById('email');
            const emailError = document.getElementById('email-error');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!email.value.trim()) {
                emailError.textContent = 'Email is required';
                valid = false;
            } else if (!emailRegex.test(email.value)) {
                emailError.textContent = 'Please enter a valid email';
                valid = false;
            } else {
                emailError.textContent = '';
            }
            
            if (!valid) {
                e.preventDefault();
            }
        });
    }
    
    
    const enrollmentForm = document.getElementById('enrollmentForm');
    if (enrollmentForm) {
        enrollmentForm.addEventListener('submit', function(e) {
            let valid = true;
            
            
            const studentId = document.getElementById('student_id');
            const studentIdError = document.getElementById('student_id-error');
            if (!studentId.value.trim()) {
                studentIdError.textContent = 'Student ID is required';
                valid = false;
            } else {
                studentIdError.textContent = '';
            }
            
            
            const courseCode = document.getElementById('course_code');
            const courseCodeError = document.getElementById('course_code-error');
            if (!courseCode.value.trim()) {
                courseCodeError.textContent = 'Course code is required';
                valid = false;
            } else {
                courseCodeError.textContent = '';
            }
            
            if (!valid) {
                e.preventDefault();
            }
        });
    }
});
