The sql file is given in the repository you can also find the sql below: 




CREATE DATABASE university_system;
USE university_system;

-- Students table
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    student_id VARCHAR(20) UNIQUE,
    department VARCHAR(50),
    major VARCHAR(50),
    date_of_birth DATE,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Courses table
CREATE TABLE courses (
    course_code VARCHAR(20) PRIMARY KEY,
    course_title VARCHAR(100) NOT NULL
);

-- Enrollments table
CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) NOT NULL,
    course_code VARCHAR(20) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    grade VARCHAR(2),
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (course_code) REFERENCES courses(course_code)
);

-- Sample courses
INSERT INTO courses (course_code, course_title) VALUES
('CSE101', 'Introduction to Computer Science'),
('CSE415', 'Web Engineering Lab'),
('MAT101', 'Calculus I'),
('ENG101', 'English Composition');
