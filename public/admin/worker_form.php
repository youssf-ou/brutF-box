<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require_once '../config.php';

$edit_mode = false;
$worker = null;

if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM workers WHERE id = $id");
    $worker = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $worker_id = mysqli_real_escape_string($conn, $_POST['worker_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $salary = floatval($_POST['salary']);
    $hire_date = mysqli_real_escape_string($conn, $_POST['hire_date']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);
    
    if ($edit_mode && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $query = "UPDATE workers SET worker_id='$worker_id', full_name='$full_name', email='$email', 
                  phone='$phone', position='$position', department='$department', salary=$salary, 
                  hire_date='$hire_date', address='$address', national_id='$national_id' WHERE id=$id";
        mysqli_query($conn, $query);
        header("Location: workers.php?msg=updated");
    } else {
        $query = "INSERT INTO workers (worker_id, full_name, email, phone, position, department, salary, hire_date, address, national_id) 
                  VALUES ('$worker_id', '$full_name', '$email', '$phone', '$position', '$department', $salary, '$hire_date', '$address', '$national_id')";
        mysqli_query($conn, $query);
        header("Location: workers.php?msg=added");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $edit_mode ? 'Edit' : 'Add'; ?> Worker</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-body">
    <div class="admin-wrapper">
        <aside class="sidebar">
            <div class="sidebar-header"><i class="fas fa-graduation-cap"></i><span>Tech University</span></div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                <a href="students.php" class="nav-item"><i class="fas fa-user-graduate"></i><span>Students</span></a>
                <a href="teachers.php" class="nav-item"><i class="fas fa-chalkboard-teacher"></i><span>Teachers</span></a>
                <a href="workers.php" class="nav-item active"><i class="fas fa-users"></i><span>Workers</span></a>
                <a href="logout.php" class="nav-item"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="page-header-admin">
                <h1><i class="fas fa-users"></i> <?php echo $edit_mode ? 'Edit' : 'Add'; ?> Worker</h1>
                <a href="workers.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>

            <div class="form-container">
                <form method="POST">
                    <?php if ($edit_mode): ?><input type="hidden" name="id" value="<?php echo $worker['id']; ?>"><?php endif; ?>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-id-card"></i> Worker ID</label>
                            <input type="text" name="worker_id" required value="<?php echo $edit_mode ? $worker['worker_id'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Full Name</label>
                            <input type="text" name="full_name" required value="<?php echo $edit_mode ? $worker['full_name'] : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" name="email" required value="<?php echo $edit_mode ? $worker['email'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> Phone</label>
                            <input type="text" name="phone" value="<?php echo $edit_mode ? $worker['phone'] : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-briefcase"></i> Должность</label>
                            <input type="text" name="position" required value="<?php echo $edit_mode ? $worker['position'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-building"></i> Отдел</label>
                            <select name="department" required>
                                <option value="">Выберите отдел</option>
                                <option <?php echo ($edit_mode && $worker['department'] == 'IT Department') ? 'selected' : ''; ?>>IT отдел</option>
                                <option <?php echo ($edit_mode && $worker['department'] == 'Administration') ? 'selected' : ''; ?>>Администрация</option>
                                <option <?php echo ($edit_mode && $worker['department'] == 'Engineering Lab') ? 'selected' : ''; ?>>Инженерная лаборатория</option>
                                <option <?php echo ($edit_mode && $worker['department'] == 'Library') ? 'selected' : ''; ?>>Библиотека</option>
                                <option <?php echo ($edit_mode && $worker['department'] == 'Facilities') ? 'selected' : ''; ?>>Хозяйственный отдел</option>
                                <option <?php echo ($edit_mode && $worker['department'] == 'Human Resources') ? 'selected' : ''; ?>>Отдел кадров</option>
                                <option <?php echo ($edit_mode && $worker['department'] == 'Security') ? 'selected' : ''; ?>>Охрана</option>
                                <option <?php echo ($edit_mode && $worker['department'] == 'Finance') ? 'selected' : ''; ?>>Финансы</option>
                                <option <?php echo ($edit_mode && $worker['department'] == 'Registrar Office') ? 'selected' : ''; ?>>Регистратура</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-dollar-sign"></i> Зарплата</label>
                            <input type="number" name="salary" step="0.01" required value="<?php echo $edit_mode ? $worker['salary'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-calendar"></i> Дата приема на работу</label>
                            <input type="date" name="hire_date" required value="<?php echo $edit_mode ? $worker['hire_date'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-id-badge"></i> Национальный ID</label>
                            <input type="text" name="national_id" value="<?php echo $edit_mode ? $worker['national_id'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-map-marker-alt"></i> Адрес</label>
                            <textarea name="address" rows="3"><?php echo $edit_mode ? $worker['address'] : ''; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> <?php echo $edit_mode ? 'Update' : 'Add'; ?></button>
                        <a href="workers.php" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
