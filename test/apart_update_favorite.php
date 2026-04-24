<?php
    $userid = $_REQUEST["userid"];
    $apart_name = $_REQUEST["apart_name"];
    $dong = $_REQUEST["dong"];
    $size = $_REQUEST["size"];
    $area_main_name = $_REQUEST["area_main_name"];
    $all_area = $_REQUEST["all_area"];
    $add = $_REQUEST["add"];
    $rent = $_REQUEST["rent"];

    $times = mktime();  // 현재 서버의 시간을 timestamp 값으로 가져옴
    $date1 = date("Y-m-d H:i:s", $times);  // 초 -> 년-월-일 시:분:초  변환

    $Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);
    mysqli_query($Conn, "set names utf8;");
    mysqli_query($Conn, "set session character_set_connection=utf8;");
    mysqli_query($Conn, "set session character_set_results=utf8;");
    mysqli_query($Conn, "set session character_set_client=utf8;");

    if($userid!='' and $apart_name!='' and $area_main_name!='' and $dong!=''){
      if($add=='Y'){
        mysqli_query($Conn, "insert into molit_favorite (userid, area_main_name, dong, apart_name, size,  insert_Date) values('$userid','$area_main_name','$dong','$apart_name','$size','$date1');");
        echo "<script> alert('즐겨찾기 등록이 완료되었습니다.');  </script> ";
        if($rent=='Y'){
          echo "<script> location.href = './apart_rent.php?area_main_name=$area_main_name&apart_name=$apart_name&size=$size&dong=$dong&all_area=$all_area';  </script>";
        }elseif ($rent=='N'){
          echo "<script> location.href = './apart.php?area_main_name=$area_main_name&apart_name=$apart_name&size=$size&dong=$dong&all_area=$all_area';  </script>";
        }

      }elseif($add=='N'){
        mysqli_query($Conn, "delete from molit_favorite where userid = '$userid' and area_main_name = '$area_main_name' and dong = '$dong' and apart_name = '$apart_name' and size = '$size';");
        echo "<script> alert('즐겨찾기 삭제가 완료되었습니다.');  </script> ";
        if($rent=='Y'){
          echo "<script> location.href = './apart_rent.php?area_main_name=$area_main_name&apart_name=$apart_name&size=$size&dong=$dong&all_area=$all_area'; </script>";
        }elseif ($rent=='N'){
          echo "<script> location.href = './apart.php?area_main_name=$area_main_name&apart_name=$apart_name&size=$size&dong=$dong&all_area=$all_area'; </script>";
        }
      }
    }else{
      echo "
      <script>
      alert('ID가 정상적이지 않습니다. 다시 로그인 후 시도해 주세요.');  
      history.back();
      </script> ";
    }

    
?>
