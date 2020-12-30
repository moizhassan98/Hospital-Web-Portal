<!DOCTYPE html>
<html>
<head>
	<title>Login Failed</title>
</head>
<body>

	<?php
		session_start();

		//$db_sid="(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
		//(HOST=dbproject.cbwj5xiianms.us-east-2.rds.amazonaws.com)
		//(PORT=1521))(CONNECT_DATA=(SID=CS213DB)))";
		$db_sid = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST=Turab-PC)(PORT = 1521)) )(CONNECT_DATA = (SID = orcl) ) )";


		
		if($_REQUEST['admin-login']){
			$db_user=$_POST['u_name_admin'];
			$db_pass=$_POST['pass_admin'];

			$con = oci_connect($db_user,$db_pass,$db_sid);
   			if(!$con) {
   				$e=oci_error();
      			echo $e; 
      			die('\ncould no connect');
      		} 
      		$_SESSION['con']=$con;
      		$_SESSION['u_name']=$db_user;
      		$_SESSION['pass']=$db_pass;
      		$_SESSION['sid']=$db_sid;
			header("Location: admin-logged.php");
			exit();
		}
		else if($_REQUEST['doctor-login']){
			$db_user=$_POST['u_name_doctor'];
			$db_pass=$_POST['pass_doctor'];

			$con = oci_connect($db_user,$db_pass,$db_sid);
   			if(!$con) {
   				$e=oci_error();
      			echo $e; 
      			die('\ncould no connect');
      		} 
      		$_SESSION['con']=$con;
      		$_SESSION['u_name']=$db_user;
      		$_SESSION['pass']=$db_pass;
      		$_SESSION['sid']=$db_sid;
			header("Location: doctor-logged.php");
			exit();
		}
		else if($_REQUEST['patient-login']){
			$db_user=$_POST['u_name_patient'];
			$db_pass=$_POST['pass_patient'];

			$con = oci_connect($db_user,$db_pass,$db_sid);
   			if(!$con) {
   				$e=oci_error();
      			echo $e; 
      			die('\ncould no connect');
      		} 
      		$_SESSION['con']=$con;
      		$_SESSION['u_name']=$db_user;
      		$_SESSION['pass']=$db_pass;
      		$_SESSION['sid']=$db_sid;
			header("Location: patient-logged.php");
			exit();
		}
	?>

	

</body>
</html>