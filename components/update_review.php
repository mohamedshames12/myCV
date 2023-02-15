<?php
    include '../config/connect.php';

    
    if(isset($_GET['get_id'])){
        $get_id = $_GET['get_id'];
    }else{
        $get_id = '';
        header('Location: ../index.php');
    }


    if(isset($_POST['submit'])){

        $title = $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $description = $_POST['description'];
        $description = filter_var($description, FILTER_SANITIZE_STRING);
        $rating = $_POST['rating'];
        $rating = filter_var($rating, FILTER_SANITIZE_STRING);

        $update_review = $conn->prepare("UPDATE `reviews` SET rating = ?, title = ?, description = ? WHERE id = ?");
        $update_review->execute([$rating,$title,$description, $get_id]);
        $success_msg[] = 'review updated!';
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
    <title>Update review</title>
</head>
<body>
    
    <?php include '../context/heater_a_.php';?>

    <div class="container-form">
        <?php
            $select_review = $conn->prepare("SELECT * FROM `reviews` WHERE id = ?");
            $select_review->execute([$get_id]);
            if($select_review->rowCount() > 0){
                while($fetch_review = $select_review->fetch(PDO::FETCH_ASSOC)){
        ?>
    <form action="" method="post">
    <h3>update your review</h3>
        <p>review title <span>*</span></p>
        <input type="text" name="title" placeholder="enter review title" maxlength="20" class="box" value="<?= $fetch_review['title']?>">
        <p>review description</p>
        <textarea name="description" maxlength="1000" cols="30" rows="10" placeholder="enter review description" value="<?= $fetch_review['description']?>" ></textarea>
        <p>review rationg <span>*</span></p>
        <select name="rating" class="box" required>
            <option value="<?= $fetch_review['rating']?>"><?= $fetch_review['rating']?></option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <input type="submit" class="btn" value="update review" name="submit">
        <a href="view_post.php?get_id=<?= $fetch_review['post_id'] ?>"  class="link_add">go back</a>
    </form>
    <?php
          }
         }else{
            echo '<p class="empty">something went wrong!</p>';
          }
    ?>
    </div>





    <!-- sweetalert cdnjs link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- JS files -->
    <script src="../js/script.js"></script>
    <?php include "alert.php"; ?>
    
    <?php include '../context/footer.php';?>
</body>
</html>