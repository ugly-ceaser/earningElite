<?php

include('./includes/header.php');

if(isset($_GET['ref'])){
    $ref = $_GET['ref'];
}

?>

    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Sign Up</h2>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Signup Section Begin -->
    <section class="signup spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>Sign Up</h3>
                        <form action="#" id="signup">
                            <div class="input__item">
                                <input type="email" name="email" id="email" placeholder="Email address" required>
                                <span class="icon_mail"></span>
                            </div>
                            <div class="input__item">
                                <input type="text" name = "fullname" id="fullname" placeholder="Your Name" required>
                                <span class="icon_profile"></span>
                            </div>

                            <div class="input__item">
                                <input type="text" name = "phone" id="phone" placeholder="Your Phone Number" required>
                                <span class="icon_phone"></span>
                            </div>
                            <div class="input__item">
                                <input type="password" name = "password" id="password" placeholder="Password" required>
                                <span class="icon_lock"></span>
                            </div>

                            <div class="input__item">
                                <input type="password" name = "retype_password" id="retype_password" placeholder="Retype Password" required>
                                <span class="icon_lock"></span>
                            </div>

                            <div class="input__item">
                                <input type="text" name = "coupon" id="coupon" placeholder="Coupon" required>
                                <span class="icon_lock"></span>
                            </div>

                            <?php

                            if(isset($_GET['ref'])){ ?>
                                <div class="input__item">
                                <input type="text" name = "referal" id= "referal" value ="<?= $ref ?>" placeholder="Referal Code" disabled>
                                <span class="icon_lock"></span>
                            </div>

                           <?php }  else { ?>

                            <div class="input__item">
                                <input type="text" name = "referal" id= "referal" placeholder="Referal Code">
                                <span class="icon_lock"></span>
                            </div>

                           <?php } ?>
                            <button type="submit" class="site-btn">Sign Up Now</button>
                        </form>
                        <h5>Already have an account? <a href="#">Log In!</a></h5>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__social__links">
                        <h3>Login With:</h3>
                        <ul>
                            <li><a href="#" class="facebook"><i class="fa fa-facebook"></i> Sign in With Facebook</a>
                            </li>
                            <li><a href="#" class="google"><i class="fa fa-google"></i> Sign in With Google</a></li>
                            <li><a href="#" class="twitter"><i class="fa fa-twitter"></i> Sign in With Twitter</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Signup Section End -->

    <?php  
   include('./includes/footer.php');
?>

<script>
    $(document).ready(()=>{
        $('#signup').submit((e)=>{
            e.preventDefault();

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
                }

            const fullname = $('#fullname').val().trim();
            const email =   $('#email').val().trim();
            const password = $('#password').val().trim();  
            const retype_password = $ ('#retype_password').val().trim();
            const referal = $('#referal').val().trim();
            const coupon = $('#coupon').val().trim();
            const phone = $('#phone').val().trim();

           if(referal.trim() == ""){
            toastr.info("Referal code is Empty !");
            
           }

           if(phone.trim() == ""){
            toastr.error("please enter a valid  phone number !");
            return
           }

           if(password.trim() != retype_password.trim()){
            toastr.error("Password do not match")
           }

           if(fullname.trim() == ""){
            toastr.error("Please enter a full name")
            return
           }

           if(email.trim() == ""){
            toastr.error("Please enter a email address")
            return
           }

           if(coupon.trim() == ""){
            toastr.error("please enter a coupon")
           }

           $.ajax({
            type : "POST",
            url : "./scripts/coupon.php",
            dataType: "json",
            data: { 'coupon' : coupon},
            success: function (response) {

             if(response.success == true) {
                 toastr.success(response.message);
                 
                
                 
             }else{

             toastr.error(response.message);
             return ;
             }
             
            
         },
         error: function (xhr, status, error) {
             
            //  console.log("error: " + error);
             console.log("error: " + xhr.responseText);
             return 
         }
         
           })

                const formdata = {
                    full_name: fullname,
                    email: email,
                    password: password,
                    coupon: coupon,
                    phone_number: phone,
                    referal_code: referal || "none" // Use the provided referal or set it to "none"
                };

                $.ajax({
                type: "POST",
                url: "./scripts/register.php",
                data: formdata,
                success: function (response) {
             
                        

             if(response.success == true) {
                 toastr.success(response.message);
                 
              
                 window.location.href = 'login.php'; 
                 
             }else{

                console.log(response);

             toastr.error(`error :${response.message}`);
             }
             
            
         },
         error: function (xhr, status, error) {
             
            console.log("error: " + xhr.responseText);
         }
            });

            
        })
    });
</script>