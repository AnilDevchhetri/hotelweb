<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panal - Canceled Bookings </title>
    <?php require('inc/links.php') ?>
</head>

<body class="bg-light">

    <?php require('inc/header.php'); ?>
    <div class="container-fluid " id="main-content-dashboard">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4"> Canceld Bookings </h3>


                <!-- Features card settings  -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">

                            <!-- <button type="button" class="btn btn-dark shadow-none btn-sm " data-bs-toggle="modal" data-bs-target="#add-room">
                                <i class="bi bi-plus-square me-1"></i>Add
                            </button> -->
                            <input type="text" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Tpye to search">
                        </div>

                        <div class="table-responsive" style="height:450px; overflow-y:scroll ">
                            <table class="table table-hover border ">
                                <thead>
                                    <tr class="bg-dark text-light ">
                                        <th scope="col">#</th>
                                        <th scope="col">User Details</th>
                                        <th scope="col">Room Details</th>
                                        <th scope="col">Refund Amount</th>

                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                    <!-- features is added using script  -->

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div><!-- end of main col-lg-10-->
        </div>
    </div>




    <?php require('inc/script.php');  ?>
    <script src="js/canceled_bookings.js"> </script>
</body>

</html>

<!-- 51:28 -->