<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../todayhouseprice.css">
<title>LG 공상평 배포관리</title>
</head>
<?php
include_once "./config.php";
$Conn = mysqli_connect("localhost", "root", "e0425820", "test");
mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

$today = date("Y-m-d");
$thistime = date("Y-m-d H:i:s");


$insert_date = $_REQUEST["insert_date"];
$server_info = $_REQUEST["server_info"];
$update_user = $_REQUEST["update_user"];
$update_op = $_REQUEST["update_op"];

$op01 = $_REQUEST["op01"];
$op02 = $_REQUEST["op02"];
$op03 = $_REQUEST["op03"];
$op04 = $_REQUEST["op04"];
$op05 = $_REQUEST["op05"];
$op06 = $_REQUEST["op06"];
$op07 = $_REQUEST["op07"];
$op08 = $_REQUEST["op08"];
$op09 = $_REQUEST["op09"];
$op10 = $_REQUEST["op10"];
$op11 = $_REQUEST["op11"];
$op12 = $_REQUEST["op12"];
$op13 = $_REQUEST["op13"];
$op14 = $_REQUEST["op14"];
$op15 = $_REQUEST["op15"];
$op16 = $_REQUEST["op16"];
$op17 = $_REQUEST["op17"];

if ($server_info==""){
  $server_info = "lgestg";
}
if ($insert_date==""){
  $insert_date = $today;
}

