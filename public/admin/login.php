<?php
session_start();
require_once '../config.php';

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Simple authentication (username: admin, password: admin)
    $query = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = 'Invalid username or password!';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход администратора - Технический университет</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-shield-alt"></i>
                <h1>Портал администратора</h1>
                <p>Система управления Техническим университетом</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" class="login-form">
                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user"></i> Имя пользователя
                    </label>
                    <input type="text" id="username" name="username" required
                           placeholder="Введите имя пользователя" value=>
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Пароль
                    </label>
                    <input type="password" id="password" name="password" required
                           placeholder="Введите пароль" value=>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Войти
                </button>
            </form>
            
            <div class="login-footer">
                <a href="../index.php">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
            </div>
            
            <div class="login-info">
                <p><strong>Стандартные учетные данные:</strong></p>
                <p>Имя пользователя: <code>admin</code></p>
                <p>Пароль: <code>admin</code></p>
            </div>
        </div>
    </div>
</body>
</html>
