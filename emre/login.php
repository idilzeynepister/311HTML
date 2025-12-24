<?php
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Lütfen kullanıcı adı ve şifre giriniz.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];

            header("Location: index.php");
            exit;
        } else {
            $error = "Hatalı kullanıcı adı veya şifre.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - n11</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #e2e2e2;
            background: #fff;
            border-radius: 4px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h2 {
            font-size: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 13px;
            color: #666;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #5d3ebc;
            background-color: #e11830;
            color: white;
            border: none;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            border-radius: 3px;
        }

        .btn-login:hover {
            background-color: #c9162b;
        }

        .error-msg {
            color: #d00;
            font-size: 13px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>

<body>

    <header style="border-bottom: 1px solid #eee;">
        <div class="container" style="display:flex; justify-content:center; padding: 20px;">
            <a href="index.php">
                <svg class="logo-icon" viewBox="0 0 100 50" width="100" height="50">
                    <circle cx="20" cy="25" r="15" fill="#333" />
                    <circle cx="20" cy="25" r="5" fill="#e11830" />
                    <text x="40" y="35" font-family="Arial, sans-serif" font-size="30" font-weight="bold"
                        fill="#333">n11</text>
                </svg>
            </a>
        </div>
    </header>

    <div class="login-container">
        <div class="login-header">
            <h2>Giriş Yap</h2>
        </div>

        <?php if ($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>E-Posta Adresi veya Kullanıcı Adı</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Şifre</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn-login">Giriş Yap</button>
        </form>
    </div>

    <div style="text-align:center; font-size:12px; color:#999; margin-top:50px;">
        &copy; 2024 n11.com
    </div>

</body>

</html>