<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	//error_reporting(0);


	$db_sid = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST=Turab-PC)(PORT = 1521)) )(CONNECT_DATA = (SID = orcl) ) )";

		$db_user="test_doctor";
		$db_pass="1234";

		$con = oci_connect($db_user,$db_pass,$db_sid);
   		if(!$con) {
   			$e=oci_error();
      		echo $e; 
      		die('\ncould no connect');
      	} 

      	// TODO: make sure H_ID and D_ID is dynamix and not hardcodded
      	$q="insert into system.patient (P_ID,D_ID,H_ID,P_name,P_age,P_gender,P_area,P_phone,
      		P_pcr_result,P_oxy_level,P_self_quarantined,P_quarantine_days,P_result,P_oxygen,P_ventilator)
      		values(".$_POST['P_ID'].",69,5,'".$_POST['P_name']."',".$_POST['P_age'].",'"
      		.$_POST['P_gender']."','".$_POST['P_area']."',".$_POST['P_phone'].",'"
      		.$_POST['P_pcr_result']."',".$_POST['P_oxy_level'].",'"
     		.$_POST['P_self_quarantined']."',".$_POST['P_quarantine_days'].",'"
      		.$_POST['P_result']."','".$_POST['P_oxygen']."','".$_POST['P_ventilator']
      		."')";
		
      	$query_id=oci_parse($con, $q); 
      	$r=oci_execute($query_id); 
      	$r=oci_commit($con);

      	$q1="create user ".$_POST['P_name']." identified by 1234";
      	$q2="grant patient_role to ".$_POST['P_name'];
      	$query_id=oci_parse($con, $q1); 
      	$r=oci_execute($query_id);
      	$query_id=oci_parse($con, $q2); 
      	$r=oci_execute($query_id);
      	$r=oci_commit($con);

	?>



	 
</body>
</html>