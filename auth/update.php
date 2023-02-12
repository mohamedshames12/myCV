<?php

include '../config/connect.php';


if (isset($_POST['update_profile'])) {

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE  id = ? LIMIT 1");
    $select_user->execute([$user_id]);
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);


    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    if (!empty($name)) {
        $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
        $update_name->execute([$name, $user_id]);
        $success_msg[] = 'Username updated successfully!';
    }

    if (!empty($email)) {
        $verfiy_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $verfiy_email->execute([$email]);
        if ($verfiy_email->rowCount() > 0) {
            $warning_msg[] = 'Email already exists!';
        } else {
            $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
            $update_email->execute([$email, $user_id]);
            $success_msg[] = 'Email successfully updated!';
        }
    }


    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = create_unique_id() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $rename;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $warning_msg[] = 'Image size is too large!';
        } else {
            $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
            $update_image->execute([$rename, $user_id]);
            move_uploaded_file($image_tmp_name, $image_folder);
            if ($fetch_user['image'] != '') {
                unlink('../uploaded_files/'.$fetch_user['image']);
            }
            $success_msg[] = 'Image uploaded successfully!';
        }
    }

    $prev_pass = $fetch_user['password'];

    $old_pass = password_hash($_POST['old_pass'], PASSWORD_DEFAULT);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);

    $empty_old = password_verify('', $old_pass);

    $new_pass = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);

    $empty_new = password_verify('', $new_pass);

    $c_pass = password_verify($_POST['c_pass'], $new_pass);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);


    if($empty_old != 1){
        $verfiy_old_pass = password_verify($_POST['old_pass'], $prev_pass);
        if($verfiy_old_pass == 1){
            if($c_pass == 1){
                if($empty_new != 1){
                    $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                    $update_pass->execute([$new_pass, $user_id]);
                    $success_msg[] = 'your password has been changed!';
                }else{
                    $warning_msg[] = 'Please enter a new password!';
                }
            }else{
                $warning_msg[] = 'Confirm password verification!';
            }
        }else{
            $warning_msg[] = 'Old password validation failed!';
        }
    }
}

 if(isset($_POST['delete_image'])){
    $slect_old_pic = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
    $slect_old_pic->execute([$user_id]);
    $fetch_old_pic = $slect_old_pic->fetch(PDO::FETCH_ASSOC);

    if($fetch_old_pic['image'] == ''){
        $warning_msg[] = "Image already exists!";
    }else{
        $update_old_pic = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
        $update_old_pic->execute(['',$user_id ]);
        if($fetch_old_pic['image'] != ''){
            unlink('../uploaded_files/'.$fetch_old_pic['image']);
        }
        $success_msg[] = "Image updated successfully!";
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
    <title>updata profile</title>
</head>

<body>

    <?php include '../context/heater_a_.php'; ?>

    <form action="" enctype="multipart/form-data" method="POST" class="form">
        <div class="form-container">
            <h1>update your profile!</h1>
            <p>your full name</p>
            <input type="text" placeholder="<?= $fetch_profile['name']; ?>" name="name" class="box">
            <p>your email</p>
            <input type="email" placeholder="<?= $fetch_profile['email']; ?>" name="email" class="box">
            <p>your old password</p>
            <input type="password" placeholder="enter your old password" name="old_pass" class="box">
            <p>your new password</p>
            <input type="password" placeholder="enter your new password" name="new_pass" class="box">
            <p>confirm new password</p>
            <input type="password" placeholder="confirm new password" name="c_pass" class="box">
            <?php if ($fetch_profile['image'] != '') { ?>
                <img src="../uploaded_files/<?= $fetch_profile['image'] ?>" alt="" class="image">
                <input type="submit" value="delete image" name="delete_image" onclick="return confirm('Do you want to delete this image?');" class="delete_btn">
            <?php }; ?>
            <p>profile pic</p>
            <input type="file" name="image" class="box box-file" accept="image/*">
            <input type="submit" name="update_profile" value="update now" class="register">
        </div>
    </form>

    <?php include '../context/footer.php' ?>

    <!-- sweetalert cdnjs link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include "../components/alert.php"; ?>
    <!-- file js -->
    <script src="../js/script.js"></script>
</body>

</html>