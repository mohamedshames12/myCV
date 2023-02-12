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
    
    <section class="projects">
            <h1 class="heading">my projects</h1>
        <div class="container-project">
            <div class="box-project">
                <?php
                    $select_project = $conn->prepare("SELECT * FROM `projects`");
                    $select_project->execute();
                    if($select_project->rowCount() > 0){
                        while($fetch_project = $select_project->fetch(PDO::FETCH_ASSOC)){
                            ?>

                            <p><?php $fetch_project["title"]?></p>


                          <?php
                        }
                    }else{
                        echo '<p>no project added yet</p>';
                    }
                ?>
            </div>
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