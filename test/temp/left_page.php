

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
	<img id="menuClose" alt="메뉴숨기기" src="./menu_close.gif" onclick="fncResizeMenu();" class="pointer" style="display:block;" />
	<img id="menuOpen" alt="메뉴보이기" src="Common/images/menu_open.gif" onclick="fncResizeMenu();" class="pointer" style="display:none;" />
	<table cellpadding="0" cellspacing="0" border="0" width="100%" id="menuTitleTable">
		<tr>
		  &nbsp;&nbsp;&nbsp;<b><font face="맑은 고딕" font size="5" color="#0000FF">반출/반입</font></b>
			<td class="menuTitle"></td>
			<br><br><br>
			&nbsp;&nbsp;&nbsp;<a href="#main" onclick="main_page();" style="text-decoration:none"><b><font size="5" face="맑은고딕" color="#000000">. 반입 처리</font></b></a>
			<br><br>
			&nbsp;&nbsp;&nbsp;<a href="#main" onclick="main_page2();" style="text-decoration:none"><b><font size="5" face="맑은 고딕" color="#000000">. 반출 처리</font></b></a>
		</tr>
	</table>
</div>


</form>

<script type="text/javascript" language="javascript">
function main_page(){
  parent.mainFrame.location.href="./PAGE/imsi1.php";
} 

function main_page2(){
  parent.mainFrame.location.href="./PAGE/imsi2.php";
}
</script>
   
</body>
</html>
