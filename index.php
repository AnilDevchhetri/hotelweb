<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'];  ?></title>

</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <!-------------------------------------
    -Slider of Navbar
  ------------------------------------->
    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">

                <?php
                $res = selectAll('carousel');
                while ($row = mysqli_fetch_assoc($res)) {
                    $path = CAROUSEL_IMG_PATH;
                    //this is hero doc method to pring data
                    echo <<<data
                <div class="swiper-slide"><img src="$path$row[image]"class="w-100 d-block"/>
                </div>
                data;
                }
                ?>


            </div>

        </div>
    </div>
    <!-------------------------------------
    -Slider of Header
  ------------------------------------->

    <!-------------------------
-----Check Availability form
--------------------------------->
    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4">Check Booking Availability</h5>
                <form action="rooms.php"  class="fade-in-up">
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight:500;">Check In</label>
                            <input type="date" class="form-control shadow-none"name="checkin"required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight:500;">Check Out</label>
                            <input type="date" class="form-control shadow-none" name="checkout"required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight:500;">Adult</label>
                            <select class="form-select shadow-nun" name="adult">
                                <?php 
                                 $guests_q = mysqli_query($con,"SELECT MAX(adult) AS `max_adult`, Max(children) AS `max_children` FROM `rooms`
                                              WHERE `status`='1' AND `removed`='0'");


                                  $guests_res = mysqli_fetch_assoc($guests_q);
                                  for($i = 1;$i<=$guests_res['max_adult'];$i++){
                                    echo "  <option value='$i'>$i</option>";
                                  }
                                ?>
                                
                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label class="form-label" style="font-weight:500;">Children</label>
                            <select class="form-select shadow-nun" name="children">
                                <?php for($i = 1;$i<=$guests_res['max_children'];$i++){
                                    echo "  <option value='$i'>$i</option>";
                                  } ?>
                        
                            </select>
                        </div>
                        <input type="hidden" name="check_availability">
                        <div class="col-lg-1 mb-lg-3 mt-2">
                            <button type="Submit" class="btn text-white shadow-none custom-bg">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-------------------------
-----Check Availability form
----------->

    <!-------------------------
-----Room section
--------------------------------->
    <section class="section-wrapper">
        <h2 class="mt-5 pt-4 text-center fw-bold h-font text-uppercase our-rooms">Our Rooms</h2>
        <div class="container rooms">
            <div class="row">


                <?php

                $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3 ", [1, 0], 'ii');

                while ($room_data  = mysqli_fetch_assoc($room_res)) {
                    //Features of rooms
                    $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f INNER JOIN `room_features` rfea on f.id = rfea.features_id WHERE rfea.room_id = $room_data[id]");
                    $features_data = "";
                    while ($fea_row = mysqli_fetch_assoc($fea_q)) {
                        $features_data .= " <span class='badge rounded-pill text-bg-light  text-wrap'>
              $fea_row[name]
          </span>";
                    }

                    //Facilities of rooms
                    $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = $room_data[id]");

                    $facilities_data = "";
                    while ($row = mysqli_fetch_assoc($fac_q)) {
                        $facilities_data .= "<span class='badge rounded-pill text-bg-light  text-wrap'>
     $row[name]
</span>";
                    }

                    //Get thumnail of image
                    $room_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
                    $thumb_q = mysqli_query($con, "SELECT * from `room_images` WHERE `room_id`= $room_data[id] AND `thumb`='1'");

                    if (mysqli_num_rows($thumb_q)) {
                        $thumb_res = mysqli_fetch_assoc($thumb_q);
                        $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
                    }

                    $book_btn = "";
                    if (!$settings_r['shutdown']) {
                        $login = 0;
                        if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                            $login = 1;
                        }
                        $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm text-white custom-bg'>Book Now</button>";
                    }

                    $rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review`
                    WHERE `room_id`='$room_data[id]' ORDER BY `sr_no` DESC LIMIT 20";
                    
                    $rating_res = mysqli_query($con,$rating_q);
                    $rating_fetch = mysqli_fetch_assoc($rating_res); 
                    $rating_data = "";
                    if($rating_fetch['avg_rating']!=null){
                        $rating_data = "<div class='ratting mb-4'>
                                           <span class='badge rounded-pill bg-light'>
                                        ";
                        for($i=1;$i<$rating_fetch['avg_rating'];$i++){
                            $rating_data .= "<i class='bi bi-star-fill text-warning'></i>";
                        }
                        $rating_data .= "</span>
                                            </div>";
                    }
                  
                ?>


                    <div class="col-lg-4 col-md-6  my-3">
                        <div class="card border-0 shadow">
                            <img src="<?php echo $room_thumb; ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $room_data['name']; ?></h5>
                                <h6 class="mb-4"> <?Php echo $room_data['price'] ?> per night</h6>
                                <div class="features mb-4">
                                    <h6 class="mb-1">Features</h6>
                                    <?php echo $features_data; ?>
                                </div>
                                <div class="fecilites mb-4">
                                    <h6 class="mb-1">Facilities</h6>
                                    <?php echo $facilities_data; ?>
                                </div>
                                <div class="guest mb-4">
                                    <h6 class="mb-1">Guest</h6>
                                    <span class="badge rounded-pill text-bg-light  text-wrap">
                                        <?Php echo $room_data['adult'] ?> adults
                                    </span>
                                    <span class="badge rounded-pill text-bg-light  text-wrap">
                                        <?Php echo $room_data['children'] ?> children
                                    </span>

                                </div>
                                <div class="ratting mb-4">
                                    <span class="badge rounded-pill bg-light">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-evenly mb-2">
                                    <?php echo $book_btn; ?>
                                    <a href="room_details.php?id=<?php echo $room_data['id'] ?>" class="btn btn-sm btn-outline-dark">More details</a>
                                </div>

                            </div>
                        </div>
                    </div><!--end of card -->



                <?php
                }
                ?>


                <div class="col-lg-12 text-center mt-5">
                    <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms >>></a>
                </div>
            </div>
        </div>
    </section>
    <!-------------------------
-----Room section
--------------------------------->



    <!-------------------------
----- Facilities section
--------------------------------->
    <section class="section-wrapper">
        <h2 class="mt-5 pt-4 text-center fw-bold h-font text-uppercase our-rooms">Our Facilites</h2>

        <div class="container">
            <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
                <?php
                $res = mysqli_query($con, "SELECT * FROM `facilities`ORDER BY `id` DESC  LIMIT 5 ");
                $path = FACILITIES_IMG_PATH;
                while ($row = mysqli_fetch_assoc($res)) {
                    echo <<<facility
                <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                   <img src="$path$row[icon]" width="80px" alt="">
                   <h5 class="mt-3">$row[name]</h5>
                </div>
                 
          facility;
                }
                ?>

                <div class="col-lg-12 text-center mt-4">
                    <a href="facilities.php" class="btn btn-sm btn-outline-dark">More Facilites</a>

                </div>
            </div>
        </div>
    </section>
    <!-------------------------
----- Facilities section
--------------------------------->


    <!-------------------------
----- Testimonials section
--------------------------------->
    <section class="section-wrapper">
        <h2 class="mt-5 mb-5 pt-4 text-center fw-bold h-font text-uppercase our-rooms">Testimonials</h2>
        <div class="container mt-5">
            <div class="swiper swiper-testimonials">

                <div class="swiper-wrapper mb-5">
                    <?php
                    $review_q = "SELECT rr.*,uc.name AS uname,uc.profile AS img, r.name AS rname FROM `rating_review` rr
                                   INNER JOIN `user_cred` uc ON rr.user_id=uc.id
                                   INNER JOIN `rooms` r ON rr.room_id=r.id
                                   ORDER BY `sr_no` DESC LIMIT 6";
                    $review_res = mysqli_query($con, $review_q);
                    $img_path = USERS_IMG_PATH;

                    if (mysqli_num_rows($review_res) == 0) {
                        echo 'No Reviews Yet';
                    } else {
                        while ($row = mysqli_fetch_assoc($review_res)) {
                            $stars = " <i class='bi bi-star-fill text-warning'></i>";
                            for ($i = 1; $i < $row['rating']; $i++) {
                                $stars .= " <i class='bi bi-star-fill text-warning'></i>";
                            }
                            echo <<<slide
                                <div class="swiper-slide bg-white shadow p-4">
                                    <div class="profile d-flex align-itmes-center mb-3">
                                        <img src="$img_path$row[img]" loading='lazy' class="rounded-circle" width="50px"alt="">
                                        <h6 class="m-0 ms-2">$row[uname]</h6>
                                    </div>
                                    <p>$row[review]</p>
                                    <div class="ratting">
                                        $stars
                                    </div>
                                </div><!-- swiper slide end -->

                            slide;
                        }
                    }

                    ?>


                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="col-lg-12 text-center mt-4">
                <a href="#" class="btn btn-sm btn-outline-dark">Know More>>></a>

            </div>
        </div>
    </section>
    <!-------------------------
----- Testimonials section
--------------------------------->

    <!-------------------------
----- Reach us section
--------------------------------->

    <section class="section-wrapper">
        <h2 class="mt-5 pt-4 text-center fw-bold h-font text-uppercase our-rooms">Reach us</h2>
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded ">
                    <iframe class="w-100 rounded" height="320" src="<?php echo $contact_r['iframe']; ?>" style="border:0;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="bg-white p-4 rounded mb-4">
                        <h5>Call us</h5>

                        <a href="tel: +3455666" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1']; ?></a><br>

                        <?Php
                        if ($contact_r['pn2'] != '') {
                            echo <<<data
                 <a href="tel: +$contact_r[pn2]" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i> +$contact_r[pn2]</a><br>
       data;
                        }
                        ?>
                    </div>
                    <div class="bg-white p-4 rounded mb-4">
                        <h5>Follow us</h5>
                        <?php if ($contact_r['tw'] != '') {
                            echo <<<data
                        <a href="#" class="d-inline-block mb-3 ">
                        <span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-twitter me-1"></i> $contact_r[tw]</span></a><br>
                        data;
                        } ?>
                        <a href="#" class="d-inline-block mb-3 ">
                            <span class="badge bg-light text-dark fs-6 p-2">
                                <i class="bi bi-facebook me-1"></i> <?php echo $contact_r['fb']; ?>
                            </span>
                        </a><br>
                        <a href="#" class="d-inline-block">
                            <span class="badge bg-light text-dark fs-6 p-2">
                                <i class="bi bi-instagram me-1"></i> <?php echo $contact_r['insta']; ?>
                            </span>
                        </a><br>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-------------------------
----- Reach us section
--------------------------------->

    <?php require('inc/footer.php'); ?>
</body>

</html>