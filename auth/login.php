<?php
 
    include '../config/connect.php';

    if(isset($_POST['login'])){

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass =  $_POST['pass'];
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);


    
        $verify_email = $conn->prepare("SELECT * FROM `users` WHERE email = ? LIMIT 1");
        $verify_email->execute([$email]);
    
        if($verify_email->rowCount() > 0){
            $fetch = $verify_email->fetch(PDO::FETCH_ASSOC);
            $verfiy_pass = password_verify($pass, $fetch['password']);
            if($verfiy_pass == 1){
                setcookie('user_id', $fetch['id'], time() + 60*60*24*30 ,'/');
                header('location: ../index.php');
            }else{
                $warning_msg[] = "Incorrect password!";
            }
        }else{
            $warning_msg[] = "Incorrect email!";
        }

    }



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- css cdnjs font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <!-- css file -->
        <link rel="stylesheet" href="../css/register.css">
        <link rel="stylesheet" href="../css/style.css">
    <title>Login</title>
</head>
<body>

    <?php include '../context/heater_a_.php';?>
    
    <form action="" enctype="multipart/form-data" method="POST" class="form">
        <div class="form-container">
        <h1>Login now</h1>
            <p>your email*</p>
            <input type="email" placeholder="enter your email" name="email" class="box" required>
            <p>your password*</p>
            <input type="password" placeholder="enter your password" name="pass" class="box" required>
            <p class="link">don't have an acount? <a href="register.php">Register now</a></p>
            <input type="submit" name="login" value="Login now" class="register">
        </div>
    </form>

    <?php include '../context/footer.php'?>

    <!-- sweetalert cdnjs link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include "../components/alert.php"; ?>
        <!-- file js -->
        <script src="../js/script.js"></script>
</body>
</html>