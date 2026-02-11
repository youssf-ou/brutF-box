<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require_once '../config.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM workers WHERE id = $id");
    header("Location: workers.php?msg=deleted");
    exit();
}

// Get all workers
$result = mysqli_query($conn, "SELECT * FROM workers ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление сотрудниками - ВГЛТУ </title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-body">
    <div class="admin-wrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-graduation-cap"></i>
                <span>ВГЛТУ </span>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item"><i class="fas fa-tachometer-alt"></i><span>Панель управления</span></a>
                <a href="students.php" class="nav-item"><i class="fas fa-user-graduate"></i><span>Студенты</span></a>
                <a href="teachers.php" class="nav-item"><i class="fas fa-chalkboard-teacher"></i><span>Преподаватели</span></a>
                <a href="workers.php" class="nav-item active"><i class="fas fa-users"></i><span>Сотрудники</span></a>
                <a href="logout.php" class="nav-item"><i class="fas fa-sign-out-alt"></i><span>Выход</span></a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="page-header-admin">
                <h1><i class="fas fa-users"></i> Управление сотрудниками</h1>
                <a href="worker_form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Добавить нового сотрудника</a>
            </div>

            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php
                    if ($_GET['msg'] == 'added') echo 'Сотрудник успешно добавлен!';
                    if ($_GET['msg'] == 'updated') echo 'Сотрудник успешно обновлен!';
                    if ($_GET['msg'] == 'deleted') echo 'Сотрудник успешно удален!';
                    ?>
                </div>
            <?php endif; ?>

            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Номер сотрудника</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Должность</th>
                            <th>Факультет</th>
                            <th>Зарплата</th>
                            <th>Национальный ID</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><strong><?php echo $row['worker_id']; ?></strong></td>
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['position']; ?></td>
                            <td><?php echo $row['department']; ?></td>
                            <td><strong>₽<?php echo number_format($row['salary'], 2); ?></strong></td>
                            <td><?php echo $row['national_id']; ?></td>
                            <td>
                                <div class="action-buttons-table">
                                    <a href="worker_form.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="workers.php?delete=<?php echo $row['id']; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Вы уверены?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
