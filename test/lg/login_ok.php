<?php
    $id   = $_POST['id'];
    $pass = $_POST['pass'];

 //$con = mysqli_connect("localhost", "root", "", "bbs");
 $con = mysqli_connect("1.239.38.238", "root", "e0425820", "test", 33306);
   $sql = "SELECT *
   		   FROM user
           WHERE id='$id'
          ";

   $result = mysqli_query($con, $sql);

   $num_match = mysqli_num_rows($result);

   if(!$num_match) {
     echo("
           <script>
             window.alert('등록되지 않은 이메일입니다!')
             location.href = 'login.php';
           </script>
         ");
    } else {
        $row = mysqli_fetch_array($result);
        $db_pass = $row['pass'];

        mysqli_close($con);
		/* 로그인 화면에서 전송된 $pass와 DB의 $db_pass의 해쉬값 비교 */
        //if(!password_verify($pass, $db_pass)){
        if($pass!=$db_pass){
        	echo("
	              <script>
	                window.alert('비밀번호가 틀립니다!')
	                location.href = 'login.php';
	              </script>
	           ");
	           exit;
        }else {
            session_start();
            $_SESSION["lguserid"] = $row["id"];
            $location_text = "<script> location.href = 'deploy.php'; </script>";

            echo $location_text;
        }
     }
?>
