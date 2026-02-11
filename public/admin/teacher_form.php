<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require_once '../config.php';

$edit_mode = false;
$teacher = null;

if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM teachers WHERE id = $id");
    $teacher = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $salary = floatval($_POST['salary']);
    $hire_date = mysqli_real_escape_string($conn, $_POST['hire_date']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    if ($edit_mode && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $query = "UPDATE teachers SET teacher_id='$teacher_id', full_name='$full_name', email='$email', 
                  phone='$phone', department='$department', specialization='$specialization', 
                  qualification='$qualification', salary=$salary, hire_date='$hire_date', address='$address' WHERE id=$id";
        mysqli_query($conn, $query);
        header("Location: teachers.php?msg=updated");
    } else {
        $query = "INSERT INTO teachers (teacher_id, full_name, email, phone, department, specialization, qualification, salary, hire_date, address) 
                  VALUES ('$teacher_id', '$full_name', '$email', '$phone', '$department', '$specialization', '$qualification', $salary, '$hire_date', '$address')";
        mysqli_query($conn, $query);
        header("Location: teachers.php?msg=added");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $edit_mode ? 'Edit' : 'Add'; ?> Teacher</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-body">
    <div class="admin-wrapper">
        <aside class="sidebar">
            <div class="sidebar-header"><i class="fas fa-graduation-cap"></i><span>Tech University</span></div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item"><i class="fas fa-tachometer-alt"></i><span>Панель</span></a>
                <a href="students.php" class="nav-item"><i class="fas fa-user-graduate"></i><span>Студенты</span></a>
                <a href="teachers.php" class="nav-item active"><i class="fas fa-chalkboard-teacher"></i><span>Преподаватели</span></a>
                <a href="workers.php" class="nav-item"><i class="fas fa-users"></i><span>Сотрудники</span></a>
                <a href="logout.php" class="nav-item"><i class="fas fa-sign-out-alt"></i><span>Выход</span></a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="page-header-admin">
                <h1><i class="fas fa-chalkboard-teacher"></i> <?php echo $edit_mode ? 'Edit' : 'Add'; ?> Teacher</h1>
                <a href="teachers.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>

            <div class="form-container">
                <form method="POST">
                    <?php if ($edit_mode): ?><input type="hidden" name="id" value="<?php echo $teacher['id']; ?>"><?php endif; ?>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-id-card"></i> Teacher ID</label>
                            <input type="text" name="teacher_id" required value="<?php echo $edit_mode ? $teacher['teacher_id'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Full Name</label>
                            <input type="text" name="full_name" required value="<?php echo $edit_mode ? $teacher['full_name'] : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" name="email" required value="<?php echo $edit_mode ? $teacher['email'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> Phone</label>
                            <input type="text" name="phone" value="<?php echo $edit_mode ? $teacher['phone'] : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-building"></i> Department</label>
                            <select name="department" required>
                                <option value="">Select Department</option>
                                <option <?php echo ($edit_mode && $teacher['department'] == 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
                                <option <?php echo ($edit_mode && $teacher['department'] == 'Electrical Engineering') ? 'selected' : ''; ?>>Electrical Engineering</option>
                                <option <?php echo ($edit_mode && $teacher['department'] == 'Mechanical Engineering') ? 'selected' : ''; ?>>Mechanical Engineering</option>
                                <option <?php echo ($edit_mode && $teacher['department'] == 'Civil Engineering') ? 'selected' : ''; ?>>Civil Engineering</option>
                                <option <?php echo ($edit_mode && $teacher['department'] == 'Information Technology') ? 'selected' : ''; ?>>Information Technology</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-graduation-cap"></i> Специализация</label>
                            <input type="text" name="specialization" required value="<?php echo $edit_mode ? $teacher['specialization'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-certificate"></i> Квалификация</label>
                            <input type="text" name="qualification" required value="<?php echo $edit_mode ? $teacher['qualification'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-dollar-sign"></i> Зарплата</label>
                            <input type="number" name="salary" step="0.01" required value="<?php echo $edit_mode ? $teacher['salary'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-calendar"></i> Дата приема на работу</label>
                            <input type="date" name="hire_date" required value="<?php echo $edit_mode ? $teacher['hire_date'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-map-marker-alt"></i> Адрес</label>
                            <textarea name="address" rows="3"><?php echo $edit_mode ? $teacher['address'] : ''; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> <?php echo $edit_mode ? 'Update' : 'Add'; ?></button>
                        <a href="teachers.php" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
