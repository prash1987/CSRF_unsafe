<?php
   include("config.php");
	
	if($_SERVER["REQUEST_METHOD"] == "POST" and (isset($_POST['userEmail']))){       
       
    $userid = $_POST["userEmail"];
    $firstname=$_POST["firstName"];
    $lastname=$_POST["lastName"];
    $password=$_POST["password"];
    $confirmpasswd=$_POST["confirm_password"];
    $email=$_POST["userEmail"];
    $contact=$_POST["userContact"];
    $address=$_POST["userAddress"];
    
    $otp = "";      
    
     		if ($password === $confirmpasswd){
			// Create connection
			$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 

			$sql = "INSERT INTO user (user_id, first_name,last_name ,address,email,contact) 
			VALUES ('$userid', '$firstname',  '$lastname', '$address','$email','$contact')";

			$salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
			$password_hash = hash('sha512', $password . $salt);

			$sql2 = "INSERT INTO login (user_id, email_id, Password, salt, otp) 
			VALUES ('$userid', '$email','$password_hash', '$salt', '$otp')";

			$sql3 = "INSERT INTO account (user_id, balance) 
			VALUES ('$userid', 0)";

			if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE) {
				header('Location: registration_successful.html');    
			} else {
				echo "User ID already exists";
			}
		}
		else {
			echo "<h3>Confirm password should match the password</h3>";
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
    <link href="css/styles.css" rel="stylesheet">

    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
   <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
   <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    
  <script>
  
  	function matchPasswords() {
		var pass = document.getElementById("password");
		var c_pass = document.getElementById("confirm_password");
		var cp_error = document.getElementById("cpass_error");
		if (c_pass.value == ""){
			cp_error.innerHTML = "Confirm Password field cannot be blank";
			c_pass.focus();
			return false;
		}
		else{
			if (pass.value == c_pass.value){
				cp_error.innerHTML = "";
				return true;
			}
			else{				
				cp_error.innerHTML = "*Passwords & Confirm password must be the same. Please re-enter both of them!";
				//alert("*Passwords & Confirm password must be the same. Please re-enter!");
				c_pass.value="";
				pass.value="";
				pass.focus();
				return false;
			}
		}
	}

	function regexCheck(){
		var pass = document.getElementById("password");
		var p_error = document.getElementById("pass_error")
		var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;
		if (pass.value == ""){
			p_error.innerHTML = "*Password field cannot be blank";
			pass.focus();
			return false;
		}
		else{
			if(!re.test(pass.value)){
				p_error.innerHTML = "*Password field must contain at least one digit, a lowercase & an uppercase letter and should be at least 6 characters long. Please re-enter it again.";
				pass.value="";
				pass.focus();
				return false;
			}
			else{
				p_error.innerHTML = "";
				return true;
			}
		}
	}
	
  </script>

  </head>
   <body class="login-bg" onload = 'set_max_date_attribute()'>
	  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-5">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="login.php">Unsafe Bank</a></h1>
	              </div>
	           </div>
	           <div class="col-md-5">
	              <div class="row">
	              </div>
	           </div>
	           <div class="col-md-2">
	              <div class="navbar navbar-inverse" role="banner">
	                  <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                       
	                  </nav>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

      <div class="page-content container">
    	<div class="row">
		  <div class="col-md-2">
		  </div>
       		<div class="row">
           	<div class="col-md-8">
               <div class="content-box-large">
                   <div class="panel-heading">
					            <div class="panel-title"><h3>Registration Form</h3></div>
					        </div>
                     <div class="panel-body">
                         <form action=" " method="post" class="form-horizontal"  enctype="multipart/form-data">
                                  
                                   <div class="form-group">
								    <label  class="col-sm-2 control-label">First Name</label>
								    <div class="col-sm-10">
								      <input type="text" class="form-control" name="firstName" placeholder="First Name" required>
								    </div>
								  </div>
                                     <div class="form-group">
								    <label  class="col-sm-2 control-label">Last Name</label>
								    <div class="col-sm-10">
								      <input type="text" class="form-control" name="lastName" placeholder="Last Name" required>
								    </div>
								  </div>
								<div class="form-group">
									<label  class="col-sm-2 control-label">Password</label>
								    <div class="col-sm-10">
										<input type="password" class="form-control" name="password" id="password" placeholder="Password" onblur= 'return regexCheck();' required>
										<p id="pass_error" style="color:red; font-size:small;"></p>
								    </div>
								</div>
								<div class="form-group">
									<label  class="col-sm-2 control-label">Confirm Password</label>
									<div class="col-sm-10">
										<input type="password" class="form-control" name="confirm_password" id="confirm_password" onblur='return matchPasswords();' placeholder="Confirm Password" required>
										<p id="cpass_error" style="color:red; font-size:small;"></p>
								    </div>
								</div>
                             <div class="form-group">
								    <label  class="col-sm-2 control-label">Email/User Name</label>
								    <div class="col-sm-10">
								      <input type="email" class="form-control" name="userEmail" placeholder="Email address">
								    </div>
								  </div>
                               <div class="form-group">
								    <label  class="col-sm-2 control-label">Location</label>
								    <div class="col-sm-10">
								      <input type="text" class="form-control" id = "userAddress" name="userAddress" placeholder="Address" required>
								    </div>
								  </div>
                              <div class="form-group">
								    <label  class="col-sm-2 control-label">Phone Number</label>
								    <div class="col-sm-10">
								      <input type="text" pattern="\d*" maxlength="10" class="form-control" name="userContact" title='Invalid phone number' placeholder="Phone Number" required>
								    </div>
								  </div>
                          
                             <br><div class="action">
                                <input type = "submit" class="btn btn-primary signup"  value = "Register" onclick="return securityQuestionCheck();" /><br />
                            </div> 
                         </form>
                   </div>
                   
               </div>
           </div>
           
       </div>

    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
   </body>
</html>