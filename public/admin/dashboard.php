<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require_once '../config.php';

// Get counts
$students_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM students"))['count'];
$teachers_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM teachers"))['count'];
$workers_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM workers"))['count'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора - ВГЛТУ </title>
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
                <span>ВГЛТУ </span>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Панель управления</span>
                </a>
                <a href="students.php" class="nav-item">
                    <i class="fas fa-user-graduate"></i>
                    <span>Студенты</span>
                </a>
                <a href="teachers.php" class="nav-item">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Преподаватели</span>
                </a>
                <a href="workers.php" class="nav-item">
                    <i class="fas fa-users"></i>
                    <span>Сотрудники</span>
                </a>
                <a href="logout.php" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Выход</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <h1>Панель администратора</h1>
                <div class="admin-info">
                    <i class="fas fa-user-shield"></i>
                    <span>Добро пожаловать, <?php echo $_SESSION['admin_username']; ?></span>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Stats Cards -->
                <div class="stats-row">
                    <div class="stat-box">
                        <div class="stat-icon students">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?php echo $students_count; ?></h3>
                            <p>Всего студентов</p>
                        </div>
                        <a href="students.php" class="stat-link">Посмотреть все <i class="fas fa-arrow-right"></i></a>
                    </div>

                    <div class="stat-box">
                        <div class="stat-icon teachers">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?php echo $teachers_count; ?></h3>
                            <p>Всего преподавателей</p>
                        </div>
                        <a href="teachers.php" class="stat-link">Посмотреть все <i class="fas fa-arrow-right"></i></a>
                    </div>

                    <div class="stat-box">
                        <div class="stat-icon workers">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?php echo $workers_count; ?></h3>
                            <p>Всего сотрудников</p>
                        </div>
                        <a href="workers.php" class="stat-link">Посмотреть все <i class="fas fa-arrow-right"></i></a>
                    </div>

                    <div class="stat-box">
                        <div class="stat-icon total">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?php echo $students_count + $teachers_count + $workers_count; ?></h3>
                            <p>Всего записей</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h2>Быстрые действия</h2>
                    <div class="action-buttons">
                        <a href="students.php?action=add" class="action-btn">
                            <i class="fas fa-plus-circle"></i>
                            Добавить студента
                        </a>
                        <a href="teachers.php?action=add" class="action-btn">
                            <i class="fas fa-plus-circle"></i>
                            Добавить преподавателя
                        </a>
                        <a href="workers.php?action=add" class="action-btn">
                            <i class="fas fa-plus-circle"></i>
                            Добавить сотрудника
                        </a>
                        <a href="../index.php" class="action-btn" target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                            Просмотреть сайт
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="recent-activity">
                    <h2>Информация о системе</h2>
                    <div class="info-grid">
                        <div class="info-card">
                            <i class="fas fa-calendar"></i>
                            <h4>Дата системы</h4>
                            <p><?php echo date('F d, Y'); ?></p>
                        </div>
                        <div class="info-card">
                            <i class="fas fa-clock"></i>
                            <h4>Текущее время</h4>
                            <p><?php echo date('h:i A'); ?></p>
                        </div>
                        <div class="info-card">
                            <i class="fas fa-server"></i>
                            <h4>База данных</h4>
                            <p>MySQL подключена</p>
                        </div>
                        <div class="info-card">
                            <i class="fas fa-shield-alt"></i>
                            <h4>Уровень доступа</h4>
                            <p>Полный администратор</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
