<!DOCTYPE HTML>
<html>
	<head>
	<title>PickupFormPage</title>
	<h1>Pick Up Your Reservation</h1>
	</head>
	<body>
		<?php
			//Create a user session or resume an existing one
			session_start();
			?>
			
			<?php
			if(isset($_POST['backButton'])){
			header('Location: member.php');
			exit;
			}
		?>
		
		<?php
			include_once 'config/connection.php'; 
			if(isset($_POST['pickup_confirmation'])){
				if (isset($_POST['rental_ID']) && isset($_POST['pickup_odemeter']) && isset($_POST['pickup_time'])){
				//$query = "INSERT INTO rental(rental_ID, pickup_odemeter, pickup_time) VALUES(?, ?, ?)";
				$query  = 	"UPDATE rental 
							SET pickup_odemeter = ?, pickup_time = ?
							WHERE rental_ID = ?";
				$stmt = $con -> prepare($query);
				//$stmt->bind_param("sss", $rental_ID, $pickup_odemeter, $pickup_time);
				$stmt->bind_param("sss", $odemeter_pickup, $time_at_pickup, $ID_rental);
				$ID_rental = $_POST['rental_ID'];
				$odemeter_pickup = $_POST['pickup_odemeter'];
				$time_at_pickup = $_POST['pickup_time'];
				$stmt->execute();
				
				//echo "Pick Up succsesful, enjoy! .<br>";
				
				//Get the correct VIN number
				$query = 	"SELECT VIN
							FROM reservations
							WHERE rental_ID = ?";
				$stmt = $con -> prepare($query);
				$stmt->bind_param("s", $ID_rental);
				
				try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
				
				$result = $stmt -> get_result();
				$row = $result->fetch_assoc();
				$the_VIN = $row['VIN'];
				
				//insert new row into member_comments
				
				$query = 	"INSERT INTO rental_comments(rental_ID, VIN, member_number) VALUES(?, ?, ?)";
				$stmt = $con -> prepare($query);
				$stmt->bind_param("sss", $ID_rental, $the_VIN, $_SESSION['member_number']);
				
				try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
				
				//insert new row into car_rental
				$query = 	"SELECT date
							FROM reservations
							WHERE rental_ID = ?";
				$stmt = $con -> prepare($query);
				$stmt->bind_param("s", $ID_rental);
				try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
				$result = $stmt -> get_result();
				$row = $result->fetch_assoc();
				$reserve_date = $row['date'];
				
				$query = 	"INSERT INTO car_rental(rental_ID, VIN, date) VALUES(?, ?, ?)";
				$stmt = $con -> prepare($query);
				$stmt->bind_param("sss", $ID_rental, $the_VIN, $reserve_date);
				try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
				
				//insert new row into mem_rental
				$query = 	"INSERT INTO mem_rental(rental_ID, member_number, date) VALUES(?, ?, ?)";
				$stmt = $con -> prepare($query);
				$stmt->bind_param("sss", $ID_rental, $_SESSION['member_number'], $reserve_date);
				try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
	
            }
			//header('Location: pickupForm.php');
			//exit; 			
			}
			
		?>
		
		<form name='pickupForm1' id='pickupForm1' action='memberRentalHistory.php' method='post'>
			<table border='0'>
				<td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
				</td>
			</table>
		</form>
		
		<form name='pickupForm2' id='pickupForm2' action='pickupForm.php' method='post'>
			<table border='0'>
				<td>
				<label for="rental_ID">Rental ID</label>
                <input type='text' id='rental_ID' name='rental_ID' value='0000' />
				</td>
				<td>
				<label for="pickup_odemeter">Pickup Odometer</label>
                <input type='text' id='pickup_odemeter' name='pickup_odemeter' value='km' />
				</td>
				<td>
				<label for="pickup_time">Pickup Time</label>
                <input type='text' id='pickup_time' name='pickup_time' value='yyyy-mm-dd hh:mm:ss' />
				</td>
				<td>
                <input type='submit' id='pickup_confirmation' name='pickup_confirmation' value='Confirm Pickup Info' />
				</td>
			</table>
		</form>
	</body>

</html>