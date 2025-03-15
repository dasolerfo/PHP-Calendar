<?php 

namespace App;

require_once __DIR__ . '/../vendor/autoload.php';

use DB\MySQLUserRepository;
use Model\User;

$errorsEmail = '';
$errorsPass = [];


session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorsEmail = "📧 Format d'email invàlid.";
    }

    if (strlen($password) < 9) {
        $errorsPass[] = "🔒 La contrasenya ha de tenir almenys 9 caràcters.";
    }
    
    if (!preg_match('/[A-Z]/', $password)) {
        $errorsPass[] = "🔠 La contrasenya ha de contenir almenys una lletra majúscula.";
    }

    if (!preg_match('/\d/', $password)) {
        $errorsPass[] = "🔢 La contrasenya ha de contenir almenys un número.";
    }

    if ($errorsEmail == '' && empty($errorsPass)) {

        $userRepo = new MySQLUserRepository();
        $user = new User(null, $email, $password);

        if ($userRepo->find($email) == null) {
            $userRepo->save($user);

            $_SESSION['email'] = $email;
        

            //echo "<p class='success-message'>✅ Registre completat amb èxit!</p>";
            header("Location: ./registration-success", true);
            exit();

        } else {
            $errorsPass[] = "🚫 El correu electrònic ja està en ús. Si us plau, utilitzeu un altre correu o inicieu sessió si ja teniu un compte."; 
        }

        
        
    }
}

?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
       
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right,rgb(154, 157, 255),rgb(200, 196, 250));
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        h2 {
            color:rgb(74, 71, 255);
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
             color:rgb(74, 71, 255) ;
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input {
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            font-family: 'Poppins', sans-serif;
            background:rgb(179, 185, 255);
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.4s ease;
        }

        .btn:hover {
            background:rgb(131, 117, 255);
        }

        .error-message {
            background: #ffebee;
            color: #d32f2f;
            padding: 10px;
            border-radius: 5px;
            margin-top: 14px;
            font-size: 14px;
            text-align: left;
        }

        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 16px;
        }
        a{
            display: inline-block;
            text-decoration: none;
            box-sizing: border-box;
            color:rgb(124, 124, 124);
            margin-top: 24px;
            font-size: small;

        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Registre</h2>

    <form action="" method="POST">
        <div class="input-group">
            <label for="email">Correu electrònic:</label>
            <input type="email" name="email" required>

            <?php if ($errorsEmail): ?>
                <p class="error-message"><?= htmlspecialchars($errorsEmail) ?></p>
            <?php endif; ?>

        </div>

        <div class="input-group">
            <label for="password">Contrasenya:</label>
            <input type="password" name="password" required>

            <?php if (!empty($errorsPass)): ?>
                <?php foreach ($errorsPass as $error): ?>
                    <p class="error-message"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn">Registrar</button>
        <a href="/login" > Ja tens un compte? </a>

    </form>
</div>

</body>
</html>
