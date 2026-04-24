

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head><title>

</title>
<meta http-equiv="Cache-Control" content="no-cache"/> 
<meta http-equiv="Expires" content="0"/> 
<meta http-equiv="Pragma" content="no-cache"/> 
<link type="text/css" rel="stylesheet" href="/Common/css/default.css?ver=20101004" />
<link type="text/css" rel="stylesheet" href="/Common/css/layout.css?ver=20101004" />
<link type="text/css" rel="stylesheet" href="/Common/css/mespkg.css?ver=20101004" />

<style type="text/css">
.topTop
{
	color:#000000;
	font-family: Dotum, 돋움;
	font-size: 12px;
}

.topTable
{
	color:#ffffff;
	font-family: Dotum, 돋움;
	font-size: 12px;
	font-weight:bold;
	border-bottom: #CCCCCC 1px solid;
}
.topBottom
{
	border-bottom: #e8e8e8 1px solid;
	background-color:#e8e8e8;
	height:15px;
}
.tdMargin
{
	margin:4px 40px 0 20px;
	float:left;
}
.tdMargin b
{
	font-weight:bold;
	cursor:pointer;
}
.pointer
{
	cursor:pointer;
}

</style>
</head>
<body topmargin="0" leftmargin="0">
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="topTop">
	<tr>
		<td style="width:184px;height:35px"><img src="./topLogo.png" class="pointer" onclick="fncGoMainPage('<?=$_REQUEST["id"]?>');" /></td>
		<td style="width:786px;text-align:right;"><img src="./welcome_icon.gif" align="absmiddle" class="pointer" onclick="fncOpenModifyLanguageTypePage();" title="언어변경" />
		<?
		    $arg_id = $_REQUEST[id];
		    echo "&nbsp;$arg_id 님 환영합니다&nbsp;&nbsp;";
		?>
		<input type="image" name="ibtnLogout" id="ibtnLogout" title="LOGOUT" src="./logout.gif" align="absmiddle" onclick="logout();" style="border-width:0px;" /></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="3" style="background-color:#e9e9e9;height:1px"></td>
	</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="topTable">
	<tr bgcolor="#6091c1">
		<td>
					<table cellpadding="0" cellspacing="0" border="0" width="1000" height="10">
			<tr align="center">
				<td class="tdMargin"><b onclick="go_leftpage1('<?=$_REQUEST["id"]?>');">제품사양입력</b></td>
				<td class="tdMargin"><b onclick="go_leftpage2('<?=$_REQUEST["id"]?>');">제품관리</b></td>
				<td class="tdMargin"><b onclick="go_leftpage3('<?=$_REQUEST["id"]?>');">반입/반출</b></td>
				<td class="tdMargin"><b onclick="go_leftpage4('<?=$_REQUEST["id"]?>');">생산관리</b></td>
				<td class="tdMargin"><b onclick="go_leftpage5('<?=$_REQUEST["id"]?>');">품질관리</b></td>
				<td class="tdMargin"><b onclick="go_leftpage6('<?=$_REQUEST["id"]?>');">자재관리</b></td>
				<td class="tdMargin"><b onclick="go_leftpage7('<?=$_REQUEST["id"]?>');">PM</b></td>
				<td class="tdMargin"><b onclick="go_leftpage8('<?=$_REQUEST["id"]?>');">공정개선</b></td>
				<td class="tdMargin"><b onclick="go_leftpage9('<?=$_REQUEST["id"]?>');">공정관리</b></td>
			</tr>
		</table>

		</td>
	</tr>
</table>
<script language="javascript" type="text/javascript">

function logout(){
  parent.document.location.href="./login.php"
}

 function go_leftpage1(id){
	    parent.mainSet.cols='180,*';
   parent.leftFrame.location.href="./left_page1.php?id="+id;
   parent.mainFrame.location.href="./PAGE/page1-1.php?init=1";
 }
  function go_leftpage2(id){
	     parent.mainSet.cols='180,*';
    parent.leftFrame.location.href="./left_page2.php?id="+id;
    parent.mainFrame.location.href="./PAGE/page2-1.php";
 }
  function go_leftpage3(id){
	     parent.mainSet.cols='180,*';
    parent.leftFrame.location.href="./left_page3.php?id="+id;
    parent.mainFrame.location.href="./PAGE/page3-1.php?init=1";
 }
  function go_leftpage4(id){
	     parent.mainSet.cols='180,*';
    parent.leftFrame.location.href="./left_page4.php?id="+id;
    parent.mainFrame.location.href="./PAGE/page4-1.php?init=1&id="+id;
 }
  function go_leftpage5(id){
	     parent.mainSet.cols='180,*';
    parent.leftFrame.location.href="./left_page5.php";
    parent.mainFrame.location.href="./PAGE/page5-1.php";
 }
 function go_leftpage6(id){
	    parent.mainSet.cols='180,*';
    parent.leftFrame.location.href="./left_page6.php";
    parent.mainFrame.location.href="./PAGE/page6-1.php";
 }
 function go_leftpage7(id){
	    parent.mainSet.cols='180,*';
    parent.leftFrame.location.href="./left_page7.php";
    parent.mainFrame.location.href="./PAGE/page7-1.php";
 }
 function go_leftpage8(id){
	    parent.mainSet.cols='180,*';
    parent.leftFrame.location.href="./left_page8.php";
    parent.mainFrame.location.href="./PAGE/page8-1.php";
 }
function go_leftpage9(id){
    //parent.leftFrame.location.href="./ptck/blank.htm";
    parent.mainSet.cols='0,*';
	parent.mainFrame.location.href="./ptck/";
 }
 function fncGoMainPage(id){
   parent.mainSet.cols='180,*';
   parent.leftFrame.location.href="./left_page1.php?id="+id;
   parent.mainFrame.location.href="./PAGE/page1-1.php?init=1";
 }
</script>
</body>
</html>