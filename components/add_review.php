<?php
    include '../config/connect.php';

    
    if(isset($_GET['get_id'])){
        $get_id = $_GET['get_id'];
    }else{
        $get_id = '';
        header('Location: ../index.php');
    }

    if(isset($_POST['submit'])){

        if($user_id != ''){
            $id = create_unique_id();
            $title = $_POST['title'];
            $title = filter_var($title, FILTER_SANITIZE_STRING);
            $description = $_POST['description'];
            $description = filter_var($description, FILTER_SANITIZE_STRING);
            $rating = $_POST['rating'];
            $rating = filter_var($rating, FILTER_SANITIZE_STRING);

            $varify_review = $conn->prepare("SELECT * FROM `reviews` WHERE post_id = ? AND user_id = ?");
            $varify_review->execute([$get_id, $user_id]);

            if($varify_review->rowCount() > 0){
                $warning_msg[] = 'your review already added!';
            }else{
                $add_review = $conn->prepare("INSERT INTO `reviews`(id, post_id, user_id, rating, title, description) VALUES(?,?,?,?,?,?)");
                $add_review->execute([$id,$get_id,$user_id,$rating,$title,$description]);
                $success_msg[] = "Review successfully!";
            }

        }else{
            $warning_msg[] = 'Please login first!';
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS files -->
        <link rel="stylesheet" href="../css/style.css">
    <!-- css cdnjs font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>Add review</title>
</head>
<body>
    
    <?php include '../context/heater_a_.php';?>

    <div class="container-form">
    <form action="" method="post">
    <h3>post your review</h3>
        <p>review title <span>*</span></p>
        <input type="text" name="title" placeholder="enter review title" maxlength="20" class="box" required>
        <p>review description</p>
        <textarea name="description" maxlength="1000" cols="30" rows="10" placeholder="enter review description" required></textarea>
        <p>review rationg <span>*</span></p>
        <select name="rating" class="box" required>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
        <input type="submit" class="btn" value="submit review" name="submit">
        <a href="view_post.php?get_id=<?= $get_id; ?>"  class="link_add">go back</a>
    </form>
    </div>





    <!-- sweetalert cdnjs link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- JS files -->
    <script src="../js/script.js"></script>
    <?php include "alert.php"; ?>
    
    <?php include '../context/footer.php';?>
</body>
</html>