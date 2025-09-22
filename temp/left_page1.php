

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head><title>
	LeftPage
</title><link type="text/css" href="/Common/css/dui_slidemenu.css" rel="stylesheet" /><link type="text/css" href="/Common/css/screen.css" rel="stylesheet" />
<style type="text/css">
	.menuWrap
	{
		color:#555555;
		font-family: Dotum, 돋움;
		font-size: 12px;
		padding:0;
		border-left: #E8E8E8 5px solid;
		border-right: #E8E8E8 1px solid;
		height:1000px;
	}
	
	.menuTitle
	{
		font-size: 15px;
		font-weight:bold;
		color:#1a5c9a;
		padding:2px 0 10px 10px;
	}
</style>

</head>
<body topmargin="0" leftmargin="0">
<form name="form1" method="post" action="LeftPage.aspx" id="form1">

<div class="menuWrap">
	<table cellpadding="0" cellspacing="0" border="0" width="100%" id="menuTitleTable">
		<tr>
		  &nbsp;&nbsp;&nbsp;<b><font face="맑은 고딕" font size="5" color="#0000FF">제품사양입력</font></b>
			<td class="menuTitle"></td>
			<br><br><br>
			&nbsp;&nbsp;&nbsp;<a href="#main" onclick="main_page();" style="text-decoration:none"><b><font size="3" face="맑은 고딕" color="#000000">. 제품사양 조회</font></b></a>
			<br><br>
			&nbsp;&nbsp;&nbsp;<a href="#main" onclick="main_page2();" style="text-decoration:none"><b><font size="3" face="맑은 고딕" color="#000000">. 제품사양 입력</font></b></a>
			<br><br>

<?
$db_conn = mysql_connect('localhost','mkpd','mkpd10041004'); 
mysql_select_db('mkpd',$db_conn);
//$db_conn = mysql_connect('localhost','ljs1092','dlwjdtjq3627'); 
//mysql_select_db('ljs1092',$db_conn);

$id = $_REQUEST["id"];


$sql = 
"
select 
authority
from MKPD_person
where id = '$id'
";

$rs = mysql_query($sql);
 
while($result = mysql_fetch_array($rs))
{
  $authority = $result[authority]; 
}

if($authority=="Y"){
  echo "&nbsp;&nbsp;&nbsp;<a href='#main' onclick='main_page3();' style='text-decoration:none'><b><font size='3' face='맑은 고딕' color='#000000'>. 제품사양 수정</font></b></a>";
}

?>
<br><br>
&nbsp;&nbsp;&nbsp;<a href="#main" onclick="main_page4('<?=$_REQUEST["id"]?>');" style="text-decoration:none"><b><font size="3" face="맑은 고딕" color="#000000">. 제품 IMAGE</font></b></a>
<br><br>
&nbsp;&nbsp;&nbsp;<a href="#main" onclick="main_page5('<?=$_REQUEST["id"]?>');" style="text-decoration:none"><b><font size="3" face="맑은 고딕" color="#000000">. 측정POINT</font></b></a>

			
			</tr>
	</table>
</div>


</form>

<script type="text/javascript" language="javascript">
function main_page(){
  parent.mainFrame.location.href="./PAGE/page1-1.php?init=1";
} 

function main_page2(){
  parent.mainFrame.location.href="./PAGE/page1-2.php?init=1";
}
function main_page3(){
  parent.mainFrame.location.href="./PAGE/page1-3.php?init=1";
}
function main_page4(id){
  parent.mainFrame.location.href="./Board/list.php?id="+id;
}
function main_page5(id){
  parent.mainFrame.location.href="./Board_Point/list_point.php?id="+id;
}
</script>
   
</body>
</html>
