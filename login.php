<?php
session_start();
require_once "conn.php";
$display_message = "";
if (isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM user_tb WHERE uusername ='$username' AND upassword = md5('$password') AND u_status = 'Activated'");
    $row = mysqli_fetch_array($query);
    $num_row = mysqli_num_rows($query);

    if ($num_row > 0) {
        $email = $row['uemail'];
        $fname = $row['fname'];
        //$_SESSION['user_id']=$row['user_id'];
        $_SESSION['fullname'] = $row['fname'];
        @$_SESSION['email'] = $row['uemail'];
        @$_SESSION['username'] = $row['uusername'];
        $_SESSION['bitwallet'] = $row['ubit_wallet'];
        $_SESSION['question'] = $row['uquestion'];
        $_SESSION['qanswer'] = $row['uquestion_answer'];
        @$_SESSION['mynetwork'] = $row['u_refer_code'];
        @$_SESSION['reg_code'] = $row['u_invit_code'];
        @$_SESSION['acct_amt'] = $row['u_amount'];
        @$_SESSION['country'] = $row['ucountry'];
        @$_SESSION['reg_date'] = $row['u_datereg'];
        @$_SESSION['update_record'] = $row['u_update_record'];
        @$_SESSION['last_see'] = $row['u_last_login'];
        @$_SESSION['acct_status'] = $row['u_status'];
        $_SESSION['userid'] = $row['user_id'];

        $display_message = "<font style='text-align:center' color='#009966' style='font-family:Arial, sans-serif' size='+1'><h3 class='mt-0'>Access granted!</h3></font>
					<p align ='center'><span class='text-black pt-5'>Please wait, system will redirect you in a moment</span></p>

					<p align ='center'><font style='text-align:center'><i class='fas fa-spinner fa-spin'></i></font></p>
					<meta http-equiv='refresh' Content='4; url=dashboard' />";

        //Insert into log activities
        $query = mysqli_query($conn, "INSERT INTO user_log(username, login_date, online_status, logout_date, user_id)
					VALUES ('$username', NOW(),'1','', '" . $row['user_id'] . "') ");

        $query_up2 = mysqli_query($conn, "INSERT INTO activities_log(act_username, act_action, act_date, act_system_id)
					VALUES ('$username', 'Login Successful', NOW(), '" . $row['user_id'] . "') ");

        // Send mail to user with verification here
        $to = $email;
        $subject = "Login Security Alert";

        // Create the body message
        @$message .= "<br>
         <div style='font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee'>
	<table align='center' width='100%' border='0' cellspacing='0' cellpadding='0' bgcolor='#eeeeee'>
    <tbody>
        <tr>
        	<td bgcolor='#FFFFFF'>
                <table align='center' width='750px' border='0' cellspacing='0' cellpadding='0' bgcolor='#eeeeee' style='width:750px!important'>
                <tbody>
                	<tr>
                    	<td>
                			<table width='690' align='center' border='0' cellspacing='0' cellpadding='0' bgcolor='#eeeeee'>
                            <tbody>
                            	<tr>
                                    <td height='80' align='center' border='0' cellspacing='0' cellpadding='0' bgcolor='#FFFFFF' style='padding:0;margin:0;font-size:0;line-height:0'><img src='https://providusoption.com/en/img/logo-white2.png'>

                                    </td>
                   			  </tr>
                                <tr>
                                    <td align='center'>
                                        <table width='630' align='center' border='0' cellspacing='0' cellpadding='0'>
                                        <tbody>
                                        	<tr>
                                            	<td colspan='3' height='60'></td></tr><tr><td width='25'></td>
                                                <td align='center'>
                                                  <h6 style='font-family:HelveticaNeue-Light,arial,sans-serif;font-size:25px;color:#404040;line-height:48px;font-weight:bold;margin:0;padding:0'>Account Login</h6>
                                                </td>
                                                <td width='25'></td>
                                            </tr>
                                            <tr>
                                            	<td colspan='3' height='40'></td></tr><tr>
                                            	  <td colspan='5' align='center'>
                                                    <p style='color:#404040;font-size:16px;line-height:24px;font-weight:lighter;padding:0;margin:0'>
													Hello $fname, We notice a successful login into your cryptoean account! If you don not reconized this transaction, kindly contact our support now.</p>
                                                    <br>
                                                    <p style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0'></p>
                                                </td>
                                            </tr>
                                            <tr>
                                            <td colspan='4'>
                                                <div style='width:100%;text-align:center;margin:30px 0'>
                                                    <table align='center' cellpadding='0' cellspacing='0' style='font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0'>
                                                    <tbody>
                                                    	<tr>
                                                            <td align='center' style='margin:0;text-align:center'><a href='https://providusoption.com/en' style='font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px' target='_blank'>Click here to contact support</a></td>
                                                      	</tr>
                                                   	</tbody>
                                                    </table>
                                               	</div>
                                           	</td>
                                       	</tr>

                                 	</tbody>
                                    </table>
                             	</td>
                   			</tr>

                            <tr bgcolor='#ffffff'>
                                <td bgcolor='#FFFFFF'>

                                  <table width='570' align='center' border='0' cellspacing='0' cellpadding='0'>
                                    <tbody>
                                      <tr>
                                        <td>
                                          <h2 style='color:#404040;font-size:22px;font-weight:bold;line-height:26px;padding:0;margin:0'>&nbsp;</h2>
                                          <div style='color:#404040;font-size:16px;line-height:22px;font-weight:lighter;padding:0;margin:0'>You can always contact us for any support or write us an email on support@providusoption.com </div>
                                        </td>
                                      </tr>
                                      <tr><td>&nbsp;</td>
                                </tr></tbody></table></td>
                              </tr>
                          	</tbody>
                            </table>
                  			<table align='center' width='750px' border='0' cellspacing='0' cellpadding='0' bgcolor='#eeeeee' style='width:750px!important'>
                            <tbody>
                            	<tr>
                                	<td align='center'>
                                        <table width='630' align='center' border='0' cellspacing='0' cellpadding='0' bgcolor='#eeeeee'>
                                        <tbody>
                                        	<tr><td colspan='2' height='30'></td></tr>
                                            <tr>
                                           	  <td width='360' valign='top'>&nbsp;</td>
                                              	<td align='right' valign='top'>
                                                	<span style='line-height:20px;font-size:10px'><a href='#'><img src='http://i.imgbox.com/BggPYqAh.png' alt='fb'></a>&nbsp;</span>
                                                    <span style='line-height:20px;font-size:10px'><a href='#'><img src='http://i.imgbox.com/j3NsGLak.png' alt='twit'></a>&nbsp;</span>
                                                    <span style='line-height:20px;font-size:10px'><a href='#'><img src='http://i.imgbox.com/wFyxXQyf.png' alt='g'></a>&nbsp;</span>
                                              	</td>
                                            </tr>
                                            <tr><td colspan='2' height='5'></td></tr>
                                      	</tbody>
                                        </table>
                                    <p><span style='color:#a3a3a3;font-size:12px;line-height:12px;padding:0;margin:0'>&copy; 2020 Providus Option. All Rights Reserved. </span></p></td>
                  				</tr>
                          	</tbody>
                          </table>
               		  </td>
                	</tr>
              	</tbody>
                </table>
            </td>
	  </tr>
 	</tbody>
    </table>
</div>";
        $header = "From:Account-Security <info@providusoption.com> \r\n";
        $header .= "Cc:noreply@providusoption.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";

        @$retval = mail($to, $subject, $message, $header);

    } else {
        $display_message = "<span style='margin-top:50px;text-align:center; color:FF0000;font-family:Arial,sans-serif;' >
        <h4 class='mt-0'>Access denied!</h4>
        </span>
		<p class='text-center'><span class='text-black pt-10' style='color:#ff5722;'>Invalide Login Details</span></p>";
    }

}
//Add Applicant details to eRegister record

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>
    F1 Trading Agency
  </title>
  <link rel="shortcut icon" href="./assets2/image/png/favicon.png" type="image/x-icon">
  <!-- Bootstrap , fonts & icons  -->
  <link rel="stylesheet" href="./assets2/css/bootstrap.css">
  <link rel="stylesheet" href="./assets2/fonts/icon-font/css/style.css">
  <link rel="stylesheet" href="./assets2/fonts/typography-font/typo.css">
  <link rel="stylesheet" href="./assets2/fonts/fontawesome-5/css/all.css">
  <!-- Plugin'stylesheets  -->
  <link rel="stylesheet" href="./assets2/plugins/aos/aos.min.css">
  <link rel="stylesheet" href="./assets2/plugins/fancybox/jquery.fancybox.min.css">
  <link rel="stylesheet" href="./assets2/plugins/nice-select/nice-select.min.css">
  <link rel="stylesheet" href="./assets2/plugins/slick/slick.min.css">
  <!-- Vendor stylesheets  -->
  <link rel="stylesheet" href="./assets2/plugins/theme-mode-switcher/switcher-panel.css">
  <link rel="stylesheet" href="./assets2/css/main.css">
  <!-- Custom stylesheet -->
</head>

<body data-theme-mode-panel-active data-theme="light">
  <div class="site-wrapper overflow-hidden ">
    <div id="loading">
      <img src="./assets2/image/preloader.gif" alt="">
    </div>
    <!-- Clean The Code And Hop in -->
    <div class="form-block form-block--sign-in bg-default-3 vh-100 position-relative">
      <div class="container position-static vh-100">
        <div class="row align-items-center justify-content-center position-static vh-100">
          <div class="col-xl-6 col-lg-5 position-static vh-100 d-none d-lg-block">
            <div class="form-img position-absolute bg-image" style="background-image: url(./assets2/image/jpg/sign-in.jpg)">
            </div>
          </div>
          <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-8 col-xs-10">
            <div class="section-title section-title--l5 pb-7">
              <h2 class="section-title__heading" data-aos="fade-up" data-aos-duration="500" data-aos-once="true">Sign In to your Account</h2>
              <p class="section-title__description mb-2" data-aos="fade-up" data-aos-duration="500" data-aos-delay="300" data-aos-once="true">Enter your account details </p><a href="index.php">Back Home</a>
              <?php echo $display_message;?>
            </div>
            <div class="form-box form-box--sign-in" data-aos="fade-up" data-aos-duration="500" data-aos-delay="500" data-aos-once="true">
              <form class="contact-form form-horizontal" data-aos="fade-up" data-aos-duration="500" data-aos-delay="300" data-aos-once="true" method="post" action="login.php">
                <div class="form-floating">
                  <input class="form-control" type="text" name="username" id="username" placeholder="Enter Username" id="floatinginput" />
                  <label for="floatinginput">Email</label>
                </div>
                <div class="form-floating">
                  <input class="form-control" name="password" id="password" type="password" placeholder="Leave a comment here" id="floatinginput2" />
                  <label for="floatinginput2">Password</label>
                </div>
                <div class="form-check d-flex align-items-center mt-6 mb-3">
                  <input class="form-check-input bg-white float-none mt-0 mb-0" type="checkbox" value="" id="flexCheckDefault">
                  <label class="form-check-label" for="flexCheckDefault">Remember me</label>
                </div>
                <button class="btn btn-primary shadow--primary-4 btn--lg-2 rounded-55 text-white mt-2"  name="login_btn" id="login_btn">Sign In</button>
              </form>
              
              <p class="mt-4">Don’t have an account?<a class="btn-link text-electric-violet-2 ms-2" href="register.php">Create a free account</a> <a class="btn-link ms-2" style='color:#ff5722;' href="reset.php">Forgot password</a>
              </p>
             
            </div>
          </div>
        </div> 
      </div>
    </div>
  </div>
  <!-- Plugin's Scripts -->
  <script src="./assets2/plugins/jquery/jquery.min.js"></script>
  <script src="./assets2/plugins/jquery/jquery-migrate.min.js"></script>
  <script src="./js/bootstrap.bundle.js"></script>
  <script src="./assets2/plugins/fancybox/jquery.fancybox.min.js"></script>
  <script src="./assets2/plugins/nice-select/jquery.nice-select.min.js"></script>
  <script src="./assets2/plugins/aos/aos.min.js"></script>
  <script src="./assets2/plugins/counter-up/jquery.counterup.min.js"></script>
  <script src="./assets2/plugins/counter-up/waypoints.min.js"></script>
  <script src="./assets2/plugins/slick/slick.min.js"></script>
  <script src="./assets2/plugins/skill-bar/skill.bars.jquery.js"></script>
  <script src="./assets2/plugins/isotope/isotope.pkgd.min.js"></script>
  <!--<script src="./plugins/theme-mode-switcher/gr-theme-mode-switcher.js"></script>-->
  <!-- Activation Script -->
  <script src="assets2/js/menu.js"></script>
  <script src="assets2/js/custom.js"></script>
</body>

</html>