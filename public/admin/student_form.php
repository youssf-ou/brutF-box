<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require_once '../config.php';

$edit_mode = false;
$student = null;

// Check if editing
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM students WHERE id = $id");
    $student = mysqli_fetch_assoc($result);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $year_level = intval($_POST['year_level']);
    $gpa = floatval($_POST['gpa']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $enrollment_date = mysqli_real_escape_string($conn, $_POST['enrollment_date']);
    
    if ($edit_mode && isset($_POST['id'])) {
        // Update
        $id = intval($_POST['id']);
        $query = "UPDATE students SET 
                  student_id='$student_id', full_name='$full_name', email='$email', 
                  phone='$phone', department='$department', year_level=$year_level, 
                  gpa=$gpa, address='$address', enrollment_date='$enrollment_date' 
                  WHERE id=$id";
        mysqli_query($conn, $query);
        header("Location: students.php?msg=updated");
    } else {
        // Insert
        $query = "INSERT INTO students (student_id, full_name, email, phone, department, year_level, gpa, address, enrollment_date) 
                  VALUES ('$student_id', '$full_name', '$email', '$phone', '$department', $year_level, $gpa, '$address', '$enrollment_date')";
        mysqli_query($conn, $query);
        header("Location: students.php?msg=added");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $edit_mode ? 'Редактировать' : 'Добавить'; ?> студента - Технический университет</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-body">
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-graduation-cap"></i>
                <span>Tech University</span>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="students.php" class="nav-item active">
                    <i class="fas fa-user-graduate"></i>
                    <span>Students</span>
                </a>
                <a href="teachers.php" class="nav-item">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Teachers</span>
                </a>
                <a href="workers.php" class="nav-item">
                    <i class="fas fa-users"></i>
                    <span>Workers</span>
                </a>
                <a href="logout.php" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header-admin">
                <h1><i class="fas fa-user-graduate"></i> <?php echo $edit_mode ? 'Edit' : 'Add'; ?> Student</h1>
                <a href="students.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>

            <div class="form-container">
                <form method="POST" action="">
                    <?php if ($edit_mode): ?>
                        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="student_id"><i class="fas fa-id-card"></i> Student ID</label>
                            <input type="text" id="student_id" name="student_id" required 
                                   value="<?php echo $edit_mode ? $student['student_id'] : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="full_name"><i class="fas fa-user"></i> Full Name</label>
                            <input type="text" id="full_name" name="full_name" required 
                                   value="<?php echo $edit_mode ? $student['full_name'] : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" id="email" name="email" required 
                                   value="<?php echo $edit_mode ? $student['email'] : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="phone"><i class="fas fa-phone"></i> Phone</label>
                            <input type="text" id="phone" name="phone" 
                                   value="<?php echo $edit_mode ? $student['phone'] : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="department"><i class="fas fa-building"></i> Department</label>
                            <select id="department" name="department" required>
                                <option value="">Выберите факультет</option>
                                <option value="Computer Science" <?php echo ($edit_mode && $student['department'] == 'Computer Science') ? 'selected' : ''; ?>>Информатика</option>
                                <option value="Electrical Engineering" <?php echo ($edit_mode && $student['department'] == 'Electrical Engineering') ? 'selected' : ''; ?>>Электротехника</option>
                                <option value="Mechanical Engineering" <?php echo ($edit_mode && $student['department'] == 'Mechanical Engineering') ? 'selected' : ''; ?>>Машиностроение</option>
                                <option value="Civil Engineering" <?php echo ($edit_mode && $student['department'] == 'Civil Engineering') ? 'selected' : ''; ?>>Гражданское строительство</option>
                                <option value="Information Technology" <?php echo ($edit_mode && $student['department'] == 'Information Technology') ? 'selected' : ''; ?>>Информационные технологии</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="year_level"><i class="fas fa-calendar-alt"></i> Year Level</label>
                            <select id="year_level" name="year_level" required>
                                <option value="">Select Year</option>
                                <option value="1" <?php echo ($edit_mode && $student['year_level'] == 1) ? 'selected' : ''; ?>>1st Year</option>
                                <option value="2" <?php echo ($edit_mode && $student['year_level'] == 2) ? 'selected' : ''; ?>>2nd Year</option>
                                <option value="3" <?php echo ($edit_mode && $student['year_level'] == 3) ? 'selected' : ''; ?>>3rd Year</option>
                                <option value="4" <?php echo ($edit_mode && $student['year_level'] == 4) ? 'selected' : ''; ?>>4th Year</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="gpa"><i class="fas fa-star"></i> GPA (0.00 - 4.00)</label>
                            <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="4" required 
                                   value="<?php echo $edit_mode ? $student['gpa'] : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="enrollment_date"><i class="fas fa-calendar"></i> Enrollment Date</label>
                            <input type="date" id="enrollment_date" name="enrollment_date" required 
                                   value="<?php echo $edit_mode ? $student['enrollment_date'] : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                            <textarea id="address" name="address" rows="3"><?php echo $edit_mode ? $student['address'] : ''; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> <?php echo $edit_mode ? 'Update' : 'Add'; ?> Student
                        </button>
                        <a href="students.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
