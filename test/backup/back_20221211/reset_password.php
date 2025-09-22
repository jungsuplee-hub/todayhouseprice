<?php
	include_once "./config.php";
?>
<!DOCTYPE html>
<html>
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="./todayhouseprice2.ico">
    <title>오늘집값 - 아파트 실거래 조회</title>
		<meta name="description" content="아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
		<meta property="og:type" content="website">
		<meta property="og:title" content="오늘집값">
		<meta property="og:description" content="오늘집값 - 아파트 매매  정보를 상세히 검색 할 수 있습니다.">
		<meta property="og:image" content="./todayhouseprice2.png">
		<meta property="og:url" content="http://todayhouseprice.com/">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3758121784656467"
         crossorigin="anonymous"></script>
		<?php include_once "./fragments/head.php";?>
	</head>
	<body>
		<!-- 표준 네비게이션 바 (화면 상단에 위치, 화면에 의존하여 확대 및 축소) -->
		<br>
		<center>
		<a href="./apart_today.php"><img style="vertical-align: middle;" width="60", height="60" src="./todayhouseprice2.png"></a>
		<span style="font-size:30px; vertical-align: middle;"><b>오늘집값</b></span>
		</center>
		<br>
		<div class="container">
			<div class="col-lg-4"></div>
			<div class="col-lg-4">
				<div class="jumbotron" style="padding-top: 20px;">
					<form name="join"  method="post" action="reset_password_ok.php">
						<h3 style="text-align: center">비밀번호 초기화 화면</h3>
						<div class="col-lg-4"></div>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="아이디" name="id" id="id" maxlength="15">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" placeholder="재설정할 비밀번호" name="pass" id="pass" maxlength="20">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" placeholder="재설정할 비밀번호 확인" name="pass_confirm" id="pass_confirm" maxlength="20">
						</div>
						<div class="form-group">
							<span id="pass_check_msg" data-check="0"></span>	<!--커스텀 속성:data-check="0"  -->
						</div>
						<div class="form-group">
							<input type="email" class="form-control" placeholder="가입때 입력한 이메일" name="email" id="email" maxlength="80">
						</div>

						<span class="btn btn-primary form-control" onclick="check_input()">비밀번호 초기화</span>

					</form>
				</div>
			</div>
		</div>
		<script>

			$(function(){/*문서가 로드되면 function을 실행하라  */
				$("#pass_confirm").blur(function(){/*아이디가 id인것을 찾아 포커즈를 빠져나갈때 발생하는 이벤트  */
					if( $(this).val()!=$("#pass").val() ) {
						$("#pass_check_msg").html("비밀번호가 일치하지 않습니다.").css("color","red");
					}else if( ($("#this").val()=="") || ($("#pass").val()=="") ){
						$("#pass_check_msg").html("비밀번호를 입력하세요.").css("color","red");
					}else{
						$("#pass_check_msg").html("비밀번호가 일치합니다.").css("color","blue");
					}
				});
			});

			function check_input()
			   {
				 if (!$("#id").val()) {
			          alert("아이디를 입력하세요!");
			          $("#id").focus();
			          return;
			      }

				 if (!$("#pass").val()) {
			          alert("비밀번호를 입력하세요!");
			          $("#pass").val().focus();
			          return;
			      }

				 if (!$("#pass_confirm").val()) {
			          alert("비밀번호확인을 입력하세요!");
			          $("#pass_confirm").focus();
			          return;
			      }

			      if (!$("#email").val()) {
			          alert("이메일 주소를 입력하세요!");
			          $("#email").focus();
			          return;
			      }

			      if ( $("#pass").val() !=
			            $("#pass_confirm").val()) {
			          alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요!");
			          $("#pass").focus();
			          $("#pass").select();
			          return;
			      }

			      document.join.submit();
			   }

			   function reset_form() {
			      document.join.id.value = "";
			      document.join.pass.value = "";
			      document.join.pass_confirm.value = "";
			      document.join.name.value = "";
			      document.join.gender.value = "";
			      document.join.phone.value = "";
			      document.join.email.value = "";
			      document.join.id.focus();
			      return;
			   }
		</script>
	</body>

	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3758121784656467"
	     crossorigin="anonymous"></script>
	<ins class="adsbygoogle"
	     style="display:block"
	     data-ad-format="fluid"
	     data-ad-layout-key="-fb+5w+4e-db+86"
	     data-ad-client="ca-pub-3758121784656467"
	     data-ad-slot="7226824761"></ins>
	<script>
	     (adsbygoogle = window.adsbygoogle || []).push({});
	</script>

	<center><span style="font-size:10px;"><b>Copyright ©2022 TodayHousePrice, Inc. All rights reserved<br>Developer : jungsup2.lee@gmail.com</b></span></center>
</html>
