<?php
require('admin/inc/db_config.php');
require('admin/inc/essentials.php');


if(isset($_GET['email_confirmation'])){
        $data = filteration($_GET);

        $qeury = select("SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? LIMIT 1",[$data['email'],$data['token']],'ss');
        if(mysqli_num_rows($qeury)==1){
              $fetch = mysqli_fetch_assoc($qeury);
              if($fetch['is_verified'] ==1){
                echo "<script>alert('email already varified')</script>";
                redirect('index.php');
              }
              else{
                $update = update("UPDATE `user_cred` SET `is_verified`=?, WHERE `id`=?",[1,$fetch['id']],'ii');
                if($update){
                    echo "<script>alert('email verified success')</script>";
                }else{
                    echo "<script>alert('email verified failed')</script>";   
                }
                redirect('index.php');
              }
        }else{
            echo "<script>alert('Invalid link')</script>";
            redirect('index.php');
        }
}