<?php 
  
  require('inc/db_config.php');
  require('inc/essentials.php');
  session_start();

    if((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
       redirect('dashboard.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
     <?php require('inc/links.php') ?>
 
</head>
<body class="bg-light">


    <div class="login-from text-center rounded bg-white shadow overflow-hidden">
        <form action="" method="POST">
            <h4 class="bg-dark text-white py-3"> ADMIN LOGIN PANEL</h4>
            <div class="p-4">
                <div class="mb-3">

                    <input type="text" require name="admin_name" class="form-control shadow-none text-center" placeholder="Admin name">
                </div>
                <div class="mb-4">

                    <input type="password" require name="admin_pass" class="form-control shadow-none  text-center" placeholder="Password">
                </div>
                <button type="Submit" name="login" class="btn text-white custom-bg shadow-none">LOGIN</button>
            </div>
        </form>
    </div>

    <?php
    if (isset($_POST['login'])) {
        $frm_data = filteration($_POST);
        $query = " SELECT * FROM `admin_cred` WHERE `admin_name`=? AND `admin_pass`=?";
        $values = [$frm_data['admin_name'], $frm_data['admin_pass']];


        $res = select($query, $values, "ss");
        if ($res->num_rows  == 1) {
            $row =  mysqli_fetch_assoc($res);
          
            $_SESSION['adminLogin'] = true;
            
            $_SESSION['adminId'] = $row['sr_no'];
            redirect('dashboard.php');
        } else {
            alert('Error','Login failed -  Invalid Cradientials');
        }
    }

    ?>

    <?php require('inc/script.php');  ?>
</body>

</html>