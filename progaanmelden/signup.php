<?php
session_start();

include("connection.php");
include("functions.php");

class RegistrationHandler {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function handleRegistration() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (!empty($username) && !empty($password) && !is_numeric($username)) {
                $userid = random_num(20);
                $query = "INSERT INTO users (userid, username, password) VALUES ('$userid', '$username', '$password')";
                mysqli_query($this->con, $query);
                header("Location: login.php");
                die;
            }
        }
    }
}
$registrationHandler = new RegistrationHandler($con);
$registrationHandler->handleRegistration();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<article class="box">

    <form method="post">
        <label>New User Name</label>
        <input type="username" name="username" placeholder="username"><br><br>

        <label>New Password</label>
        <input type="password" name="password" placeholder="wachtwoord"><br><br>

        <input class="submit__button" type="submit" value="SIGN UP"><br><br>

        <a href="login.php">Click to Login</a><br><br>
        <a class="return" href="index.php">Terug  naar de home pagina</a><br><br>
    </form>

    </article>
    
</body>
</html>