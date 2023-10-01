<?php

include('./includes/header.php');

?>

    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Login</h2>
                     
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Login Section Begin -->
    <section class="login spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>Login</h3>
                        <form action="./scripts/login.php" method ="POST">
                            <div class="input__item">
                                <input type="text" id="email" name="email" placeholder="Email address">
                                <span class="icon_mail"></span>
                            </div>
                            <div class="input__item">
                                <input type="text" name="password"  id="password"placeholder="Password">
                                <span class="icon_lock"></span>
                            </div>
                            <button type="submit" class="site-btn">Login Now</button>
                        </form>
                        <a href="#" class="forget_pass">Forgot Your Password?</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__register">
                        <h3>Dont’t Have An Account?</h3>
                        <a href="#" class="primary-btn">Register Now</a>
                    </div>
                </div>
            </div>
            <div class="login__social">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6">
                        <div class="login__social__links">
                            <span>or</span>
                            <ul>
                                <li><a href="#" class="facebook"><i class="fa fa-facebook"></i> Sign in With
                                Facebook</a></li>
                                <li><a href="#" class="google"><i class="fa fa-google"></i> Sign in With Google</a></li>
                                <li><a href="#" class="twitter"><i class="fa fa-twitter"></i> Sign in With Twitter</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Section End -->

    <!-- Footer Section Begin -->
    <?php  

include('./includes/footer.php');



?>

<script>
    $(document).ready(()=>{
        toastr.info("Welcome, please enter your email address and password")

        $('form').submit((e)=>{
            e.preventDefault();

            const email = $("#email").val().trim();
            const password = $("#password").val().trim();

            if(email ==""){
                toastr.error("email is required")
                return
            }

            if(password ==""){
                toastr.error("password is required")
                return
            }

            const formdata ={
                 email: email,
                 password: password
            }

            $.ajax({
                type: "POST",
                url: "./scripts/login.php",
                dataType: "json",
                data: formdata,
                success:(response)=>{
                    if(response.success){
                        toastr.success(`success : ${response.message}`);
                        if(response.data == "user"){
                            window.location.href="user/index.php";

                        }else if(response.data == "admin"){
                            window.location.href="user/admin.php";

                        }
                    //    
                    }else{

                        toastr.error(`Error : ${response.message}`);
                        

                    }

                },
                error:(err)=>{
                    console.log(err);
                }
            })
        })
    })
</script>