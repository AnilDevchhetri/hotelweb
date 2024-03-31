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
    <title>Admin Panal - New Bookings </title>
    <?php require('inc/links.php') ?>
</head>

<body class="bg-light">

    <?php require('inc/header.php'); ?>
    <div class="container-fluid " id="main-content-dashboard">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4"> New Bookings </h3>


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
                                        <th scope="col">Booking Details</th>

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


    <!-- Asign room Number Modal -->
    <div class="modal fade" id="assign-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="assign_room_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Assign Room</h1>
                    </div>
                    <div class="modal-body">
                        <div class=" mb-3">
                            <label class="form-label fw-bold">Room Number</label>
                            <input type="Text" required name="room_number" id="" class="form-control shadow-none">
                        </div>
                         <span class="badge rounded-pill text-bg-light mb-3 text-wrap lh-base">
                            Note: Assign Room number only when Guest arrived.
                        </span>
                        <input type="hidden" name="booking_id">
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">ASSIGN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>





    <?php require('inc/script.php');  ?>
    <script src="js/new_bookings.js"> </script>
</body>

</html>

<!-- 51:28 -->