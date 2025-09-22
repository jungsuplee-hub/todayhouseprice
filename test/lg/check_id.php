<?php
	!empty($_POST['id']) ? $id = $_POST['id'] : $id="";
	$ret['check'] = false;	
	if($id != ""){
 		//$con = mysqli_connect("localhost", "root", "", "bbs");
 		$con = mysqli_connect("1.239.38.238", "root", "e0425820", "test", 33306);
		$sql = "select 
					id 
				from 
					user
				where
					id = '{$id}' 
				";
		$result = mysqli_query($con, $sql);
		$num = mysqli_num_rows($result);
		
		if($num==0){
			$ret['check'] = true;
		}
	}
	echo json_encode($ret);
?>