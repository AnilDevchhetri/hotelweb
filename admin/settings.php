<?php
require('inc/essentials.php');

adminLogin();
// session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panal - Settings</title>
    <?php require('inc/links.php') ?>
</head>

<body class="bg-light">

    <?php require('inc/header.php') ?>
    <div class="container-fluid " id="main-content-dashboard">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Settings</h3>

                <!-- Genreral settings  -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">General Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm " data-bs-toggle="modal" data-bs-target="#general-s">
                                <i class="bi bi-pencil-square"></i>Edit
                            </button>
                        </div>

                        <h6 class="card-subtitle mb-1 fw-bold">Site title</h6>
                        <p class="card-text" id="site_title">content.</p>
                        <h6 class="card-subtitle mb-1 fw-bold">About us</h6>
                        <p class="card-text" id="site_about">content.</p>
                    </div>
                </div>

                <!-- General Settings Modal -->
                <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="general_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">General Settings</h1>
                                </div>
                                <div class="modal-body">
                                    <div class=" mb-3">
                                        <label class="form-label fw-bold">Site Title</label>
                                        <input type="Text" required name="site_title" id="site_title_inp" class="form-control shadow-none">
                                    </div>
                                    <div class=" mb-3">
                                        <label class="form-label fw-bold">About</label>
                                        <textarea class="form-control shadow-none" required name="site_about" id="site_about_inp" rows="6"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" onclick="site_title.value = general_data.site_title, site_about.value = general_data.site_about">Cancel</button>
                                    <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Shut down-->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Shutdown services</h5>
                            <div class="form-check form-switch">
                                <form action="">
                                    <input class="form-check-input" onchange="upd_shutdown(this.value)" type="checkbox" role="switch" id="shutdown-toggle">

                                </form>
                            </div>
                        </div>
                        <p class="card-text">No customer will be able to book room when serivces is shut down.</p>

                    </div>
                </div>


                <!-- Cotacta settings  -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Contact Page Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm " data-bs-toggle="modal" data-bs-target="#contact-us-s">
                                <i class="bi bi-pencil-square"></i>Edit
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Address</h6>
                                    <p class="card-text" id="address"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Google Map</h6>
                                    <p class="card-text" id="gmap"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Phone Number </h6>
                                    <p class="card-text">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="pn1"></span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="pn2"></span>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Email</h6>
                                    <p class="card-text" id="email"></p>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-2 fw-bold">Social links</h6>
                                    <p class="card-text">
                                        <i class="bi bi-facebook mb-1"></i>
                                        <span id="fb"></span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-instagram mb-1"></i>
                                        <span id="insta"></span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-twitter mb-1"></i>
                                        <span id="tw"></span>
                                    </p>

                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">IFrame</h6>
                                    <iframe src="" loadding="lazy" class="border p-2 w-100" id="iframe" frameborder="0"></iframe>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cotact Settings Modal -->
                <div class="modal fade" id="contact-us-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form id="contacts_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Contact Settings</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid p-0 row">
                                        <div class="col-md-6">
                                            <div class=" mb-3">
                                                <label class="form-label fw-bold">Address</label>
                                                <input type="Text" required name="address" id="address_inp" class="form-control shadow-none">
                                            </div>
                                            <div class=" mb-3">
                                                <label class="form-label fw-bold">Goggle map link</label>
                                                <input type="Text" required name="gmap" id="gmap_inp" class="form-control shadow-none">
                                            </div>
                                            <div class=" mb-3">
                                                <label class="form-label fw-bold">Phone numbers(with contry code)</label>
                                                <div class="row">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">1</span>
                                                        <input type="text" class="form-control shadow-none" placeholder="Phone number 1" name="pn1" id="pn1_inp">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">1</span>
                                                        <input type="text" class="form-control shadow-none" placeholder="Phone number 2" name="pn2" id="pn2_inp">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" mb-3">
                                                <label class="form-label fw-bold">Email</label>
                                                <input type="Text" required name="email" id="email_inp" class="form-control shadow-none">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class=" mb-3">
                                                <label class="form-label fw-bold">Socal Links</label>
                                                <div class="row">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"> <i class="bi bi-facebook mb-1"></i></span>
                                                        <input type="text" class="form-control shadow-none" placeholder="" name="fb" id="fb_inp">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"> <i class="bi bi-instagram mb-1"></i></span>
                                                        <input type="text" class="form-control shadow-none" placeholder="" name="insta" id="insta_inp">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"> <i class="bi bi-twitter mb-1"></i></span>
                                                        <input type="text" class="form-control shadow-none" name="tw" id="tw_inp">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label class="form-label fw-bold">Iframe src</label>
                                                <input type="Text" required name="iframe" id="iframe_inp" class="form-control shadow-none">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" onclick="contacts_inp(contacts_data)">Cancel</button>
                                    <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Genreral settings  -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Team Memebers</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm " data-bs-toggle="modal" data-bs-target="#team-s">
                                <i class="bi bi-plus-square me-1"></i>Add
                            </button>
                        </div>
                        <div class="row" id="team-data">
                            <!-- <div class="col-md-2 mb-3">
                                <div class="card text-bg-dark">
                                    <img src="../images/about/IMG_83673.jpg" class="card-img" alt="...">
                                    <div class="card-img-overlay text-end">
                                        <button type="button" class=" btn btn-danger btn-sm shadow-none"><i class="bi bi-trash"></i></button>                                        
                                    </div>
                                    <p class="card-text text-center px-3 py-3">Random name</p>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <!-- Team Settings Modal -->
                <div class="modal fade" id="team-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="team_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Add Team Member </h1>
                                </div>
                                <div class="modal-body">
                                    <div class=" mb-3">
                                        <label class="form-label fw-bold">Name</label>
                                        <input type="Text" required name="member_name" id="member_name_inp" class="form-control shadow-none">
                                    </div>
                                    <div class=" mb-3">
                                        <label class="form-label fw-bold">Picture</label>
                                        <input type="file" required name="member_picture" accept=".jpg, .png, .webp, .jpeg, .svg" id="member_picture_inp" class="form-control shadow-none">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" onclick="member_name.value='',member_picture.value=''">Cancel</button>
                                    <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div><!-- end of main col-lg-10-->
        </div>
    </div>

    <?php require('inc/script.php');  ?>
    <script src="js/setting.js"></script>
</body>

</html>