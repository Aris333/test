<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login | SpeedyFax</title>
     <link rel="icon" type="image/x-icon" href="https://speedyfaxapp.com/api//assests/images/logo_transparent.png">

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>/assests/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>/assests/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url(); ?>/assests/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->


    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>/assests/css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assests/css/speedyfax.css" rel="stylesheet">
  </head>

  <body class="login" id="loginBody">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>


      <div class="login_wrapper">
        <div class="logo_wrapper text-center">
          <img src="<?php echo base_url(); ?>assests/images/logo_transparent.png" />
        </div>

        <div class="animate form login_form">

          <section class="login_content">


            
            <form method="post" id="loginForm">
              <h1>Login</h1>
              <div  id="message"></div>
              <div class="form-group">
                <div class="input-group"> 
                  <div class="input-group-addon"><span class="fa fa-user"></div> 
                  <input type="text" placeholder="Email" required="" name="txtEmail" id="txtEmail" class="form-control"> 
                </div>
              </div>
              <div class="form-group">
                <div class="input-group"> 
                  <div class="input-group-addon"><span class="fa fa-lock"></span></div> 
                  <input type="password" placeholder="Password" required="" name="txtPassword" id="txtPassword" class="form-control"> 
                </div>
              </div>



              <div class="form-group">
                <input type="submit" class="btn btn-success btn-block submit pull-left" value="Login" id="login" />
              </div>
              <div id="message"></div>
              <div class="clearfix"></div>

              <div class="separator">                

                <div class="clearfix"></div>
                <br />

                <div class="copyright">
                  <p>©<?php echo date("Y"); ?> All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

      </div>
    </div>

    <!-- Scripts  -->
    <script src="<?php echo base_url(); ?>/assests/vendors/jquery/dist/jquery.min.js"></script>
    
    <script>

        jQuery(document).ready(function ($) {
          $("#loginForm").submit(function (event) {
            event.preventDefault();
            
            $.ajax({
              url: "<?php echo base_url("/user/verifyLogin"); ?>",
              type: "POST",
              data: { txtEmail: $('#txtEmail').val(), txtPassword: $('#txtPassword').val()},
              success: function (data){
               if(data==1) {             
                   //alert("Yes");
                   $("#message").html('<div class="col-lg-12 alert alert-success alert-dismissible fade in" role="alert"><strong>Logging in..</strong></div>');                     
                   window.location.href = "<?php echo site_url('dashboard'); ?>";
               }
               else
               {
                $("#message").html('<div class="col-lg-12 alert alert-danger alert-dismissible fade in" role="alert"><strong>The email or password you entered is incorrect</strong></div>');                     
                }
             }
            });
          });
        });
        
    </script>
    <!-- Ends -->

  </body>
</html>