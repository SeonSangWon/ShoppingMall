<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../signUp/css/material-design-iconic-font.min.css">
<link rel="stylesheet" type="text/css" href="../signUp/cssanimate.css">
<link rel="stylesheet" type="text/css" href="../signUp/css/hamburgers.min.css">
<link rel="stylesheet" type="text/css" href="../signUp/css/animsition.min.css">
<link rel="stylesheet" type="text/css" href="signUp/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="../signUp/css/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="../signUp/css/util.css">
<link rel="stylesheet" type="text/css" href="../signUp/css/main.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="UTF-8">
<title>SignUp</title>
</head>
<body>

<div class="limiter">
	<div class="container-login100">
		<div class="login100-more"></div>
	
		<div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">
			<form class="login100-form validate-form" action="signup.php" method="POST">
			<span class="login100-form-title p-b-59">
				Sign UP
			</span>
			
			<!-- ID -->
			<div class="wrap-input100 validate-input" data-validate="Id is required">
				<span class="label-input100">ID</span>
				<input class="input100" type="text" name="id" placeholder="이름을 입력해주세요.">
				<span class="focus-input100"></span>
			</div>
	
			<!-- PASSWORD -->
			<div class="wrap-input100 validate-input" data-validate="Password is required">
				<span class="label-input100">Password</span>
				<input class="input100" type="password" name="password" placeholder="비밀번호를 입력해주세요.">
				<span class="focus-input100"></span>
			</div>
	
			<!-- NAME -->
			<div class="wrap-input100 validate-input" data-validate="Name is required">
				<span class="label-input100">Name</span>
				<input class="input100" type="text" name="name" placeholder="이름을 입력해주세요.">
				<span class="focus-input100"></span>
			</div>
			
			<!-- PHONE -->
			<div class="wrap-input100 validate-input" data-validate="Phone is required">
				<span class="label-input100">Phone</span>
				<input class="input100" type="text" name="phone" placeholder="전화번호 '-'를 제외하고 입력해주세요.">
				<span class="focus-input100"></span>
			</div>
                
            <!-- POSTCODE -->
			<div class="wrap-input100 validate-input" data-validate="Postcode is required">
				<span class="label-input100">Postcode</span>
				<input class="input100" type="text" name="postcode" placeholder="우편번호를 입력해주세요.">
				<span class="focus-input100"></span>
			</div>
                
            <!-- ADDRESS -->
			<div class="wrap-input100 validate-input" data-validate="Postcode is required">
				<span class="label-input100">Address</span>
				<input class="input100" type="text" name="address" placeholder="주소를 입력해주세요.">
				<span class="focus-input100"></span>
			</div>
	
			<div class="container-login100-form-btn">
				<div class="wrap-login100-form-btn">
					<div class="login100-form-bgbtn">
					</div>
					<button class="login100-form-btn">
						회원가입
					</button>
				</div>
	
				<a href="../index.php" class="dis-block txt3 hov1 p-r-30 p-t-10 p-b-10 p-l-30">
					돌아가기
					<i class="fa fa-long-arrow-right m-l-5"></i>
				</a>
			</div>
			</form>
		</div>
	</div>
</div>    
    
</body>
</html>