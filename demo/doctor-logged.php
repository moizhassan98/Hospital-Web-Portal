<!DOCTYPE html>
<html>
<head>
	<title></title>
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
	<h2>Dashboard</h2>
	<?php
		$q="select * from system.doctor where D_name='".$db_user."'";
		
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
		//print_r($row);

		$doctor_ID=$row['D_ID'];

		$q="select H_name from system.hospital where H_ID='".$row['H_ID']."'";
		
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		$ro=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
		$hospital_name=$ro[0];



		


	?>

	<div>Name : <?php echo $row['D_NAME']; ?></div>
	<div>Age : <?php echo $row['D_AGE']; ?></dir>
	<div>Gender : <?php echo $row['D_GENDER']; ?></dir>
	<div>Phone number : <?php echo $row['D_PHONE']; ?></dir>
	<div>PCR Result : <?php echo $row['D_PCR_RESULT']; ?></dir>
	<div>Last date of PCR : <?php echo $row['D_PCR_DATE']; ?></div>
	<div>Hospital Name : <?php echo $hospital_name; ?></div>

	<h2>Patients</h2>
	<h3>View Own Patients patients</h3>

	<table class="styled-table">
		<thead>
			<tr>
				<th>P_ID</th>
				<th>Name</th>
				<th>Oxygen Level</th>
				<th>Recommendation</th>

			</tr>
		</thead>
		<tbody>
	<form action="recommend.php" method="POST">	
	<?php

		
		$q="select * from system.patient where D_ID=".$doctor_ID;
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		
		while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
			if($row['P_OXY_LEVEL']>85){
				echo "<tr>";
			}
			if($row['P_OXY_LEVEL']<=85 && $row['P_OXY_LEVEL']>60){
				echo "<tr class='oxygen-needed'>";


			}
			if($row['P_OXY_LEVEL']<=60){
				echo "<tr class='ventilator-needed'>";
			}
			
			echo "<td>".$row['P_ID']."</td>
					<td>".$row['P_NAME']."</td>
					<td>".$row['P_OXY_LEVEL']."</td>";

			if($row['P_OXY_LEVEL']<=90 && $row['P_OXY_LEVEL']>85){
				echo "<td> Monitor </td>";
			}

			if($row['P_OXY_LEVEL']<=85 && $row['P_OXY_LEVEL']>60){
				echo "<td> <input type='submit' name='oxygen-btn' value='Oxygen'/> </td>";
			}
			if($row['P_OXY_LEVEL']<=60){
				echo "<td> <input type='submit' name='ventilatoe-btn' value='Ventilator'/> </td>";
			}			

			echo"</tr>";
		}

	?>
	</form>

	</tbody>
		
	</table>

	<h2>Search</h2>
		<form action="" method="POST">
			Enter the name of Patient: <input type="text" name="name-search">
			or Enter Mobile number: <input type="number" name="phone-search">
			<input type="submit" name="search-btn" value="Search"/>
		</form>

		<table class="styled-table">
		<thead>
			<tr>
				<th>P_ID</th>
				<th>Name</th>
				<th>Age</th>
				<th>Gender</th>
				<th>PCR Result</th>
				<th>Result</th>

			</tr>
		</thead>
		<tbody>

		<?php

			if(isset($_POST['search-btn'])){
				if($_POST['name-search']){
					$q="select * from system.patient where P_name='".$_POST['name-search']."'";
				}
				if($_POST['phone-search']){
					$q="select * from system.patient where P_phone=".$_POST['phone-search'];
				}
				$query_id=oci_parse($con, $q);
				$r=oci_execute($query_id);
				$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);

				echo "<tr> <td>".$row['P_ID']."</td>
						   <td>".$row['P_NAME']."</td>
						   <td>".$row['P_AGE']."</td>
						   <td>".$row['P_GENDER']."</td>
						   <td>".$row['P_PCR_RESULT']."</td>
						   <td>".$row['P_RESULT']."</td>
					  </tr>";
			}

		?>
	</tbody>
	</table>

	<h2>All Patients</h2>
	<table class="styled-table">
		<thead>
			<tr>
				<th>P_ID</th>
				<th>Name</th>
				<th>Age</th>
				<th>Gender</th>
				<th>PCR Result</th>
				<th>Result</th>
			</tr>
		</thead>
		<tbody>
	<?php

		$q="select * from system.patient";
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		
		while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
			echo "<tr> <td>".$row['P_ID']."</td>
						<td>".$row['P_NAME']."</td>
						   <td>".$row['P_AGE']."</td>
						   <td>".$row['P_GENDER']."</td>
						   <td>".$row['P_PCR_RESULT']."</td>
						   <td>".$row['P_RESULT']."</td>
					  </tr>";
		}


	?>
	</tbody>
	</table>

	<h2>Account Managment</h2>


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



</body>
</html>