<!DOCTYPE HTML>
<html>
	<head>
	<title>DropoffFormPage</title>
	<h1>Drop Off Your Reservation</h1>
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
			if(isset($_POST['dropoff_confirmation'])){
				if(isset($_POST['rental_ID']) && isset($_POST['dropoff_odemeter']) && isset($_POST['dropoff_time']) && isset($_POST['return_status']) && isset($_POST['comment']) && isset($_POST['rating'])){
					$dropoffOdem = $_POST['dropoff_odemeter'];
					$dropoffTime = $_POST['dropoff_time'];
					$returnStatus = $_POST['return_status'];
					$rentalID = $_POST['rental_ID'];
					$comment = $_POST['comment'];
					$rating = $_POST['rating'];
					$query  =	"UPDATE rental 
								SET dropoff_odemeter = ?, dropoff_time = ?, return_status = ?
								WHERE rental_ID = ?";
					$stmt = $con -> prepare($query);
					$stmt->bind_param("ssss", $dropoffOdem, $dropoffTime, $returnStatus, $rentalID);
					
					try {
					$stmt -> execute(); }
					catch(Exception $exception) {
					echo "Query failed: ", $exception->getMessage(); }
					
					$query  =	"UPDATE rental_comments 
								SET rating = ?, comment_text = ? 
								WHERE rental_ID = ?";
					$stmt = $con -> prepare($query);
					$stmt->bind_param("sss", $rating, $comment, $rentalID);
					
					try {
					$stmt -> execute(); }
					catch(Exception $exception) {
					echo "Query failed: ", $exception->getMessage(); }
					
					$query = 	"DELETE FROM reservations
								WHERE rental_ID = ?";
					$stmt = $con -> prepare($query);
					$stmt->bind_param("s", $rentalID);
					
					try {
					$stmt -> execute(); }
					catch(Exception $exception) {
					echo "Query failed: ", $exception->getMessage(); }

				}
			header('Location: member.php');
			exit;
			}
		?>
		
		<form name='dropOffForm1' id='dropOffForm1' action='dropoffForm.php' method='post'>
			<table border='0'>
				<td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
				</td>
			</table>
		</form>
		
		<form name='dropOffForm2' id='dropOffForm2' action='dropoffForm.php' method='post'>
			<table border='0'>
				<td>
				<label for="rental_ID">Rental ID</label>
                <input type='text' id='rental_ID' name='rental_ID' value='0000' />
				</td>
				<td>
				<label for="pickup_odemeter">Dropoff Odometer</label>
                <input type='text' id='dropoff_odemeter' name='dropoff_odemeter' value='km' />
				</td>
				<td>
				<label for="dropoff_time">Dropoff Time</label>
                <input type='text' id='dropoff_time' name='dropoff_time' value='yyyy-mm-dd hh:mm:ss' />
				</td>
				<td>
				<label for="return_status">Return Status</label>
					<select name = 'return_status' id='return_status'>
						<option value="normal">Normal</option>
						<option value="damaged">Damaged</option>
						<option value="not running">Not Running</option>
					</select>				</td>
				<td>
                <input type='submit' id='dropoff_confirmation' name='dropoff_confirmation' value='Confirm Dropoff Info' />
				</td>
				<label for="comment">Comment</label>
                <input type='text' id='comment' name='comment' value='' />
				</td>
				<label for="rating">Rating</label>
                <input type='text' id='rating' name='rating' value='' />
				</td>
			</table>
		</form>
	</body>
</html>