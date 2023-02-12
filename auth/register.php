<?php
 
    include '../config/connect.php';


    if(isset($_POST['register'])){

        $id = create_unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        $c_pass = password_verify($_POST['c_pass'], $pass);
        $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = create_unique_id().'.'.$ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_files/'.$rename;



        if(!empty($image)){
            if($image_size > 2000000){
                $warning_msg[] = "image size is too large!";
            }else{
                move_uploaded_file($image_tmp_name, $image_folder);
            }
        }else{
            $rename = '';
        }
    
        $verify_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $verify_email->execute([$email]);
    
        if($verify_email->rowCount() > 0){
            $warning_msg[] = 'Email already exists!';
        }else{
            if($c_pass == 1){
                $insert_user = $conn->prepare("INSERT INTO `users` (id, name , email , password, image) VALUES(?,?,?,?,?)");
                $insert_user->execute([$id, $name, $email, $pass, $rename]);
                $success_msg[] = 'registered successfully!';
                header('location: login.php');
            }else{
                $warning_msg[] = 'Confirm password not matched!';
            }
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
    <title>Register</title>
</head>
<body>

    <?php include '../context/heater_a_.php';?>
    
    <form action="" enctype="multipart/form-data" method="POST" class="form">
        <div class="form-container">
        <h1>Make your acount!</h1>
            <p>your full name*</p>
            <input type="text" placeholder="enter your name" name="name" class="box" required>
            <p>your email*</p>
            <input type="email" placeholder="enter your email" name="email" class="box" required>
            <p>your password*</p>
            <input type="password" placeholder="enter your password" name="pass" class="box" required>
            <p>confirm password*</p>
            <input type="password" placeholder="confirm password" name="c_pass" class="box" required>     
            <p>your profile*</p>
            <input type="file" name="image" class="box box-file" required accept="image/*">
            <p class="link">already have an acount? <a href="login.php">login now</a></p>
            <input type="submit" name="register" value="register now" class="register">
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