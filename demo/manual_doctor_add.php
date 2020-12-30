<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
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
      ?>
	<form action="doc-add.php" method="post">
		<div>
			ID:<input type="number" name="D_ID">
		</div>
		<div>
			Name :<input type="text" name="D_name">
		</div>
		<div>
			Age :<input type="number" name="D_age">
		</div>
		<div>
			Gender:<input type="radio" name="D_gender" value="Male">Male 
					<input type="radio" name="D_gender" value="Female">Female
		</div>
		
		<div>
			phone:<input type="number" name="D_phone">
		</div>
		<div>
			PCR Result:<input type="radio" name="D_pcr_result" value="positive">positive 
						<input type="radio" name="D_pcr_result" value="negative">negative
		</div>
		<div>
			PCR Last date:<input type="date" name="D_pcr_date" >
		</div>
	
		<div>
			<?php $q="select * from system.hospital";
				$query_id=oci_parse($con, $q);
				$r=oci_execute($query_id);
				echo "<form action='doc-add.php' method='POST' >Hospital:  <select name='hos-sel' >
				<option value=''></option>";
				while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
					echo "<option value=".$row['H_NAME']." >".$row['H_NAME']."</option>";
				}
				echo "</select><br><input type='submit'name='sel' value='Sign-up'/></form> ";
				if(isset($_POST['sel'])){
					$hospital=$_POST['hos-sel'];
					$q="select h_id from system.hospital where h_name= '".$hospital."'";
					$query_id=oci_parse($con, $q);
					$r=oci_execute($query_id);
					$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
					$hospital_ID=$row[0];
					$_SESSION['H_ID']=$hospital_ID;


				}






			?>
		</div>
	

		<div>
			

			
		</div>
	</form>
</body>
</html>