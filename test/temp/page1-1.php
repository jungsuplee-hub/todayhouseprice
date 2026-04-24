

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>
</title>

<body>
&nbsp;&nbsp;&nbsp;<b><font face="맑은 고딕" font size="4">제품사양 조회</font>
<br><br>

<table>
    <tr>
        <td>거래선
                <input type="text" name="_customer_line" id="_customer_line" value='<?=$_REQUEST["customer_line"]?>'/>
        </td>
        
        <td>거래처
                <input type="text" name="_customer" id="_customer" value='<?=$_REQUEST["customer"]?>'/>
        </td>
        <!--
        <td>거래선
            <select name="_customer" id="_customer">
        		    <option <?if($_REQUEST[customer_line]==""){echo "selected='selected'";} ?> value="">ALL</option>
        		    <option <?if($_REQUEST[customer_line]=="L001"){echo "selected='selected'";} ?> value="L001">STS반도체통신</option>
        		    <option <?if($_REQUEST[customer_line]=="L002"){echo "selected='selected'";} ?> value="L002">삼성전자</option>
        		    <option <?if($_REQUEST[customer_line]=="L003"){echo "selected='selected'";} ?> value="L003">삼성전자 SESS</option>
        		    <option <?if($_REQUEST[customer_line]=="L004"){echo "selected='selected'";} ?> value="L004">바른전자</option>
        		    <option <?if($_REQUEST[customer_line]=="L005"){echo "selected='selected'";} ?> value="L005">하이닉스</option>
        		    <option <?if($_REQUEST[customer_line]=="L006"){echo "selected='selected'";} ?> value="L006">LGITKR</option>
        		    <option <?if($_REQUEST[customer_line]=="L007"){echo "selected='selected'";} ?> value="L007">AVAGO</option>
        		    <option <?if($_REQUEST[customer_line]=="L008"){echo "selected='selected'";} ?> value="L008">STEMCO</option>
        		    <option <?if($_REQUEST[customer_line]=="L009"){echo "selected='selected'";} ?> value="L009">대덕전자</option>
        		    <option <?if($_REQUEST[customer_line]=="L010"){echo "selected='selected'";} ?> value="L010">SCK</option>
        		    <option <?if($_REQUEST[customer_line]=="L999"){echo "selected='selected'";} ?> value="L999">Test</option>
        </td>
        
        
        <td>거래처
            <select name="_customer" id="_customer">
        		    <option <?if($_REQUEST[customer]==""){echo "selected='selected'";} ?> value="">ALL</option>
        		    <option <?if($_REQUEST[customer]=="C001"){echo "selected='selected'";} ?> value="C001">LGIT 오산</option>
        		    <option <?if($_REQUEST[customer]=="C002"){echo "selected='selected'";} ?> value="C002">LGIT 구미</option>
        		    <option <?if($_REQUEST[customer]=="C003"){echo "selected='selected'";} ?> value="C003">KCC</option>
        		    <option <?if($_REQUEST[customer]=="C004"){echo "selected='selected'";} ?> value="C004">코스모텍</option>
        		    <option <?if($_REQUEST[customer]=="C005"){echo "selected='selected'";} ?> value="C005">DAP</option>
        		    <option <?if($_REQUEST[customer]=="C006"){echo "selected='selected'";} ?> value="C006">심텍</option>
        		    <option <?if($_REQUEST[customer]=="C007"){echo "selected='selected'";} ?> value="C007">본사</option>
        </td>
        -->
        
        <td>제품군
            <select name="_product_grp" id="_product_grp">
        		    <option <?if($_REQUEST[product_grp]==""){echo "selected='selected'";} ?> value="">ALL</option>
        		    <option <?if($_REQUEST[product_grp]=="COB"){echo "selected='selected'";}?> value="COB">COB</option>
        		    <option <?if($_REQUEST[product_grp]=="CSP"){echo "selected='selected'";}?> value="CSP">CSP</option>
        		    <option <?if($_REQUEST[product_grp]=="BGA"){echo "selected='selected'";}?> value="BGA">BGA</option>
        		    <option <?if($_REQUEST[product_grp]=="FMC"){echo "selected='selected'";}?> value="FMC">FMC</option>
        		    <option <?if($_REQUEST[product_grp]=="BOC"){echo "selected='selected'";}?> value="BOC">BOC</option>
        		    <option <?if($_REQUEST[product_grp]=="COR"){echo "selected='selected'";}?> value="COR">Coreless</option>
        		    <option <?if($_REQUEST[product_grp]=="CAM"){echo "selected='selected'";}?> value="CAM">Camera module</option>
        		    <option <?if($_REQUEST[product_grp]=="MC"){echo "selected='selected'";}?> value="MC">MC</option>
        		    <option <?if($_REQUEST[product_grp]=="TEST"){echo "selected='selected'";}?> value="TEST">Test</option>
        		    <option <?if($_REQUEST[product_grp]=="HDI"){echo "selected='selected'";}?> value="HDI">HDI</option>
                <option <?if($_REQUEST[product_grp]=="RF"){echo "selected='selected'";}?> value="RF">RF</option>
        </td>
        
        <td>Layer
            <select name="_layer" id="_layer">
        		    <option <?if($_REQUEST[layer]==""){echo "selected='selected'";} ?> value="">ALL</option>
        		    <option <?if($_REQUEST[layer]=="layer1"){echo "selected='selected'";} ?> value="layer1">Layer1</option>
        		    <option <?if($_REQUEST[layer]=="layer2"){echo "selected='selected'";} ?> value="layer2">Layer2</option>
        		    <option <?if($_REQUEST[layer]=="layer3"){echo "selected='selected'";} ?> value="layer3">Layer3</option>
        		    <option <?if($_REQUEST[layer]=="layer4"){echo "selected='selected'";} ?> value="layer4">Layer4</option>
        		    <option <?if($_REQUEST[layer]=="layer5"){echo "selected='selected'";} ?> value="layer5">Layer5</option>
        		    <option <?if($_REQUEST[layer]=="layer6"){echo "selected='selected'";} ?> value="layer6">Layer6</option>
        		    <option <?if($_REQUEST[layer]=="layer7"){echo "selected='selected'";} ?> value="layer7">Layer7</option>
        		    <option <?if($_REQUEST[layer]=="layer8"){echo "selected='selected'";} ?> value="layer8">Layer8</option>
        		    <option <?if($_REQUEST[layer]=="layer9"){echo "selected='selected'";} ?> value="layer9">Layer9</option>
        		    <option <?if($_REQUEST[layer]=="layer10"){echo "selected='selected'";} ?> value="layer10">Layer10</option>
               	<option <?if($_REQUEST[layer]=="layer12"){echo "selected='selected'";} ?> value="layer12">Layer12</option>
 		            <option <?if($_REQUEST[layer]=="layer14"){echo "selected='selected'";} ?> value="layer14">Layer14</option>  
        </td>
        
            
        <td>모델
                <input type="text" name="_page_number" id="_page_number" value='<?=$_REQUEST["page_number"]?>'/>
        </td>
        
        <td>모델설명
                <input type="text" name="_page_name" id="_page_name" value='<?=$_REQUEST["page_name"]?>'/>
        </td>
        
    </tr>
