<?php
session_start();
require 'config.php';

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($con, trim($_POST['username']));
    $password = mysqli_real_escape_string($con, trim($_POST['password']));

    try {
        $stmt = $con->prepare("SELECT userID, name, password FROM users WHERE username = ?");
        if ($stmt) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($userID, $name, $hashedPassword);
                $stmt->fetch();
               
                // Verify password
                if (password_verify($_POST['password'], $hashedPassword)) {
                    // Password is correct, set session variables or perform further actions
                    $_SESSION['userID'] = $userID;
                    $_SESSION['name'] = $name;

                    // Redirect to the dashboard or desired page
                    header("Location: ../admin/index.php");
                    exit();
                } else {
                    // Password is incorrect
                    header("Location: login.php?error=Invalid username or password");
                    exit();
                }
            } else {
                // User does not exist
                header("Location: login.php?error=Invalid username or password");
                exit();
            }
            $stmt->close();
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
    <link rel="icon" type="image/png" sizes="32x32" href="./pics/favicon-32x32.png">
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
    #login{
        justify-content: center;
        margin: 14%;
    }
    .login-box{
        width: 460px;
        height: 360px;
        margin: auto;
        border: 2px solid #c8815f;
        background-color: #fff;
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
        margin-top: 20px;
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
    <section id="login">
    <div class="login-box">
        <h1>Login</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label>Username</label>
            <input type="text" name="username" placeholder="" />
            <label>Password</label>
            <input type="password" name="password" placeholder="" />
            <input type="submit" name="submit" value="Submit">
        </form>
        <p class="para-2">
            Don't have an account? <a href="inscription.php">Sign up here</a>
        </p>
    </div>
    </section>
</body>
</html>