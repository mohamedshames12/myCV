<header class="heater">
    <div class="container-heater">
        <a href="../index.php" class="logo">BIOGRAPHY</a>
        <nav class="navbar">
            <a href="../auth/login.php"><i class="fa fa-thin fa-right-to-bracket"></i></a>
            <a href="../auth/register.php"><i class="fa-solid fa-registered"></i></a>
            <a href="#"><i class="fa-solid fa-eye"></i></a>
            <?php
            if ($user_id != '') {


            ?>
                <div id="user-btn" class="far fa-user"></div>
            <?php }; ?>
        </nav>

        <?php
        if ($user_id != '') {

        ?>
            <div class="profile">
                <?php

                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
                $select_profile->execute([$user_id]);

                if ($select_profile->rowCount() > 0) {
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                
                    <div class="links">
                        <p class="name"> <?= $fetch_profile['name']; ?></p>
                        <?php if($fetch_profile['image'] != ''){ ?>
                            <img src="../uploaded_files/<?= $fetch_profile['image']?>" alt="" class="image_h">
                            <?php }; ?>
                        <a href="../auth/update.php" class="update">update profile</a>
                        <a href="../auth/logout.php" class="logout" onclick="return confirm('logout form this website?');">logout</a>
                    </div>
                <?php } else { ?>
                    <div class="flex-btn">
                        <p>please login or register</p>
                        <a href="../auth/login.php" class="login">login</a>
                        <a href="../auth/register.php" class="register">register</a>
                    </div>
                <?php }; ?>
            </div>
        <?php }; ?>


    </div>
</header>