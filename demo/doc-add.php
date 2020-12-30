<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	//error_reporting(0);
	session_start();


	$db_sid = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST=Turab-PC)(PORT = 1521)) )(CONNECT_DATA = (SID = orcl) ) )";

		$db_user="dbadmin";
		$db_pass="1234";

		$con = oci_connect($db_user,$db_pass,$db_sid);
   		if(!$con) {
   			$e=oci_error();
      		echo $e; 
      		die('\ncould no connect');
      	} 

      	$d_id=$_POST['D_ID'];
      	$h_id=$_SESSION['H_ID'];
      	$d_name=$_POST['D_name'];
      	$d_age=$_POST['D_age'];
      	$d_gender=$_POST['D_gender'];
      	$d_phone=$_POST['D_phone'];
      	$d_pcr_result=$_POST['D_pcr_result'];
      	$d_pcr_date=$_POST['D_pcr_date'];
      	



      	
      	$q="insert into system.doctor (D_ID,H_ID,D_name,D_age,D_gender,D_phone,
      		D_pcr_result,D_pcr_date)values(".
      		$d_id.",".
      		$h_id.",'".
      		$d_name."',".
      		$d_age.",'".
      		$d_gender."',".
      		$d_phone.",'".
      		$d_pcr_result.
      		"',to_date('".$d_pcr_date."','yyyy-mm-dd'))";
		
      	$query_id=oci_parse($con, $q); 
      	$r=oci_execute($query_id); 
      	$r=oci_commit($con);

      	$q1="create user ".$d_name." identified by 1234";
      	$q2="grant doctor_role to ".$d_name;
      	$query_id=oci_parse($con, $q1); 
      	$r=oci_execute($query_id);
      	$query_id=oci_parse($con, $q2); 
      	$r=oci_execute($query_id);
      	$r=oci_commit($con);

      

      	?>
</body>
</html>