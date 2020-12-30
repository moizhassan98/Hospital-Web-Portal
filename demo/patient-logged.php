<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 
		//error_reporting(0);
		session_start(); 
		//$con=$_SESSION['con'];
		$db_user=$_SESSION['u_name'];
		$db_pass=$_SESSION['pass'];
		$db_sid=$_SESSION['sid'];
		//echo($db_user." ".$db_pass);
		$con=oci_connect($db_user, $db_pass, $db_sid);
		if(!$con) {
   				$e=oci_error();
      			echo $e; 
      			die('\ncould no connect');
      	} 


	?>
	<h2>Dashboard</h2>
	<div>create edit button for editing details</div>
	<div>
		Patient logged!
	</div>
	<?php
		$q="select * from system.patient where P_name='".$db_user."'";
		
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
		//print_r($row);

		$patient_ID=$row['P_ID'];
		


	?>

	<div>Name : <?php echo $row['P_NAME']; ?></div>
	<div>Age : <?php echo $row['P_AGE']; ?></dir>
	<div>Gender : <?php echo $row['P_GENDER']; ?></dir>
	<div>Area : <?php echo $row['P_AREA']; ?></dir>
	<div>Phone number : <?php echo $row['P_PHONE']; ?></dir>
	<div>PCR Result : <?php echo $row['P_PCR_RESULT']; ?></dir>
	<div>Oxygen Saturation Level : <?php echo $row['P_OXY_LEVEL']; ?></dir>
	<div>Self Quarantined? : <?php echo $row['P_SELF_QUARANTINED']; ?></dir>
	<div>Quarantined Days : <?php echo $row['P_QUARANTINE_DAYS']; ?></div>
	<div>Result : <?php echo $row['P_RESULT']; ?></div>



	<h2>Book an appointment</h2>
	
	
		
		<div>
			<?php 
				$q="select * from system.hospital";
				$query_id=oci_parse($con, $q);
				$r=oci_execute($query_id);
				echo "<form action='' method='POST' >Hospital:  <select name='hos-sel' >";
				while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
					echo "<option value=".$row['H_NAME']." >".$row['H_NAME']."</option>";
				}
				echo "</select> ";
				$q="select * from system.doctor ";
				$query_id=oci_parse($con, $q);
				$r=oci_execute($query_id);
				echo "<br> Doctor:   <select name='doc-sel'>";
				while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
					echo "<option value=".$row['D_NAME']." >".$row['D_NAME']."</option>";
				}
				echo "</select><br> <input type='submit' name='sel' value='Book Appointment'/></form>";

				if(isset($_POST['sel'])){
					$hospital=$_POST['hos-sel'];
					$doctor=$_POST['doc-sel'];

					$q="select d_id from system.doctor where d_name= '".$doctor."'";
					$query_id=oci_parse($con, $q);
					$r=oci_execute($query_id);
					$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
					$doctor_ID=$row[0];

					$q="select h_id from system.hospital where h_name= '".$hospital."'";
					$query_id=oci_parse($con, $q);
					$r=oci_execute($query_id);
					$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
					$hospital_ID=$row[0];

					
					$q="select count(*) from system.appointments where p_id= ".$patient_ID;
					$query_id=oci_parse($con, $q);
					$r=oci_execute($query_id);
					$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
					if($row[0]){
						echo("<br>You already have an appointment with Doctor ");
						$q="select d_id from system.appointments where p_id= ".$patient_ID;
						$query_id=oci_parse($con, $q);
						$r=oci_execute($query_id);
						$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
						$q="select d_name from system.doctor where d_id=".$row[0];
						$query_id=oci_parse($con, $q);
						$r=oci_execute($query_id);
						$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
						echo $row[0];


					}
					else{

						$q="insert into system.appointments(A_ID,P_ID,D_ID,H_ID) values(".rand().",".$patient_ID.",".$doctor_ID.",".$hospital_ID.")";
						$query_id=oci_parse($con, $q);
						$r=oci_execute($query_id);
						if(!$r){
							echo("Sorry that doctor doesn't work in that hospital");
						}
						$r=oci_commit($con);


					}

				}//if(isset) end



			?>
			
		</div>

		<div>
			<h2> Change Password</h2>
			<form action="" method="POST">
				Current password:<input type="Password" name="old-password" />
				New Password:<input type="Password" name="new-password" />
				<input type="submit" name="change-pass" value="Change Password"/>
			</form>

			<?php

				$current_pwd=$_POST['old-password'];
				$new_pwd=$_POST['new-password'];
				$r=oci_password_change($con, $db_user, $current_pwd, $new_pwd);
				if($r){
					echo "<br>Password Changed";
				}

			?>

			
		</div>


	</body></html>

	

