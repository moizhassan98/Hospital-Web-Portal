<!DOCTYPE html>
<html>
<head>
	<title>
	
	</title>

	<link rel="stylesheet" type="text/css" href="css/table.css">
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
	<?php

		function get_hospital_name($H_ID,$con){
			$q="select H_name from system.hospital where H_ID=".$H_ID;
			$query_id=oci_parse($con, $q);
			$r=oci_execute($query_id);
			$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
			return $row[0];

		}
		function get_doctor_name($D_ID,$con){
			$q="select D_name from system.doctor where D_ID=".$D_ID;
			$query_id=oci_parse($con, $q);
			$r=oci_execute($query_id);
			$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
			return $row[0];

		}
		function get_patient_name($P_ID,$con){
			$q="select P_name from system.patient where P_ID=".$P_ID;
			$query_id=oci_parse($con, $q);
			$r=oci_execute($query_id);
			$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
			return $row[0];

		}

	?>
	<h2>Dashboard</h2>
	<h3>Patients</h3>
	<table class="styled-table">

		<thead>
			<tr>
				<th>P_ID</th>
				<th>Name</th>
				<th>Age</th>
				<th>Gender</th>
				<th>Area</th>
				<th>Phone</th>
				<th>PCR Result</th>
				<th>Oxygen Level</th>
				<th>Self Quarantined?</th>
				<th>Quarantined Days</th>
				<th>Result</th>
			</tr>
		</thead>
		<tbody>
	<?php

		$q="select * from system.patient";
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		
		while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
			echo "<tr>  <td>".$row['P_ID']."</td>
						<td>".$row['P_NAME']."</td>
						<td>".$row['P_AGE']."</td>
						<td>".$row['P_GENDER']."</td>
						<td>".$row['P_AREA']."</td>
						<td>".$row['P_PHONE']."</td>
						<td>".$row['P_PCR_RESULT']."</td>
						<td>".$row['P_OXY_LEVEL']."%</td>
						<td>".$row['P_SELF_QUARANTINED']."</td>
						<td>".$row['P_QUARANTINE_DAYS']."</td>
						<td>".$row['P_RESULT']."</td>
					  </tr>";
		}


	?>
	</tbody>
	</table>

	<h3>Doctors</h3>
	<table class="styled-table">

		<thead>
			<tr>
				<th>D_ID</th>
				<th>Name</th>
				<th>Age</th>
				<th>Gender</th>
				<th>Phone</th>
				<th>PCR Result</th>
				<th>Last PCR Date</th>
				<th>Hospital ID</th>
			</tr>
		</thead>
		<tbody>
		<?php

		$q="select * from system.doctor";
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		
		while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
			echo "<tr>  <td>".$row['D_ID']."</td>
						<td>".$row['D_NAME']."</td>
						<td>".$row['D_AGE']."</td>
						<td>".$row['D_GENDER']."</td>
						<td>".$row['D_PHONE']."</td>
						<td>".$row['D_PCR_RESULT']."</td>
						<td>".$row['D_PCR_DATE']."</td>
						<td>".$row['H_ID']."</td>
					  </tr>";
		}


	?>
	</tbody>
	</table>

	<h3>Appointments</h3>

	<table class="styled-table">

		<thead>
			<tr>
				<th>Appointment ID</th>
				<th>Patient Name</th>
				<th>Doctor Name</th>
				<th>Hospital Name</th>
			</tr>
		</thead>
		<tbody>
		<?php

		$q="select * from system.appointments";
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		
		while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
			echo "<tr>  <td>".$row['A_ID']."</td>
						<td>".get_patient_name($row['P_ID'],$con)."</td>
						<td>".get_doctor_name($row['D_ID'],$con)."</td>
						<td>".get_hospital_name($row['H_ID'],$con)."</td>
					  </tr>";
		}


	?>
	</tbody>
	</table>

	<h2>Doctor</h2>
	<h3>Add Doctors</h3>




</body>
</html>