<?php

//FRONTEND PURPOSE DATA
define('SITE_URL_WITHOUT_IP','http://localhost/hotelbookingphp/');
define('SITE_URL', 'http://127.0.0.1/hotelbookingphp/');
define('ABOUT_IMG_PATH', SITE_URL . 'images/about/');
define('CAROUSEL_IMG_PATH', SITE_URL . 'images/carousel/');
define('FACILITIES_IMG_PATH', SITE_URL . 'images/facilities/');
define('ROOMS_IMG_PATH', SITE_URL . 'images/rooms/');
define('USERS_IMG_PATH', SITE_URL . 'images/users/');

// USE FOR UPLOAD PROCESS backend
define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/hotelbookingphp/images/');
define('ABOUT_FOLDER', 'about/');
define('CAROUSEL_FOLDER', 'carousel/');
define('FACILITIES_FOLDER', 'facilities/');
define('ROOMS_FOLDER', 'rooms/');
define('USERS_FOLDER', 'users/');

//Send grid api key        
define('SENDGRID_API_KEY','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');
define('SENDGRID_EMAIL','sunilchhetriapp@gmail.com.com');
define('SENDGRID_NAME','Hotel Booking');

//industry id for payment
define('INDUSTRY_TYPE_ID','Retail');
define('CHANNEL_ID','Web');
define('PAYTM_MERCHANT_WEBSITE','paytm.com');
define('CALLBACK_URL,','http://localhost/hotelbookingphp/pay_response.php');



function adminLogin()
{
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        echo "<script>
        window.location.href='index.php';
        </script>;
       ";
        exit;
    }
    // session_regenerate_id(true);
}

function redirect($url)
{
    echo "<script>
     window.location.href='$url';
     </script>;
    ";
    exit;
}

function alert($type, $msg)
{
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger";

    echo <<<alert
                <div class="alert $bs_class custom-alert  alert-dismissible fade show" role="alert">
                <strong class="">$msg</strong> 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        alert;
}

function uploadImage($image, $folder)
{
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp', 'image/svg'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img'; //Invalid Image
    } else if ($image['size'] / (1024 * 1024) > 3) {
        return 'inv_size'; //Invalid size greater than 2 mb;
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";
        $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}

function uploadSVGImage($image, $folder)
{
    $valid_mime = ['image/svg+xml'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img'; //Invalid Image
    } else if ($image['size'] / (1024 * 1024) > 1) {
        return 'inv_size'; //Invalid size greater than 2 mb;
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";
        $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}


function deleteImage($image, $folder)
{
    if (unlink(UPLOAD_IMAGE_PATH . $folder . $image)) {
        return true;
    } else {
        return false;
    }
}

function uploadUserImage($image)
{
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img'; //Invalid Image
    
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . ".jpeg";
        $img_path = UPLOAD_IMAGE_PATH.USERS_FOLDER . $rname;

       if($ext ==  'png' || $ext == 'PNG'){
        $img = imagecreatefrompng($image['tmp_name']); 
       }elseif($ext ==  'webp' || $ext == 'WEBP'){
        $img = imagecreatefromwebp($image['tmp_name']);
       }else{
        $img = imagecreatefromjpeg($image['tmp_name']);
       }  
     


        if (imagejpeg($img,$img_path,75)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}
