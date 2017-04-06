<?php
		//Create a user session or resume an existing one
		session_start();
?>
<!DOCTYPE HTML>


<html>
	<head>
	<style>
        table.content, th.content, td.content {
        border: 1px solid black;
        border-collapse: collapse;
        }
        th.content, td.content {
            padding: 5px;
            text-align: left;    
                }
    </style>
	<title>AvailableCarsPage</title>
	<h1>Available Cars</h1>
	</head>
	<body>
			
	<?php
		if(isset($_POST['backButton'])){
			header('Location: reserveCar.php');
			exit;
		}
	?>
	
	<?php
	include_once 'config/connection.php'; 
		if(isset($_POST['reserveCarButton'])){
			if(isset($_POST['insertVIN']) && isset($_POST['insertDuration'])){
				$query = 	"SELECT MAX(rental_ID) AS maxRentalID
							FROM rental";
				$stmt = $con -> prepare($query);
				
				try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
				
				$result = $stmt -> get_result();
				$row = $result->fetch_assoc();
				$maximumRentalID = $row['maxRentalID'];
				$maximumRentalID = $maximumRentalID +1;
				
				$query = 	"SELECT MAX(reservation_number) AS maxReservationNumber
							FROM reservations";
				$stmt = $con -> prepare($query);
				
				try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
				
				$result = $stmt -> get_result();
				$row = $result->fetch_assoc();
				$maximumReservationNumber = $row['maxReservationNumber'];
				$maximumReservationNumber = $maximumReservationNumber +1;
				
				$query = 	"SELECT MAX(access_code) AS maxAccessCode
							FROM reservations";
				$stmt = $con -> prepare($query);
				
				try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
				
				$result = $stmt -> get_result();
				$row = $result->fetch_assoc();
				$maximumAccessCode = $row['maxAccessCode'];
				$maximumAccessCode = $maximumAccessCode +1;
				
				$query = 	"INSERT INTO reservations(rental_ID, reservation_number, member_number, VIN, access_code, reservation_length, date) VALUES(?, ?, ?, ?, ?, ?, ?)";
				$stmt = $con -> prepare($query);
				$stmt->bind_param("sssssss", $maximumRentalID, $maximumReservationNumber, $_SESSION['member_number'], $_POST['insertVIN'], $maximumAccessCode, $_POST['insertDuration'], $_SESSION['res_date']);
				
				try {
                $stmt -> execute(); 
				}
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
				
				$query = 	"INSERT INTO rental(rental_ID) VALUES(?)";
				$stmt = $con -> prepare($query);
				$stmt->bind_param("s",  $maximumRentalID);
				
				try {
                $stmt -> execute(); 
				echo "Succsessfull Reservation, Reservation ID:" . $maximumRentalID . ".<br>";
				}
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }

			}
			//header('Location: available_cars.php');
			//exit;
		}
	?>
	
	<form name='availableCars1' id='availableCars1' action='member.php' method='post'>
			<table border='0'>
				<td>
                <input type='submit' id='backButton' name='backButton' value='Back To Dashboard' />
				</td>
			</table>
		</form>
		
	<form name='availableCars2' id='availableCars2' action='available_cars.php' method='post'>
		<table border='0'>
		<td><?php
			include_once 'config/connection.php'; 
			$location = $_SESSION['location'];
			$res_date = $_SESSION['res_date'];
			$res_date2 = $_SESSION['res_date'];
			
				$query =	"SELECT VIN, address, make, model, year, daily_fee
							FROM parking_locations NATURAL JOIN cars NATURAL join reservations JOIN (SELECT ? as thedate) const
							WHERE location_ID = ?  AND (thedate < date OR
							thedate > (DATE_ADD(date, interval reservation_length day)))";
				$stmt = $con -> prepare($query);
 				$stmt->bind_param('ss', $res_date, $location);
				
				try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
				$result = $stmt -> get_result();
				
			echo '<table class="content" style="width:100%">
                  <tr class="content">
					<th class="content">VIN</th>
                    <th class="content">address</th>
                    <th class="content">make</th>
                    <th class="content">model</th>
                    <th class="content">year</th>
					<th class="content">daily_fee</th>
                  </tr>';
                while($row = $result->fetch_assoc())
                    {
                         echo '<tr class="content">
						        <td class="content">' . $row["VIN"] . '</td>
                                <td class="content">' . $row["address"] . '</td>
                                <td class="content">' . $row["make"] . '</td>
                                <td class="content">' . $row["model"] . '</td>
                                <td class="content">' . $row["year"] . '</td>
								<td class="content">' . $row["daily_fee"] . '</td>
                            </tr>';
                    }
                echo '</table>'
		?></td>
		</table>
		<td>
			<label for="insertVIN">Vehicle Identification Number</label>
			<input type='text' id='insertVIN' name='insertVIN' value='Vehicle VIN' />
		</td>
		<td>
			<label for="insertDuration">Duration of Reservation</label>
			<input type='text' id='insertDuration' name='insertDuration' value='Length in Days' />
		</td>
		<td>
			<input type='submit' id='reserveCarButton' name='reserveCarButton' value='Reserve Car' />
		</td>
		</table>
	</form>
	</body>
</html>