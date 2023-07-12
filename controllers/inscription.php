<?php
session_start();
require 'config.php';

$name = $username = $password_1 = $password_2 = "";

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password_1 = trim($_POST['password_1']);
    $password_2 = trim($_POST['password_2']);

    // Check if the passwords match
    if ($password_1 != $password_2) {
        header("Location: inscription.php?error=passwords don't match");
        exit();
    }

    try {
        $stmt = $con->prepare("SELECT userID, name, password FROM users WHERE username = :username");
        if ($stmt) {
            $stmt->bindParam(':username', $_POST['username']);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result > 0) {
                header("Location: inscription.php?error=username already exists!");
            } else {
                $stmt = $con->prepare("INSERT INTO users(name, username, password) VALUES (:name, :username, :password)");
                if ($stmt) {
                    $password = password_hash($_POST['password_1'], PASSWORD_BCRYPT);
                    $stmt->bindParam(':name', $_POST['name']);
                    $stmt->bindParam(':username', $_POST['username']);
                    $stmt->bindParam(':password', $password);
                    $stmt->execute();
                    header("Location: login.php");
                } else {
                    throw new Exception("Failed to prepare INSERT statement.");
                }
            }
            exit();
        } else {
            throw new Exception("Failed to prepare SELECT statement.");
        }
    } catch (Exception $e) {
        // Display the detailed error message
        echo "Error: " . $e->getMessage();
    }
    $con->close();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="../pics/favicon-32x32.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Connexion</title>
    <style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    list-style: none;
    font-family: 'cinzel', serif;
    text-decoration: none;
    scroll-behavior: smooth;
    }
    body{
    background-color: #D7DCE2;
    color: #111111;
    }
    #inscription{
        justify-content: center;
        margin: 4%;
    }
    .signup-box{
        width: 460px;
        height: 520px;
        margin: auto;
        background-color: #fff;
        border: 2px solid #c8815f;
    }
    h1{
        text-align: center;
        font-size: 30px;
        text-transform: uppercase;
        padding-top: 15px;
        padding-bottom: 30px;
    }
    form{
        width: 400px;
        margin-left: 20px;
    }
    form label{
        display: flex;
        margin-top: 20px;
        font-size: 18px;
    }
    form input{
        width: 100%;
        padding: 7px;
        border: none;
        border-bottom: 2px solid #c8815f;
        outline: none;
    }
    input[type="submit"]{
        width: 420px;
        height: 35px;
        margin-top: 25px;
        border: 3px solid #c8815f;
        background-color: #c8815f;
        color: #fff;
        border-radius: 5px;
        font-weight: 700;
        font-size: 18px;
        text-transform: uppercase;
        cursor: pointer;
        overflow: hidden;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    p{
        text-align: center;
        padding-top: 50px;
        font-size: 15px;
    }
    .para-2{
        text-align: center;
        color: #999999;
        font-size: 15px;
        margin-top: -10px;
    }
    .para-2 a{
        color: #111111;
    }
    </style>
</head>
<body>
    <section id="inscription">
    <div class="signup-box">
        <h1>Sign up</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label>Name</label>
            <input type="text" name="name" id="name" placeholder="">
            <label>Username</label>
            <input type="text" name="username" id="username" placeholder="">
            <label>Password</label>
            <input type="password" name="password_1" id="password_1" placeholder="">
            <label>Confirm password</label>
            <input type="password" name="password_2" id="password_2" placeholder="">
            <input type="submit" value="Submit" name="submit" id="submit">
        </form>
        <p class="para-2">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </div>
    </section>
</body>
</html>