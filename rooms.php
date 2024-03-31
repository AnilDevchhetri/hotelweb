<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'];  ?></title>
</head>

<body class="bg-light">
    <?php 
    require('inc/header.php');
     $checkin_default = '';
     $checkout_default = '';
     $adult_default = '';
     $children_default = '';
     if(isset($_GET['check_availability'])){
        $frm_data = filteration($_GET);
        $checkin_default = $frm_data['checkin'];
        $checkout_default = $frm_data['checkout'];
        $adult_default = $frm_data['adult'];
        $children_default = $frm_data['children'];
       
     }
    
    ?>

    <!-------------------------
----- Reach us section
--------------------------------->
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center ">Rooms</h2>
        <div class="h-line bg-dark"></div>
        <div class="h2-line bg-dark "></div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-lg-0  ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="navbar-brand mt-2">Filter</h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse  flex-column mt-2 align-item-sctrech" id="filterDropdown">
                            <div class="border w-100 bg-light p-3 rounded mb-3">
                                <h5 class="mb-3 d-block align-items-center justify-content-between fillter-header">
                                    <span>Check Availability</span>
                                    <button id="chk_avail_btn" class="btn btn-sm text-secondary d-none shadow-none" onclick="chk_avail_clear()">Reset</button>
                                </h5>
                                <label class="form-label">Check In</label>
                                <input type="date" value="<?php echo $checkin_default; ?>" id="checkin" class="form-control shadow-none mb-3" onchange="chk_avail_filter()">
                                <label class="form-label">Check out</label>
                                <input type="date" id="checkout"  value="<?php echo $checkout_default; ?>" class="form-control shadow-none" onchange="chk_avail_filter()">
                            </div>
                            <div class="border bg-light p-3 w-100 rounded mb-3">
                                <h5 class="mb-3 d-flex align-items-center justify-content-between fillter-header">
                                    <span>Facilities</span>
                                    <button id="facilities_btn" class="btn btn-sm text-secondary d-none shadow-none" onclick="facilities_clear()">Reset</button>
                                </h5>
                                <?php
                                $facilities_q = selectAll('facilities');
                                while ($row = mysqli_fetch_assoc($facilities_q)) {
                                    echo <<<data
                                      <div class="mb-2">
                                        <input type="checkbox" onclick='fetch_rooms()' id="$row[id]" name='facilities' value='$row[id]' class="form-check-input shadow-none me-1">
                                        <label class="form-label" for="$row[id]">$row[name]</label>
                                      </div>
                                    data;
                                }
                                ?>
                                <!-- <div class="mb-2">
                                    <input type="checkbox" id="f1" class="form-check-input shadow-none me-1">
                                    <label class="form-label" for="f1">Facility one</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" id="f2" class="form-check-input shadow-none me-1">
                                    <label class="form-label" for="f2">Facility one</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" id="f3" class="form-check-input shadow-none me-1">
                                    <label class="form-label" for="f3">Facility one</label>
                                </div> -->

                            </div>
                            <div class="border bg-light p-3 w-100 rounded mb-3">

                                <h5 class="mb-3 d-flex align-items-center justify-content-between fillter-header">
                                    <span>GUESTS</span>
                                    <button id="guests_btn" class="btn btn-sm text-secondary d-none shadow-none" onclick="guests_clear()">Reset</button>
                                </h5>
                                <div class="d-flex">
                                    <div class="me-3">
                                        <label class="form-label">Adults</label>
                                        <input type="Number" min="1" id="adults"  value="<?php echo $adult_default; ?>" onchange="guests_filter()" oninput="guests_filter()" class="form-control shadow-none">
                                    </div>
                                    <div>
                                        <label class="form-label">Children</label>
                                        <input type="Number" min="1" id="children" value="<?php echo $children_default; ?>" onchange="guests_filter()" oninput="guests_filter()" class="form-control shadow-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9 col-md-12 px-4" id="rooms-data">

            </div>
        </div>
    </div>
    <!-----------------------------------------------------
------------------------------ Reach us section----------------------------------
-------------------------------------------------->
    <script>
        let rooms_data = document.getElementById('rooms-data');
        let checkin = document.getElementById('checkin');
        let checkout = document.getElementById('checkout');
        let chk_avail_btn = document.getElementById('chk_avail_btn');

        let adults = document.getElementById('adults');
        let children = document.getElementById('children');
        let guests_btn = document.getElementById('guests_btn');
        let facilities_btn = document.getElementById('facilities_btn');



        function fetch_rooms() {

            let chk_avail = JSON.stringify({
                checkin: checkin.value,
                checkout: checkout.value
            });

            let guests = JSON.stringify({
                adults: adults.value,
                children: children.value
            });

            let facility_list = {"facilities":[]};
            let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
            if (get_facilities.length > 0) {
                get_facilities.forEach((facility) => {
                    facility_list.facilities.push(facility.value);
                })
                facilities_btn.classList.remove('d-none');

            }else{
                facilities_btn.classList.add('d-none');
            }
            facility_list = JSON.stringify(facility_list); 
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "ajax/rooms.php?fetch_rooms&chk_avail=" + chk_avail + "&guests= " + guests+"&facility_list="+facility_list, true);

            xhr.onprogress = function() {
                rooms_data.innerHTML = ` <div class='spinner-border text-info mx-auto d-block mb-3' id='rooms_loader' role='status'>
                    <span class='visually-hidden'>Loading...</span>
                </div>`;
            }

            xhr.onload = function() {
                rooms_data.innerHTML = this.responseText;
            }
            xhr.send();
        }

        function chk_avail_filter() {
            if (checkin.value != '' && checkout.value != '') {
                fetch_rooms();
                chk_avail_btn.classList.remove('d-none');

            }
        }

        function chk_avail_clear() {
            checkin.value = '';
            checkout.value = '';
            chk_avail_btn.classList.add('d-none');
            fetch_rooms();

        }

        function guests_filter() {
            if (adults.value > 0 || children.value > 0) {
                fetch_rooms();
                guests_btn.classList.remove('d-none');
            }
        }

        function guests_clear() {
            adults.value = '';
            children.value = '';
            fetch_rooms();
            guests_btn.classList.add('d-none');
        }
        function facilities_clear() {
            let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
            if (get_facilities.length > 0) {
                get_facilities.forEach((facility) => {
                    facility.checked = false;
                })
                facilities_btn.classList.add('d-none');
                  fetch_rooms();
            }
        }
  window.onload = function(){
    fetch_rooms();
    guests_filter();
    chk_avail_filter();
  }
    </script>
    <?php require('inc/footer.php') ?>

</body>

</html>