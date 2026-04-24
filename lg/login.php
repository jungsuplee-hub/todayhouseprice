<?php
	include_once "./config.php";
?>
<!DOCTYPE html>
<html>
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <title>로그인</title>
		<?php include_once "./head.php";?>

	</head>
	<br>
	<center>
	<span style="font-size:30px; vertical-align: middle;"><b>로그인</b></span>
	</center>

	<body>
		<!-- 표준 네비게이션 바 (화면 상단에 위치, 화면에 의존하여 확대 및 축소) -->
		<br>
		<div class="container">
			<div class="col-lg-4"></div>
			<div class="col-lg-4">
				<div class="jumbotron" style="padding-top: 20px;">
					<form name="loginSbmt" id="loginSbmt" method="post" action="login_ok.php">
						<h3 style="text-align: center">로그인 화면</h3>
						<div class="col-lg-4"></div>
						<div class="form-group">
							<input type="email" class="form-control" placeholder="LG 협력사 이메일" name="id" maxlength="40">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" placeholder="비밀번호" name="pass" maxlength="20">
						</div>
						<a href="#"><span class="btn btn-primary form-control" onclick="check_input()">로그인</span></a>
						<br><br>
						<a href="./join.php"><span class="btn btn-primary form-control">회원가입</span></a>
						<br><br>
						<a href="./reset_password.php"><span class="btn btn-primary form-control">비밀번호 재설정</span></a>
					</form>
				</div>
			</div>
		</div>
		<script src="./login.js"></script>
	</body>

</html>
