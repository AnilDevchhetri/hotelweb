<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'];  ?>: Booking Confirmation</title>

</head>

<body class="bg-light">
    <?php
    require('inc/header.php');
    /*
     check from url id is present or not
     shutdown mode is active or not
     user is login or not
 
    */
    if (!isset($_GET['id']) ||  $settings_r['shutdown'] == true) {
        redirect('rooms.php');
    } else if (!isset($_SESSION['login']) && $_SESSION['login'] == true) {
        redirect('rooms.php');
    }

    //filter and get room data
    $data = filteration($_GET);
    $room_res = select("SELECT *  FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');
    if (mysqli_num_rows($room_res) == 0) {
        redirect('room.php');
    }
    $room_data = mysqli_fetch_assoc($room_res);
    $_SESSION['room'] = [
        "id" => $room_data['id'],
        "name" => $room_data['name'],
        "price" => $room_data['price'],
        "payment" => null,
        "available" => false

    ];
    $user_res = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 'i');
    $user_data = mysqli_fetch_assoc($user_res);

    ?>


    <!-------------------------
----- Reach us section
--------------------------------->


    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">Confirm Booking</h2>
                <div style="font-size:14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">CONFIRM</a>
                </div>
            </div>
            <div class="col-lg-7 col-md-12 px-4 ">
                <?php

                //Get thumnail of image
                $room_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
                $thumb_q = mysqli_query($con, "SELECT * from `room_images` WHERE `room_id`= $room_data[id] AND `thumb`='1'");

                if (mysqli_num_rows($thumb_q) > 0) {
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
                }
                echo <<<data
                      <div class="card p-3 shadow-sm rounded">
                       <img src="$room_thumb" class="img-fluid rounded mb-3" />
                       <h5>$room_data[name]</h5>
                       <h5>₹$room_data[price] per night</h5>
                      </div>
                      data;
                ?>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form id="booking_form">
                            <h6 class="mb-3">Booking Details</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="Text" value="<?php echo $user_data['name']; ?>" name="name" class="form-control shadow-none " required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="number" name="phonenum" value="<?php echo $user_data['phonenum']; ?>" class="form-control shadow-none " required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control shadow-none" rows="2" required><?php echo $user_data['address']; ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-in</label>
                                    <input type="date" onchange="check_availability()" name="checkin" class="form-control shadow-none " required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-out</label>
                                    <input type="date" onchange="check_availability()" name="checkout" class="form-control shadow-none " required>
                                </div>
                                <div class="col-md-12">
                                    <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <h6 class="mb-3 text-danger " id="pay_info">Provide check-in and check-out date</h6>
                                    <button name="pay_now" class="btn w-100 text-white custom-bg shadow-none mb-1" disabled>Pay Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-------------------------
----- Reach us section

--------------------------------->

    <?php require('inc/footer.php') ?>
    <script>
        let booking_form = document.getElementById('booking_form');
        let info_loader = document.getElementById('info_loader');
        let pay_info = document.getElementById('pay_info');

        function check_availability() {
            
            let checkin_val = booking_form.elements['checkin'].value;
            let checkout_val = booking_form.elements['checkout'].value;
            booking_form.elements['pay_now'].setAttribute('disabled', true);

            if (checkin_val != '' && checkout_val != '') {
                pay_info.classList.add('d-none');
                pay_info.classList.replace('text-dark', 'text-danger');
                info_loader.classList.remove('d-none');
                let data = new FormData();
                data.append('check_availability', '');
                data.append('check_in', checkin_val);
                data.append('check_out', checkout_val);


                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/confirm_booking.php", true);

                // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
                xhr.onload = function() {
                     let data = JSON.parse(this.responseText);
                     
                    if (data.status == 'check_in_out_equal') {
                        pay_info.innerText = "You cannot checkout on same date";
                    } else if (data.status == 'check_out_earlier') {
                        pay_info.innerText = "You Checkout date is earlier";
                    } else if (data.status == 'check_in_earlier') {
                        pay_info.innerText = "Check in date earlier than todays date";
                    } else if (data.status == 'unavailable') {
                        pay_info.innerText = "Room is unavailable for the momment";
                    } else {
                        pay_info.innerHTML = "No. of Days: " + data.days + "<br>Total amount: ₹" + data.payment;
                        pay_info.classList.replace('text-danger', 'text-dark');
                        booking_form.elements['pay_now'].removeAttribute('disabled');
                    }
                    info_loader.classList.add('d-none');
                    pay_info.classList.remove('d-none');
                }
                xhr.send(data);
            }
        }

        function book_now() {
          
            let checkin_val = booking_form.elements['checkin'].value;
            let checkout_val = booking_form.elements['checkout'].value;
            let user_name = booking_form.elements['name'].value;
            let address = booking_form.elements['address'].value;
            let phonenum = booking_form.elements['phonenum'].value;
            let data = new FormData();
            data.append('pay_now', '');
            data.append('check_in', checkin_val);
            data.append('check_out', checkout_val);
            data.append('name', user_name);
            data.append('address', address);
            data.append('phonenum', phonenum);
               let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/pay_now.php", true);

                // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
                xhr.onload = function() {
                   console.log(this.responseText);
                   if(this.responseText == 'room_booked'){
                    alert('success','Room Is scucessfully booked');
                    
                   }else{
                    alert('error','Room not booked!Server error');
                   }
                }
                xhr.send(data);
            }
        booking_form.addEventListener('submit',function(e){
                e.preventDefault();
                book_now();
        });
    </script>
</body>

</html>