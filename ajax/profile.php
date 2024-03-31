<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');

if (isset($_POST['info_form'])) {
    $frm_data = filteration($_POST);

    session_start();

    //Check user exitst or not
    $u_exist = select("SELECT * FROM `user_cred` WHERE `phonenum`=? AND `id`!=? LIMIT 1", [$frm_data['phonenum'], $_SESSION['uId']], 'si');

    if (mysqli_num_rows($u_exist)) {
        echo 'phone_already';
        exit;
    }
    $query = "UPDATE `user_cred` SET `name`=?, `address`=? , `phonenum`=?, `pincode`=?, `dob`=? WHERE `id`=? ";
    $values = [$frm_data['name'], $frm_data['address'], $frm_data['phonenum'], $frm_data['pincode'], $frm_data['dob'], $_SESSION['uId']];

    if (update($query, $values, 'sssssi')) {
        $_SESSION['uName'] = $frm_data['name'];
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['profile_form'])) {
    $frm_data = filteration($_POST);

    session_start();
    //Upload user image to server
    $img = uploadUserImage($_FILES['profile']);
    if ($img == 'inv_img') {
        echo 'inv_img';
        exit;
    } else if ($img == 'upd_failed') {
        echo 'upd_failed';
        exit;
    }

    //Check user exitst or not
    $u_exist = select("SELECT `profile` FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 'i');
    $u_fetch = mysqli_fetch_assoc($u_exist);
    deleteImage($u_fetch['profile'],USERS_FOLDER);

    $query = "UPDATE `user_cred` SET `profile`=? WHERE `id`=? ";
    $values = [ $img, $_SESSION['uId']];

    if (update($query, $values, 'si')) {
        $_SESSION['uPic'] = $img;
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['pass_form'])) {
    $frm_data = filteration($_POST);

    session_start();
     if($frm_data['new_pass']!=$frm_data['new_pass']){
        echo 'mismatch';
        exit;
     }
    $enc_pass = password_hash($frm_data['new_pass'], PASSWORD_BCRYPT);

    

    $query = "UPDATE `user_cred` SET `password`=? WHERE `id`=? LIMIT 1";
    $values = [ $enc_pass, $_SESSION['uId']];

    if (update($query, $values, 'si')) {
      
        echo 1;
    } else {
        echo 0;
    }
}
