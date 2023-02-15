<?php
    include '../config/connect.php';

    if(isset($_GET['get_id'])){
        $get_id = $_GET['get_id'];
    }else{
        $get_id = '';
        header('Location: ../index.php');
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
    <title>view progect</title>
</head>
<body>
    
    <?php include '../context/heater_a_.php';?>

    <div class="details">
        <h1 class="heading-details">Project details</h1>
        <a href="../index.php">All Projects</a>
    </div>

    <?php
        $select_project = $conn->prepare("SELECT * FROM `projects` WHERE id = ? LIMIT 1");
        $select_project->execute([$get_id]);
        if($select_project->rowCount() > 0) {
            while($fetch_profile = $select_project->fetch(PDO::FETCH_ASSOC)) {

                $total_ratings = 0;
                $ratings_1 = 0;
                $ratings_2 = 0;
                $ratings_3 = 0;
                $ratings_4 = 0;
                $ratings_5 = 0;

                $select_ratings = $conn->prepare("SELECT * FROM `reviews` WHERE post_id = ?");
                $select_ratings->execute([$fetch_profile['id']]);
                $total_reviews = $select_ratings->rowCount();
                while($fetch_rating = $select_ratings->fetch(PDO::FETCH_ASSOC)){
                    $total_ratings += $fetch_rating['rating'];
                    if($fetch_rating['rating'] == 1){
                        $ratings_1 +=$fetch_rating['rating'];
                    }
                    if($fetch_rating['rating'] == 2){
                        $ratings_2 +=$fetch_rating['rating'];
                    }
                    if($fetch_rating['rating'] == 3){
                        $ratings_3 +=$fetch_rating['rating'];
                    }
                    if($fetch_rating['rating'] == 4){
                        $ratings_4 +=$fetch_rating['rating'];
                    }
                    if($fetch_rating['rating'] == 5){
                        $ratings_5 +=$fetch_rating['rating'];
                    }
                }

                if($total_reviews != 0){
                   $average = round($total_ratings / $total_reviews , 1);
                }else{
                    $average = 0;
                }
            ?>
                <div class="row">
                    <div class="col">
                        <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
                        <h3><?= $fetch_profile['title']; ?></h3>
                    </div>
                            <div class="total-reviews">
                                <h3><?= $average; ?><i class="fa-solid fa-star"></i> </h3>
                                <p><?= $total_reviews;?> reviews</p>
                            </div>
                            <div class="total-ratings">
                                <p>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <span><?= $ratings_5; ?></span>
                                </p>
                                <p>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <span><?= $ratings_4; ?></span>
                                </p>
                                <p>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <span><?= $ratings_3; ?></span>
                                </p>
                                <p>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <span><?= $ratings_2; ?></span>
                                </p>
                                <p>
                                <i class="fa-solid fa-star"></i>
                                <span><?= $ratings_1; ?></span>
                                </p>
                            </div>
                        </div>

       <?php
    
        }
        }else{
            echo '<p class="empty">project is missing!</p>';
        }
    ?>

<div class="details">
        <h1 class="heading-details">user's reviews</h1>
        <a href="add_review.php?get_id=<?= $get_id; ?>">Add review</a>
    </div>

    <?php 
        include '../context/footer.php';
    ?>

            <!-- sweetalert cdnjs link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- JS files -->
    <script src="../js/script.js"></script>
    <?php include "alert.php"; ?>
</body>
</html>