if($update_user=="true"){
  if($userid){
    if ($update_op=="op01") { mysqli_query($Conn, "update DeployList set option01 = '$op01' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 BMIDE를 $op01 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op02") { mysqli_query($Conn, "update DeployList set option02 = '$op02' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 ITK를 $op02 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op03") { mysqli_query($Conn, "update DeployList set option03 = '$op03' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 AWC Build를 $op03 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op04") { mysqli_query($Conn, "update DeployList set option04 = '$op04' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 ACL를 $op04 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op05") { mysqli_query($Conn, "update DeployList set option05 = '$op05' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 Preference를 $op05 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op06") { mysqli_query($Conn, "update DeployList set option06 = '$op06' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 Stylesheet를 $op06 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op07") { mysqli_query($Conn, "update DeployList set option07 = '$op07' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 Workflow를 $op07 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op08") { mysqli_query($Conn, "update DeployList set option08 = '$op08' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 SavedQuery를 $op08 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op09") { mysqli_query($Conn, "update DeployList set option09 = '$op09' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 UI_Config를 $op09 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op10") { mysqli_query($Conn, "update DeployList set option10 = '$op10' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 WS_Config를 $op10 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op11") { mysqli_query($Conn, "update DeployList set option11 = '$op11' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 Restfulservice를 $op11 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op12") { mysqli_query($Conn, "update DeployList set option12 = '$op12' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 com.qps.common.uis를 $op12 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op13") { mysqli_query($Conn, "update DeployList set option13 = '$op13' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 com.qps.fmea.scheduler를 $op13 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op14") { mysqli_query($Conn, "update DeployList set option14 = '$op14' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 com.qps.pms.mail를 $op14 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op15") { mysqli_query($Conn, "update DeployList set option15 = '$op15' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 com.qps.pms.scheduler를 $op15 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op16") { mysqli_query($Conn, "update DeployList set option16 = '$op16' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 com.qps.qms.crt를 $op16 로 수정했습니다','$thistime');"); $update_user = "";}
    elseif ($update_op=="op17") { mysqli_query($Conn, "update DeployList set option17 = '$op17' where yyyymmdd = '$insert_date' and server = '$server_info';"); mysqli_query($Conn, "insert into update_history (yyyymmdd,server,history,update_date) values('$insert_date','$server_info','$userid 님이 Reindex를 $op17 로 수정했습니다','$thistime');"); $update_user = "";}
  }
}else
{
    $sql = "
      select 
      yyyymmdd,
      server,
      option01,
      option02,
      option03,
      option04,
      option05,
      option06,
      option07,
      option08,
      option09,
      option10,
      option11,
      option12,
      option13,
      option14,
      option15,
      option16,
      option17,
      option18,
      option19,
      option20,
      last_update_date,
      confirm,
      confirm_date
      from DeployList
      where yyyymmdd = '$insert_date'
      and server = '$server_info'
      ";
    
    $rs = mysqli_query($Conn, $sql);
    $row = mysqli_fetch_assoc($rs);
    $row_count = mysqli_num_rows($rs);
    
    if($row_count==0){
      mysqli_query($Conn, "insert into DeployList (yyyymmdd, server) values('$insert_date','$server_info');");
      
      
      $op01 = false;
      $op02 = false;
      $op03 = false;
      $op04 = false;
      $op05 = false;
      $op06 = false;
      $op07 = false;
      $op08 = false;
      $op09 = false;
      $op10 = false;
      $op11 = false;
      $op12 = false;
      $op13 = false;
      $op14 = false;
      $op15 = false;
      $op16 = false;
      $op17 = false;
      
    }else{
      $op01 = $row['option01'];
      $op02 = $row['option02'];
      $op03 = $row['option03'];
      $op04 = $row['option04'];
      $op05 = $row['option05'];
      $op06 = $row['option06'];
      $op07 = $row['option07'];
      $op08 = $row['option08'];
      $op09 = $row['option09'];
      $op10 = $row['option10'];
      $op11 = $row['option11'];
      $op12 = $row['option12'];
      $op13 = $row['option13'];
      $op14 = $row['option14'];
      $op15 = $row['option15'];
      $op16 = $row['option16'];
      $op17 = $row['option17'];
    }
}

$sql_all = "
      select 
      yyyymmdd,
      server,
      IFNULL(option01,'false') as option01,
      IFNULL(option02,'false') as option02,
      IFNULL(option03,'false') as option03,
      IFNULL(option04,'false') as option04,
      IFNULL(option05,'false') as option05,
      IFNULL(option06,'false') as option06,
      IFNULL(option07,'false') as option07,
      IFNULL(option08,'false') as option08,
      IFNULL(option09,'false') as option09,
      IFNULL(option10,'false') as option10,
      IFNULL(option11,'false') as option11,
      IFNULL(option12,'false') as option12,
      IFNULL(option13,'false') as option13,
      IFNULL(option14,'false') as option14,
      IFNULL(option15,'false') as option15,
      IFNULL(option16,'false') as option16,
      IFNULL(option17,'false') as option17,
      last_update_date,
      confirm,
      confirm_date
      from DeployList
      where yyyymmdd = '$insert_date'
      ";


$rs_all = mysqli_query($Conn, $sql_all);
$rs_count_all = mysqli_num_rows($rs_all);
while ( $row_all = mysqli_fetch_assoc($rs_all) ) {
    $rows_all[] = $row_all;
}


$sql_his = "
      select 
      yyyymmdd,
      server,
      history,
      update_date
      from update_history
      where yyyymmdd = '$insert_date'
      and server = '$server_info'
      order by update_date desc
      ";


$rs_his = mysqli_query($Conn, $sql_his);
$rs_count_all = mysqli_num_rows($rs_his);
while ( $row_his = mysqli_fetch_assoc($rs_his) ) {
    $rows_his[] = $row_his;
}

$before1Day = date("Y-m-d", strtotime($today." -1 day"));
$before2Day = date("Y-m-d", strtotime($today." -2 day"));
$before3Day = date("Y-m-d", strtotime($today." -3 day"));
$before4Day = date("Y-m-d", strtotime($today." -4 day"));
$before5Day = date("Y-m-d", strtotime($today." -5 day"));
$before6Day = date("Y-m-d", strtotime($today." -6 day"));
$before7Day = date("Y-m-d", strtotime($today." -7 day"));


?>

<?php
  if(!$userid){
?>
<a style="font-size:20px;" href="./login.php"><b>로그인 <--- 로그인 해야 수정이 가능합니다!!</b></a><span style="font-size:20px;"></span>
<?php
  }else if($userid){
    //$logged = $username."(".$userid.")";
    $logged = $userid;
?>
<span style="font-size:20px;"><b><?=$logged ?>님 </b></span><a style="font-size:20px;" href="./logout.php"><b>로그아웃</b></a>
<?php }?>


<center>
<span style="font-size:60px; vertical-align: middle;">LG 공상평 배포관리 사이트</span>
</center>
<br>

<span style="font-size:30px;"><b>배포날짜</b></span>
<select style="width:200px;font-size:30px;" name="day" id="day" onchange="day(this)">
<option value=<?php echo $today; ?> <?php if ($insert_date==$today){echo 'selected';} ?>><?php echo $today; ?></option>
<option value=<?php echo $before1Day; ?> <?php if ($insert_date==$before1Day){echo 'selected';} ?>><?php echo $before1Day; ?></option>
<option value=<?php echo $before2Day; ?> <?php if ($insert_date==$before2Day){echo 'selected';} ?>><?php echo $before2Day; ?></option>
<option value=<?php echo $before3Day; ?> <?php if ($insert_date==$before3Day){echo 'selected';} ?>><?php echo $before3Day; ?></option>
<option value=<?php echo $before4Day; ?> <?php if ($insert_date==$before4Day){echo 'selected';} ?>><?php echo $before4Day; ?></option>
<option value=<?php echo $before5Day; ?> <?php if ($insert_date==$before5Day){echo 'selected';} ?>><?php echo $before5Day; ?></option>
<option value=<?php echo $before6Day; ?> <?php if ($insert_date==$before6Day){echo 'selected';} ?>><?php echo $before6Day; ?></option>
<option value=<?php echo $before7Day; ?> <?php if ($insert_date==$before7Day){echo 'selected';} ?>><?php echo $before7Day; ?></option>
</select>
&nbsp;&nbsp;
<span style="font-size:30px;"><b>서버</b></span>
<select style="width:240px;font-size:30px;" name="server_info" id="server_info" onchange="server_type(this)">
	<option value="lgestg" <?php if($server_info=='lgestg'){echo 'selected';}?>>LGE STG </option>
	<option value="lgitstg" <?php if($server_info=='lgitstg'){echo 'selected';}?>>LGIT STG </option>
	<option value="lgesstg" <?php if($server_info=='lgesstg'){echo 'selected';}?>>LGES STG </option>
	<option value="lgedetest" <?php if($server_info=='lgedetest'){echo 'selected';}?>>LGE DETEST </option>
	<option value="lgitdetest" <?php if($server_info=='lgitdetest'){echo 'selected';}?>>LGIT DETEST </option>
	<option value="lgesdetest" <?php if($server_info=='lgesdetest'){echo 'selected';}?>>LGES DETEST </option>
</select>

<br>
<br>
<span style="font-size:20px;"><b>클릭시 바로 업데이트 됩니다.</b></span>
<br>
<form name="mform">
 <input style="width:22px; height:22px;" type="checkbox" id="op01" onclick="check01(this)" <?php if($op01=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>BMIDE</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op02" onclick="check02(this)" <?php if($op02=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>ITK</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op03" onclick="check03(this)" <?php if($op03=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>AWC Build</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op04" onclick="check04(this)" <?php if($op04=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>ACL</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op05" onclick="check05(this)" <?php if($op05=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>Preference</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op06" onclick="check06(this)" <?php if($op06=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>Stylesheet</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op07" onclick="check07(this)" <?php if($op07=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>Workflow</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op08" onclick="check08(this)" <?php if($op08=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>SavedQuery</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op09" onclick="check09(this)" <?php if($op09=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>UI_Config</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op10" onclick="check10(this)" <?php if($op10=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>WS_Config</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op11" onclick="check11(this)" <?php if($op11=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>Restfulservice</b></span><br>
 <input style="width:22px; height:22px;" type="checkbox" id="op12" onclick="check12(this)" <?php if($op12=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>com.qps.common.uis</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op13" onclick="check13(this)" <?php if($op13=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>com.qps.fmea.scheduler</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op14" onclick="check14(this)" <?php if($op14=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>com.qps.pms.mail</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op15" onclick="check15(this)" <?php if($op15=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>com.qps.pms.scheduler</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op16" onclick="check16(this)" <?php if($op16=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>com.qps.qms.crt</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="op17" onclick="check17(this)" <?php if($op17=="true"){ echo "checked";}?> <?php if(!$userid){echo "disabled";}?>><span style="font-size:25px;"><b>Reindex</b></span>
</form>

<script>
function check01(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op01";
}
function check02(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op02";
}
function check03(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op03";
}
function check04(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op04";
}
function check05(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op05";
}
function check06(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op06";
}
function check07(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op07";
}
function check08(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op08";
}
function check09(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op09";
}
function check10(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op10";
}
function check11(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op11";
}
function check12(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op12";
}
function check13(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op13";
}
function check14(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op14";
}
function check15(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op15";
}
function check16(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op16";
}
function check17(e){
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked+"&update_user=true&update_op=op17";
}
function day(e) {
  location.href = "./deploy.php?insert_date="+document.getElementById("day").value+"&server_info=<?=$server_info?>&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked;
}
function server_type(e) {
  location.href = "./deploy.php?insert_date=<?=$insert_date?>&server_info="+document.getElementById("server_info").value+"&op01="+document.getElementById("op01").checked+"&op02="+document.getElementById("op02").checked+"&op03="+document.getElementById("op03").checked+"&op04="+document.getElementById("op04").checked+"&op05="+document.getElementById("op05").checked+"&op06="+document.getElementById("op06").checked+"&op07="+document.getElementById("op07").checked+"&op08="+document.getElementById("op08").checked+"&op09="+document.getElementById("op09").checked+"&op10="+document.getElementById("op10").checked+"&op11="+document.getElementById("op11").checked+"&op12="+document.getElementById("op12").checked+"&op13="+document.getElementById("op13").checked+"&op14="+document.getElementById("op14").checked+"&op15="+document.getElementById("op15").checked+"&op16="+document.getElementById("op16").checked+"&op17="+document.getElementById("op17").checked;
}
</script>

<br>
<br>
<span style="font-size:30px;"><b><?=$insert_date?> 전체 서버 배포정보</b></span>
<br>
<br>
<table>
    <thead>
    <tr>
        <th style="font-size: 15px;"><b>서버명</b></th>
        <th style="font-size: 15px;">bmide</th>
        <th style="font-size: 15px;">ITK</th>
        <th style="font-size: 15px;">AWC Build</th>
        <th style="font-size: 15px;">ACL</th>
        <th style="font-size: 15px;">Preference</th>
        <th style="font-size: 15px;">Stylesheet</th>
        <th style="font-size: 15px;">Workflow</th>
        <th style="font-size: 15px;">SavedQuery</th>
        <th style="font-size: 15px;">UI_Config</th>
        <th style="font-size: 15px;">WS_Config</th>
        <th style="font-size: 15px;">Restfulservice</th>
        <th style="font-size: 15px;">common.uis</th>
        <th style="font-size: 15px;">fmea.scheduler</th>
        <th style="font-size: 15px;">pms.mail</th>
        <th style="font-size: 15px;">pms.scheduler</th>
        <th style="font-size: 15px;">qms.crt</th>
        <th style="font-size: 15px;">Reindex</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows_all as $row_all) { ?>
      <tr>
          <td style="font-size: 20px;"><?=$row_all['server']?></td>
          <td style="font-size: 20px;"><?php if($row_all['option01']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option01']?><?php if($row_all['option01']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option02']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option02']?><?php if($row_all['option02']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option03']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option03']?><?php if($row_all['option03']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option04']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option04']?><?php if($row_all['option04']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option05']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option05']?><?php if($row_all['option05']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option06']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option06']?><?php if($row_all['option06']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option07']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option07']?><?php if($row_all['option07']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option08']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option08']?><?php if($row_all['option08']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option09']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option09']?><?php if($row_all['option09']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option10']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option10']?><?php if($row_all['option10']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option11']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option11']?><?php if($row_all['option11']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option12']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option12']?><?php if($row_all['option12']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option13']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option13']?><?php if($row_all['option13']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option14']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option14']?><?php if($row_all['option14']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option15']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option15']?><?php if($row_all['option15']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option16']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option16']?><?php if($row_all['option16']=="true"){ echo "<span>";}?></td>
          <td style="font-size: 20px;"><?php if($row_all['option17']=="true"){ echo "<span style='color:red;'>";}?><?=$row_all['option17']?><?php if($row_all['option17']=="true"){ echo "<span>";}?></td>
      </tr>
      <?php } ?>
    </tbody>
</table>


<br><br>
<span style="font-size:25px;"><b><?=$insert_date?> <?=$server_info?> 서버 수정이력 정보</b></span>
<br>
<br>
<table>
    <thead>
    <tr>
        <th style="font-size: 15px; width:70%;">이력</th>
        <th style="font-size: 15px; width:30%;">수정날짜</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows_his as $row_his) { ?>
      <tr>
          <td style="font-size: 20px;"><?=$row_his['history']?></td>
          <td style="font-size: 20px;"><?=$row_his['update_date']?></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
<center><span style="font-size:20px;"><b>개발자 : 이정섭(sup.lee@cnspartner.com)</b></span></center>
