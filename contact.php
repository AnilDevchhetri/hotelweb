
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
    <h2 class="fw-bold h-font text-center ">Contact us</h2>
    <div class="h-line bg-dark"></div>
    <div class="h2-line bg-dark "></div>
    <p class="text-center mt-3">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Omnis, consectetur vero! Architecto <br>reprehenderit suscipit eius sunt fuga laboriosam tempora dolorem!</p>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 col-md-6 mb-5 px-4">
            <div class="bg-white shadow rounded p-4">
                <iframe class="w-100 rounded mb-5" height="320" src="<?php echo $contact_r['iframe']; ?>" style="border:0;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <h5>Address</h5>
                <a href="https://maps.app.goo.gl/2pWxbkNwz9aqvnLC7" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2">
                    <i class="bi bi-geo-alt-fill"></i><?php echo $contact_r['address']; ?></a>
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mt-4">Call us</h5>
                        <a href="tel: +<?php echo $contact_r['pn1']; ?>" class="d-inline-block mb-2 text-decoration-none text-dark me-1"><i class="bi bi-telephone-fill"></i> <?php echo $contact_r['pn1']; ?></a>
                        <?php
                        if($contact_r['pn2']!=''){
                            echo<<<data
                            <a href="tel: +$contact_r[pn2]; " class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i> +$contact_r[pn2]; </a>
                            data; 
                        }
                                            ?>

                    </div>
                    <div>
                        <h5 class="mt-4">Email</h5>
                        <a href="mailto:<?php echo $contact_r['email']; ?>" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-envelope-fill"></i> <?php echo $contact_r['email']; ?></a>
                    </div>

                </div>
                <h5 class="mb-2 mt-4">Follow Us</h5>

                <a href="<?php echo $contact_r['tw']; ?>" class="d-inline-block text-dark text-decoration-none  me-2 fs-5 ">
                    <i class="bi bi-twitter me-1"></i>
                </a>
                <a href="<?php echo $contact_r['fb']; ?>" class="d-inline-block text-dark text-decoration-none  me-2 fs-5 ">
                    <i class="bi bi-facebook me-1"></i>
                </a>
                <a href="<?php echo $contact_r['insta']; ?>" class="d-inline-block text-dark text-decoration-none  fs-5 ">
                    <i class="bi bi-instagram me-1"></i>
                </a>



            </div>
        </div>
        <div class="col-lg-6 col-md-6 px-4 contact-form">
            <div class="bg-white shadow rounded p-4 border-top">
                <form action="" method="POST">
                    <h5>Send a message</h5>
                    <div class="mt-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" required class="form-control">
                    </div>
                    <div class="mt-3">
                        <label class="form-label" >Email</label>
                        <input type="Email" name="email" required class="form-control">
                    </div>
                    <div class="mt-3">
                        <label class="form-label" >Subject</label>
                        <input type="text" name="subject" required class="form-control">
                    </div>
                    <div class="mt-3">
                        <label class="form-label" >Message</label>
                         <textarea class="form-control shadow-none" name="message" required rows="5"></textarea>
                    </div>
                    <button class="btn text-white custom-bg mt-3 shadow-none" name="send" type="submit">Submit</button>
                </form>


            </div>
        </div>

    </div>
</div>
<!-------------------------
----- Reach us section
--------------------------------->
<?php 
if(isset($_POST['send'])){
    $frm_data = filteration($_POST);
    $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
    $values = [$frm_data['name'],$frm_data['email'],$frm_data['subject'],$frm_data['message']];

    $res = insert($q,$values,'ssss');
    if($res == 1){
        //this is calling php alert function which we built in essentials.php file
        alert('success','Mail sent');
    }else{
        alert('error','server down try again');
    }

}

?>
<?php require('inc/footer.php') ?>
</body>

</html>