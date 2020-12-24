<!DOCTYPE html>
<html>
<head>
	<title>Login Failed</title>
</head>
<body>

	<?php

		$db_sid="(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
		(HOST=dbproject.cbwj5xiianms.us-east-2.rds.amazonaws.com)
		(PORT=1521))(CONNECT_DATA=(SID=CS213DB)))";

		$db_user=$_POST['u_name'];
		$db_pass=$_POST['pass'];

		//echo($db_user.$db_pass.$db_sid);

		$con = oci_connect($db_user,$db_pass,$db_sid); 
		echo('done');
   		if($con) {
      	 echo "Oracle Connection Successful."; 
   		}
   		else{ 
      		echo('Could not connect to Oracle: '); 
      	} 

	?>

</body>
</html>