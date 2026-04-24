

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>MKPD MES WEB</title>
</head>
<?
$db_conn = mysql_connect('localhost','mkpd','mkpd10041004'); 
mysql_select_db('mkpd',$db_conn);
//$db_conn = mysql_connect('localhost','ljs1092','dlwjdtjq3627'); 
//mysql_select_db('ljs1092',$db_conn);

$id = $_REQUEST[id];

$user_ip = $_SERVER['REMOTE_ADDR'];

$sql = "SELECT ip_addr ,id, TIMEDIFF(now(), str_to_date(login_date,'%Y-%m-%d %T')) time FROM `MKPD_person` WHERE id ='$id'";

$rs = mysql_query($sql); 

while($result = mysql_fetch_array($rs))
{
  $ip_addr=$result[ip_addr];
  $time=$result[time];
  $id=$result[id];
  
  /*
  if($ip_addr!=$user_ip){
    echo "<script>alert('접속한 PC가 바뀌었습니다. 다시 로그인하세요.');</script>";
    echo "<script>parent.document.location.href='./login.php';</script>";
  }
  */
  
  /*
  $time_check = substr($time,0,2);
  if($time_check!="00"){
    echo "<script>alert('접속시간이 만료되었습니다. 다시 로그인하세요.');</script>";
    echo "<script>parent.document.location.href='./login.php';</script>";
  }else{
    $sql1 = "
        update MKPD_person 
        set login_date = DATE_FORMAT(now(),'%Y-%m-%d %H:%i:%s')
        where id = '$id'
        ";
    $rs1 = mysql_query($sql1);
  } 
  */
}

?>

<frameset name="topSet" rows="77,*,22" framespacing="0" frameborder="no">
<?
  $arg_id = $_REQUEST[id];
	echo "<frame name='topFrame' id='headerFrame' src='./top_page.php?id=$arg_id' scrolling='no' frameborder='no' noresize>";

	echo "<frameset name='mainSet' id='mainSet' cols='180,*' frameborder='no' scrolling='yes'>";
	echo "<frame name='leftFrame' id='leftFrame' src='./left_page1.php?id=$arg_id' scrolling='no' frameborder='no' noresize>";
?>	
	<frame name="mainFrame" id="mainFrame" src="./PAGE/page1-1.php?init=1" scrolling="yes" frameborder="no">
	</frameset>
	<frame name="underFrame" id="footerFrame" src="./under_page.php" scrolling="no" frameborder="no" noresize>
</frameset>
</html>
