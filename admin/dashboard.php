<?php
require('inc/essentials.php');
require('inc/db_config.php');

adminLogin();
// session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panal - Dashboard</title>
  <?php require('inc/links.php') ?>
</head>

<body class="bg-light">

  <?php 
  require('inc/header.php');
  
   $is_shutdown = mysqli_fetch_assoc(mysqli_query($con,"SELECT `shutdown` from `settings`"));
   $current_bookings = mysqli_fetch_assoc(mysqli_query($con, "SELECT 
   COUNT(CASE WHEN booking_status='booked' AND arrival=0 THEN 1 END) AS `new_bookings`
   FROM `booking_order`"));
   $unread_queries = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count` from `user_queries` WHERE `seen`=0"));

   $unread_reviews = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count` from `rating_review` WHERE `seen`=0"));

   $users = mysqli_fetch_assoc(mysqli_query($con, "SELECT 
   COUNT(id) AS `total`,
   COUNT(CASE WHEN `status`=1 THEN 1 END) AS `active`,
   COUNT(CASE WHEN `status`=0 THEN 1 END) AS `inactive`,
   COUNT(CASE WHEN `is_verified`=0 THEN 1 END) AS `status_unvarified`
   FROM `user_cred`"));

  ?>
  <div class="container-fluid " id="main-content-dashboard">
    <div class="row">
      <div class="col-lg-10 ms-auto p-4 overflow-hidden">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h3>DASHBOARD</h3>
          <?php 
          if($is_shutdown['shutdown']){
            echo <<<data
                   <H6 class="badge bg-danger p2 rounded">Shutdown Mode is Active</H6>
            data;
          }
          ?>
       
        </div>

        <div class="row">
          <div class="col-md-3 mb-4">
            <a href="new_bookings.php" class="text-decoration-none ">
              <div class="card text-center p-3 text-success ">
                <h6>New Bookings </h6>
                <h1 class="mt-2 mb-0"><?php echo $current_bookings['new_bookings']; ?></h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="user_queries.php" class="text-decoration-none ">
              <div class="card text-center p-3 text-info ">
                <h6>User Queies</h6>
                <h1 class="mt-2 mb-0"><?php echo $unread_queries['count']; ?></h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="rate_review.php" class="text-decoration-none ">
              <div class="card text-center p-3 text-success ">
                <h6>Rating & Reviews </h6>
                <h1 class="mt-2 mb-0"><?php echo $unread_reviews['count']; ?></h1>
              </div>
            </a>
          </div>

          <div class="d-flex align-items-center justify-content-between mb-4">
            <h3>Booking Analytics</h3>
            <select class="form-select shadow-none bg-light w-auto" onchange="booking_analytics(this.value)">

              <option value="1">Past 30 Days</option>
              <option value="2">Past 90 Days</option>
              <option value="3">Past 1 year</option>
              <option value="4">All time</option>
            </select>
          </div>


          <div class="row">
            <div class="col-md-3 mb-4">
              <div class="card text-center p-3 text-primary ">
                <h6>Total Bookings </h6>
                <h1 class="mt-2 mb-0" id="total_bookings"></h1>
                <h4 class="mt-2 mb-0" id="total_amt"> </h4>
              </div>
            </div>
            <div class="col-md-3 mb-4">
              <div class="card text-center p-3 text-success ">
                <h6>Active Booking</h6>
                <h1 class="mt-2 mb-0" id="active_bookings">5</h1>
                <h4 class="mt-2 mb-0" id="active_amt" > ₹ 5</h4>
              </div>
            </div>

            <div class="col-md-3 mb-4">
              <div class="card text-center p-3 text-primary ">
                <h6>cancelled Bookings </h6>
                <h1 class="mt-2 mb-0" id="cancelled_bookings">5</h1>
                <h4 class="mt-2 mb-0" id="cancelled_amt" > ₹ 5</h4>
              </div>
            </div>

          </div>

          <div class="d-flex align-items-center justify-content-between mb-4">
            <h3>User, Queries, Review Analytics</h3>
            <select class="form-select shadow-none bg-light w-auto" onchange="users_analytics()">

              <option value="1">Past 30 Days</option>
              <option value="2">Past 90 Days</option>
              <option value="3">Past 1 year</option>
              <option value="4">All time</option>
            </select>
          </div>


          <div class="row">
            <div class="col-md-3 mb-4">
              <div class="card text-center p-3 text-success ">
                <h6>Total New Users </h6>
                <h1 class="mt-2 mb-0" id="total_new_reg">5</h1>
             
              </div>
            </div>
            <div class="col-md-3 mb-4">
              <div class="card text-center p-3 text-primary ">
                <h6>Queries</h6>
                <h1 class="mt-2 mb-0" id="total_queries">5</h1>
                
              </div>
            </div>

            <div class="col-md-3 mb-4">
              <div class="card text-center p-3 text-primary ">
                <h6>Review </h6>
                <h1 class="mt-2 mb-0" id="total_reviews">5</h1>
    
              </div>
            </div>

          </div>

          <h5>Users</h5>
          <div class="row">
            <div class="col-md-3 mb-4">
              <div class="card text-center p-3 text-info ">
                <h6>Total Users </h6>
                <h1 class="mt-2 mb-0"><?php echo $users['total']; ?></h1>
            
              </div>
            </div>
            <div class="col-md-3 mb-4">
              <div class="card text-center p-3 text-success ">
                <h6>Active </h6>
                <h1 class="mt-2 mb-0"><?php echo $users['active']; ?></h1>
      
              </div>
            </div>

            <div class="col-md-3 mb-4">
              <div class="card text-center p-3 text-warning ">
                <h6>In Active  </h6>
                <h1 class="mt-2 mb-0"><?php echo $users['inactive']; ?></h1>
   
              </div>
            </div>

            <div class="col-md-3 mb-4">
              <div class="card text-center p-3 text-danger ">
                <h6>Unvarified </h6>
                <h1 class="mt-2 mb-0"><?php echo $users['status_unvarified']; ?></h1>
             
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>

  <?php require('inc/script.php');  ?>
  <script src="js/dashboard.js"></script>
</body>

</html>