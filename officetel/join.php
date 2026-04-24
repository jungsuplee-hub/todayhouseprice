<?php
	include_once "./config.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-EF60WVGV7F"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-EF60WVGV7F');
	gtag('config', 'AW-945296853');
	gtag('event', 'conversion', {'send_to': 'AW-945296853/nBcaCMiZnYcYENWr4MID'});
</script>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="./todayhouseprice2.ico">
    <title>오늘집값 - 회원가입</title>
		<meta name="description" content="오피스텔 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
		<meta property="og:type" content="website">
		<meta property="og:title" content="오늘집값">
		<meta property="og:description" content="오늘집값 - 오피스텔 매매  정보를 상세히 검색 할 수 있습니다.">
		<meta property="og:image" content="./todayhouseprice2.png">
		<meta property="og:url" content="http://todayhouseprice.com/">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871"
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
					<form name="join"  method="post" action="join_ok.php">
						<h3 style="text-align: center">회원가입 화면</h3>
						<div class="col-lg-4"></div>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="아이디" name="id" id="id" maxlength="15">
						</div>
						<div class="form-group">
							<span id="id_check_msg" data-check="0"></span>	<!--커스텀 속성:data-check="0"  -->
						</div>
						<div class="form-group">
							<input type="password" class="form-control" placeholder="비밀번호" name="pass" id="pass" maxlength="20">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" placeholder="비밀번호 확인" name="pass_confirm" id="pass_confirm" maxlength="20">
						</div>
						<div class="form-group">
							<span id="pass_check_msg" data-check="0"></span>	<!--커스텀 속성:data-check="0"  -->
						</div>
						<!--
						<div class="form-group">
							<input type="text" class="form-control" placeholder="이름" name="name" id="name" maxlength="20">
						</div>
						<!--<div class="form-group" style="text-align: center">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-primary active">
									<input type="radio" name="gender" id="gender1" autocomplete="off" value="남자" checked>남자
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="gender" id="gender2" autocomplete="off" value="여자">여자
								</label>
							</div>
						</div>

						<div class="form-group">
							<input type="tel" class="form-control" placeholder="전화번호" name="phone" id="phone" maxlength="20">
						</div>
						<div class="col-lg-4"></div>
						-->
						<div class="form-group">
							<input type="email" class="form-control" placeholder="이메일 (비밀번호 초기화용)" name="email" id="email" maxlength="80">
						</div>

						<span class="btn btn-primary form-control" onclick="check_input()">회원가입</span>&nbsp;
						<span class="btn btn-primary form-control" onclick="reset_form()">초기화</span>

					</form>
				</div>
			</div>
		</div>

		<?php if($advertize=="1"){ ?>
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871"
				 crossorigin="anonymous"></script>
		<ins class="adsbygoogle"
				 style="display:block"
				 data-ad-format="fluid"
				 data-ad-layout-key="-fb+5w+4e-db+86"
				 data-ad-client="ca-pub-2265060002718871"
				 data-ad-slot="3474043280"></ins>
		<script>
				 (adsbygoogle = window.adsbygoogle || []).push({});
		</script>
		<?php } ?>

		<script>

			/* 아이디 중복 체크(비동기통신) */
			$(function(){/*문서가 로드되면 function을 실행하라  */
				$("#id").blur(function(){/*아이디가 id인것을 찾아 포커즈를 빠져나갈때 발생하는 이벤트  */
					if($(this).val()==""){
						$("#id_check_msg").html("아이디를 입력하세요.").css("color","red").attr("data-check","0");/*선택자를 .연사자추가해서 계속 사용가능  */
						$(this).focus();
					}else{
						checkIdAjax();
					}
				});
			});

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

			/* 아이디 중복 체크(비동기통신) */
			function checkIdAjax(){//id값을 post로 전송해서 서버와 통신하여 중복 결과 json 형태로 받아오는 함수
				$.ajax({				//비동기통신방법, 객체로 보낼때{}사용
					url : "./ajax/check_id.php",
					type : "post",
					dataType : "json",
					data : {
						"id" : $("#id").val()
					},
					success : function(data){
						if(data.check){			//json사용했기때문에 data.으로 접근가능
							$("#id_check_msg").html("사용 가능한 아이디입니다.").css("color", "blue").attr("data-check","1");
						}else{
							$("#id_check_msg").html("중복된 아이디입니다.").css("color", "red").attr("data-check","0");
							$("#id").focus();
						}
					}
				});
			}

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

				 //if (!$("#name").val()) {
			   //       alert("이름을 입력하세요!");
			   //       $("#name").focus();
			   //       return;
			   //   }

			   //   if (!$("#phone").val()) {
			   //       alert("전화번호를 입력하세요!");
			   //       $("#phone").focus();
			   //       return;
			   //   }

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
	<center><span style="font-size:10px;"><b>Copyright ©2022 TodayHousePrice, Inc. All rights reserved<br>Developer : todayhouseprice.com@gmail.com</b></span></center>
</html>
