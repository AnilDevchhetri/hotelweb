<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'];  ?>: Bookings</title>

</head>

<body class="bg-light">
    <?php
    require('inc/header.php');
    if (!isset($_SESSION['login']) && $_SESSION['login'] == false) {
        redirect('rooms.php');
        exit;
    }

    $u_exits = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 'i');
    if (mysqli_num_rows($u_exits) == 0) {
        redirect('index.php');
    }
    $u_fetch = mysqli_fetch_assoc($u_exits);


    ?>


    <!-------------------------
----- Reach us section
--------------------------------->


    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold"> PROFILE</h2>
                <div style="font-size:14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">PROFILE</a>
                </div>
            </div>

            <div class="col-12  mb-4 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form action="" id="info-form">
                        <h5 class="mb-3 fw-4">User Infromation</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="<?php echo $u_fetch['name']; ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phone number</label>
                                <input type="number" value="<?php echo $u_fetch['phonenum']; ?>" name="phonenum" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Date of birth</label>
                                <input type="date" name="dob" value="<?php echo $u_fetch['dob']; ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pinecode</label>
                                <input type="number" name="pincode" value="<?php echo $u_fetch['pincode']; ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control shadow-none" rows="1" required><?php echo $u_fetch['address']; ?></textarea>
                            </div>
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <button class="btn custom-bg text-white shadow-none">Save Changes</button>
                    </form>
                </div>
            </div>

            <div class="col-4 mb-4 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form action="" id="profile-form">
                        <h5 class="mb-3 fw-4">User Picture</h5>

                        <img src="<?php echo USERS_IMG_PATH . $u_fetch['profile']; ?>" class=" img-fluid" alt="">
                        <label class="form-label">New Picture</label>
                        <input type="file" name="profile" accept=".jpg,.jpeg,.png,.webp" class="form-control shadow-none mb-4" required>

                        <button class="btn custom-bg text-white shadow-none">Save Changes</button>
                    </form>
                </div>
            </div>

            <div class="col-8 mb-4 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form action="" id="pass-form">
                        <h5 class="form-label">Change Password</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_pass" value="" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_pass" value="" class="form-control shadow-none" required>
                            </div>
                        </div>
                        <button class="btn custom-bg text-white shadow-none">Save Changes</button>
                    </form>
                </div>
            </div>





        </div>
    </div>
    <!-------------------------
----- Reach us section

--------------------------------->

    <?php require('inc/footer.php') ?>

    <script>
        let info_form = document.getElementById('info-form');

        info_form.addEventListener('submit', function(e) {
            e.preventDefault();
            let data = new FormData();
            data.append('info_form', '');
            data.append('name', info_form.elements['name'].value);
            data.append('phonenum', info_form.elements['phonenum'].value);
            data.append('dob', info_form.elements['dob'].value);
            data.append('pincode', info_form.elements['pincode'].value);
            data.append('address', info_form.elements['address'].value);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/profile.php", true);
            xhr.onload = function() {
                console.log(this.responseText);
                if (this.responseText == 'phone_already') {
                    alert('error', "Phon number is already registered");
                } else if (this.response == '0') {
                    alert('error', 'No Changes Made');
                } else {
                    alert('success', 'Changes Saved');
                }
            }
            xhr.send(data);

        });
        let profile_form = document.getElementById('profile-form');
     
        profile_form.addEventListener('submit', function(e) {
            e.preventDefault();
            let data = new FormData();
            data.append('profile_form', '');
            data.append('profile', profile_form['profile'].files[0]);


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/profile.php", true);
            xhr.onload = function() {
                console.log(this.responseText);
                if (this.responseText == 'inv_img') {
                    alert('error', 'Only JPG, WEBP & PNG images are allowed');
                } else if (this.responseText == 'upd_failed') {
                    alert('error', 'Email upload faile');
                } else if (this.responseText == 0) {
                    alert('error', 'No Changes Made');
                } else {
                    window.location.href = window.location.pathname;
                }
            }
            xhr.send(data);

        });

        let pass_form = document.getElementById('pass-form');
        pass_form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let new_pass = pass_form.elements['new_pass'].value;
            let confirm_pass = pass_form.elements['confirm_pass'].value;
            if(new_pass !=confirm_pass){
               alert('error','New password and confirm password not match');
               return false;
            }
            

            let data = new FormData();
            data.append('pass_form', '');
            data.append('new_pass', pass_form['new_pass'].value);
            data.append('confirm_pass', pass_form['confirm_pass'].value);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/profile.php", true);
            xhr.onload = function() {
                console.log(this.responseText);
                if (this.responseText == 'mismatch') {
                    alert('error', 'Password do not match');
                }else if (this.responseText == 0) {
                    alert('error', 'No Changes Made');
                } else {
                   alert('success','Change Saved');
                   pass_form.reset();
                }
            }
            xhr.send(data);

        });

    </script>
</body>

</html>
8:05