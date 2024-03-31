
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'];  ?></title>
   
</head>

<body class="bg-light">
<?php require('inc/header.php') ?>

<!-------------------------
----- Reach us section
--------------------------------->
<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center ">Our Facilites</h2>
    <div class="h-line bg-dark"></div>
    <div class="h2-line bg-dark "></div>
    <p class="text-center mt-3">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Omnis, consectetur vero! Architecto <br>reprehenderit suscipit eius sunt fuga laboriosam tempora dolorem!</p>
</div>


<div class="container">
    <div class="row mt-5">

        <?php
        $res = selectAll('facilities');
        $path = FACILITIES_IMG_PATH;
        while ($row = mysqli_fetch_assoc($res)) {
  echo <<<facility
                 <div class='col-lg-4 col-md-6 mb-5 px-4'>
                    <div class="bg-white shadow rounded p-4 border-top border-4 border-dark pop">
                            <div class="d-flex align-items-center mb-2">
                                <img src="$path$row[icon]" width="40px" alt="">
                                <h5 class="m-0 ms-3">$row[name]</h5>
                            </div>
                            <p>$row[description] </p>
                        </div>
                 </div>
          facility;
        }
        ?>
     
    </div>
</div>
<!-------------------------
----- Reach us section
--------------------------------->

<?php require('inc/footer.php') ?>
</body>

</html>