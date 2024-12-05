<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; 

    if ($role === 'admin' && $username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_dashboard.php');
        exit;
    } elseif ($role === 'client') {
        $email = $_POST['username'];
        $mot_de_passe = $_POST['password'];
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE email = ?");
        $stmt->execute([$email]);
        $client = $stmt->fetch();
        if ($client && password_verify($mot_de_passe, $client['mot_de_passe'])) {
            $_SESSION['client_id'] = $client['id'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error_message = "Identifiants incorrects.";
        }
    } else {
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page de Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
        }
        .login-container label {
            text-align: left;
            margin-bottom: 5px;
            color: #555;
        }
        .login-container input, .login-container select, .login-container button {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-container button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #0056b3;
        }
        .login-container p {
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <?php if (isset($error_message)): ?>
            <p><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        
        <form method="POST">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" name="username" required>

            <label for="password">Mot de passe:</label>
            <input type="password" name="password" required>

            <label for="role">Rôle:</label>
            <select name="role" required>
                <option value="admin">Administrateur</option>
                <option value="client">Client</option>
            </select>
            
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
