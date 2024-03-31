<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'];  ?></title>

</head>

<body class="bg-light">

    <?php require('inc/header.php') ?>

    <!-------------------------
----- Reach us section
--------------------------------->
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center ">About Us</h2>
        <div class="h-line bg-dark"></div>
        <div class="h2-line bg-dark "></div>
        <p class="text-center mt-3">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Omnis, consectetur vero! Architecto <br>reprehenderit suscipit eius sunt fuga laboriosam tempora dolorem!</p>
    </div>


    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 ordre-2">
                <h3 class="mb-3">Lorem ipsum dolor sit.</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit voluptates pariatur cupiditate aliquid in. Doloremque consectetur adipisci provident.
                    dolor sit amet consectetur adipisicing elit. Velit voluptates pariatur cupiditate aliquid in. Doloremque consectetur adipisci provident.
                </p>
            </div>
            <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
                <img src="images/about/about.jpg" class="w-100" alt="">
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-w-4 text-center box">
                    <img src="images/about/hotel.svg" width="70px" alt="">
                    <h4 class="mt-3">100+ Rooms</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-w-4 text-center box">
                    <img src="images/about/customers.svg" width="70px" alt="">
                    <h4 class="mt-3">100+ Rooms</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-w-4 text-center box">
                    <img src="images/about/hotel.svg" width="70px" alt="">
                    <h4 class="mt-3">100+ Rooms</h4>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-w-4 text-center box">
                    <img src="images/about/hotel.svg" width="70px" alt="">
                    <h4 class="mt-3">100+ Rooms</h4>
                </div>
            </div>



        </div>
    </div>

    <h3 class="my-5 fw-bold h-font text-center">Managment Team</h3>
    <div class="container px-4">
        <!-- Swiper -->
        <div class="swiper team-swiper">
            <div class="swiper-wrapper mb-5 ">

                <?php
                $about_r = selectAll('team_details');
                $path = ABOUT_IMG_PATH;
                while ($row = mysqli_fetch_assoc($about_r)) {

                ?>
                    <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                        <img src="<?php echo $path . $row['picture']; ?>" class="w-100" alt="">
                        <h5 class="mt-2"><?php echo $row['name']; ?></h5>
                    </div>


                <?php } ?>

            </div>
            <div class="swiper-pagination"></div>
        </div>

        <!-- Swiper JS -->
    </div>
    <?php require('inc/footer.php') ?>
</body>

</html>