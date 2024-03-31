<!-------------------------
----- Footer section
--------------------------------->

<footer>
    <div class="container-fluid bg-white p-5 mt-5">
        <div class="row">
            <div class="col-lg-4 p-4">
                <h3 class="h-font fw-bold fs-3 mb-2">AC Hotels</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Molestias suscipit ea iusto. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur, voluptate!</p>

            </div>
            <div class="col-lg-4 p-4">
                <h5 class="mb-3 ">Links</h5>
                <div class="footer-links d-flex flex-column">
                    <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a>
                    <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">Facilites</a>
                    <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a>
                    <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">Contact us</a>
                    <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">About</a>
                </div>

            </div>
            <div class="col-lg-4 p-4">
                <h5 class="mb-3">Follow Us</h5>
                <div class="footer-social-links  d-flex flex-column">
                    <a href="<?php echo $contact_r['tw']; ?>" class="d-inline-block text-dark text-decoration-none mb-2 ">
                        <i class="bi bi-twitter me-1"></i>Twitter
                    </a>
                    <a href="<?php echo $contact_r['fb']; ?>" class="d-inline-block text-dark text-decoration-none mb-2 ">
                        <i class="bi bi-facebook me-1"></i>Facebook
                    </a>
                    <a href="<?php echo $contact_r['insta']; ?>" class="d-inline-block text-dark text-decoration-none mb-2 ">
                        <i class="bi bi-instagram me-1"></i>Instagram
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-------------------------
----- Footer section
--------------------------------->
<h6 class="text-center bg-dark text-white p-3 m-0">Design and developed By Chhetri anil</h6>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="js/main.js"></script>
<!-- Initialize Swiper -->
<script>
    function alert(type, msg, position = 'body') {
        let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
        let element = document.createElement('div');
        element.innerHTML = `
            <div class="alert ${bs_class} alert-dismissible fade show" role="alert">
                <strong class="">${msg}</strong> 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        if (position = 'body') {
            document.body.append(element);
            element.classList.add('custom-alert');
        } else {
            document.getElementById(position).appendChild(element);
        }

        setTimeout(remAlert, 3000);
    }

    function remAlert() {
        document.getElementsByClassName('alert')[0].remove();
    }
    var swiper = new Swiper(".swiper-container", {
        spaceBetween: 30,
        effect: "fade",
        grabCursor: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false

        },

    });

    // testimonial swiper 
    var swiper = new Swiper(".swiper-testimonials", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "3",
        loop: true,
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: false,
        },
        pagination: {
            el: ".swiper-pagination",
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            640: {
                slidesPerView: 1,
            },
            720: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3
            }


        }
    });


    // about us team 
    var swiper = new Swiper(".team-swiper", {
        slidesPerView: 4,
        spaceBetween: 40,
        pagination: {
            el: ".swiper-pagination",
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            640: {
                slidesPerView: 2,
            },
            720: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4
            }


        }
    });

    let register_form = document.getElementById('register-form');

    register_form.addEventListener('submit', (e) => { //arrow function
        e.preventDefault();
        let data = new FormData();
        data.append('name', register_form['name'].value);
        data.append('email', register_form['email'].value);
        data.append('phonenum', register_form['phonenum'].value);
        data.append('address', register_form['address'].value);
        data.append('pincode', register_form['pincode'].value);
        data.append('dob', register_form['dob'].value);
        data.append('pass', register_form['pass'].value);
        data.append('cpass', register_form['cpass'].value);
        data.append('profile', register_form['profile'].files[0]);
        data.append('register', '');

        var myModal = document.getElementById('registerModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();


        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
        xhr.onload = function() {
            console.log(this.responseText);
            if (this.response == 'pass_missmatch') {
                alert('error', "password missmatch")
            } else if (this.response == 'email_already') {
                alert('error', "email is already registered");
            } else if (this.response == 'phone_already') {
                alert('error', "Phon number is already registered");
            } else if (this.response == 'inv_img') {
                alert('error', 'Only JPG, WEBP & PNG images are allowed');
            } else if (this.response == 'upd_failed') {
                alert('error', 'Email upload faile');
            } else if (this.response == 'mail_failed') {
                alert('error', 'Cannot send conformation ! Server down');
            } else if (this.response == 'ins_failed') {
                alert('error', 'Registeration failed ! Server down');
            } else {
                alert('success', "Registeration Scuccess. Confirmation link sent to email");
                register_form.reset();
            }

        }
        xhr.send(data);


    });

    let login_form = document.getElementById('login-form');

    login_form.addEventListener('submit', (e) => { //arrow function
        e.preventDefault();
        let data = new FormData();
        data.append('email_mob', login_form['email_mob'].value);
        data.append('pass', login_form['pass'].value);
        data.append('login', '');

        var myModal = document.getElementById('LoginModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();


        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
        xhr.onload = function() {

             console.log(this.responseText);
            if (this.response == 'inv_email_mob') {
                alert('error', "Email or Mobile number missmatch")
            } else if (this.response == 'not_verified') {
                alert('error', "email is not varified");
            } else if (this.response == 'in_active') {
                alert('error', "Acount is inactive contact the admin");
            } else if (this.response == 'invalid_pass') {
                alert('error', 'The Password is invalid');

            } else {
                let fileurl = window.location.href.split('/').pop().split('?').shift();
               if(fileurl == 'room_details.php'){
                window.location = window.location.href;
               }else{
                window.location = window.location.pathname;
               }
              
            }

        }
        xhr.send(data);


    });


    let forgot_form = document.getElementById('forgot-form');

    forgot_form.addEventListener('submit', (e) => { //arrow function
        e.preventDefault();
        let data = new FormData();
        data.append('email', forgot_form['email'].value);
        data.append('forgot_pass', '');

        var myModal = document.getElementById('forgotModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();


        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
        xhr.onload = function() {

            //  console.log(this.responseText);
            // if (this.response == 'inv_email_mob') {
            //     alert('error', "Email or Mobile number missmatch")
            // } else if (this.response == 'not_verified') {
            //     alert('error', "email is not varified");
            // } else if (this.response == 'in_active') {
            //     alert('error', "Acount is inactive contact the admin");
            // } else if (this.response == 'invalid_pass') {
            //     alert('error', 'The Password is invalid');

            // } else {
            //    window.location = window.location.pathname;
            // }

        }
        xhr.send(data);


    });

//check login status for booking
function checkLoginToBook(status,room_id){
   if(status){
    window.location.href='confrim_booking.php?id='+room_id;
   }else{
    alert('error','Please login to book room!');
   }
}
</script>



<!-- 20 -->