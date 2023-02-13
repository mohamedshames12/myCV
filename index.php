<?php

    include "config/connect.php";
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS files -->
    <link rel="stylesheet" href="css/style.css">
    <!-- css cdnjs font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>My CV</title>
</head>
<body>
    
    <?php include 'context/heater_b_.php'; ?>


    <section class="about-me">
        <div class="container-about">
        <div class="image">
            <img src="images/mohamed.jpg" alt="">
        </div>
        <div class="bio">
            <h1>Mohamed Shams</h1>
            <p>full stack, web developer</p>
            <a href="#">show profile</a>
        </div>
        </div>
    </section>
    
    <h1 class="heading">my projects</h1>
    <section class="projects">
           
        <div class="container-project">
                <?php
                    $select_project = $conn->prepare("SELECT * FROM `projects`");
                    $select_project->execute();
                    if($select_project->rowCount() > 0){
                        while($fetch_project = $select_project->fetch(PDO::FETCH_ASSOC)){

                            $project_id = $fetch_project['id'];

                            $count_review = $conn->prepare("SELECT * FROM `reviews` WHERE post_id = ?");
                            $count_review->execute([$project_id]);
                            $total_review = $count_review->rowCount();
                            ?>

                             <div class="box-project">
                                <img src="uploaded_files/<?= $fetch_project['image']; ?>" alt="">
                                <h3><?= $fetch_project['title']; ?></h3>
                                <p class="total_review"> <i class="fa-solid fa-star"></i> <span><?= $total_review; ?></span></p>
                                <a href="components/view_post.php?get_id=<?= $project_id; ?>" class="get_btn">view project</a>
                             </div>


                          <?php
                        }
                    }else{
                        echo '<p class="empty">no project added yet</p>';
                    }
                ?>
        </div>
    </section>




    <!-- sweetalert cdnjs link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- JS files -->
    <script src="js/script.js"></script>
    <?php include "components/alert.php"; ?>
    <?php include "context/footer.php"; ?>
</body>
</html>