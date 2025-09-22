<?php
    $email   = $_REQUEST['email'];
    $status = $_REQUEST['status']; // 입력받은 패스워드를 해쉬값으로 암호화
    $from = $_REQUEST['from'];

    $Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);
    $rs = mysqli_query($Conn, "select count(1) as cnt from user where email = '$email';");
    $row = mysqli_fetch_assoc($rs);

    if($row['cnt']>0){
      mysqli_query($Conn, "update user set email_yn = '$status' where email = '$email'");
      if ($from == 'email'){
        echo "구독이 중지되었습니다.";
      }elseif ($status=='Y'){
        echo "<script> alert('구독신청이 완료되었습니다.'); history.back(); </script> ";
      }else{
        echo "<script> alert('구독신청이 해제되었습니다.'); history.back(); </script> ";
      }
    }elseif ($row['cnt']==0 && $from =='email'){
      echo "해당이메일로 등록된 정보가 없습니다.";
    }else{
      echo "<script> alert('이메일정보가 올바르지 않습니다.'); history.back(); </script> ";
    }
?>
