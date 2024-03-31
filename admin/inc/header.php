<div class="container-fluid bg-dark text-light p-4 d-flex align-items-center justify-content-between sticky-top">
    <div class=" d-flex align-items-center justify-content-between">
        <h3 class="me-3">ADMIN PANEL</h3>
        <h4 class="text-decoration-none text-white"><a href="../index.php" target="_blank">View</a></h4>

    </div>
    <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
</div>
<div class="col-lg-2 bg-dark border-top border-3 border-secondary " id="dashboard-menu">
    <nav id="dashboard-nav-bar" class="navbar navbar-expand-lg navbar-dark   shadow-none">
        <div class="container-fluid flex-lg-column align-items-stretch">

            <h4 class="navbar-brand mt-2">Admin Panel</h4>


            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse  flex-column mt-2 align-item-sctrech" id="adminDropdown">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn text-white px-3 w-100 shadow-none  text-start d-flex align-item-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#booking_links">
                            <span>Bookings</span>
                            <span><i class="bi bi-caret-down-fill"></i></span>
                        </button>
                        <div class="collapse show px-3 small mb-1" id="booking_links">
                            <ul class="nav nav-pills flex-column rounded border border-secondary">
                                <li class="nav-item">
                                    <a class="nav-link text-white" aria-current="page" href="new_bookings.php">New Bookins</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="booking_records.php">Booking Records</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="canceled_bookings.php">Canceled Bookings</a>
                                </li>
                               
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="user_queries.php">User Message</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="rate_review.php">Rating & Review</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="rooms.php">Rooms</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="features_facilites.php">Features & Facilites</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="carousel.php">Carousel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="settings.php">Settings</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</div>