</table>
<table>
    <tr>
        <td>
            <input type="button" name="execute" onclick="fnc_execute()" value="조    회"/>
        </td>
        <td>
            <input type="button" name="execute" onclick="fnc_excel()" value="엑셀 다운"/>
        </td>
    </tr>
</table>
<div style="width:2140px; height:document.body.clientHeight; overflow: auto">
<table style="border:1px solid black; border-collapse:collapse; overflow:auto;">
    <tr>
        <td align="center" bgcolor="#D5D5D5" style="width:130px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">거래선</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:100px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">거래처</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">제품군</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">Layer</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:100px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">도금방식</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">H/G<br>광택사양</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:100px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">모델</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:100px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">모델설명</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">원자재<br>두께</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">최종완성<br>두께</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">BF폭<br>PITCH</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">BF간격<br>PITCH</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">BF폭</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">BF간격</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">Au두께<br>SG-컴프</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">Au두께<br>SG-솔드</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">Au두께<br>ENIG-컴프</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">Au두께<br>ENIG-솔드</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">Ni두께<br>SG-컴프</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">Ni두께<br>SG-솔드</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">Ni두께<br>ENIG-컴프</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">Ni두께<br>ENIG-솔드</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">도금면적<br>SG-컴프</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">도금면적<br>SG-솔드</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">도금면적<br>ENIG-컴프</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">도금면적<br>ENIG-솔드</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">PCS/PNL</font></td>
        <td align="center" bgcolor="#D5D5D5" style="width:70px; border:1px solid black; border-collapse:collapse;"><font size="2px" face="맑은 고딕">STRIP/PNL</font></td>
        
    </tr >
    <?
      $db_conn = mysql_connect('localhost','mkpd','mkpd10041004'); 
      mysql_select_db('mkpd',$db_conn);
      //$db_conn = mysql_connect('localhost','ljs1092','dlwjdtjq3627'); 
      //mysql_select_db('ljs1092',$db_conn);
      
      $customer_line = $_REQUEST["customer_line"];
      $customer = $_REQUEST["customer"];
      $product_grp = $_REQUEST["product_grp"];
      $layer = $_REQUEST["layer"];
      $page_number = $_REQUEST["page_number"];
      $page_name = $_REQUEST["page_name"];
      
      
      $init = $_REQUEST[init];
      $sql = 
      "
      select 
      customer_line,   customer_line_name,   customer,   customer_name,   product_grp,   product_grp_name,   layer,   page_number,   page_name,   hg_light,   hg_light_name,   draw,   draw_name,   raw_thick,   complete_thick,   bf_width_pitch,   bf_gap_pitch,   bf_width,   bf_gap,   au_thick_sgc,   au_thick_sgs,   au_thick_hgc,   au_thick_hgs,   ni_thick_sgc,   ni_thick_sgs,   ni_thick_hgc,   ni_thick_hgs,   draw_size_sgc,   draw_size_sgs,   draw_size_hgc,   draw_size_hgs,   pcs_pnl,   strip_pnl,   insert_date, insert_worker
      from MKPD_product_spec
      where customer_line_name like '%$customer_line%'
      and customer_name like '%$customer%'
      and product_grp like '$product_grp%'
      and layer like '%$layer%'
      and page_number like '%$page_number%'
      and page_name like '%$page_name%'
      ";
       
      if($init==1){
        $sql="";
      }   
      $rs = mysql_query($sql);
       
      while($result = mysql_fetch_array($rs))
      {
        $customer_line = $result[customer_line]; 
        $customer_line_name = $result[customer_line_name]; 
        $customer = $result[customer]; 
        $customer_name = $result[customer_name]; 
        $product_grp = $result[product_grp]; 
        $product_grp_name = $result[product_grp_name]; 
        $layer = $result[layer]; 
        $page_number = $result[page_number]; 
        $page_name = $result[page_name]; 
        $hg_light = $result[hg_light]; 
        $hg_light_name = $result[hg_light_name];
        $raw_thick = $result[raw_thick]; 
        $complete_thick = $result[complete_thick]; 
        $bf_width_pitch = $result[bf_width_pitch]; 
        $bf_gap_pitch = $result[bf_gap_pitch]; 
        $bf_width = $result[bf_width]; 
        $bf_gap = $result[bf_gap]; 
        $au_thick_sgc = $result[au_thick_sgc]; 
        $au_thick_sgs = $result[au_thick_sgs];
        $au_thick_hgc = $result[au_thick_hgc];
        $au_thick_hgs = $result[au_thick_hgs];
        $ni_thick_sgc = $result[ni_thick_sgc]; 
        $ni_thick_sgs = $result[ni_thick_sgs]; 
        $ni_thick_hgc = $result[ni_thick_hgc]; 
        $ni_thick_hgs = $result[ni_thick_hgs]; 
        $draw_size_sgc = $result[draw_size_sgc]; 
        $draw_size_sgs = $result[draw_size_sgs]; 
        $draw_size_hgc = $result[draw_size_hgc]; 
        $draw_size_hgs = $result[draw_size_hgs]; 
        $draw = $result[draw]; 
        $draw_name = $result[draw_name]; 
        $pcs_pnl = $result[pcs_pnl]; 
        $strip_pnl = $result[strip_pnl]; 
        
        echo "<tr>                                                     ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$customer_line_name</font></td>              ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$customer_name</font></td>              ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$product_grp_name</font></td>              ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$layer</font></td>               ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$draw_name</font></td>            ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$hg_light_name</font></td>               ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$page_number</font></td>                ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$page_name</font></td>              ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$raw_thick</font></td>          ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$complete_thick</font></td>        ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$bf_width_pitch</font></td>       ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$bf_gap_pitch</font></td>     ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$bf_width</font></td>                ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$bf_gap</font></td>              ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$au_thick_sgc</font></td>              ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$au_thick_sgs</font></td>              ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$au_thick_hgc</font></td>              ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$au_thick_hgs</font></td>              ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$ni_thick_sgc</font></td>    ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$ni_thick_sgs</font></td>    ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$ni_thick_hgc</font></td>    ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$ni_thick_hgs</font></td>    ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$draw_size_sgc</font></td>    ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$draw_size_sgs</font></td>    ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$draw_size_hgc</font></td>    ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$draw_size_hgs</font></td>    ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$pcs_pnl</font></td>    ";
        echo "    <td align='center' style='border:1px solid black; border-collapse:collapse;'><font size='2px' face='맑은 고딕'>$strip_pnl</font></td>    ";
        echo "</tr>                                                    ";
      }
      
      mysql_close($db_conn);
  ?>
</table> 
</div>
<script type="text/javascript" language="javascript">
function fnc_execute(){
  
  parent.mainFrame.location.href = "./page1-1.php?"
  +"customer_line="+document.getElementById('_customer_line').value
  +"&customer="+document.getElementById('_customer').value
  +"&product_grp="+document.getElementById('_product_grp').value
  +"&layer="+document.getElementById('_layer').value
  +"&page_number="+document.getElementById('_page_number').value
  +"&page_name="+document.getElementById('_page_name').value;
} 
function fnc_excel(){
  
  var url = "./page1-1_excel.php?"
  +"customer_line="+document.getElementById('_customer_line').value
  +"&customer="+document.getElementById('_customer').value
  +"&product_grp="+document.getElementById('_product_grp').value
  +"&layer="+document.getElementById('_layer').value
  +"&page_number="+document.getElementById('_page_number').value
  +"&page_name="+document.getElementById('_page_name').value;
  
  window.open(url, "Example", "scrollbars=no,width=50,height=50,menubar=false");
} 
</script>



</body>
</html>


