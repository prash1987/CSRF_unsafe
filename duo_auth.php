<!DOCTYPE html>

<?php
   include("config.php");
  
   $msg = ".";

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $msg = ".";

      $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
       
      $email_id = mysqli_real_escape_string($db,$_POST['email_id']);
      $otp = mysqli_real_escape_string($db,$_POST['otp']); 
      
      $sql = "SELECT email_id, otp FROM login WHERE email_id='$email_id' AND otp='$otp'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      
      $count = mysqli_num_rows($result);
      
      // If result has a match, table row must be 1 row
      if($count == 1) {
        $_SESSION['login_user'] = $email_id;
        $_SESSION['loggedin'] = true;
        header('Location: homepage_GET.php');   
      }else {
         $msg = "Authentication failed";
      }
   }
?>


<html>
  <head>
    <title>Unsafe Bank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="styles.css" rel="stylesheet">

  </head>
  <body class="login-bg">
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-12">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="index.php">Unsafe Bank</a></h1>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

	<div class="page-content container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-wrapper">
			        <div class="box">
			            <div class="content-wrap">
			                <h6>Dual Authentication</h6>
			                <div class="social">
	                            
	                        </div>
                      <form name="Form1" action = "" method = "post">
  			                <input class="form-control" type="text" name = "email_id" value="<?php echo $_SESSION['login_user']; ?>" readonly>
  			                <input class="form-control" type="text" name = "otp" placeholder="One-Time Password" autofocus>

                        <div class="already">
                          <p><?php if (isset($msg)) echo $msg ?></p>
                        </div>

  			                <div class="action">
                                  <input type = "submit" class="btn btn-primary signup"  value = "Login" /><br />
  			                </div> 
                      </form>        
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>