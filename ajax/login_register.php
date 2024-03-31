<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');
require("../inc/sendgrid/sendgrid-php.php");

function sendmail($mail, $token,$type)
{

    if($type == "email_confirmation"){
        $page = 'email_confirm.php';
        $subject = 'Acount verfication link';
        $content = "Conrom your email";
    }
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom(SENDGRID_EMAIL, SENDGRID_NAME);
    $email->setSubject($subject);
    $email->addTo($mail, "User");


    $email->addContent(
        "text/html",
        "Click the link to confirm: <br>
         <a href='" . SITE_URL . "$page?$type&email=$mail&token=$token" . "'>CLICK ME</a>
        "
    );
    $sendgrid = new \SendGrid(SENDGRID_API_KEY);
    try {
        $sendgrid->send($email);
        return 1;
    } catch (Exception $e) {
        return 0;
    }
}

if (isset($_POST['register'])) {
    $data = filteration($_POST);

    //Match password and confirm password
    if ($data['pass'] != $data['cpass']) {
        echo 'pass_missmatch';
        exit;
    }

    //Check user exitst or not
    $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phonenum`=? ", [$data['email'], $data['phonenum']], 'ss');

    if (mysqli_num_rows($u_exist)) {
        $u_exist_fetch = mysqli_fetch_assoc($u_exist);
        echo ($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
        exit;
    }

    //Upload user image to server
    $img = uploadUserImage($_FILES['profile']);

    if ($img == 'inv_img') {
        echo 'inv_img';
        exit;
    } else if ($img == 'upd_failed') {
        echo 'upd_failed';
        exit;
    }


    //Send Confirmation link to user's email ways(php mirror, using server smtp, sendgradu smtp use this)
    $token = bin2hex(random_bytes(16));
    if (!sendmail($data['email'], $token,"email_confirmation")) {
        echo 'mail_failed';
        exit;
    }

    $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);
    $query = "INSERT INTO `user_cred`(`name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`,`token`) VALUES (?,?,?,?,?,?,?,?,?)";

    $values = [$data['name'], $data['email'], $data['address'], $data['phonenum'], $data['pincode'], $data['dob'],  $img, $enc_pass, $token];

    if (insert($query, $values, 'sssssssss')) {
        echo 1;
    } else {
        echo 'ins_failed';
    }
}


if (isset($_POST['login'])) {
    $data = filteration($_POST);
    //Check user exitst or not
    $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phonenum`=? LIMIT 1", [$data['email_mob'], $data['email_mob']], 'ss');

    if (mysqli_num_rows($u_exist) == 0) {
        echo 'inv_email_mob';
    } else {
        $u_fetch = mysqli_fetch_assoc($u_exist);
        if($u_fetch['is_verified']==0){
            echo 'not_verified';
        }else if($u_fetch['status']==0){
           echo 'in_active';
        }else{
           if(!password_verify($data['pass'],$u_fetch['password'])){
              echo 'invalid_pass';
           }
           else{
            session_start();
             $_SESSION['login'] = true;
             $_SESSION['uId'] = $u_fetch['id'];
             $_SESSION['uName'] = $u_fetch['name'];
             $_SESSION['uPic'] = $u_fetch['profile'];
             $_SESSION['uPhone'] = $u_fetch['phonenum'];
             $_SESSION[''] = $u_fetch['phonenum'];
             echo 1;
           }
         }
    }
}


if(isset($_POST['forgot_pass'])){
    $data = filteration($_POST);
    $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? LIMIT 1", [$data['email']], 's');

    if(mysqli_num_rows($u_exist)==0){
        echo 'inv_email';
    }else{
        $u_fetch = mysqli_fetch_assoc($u_exist);
        if($u_fetch['is_verified']==0){
            echo 'not_verified';
        }else if($u_fetch['status']==0){
           echo 'in_active';
        }else{
            //send reset link to email
            $token = bin2hex(random_bytes(16));
            sendmail($data['email'],$token,"forgot_password");
        }
    }
}