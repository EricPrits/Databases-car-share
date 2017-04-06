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
	<title>reserveCar</title>
	<h1>Car Reservation</h1>
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
		if(isset($_POST['reservation_confirmation'])){
			if(isset($_POST['location_select']) && isset($_POST['reservation_date'])){
				$location = $_POST['location_select'];
				$reserve_date = $_POST['reservation_date'];
				$_SESSION['location'] = $location;
				$_SESSION['res_date'] = $reserve_date;
			}
			header('Location: available_cars.php');
			exit;
		}
	?>
	
	<?php
		if(isset($_POST['testButton'])){
			//echo "Favorite color is ". $_POST['location_select'] . ".<br>";
			if(isset($_POST['location_select'])){
				echo "Favorite color is ". $_POST['location_select'] . ".<br>";
			}
			if(isset($_POST['reservation_date'])){
				echo "Favorite color is ". $_POST['reservation_date'] . ".<br>";
			}
			//header('Location: reserveCar.php');
			//exit;
		}
	?>
		
		<form name='reserveCar1' id='reserveCar1' action='reserveCar.php' method='post'>
			<table border='0'>
				<td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
			
				</td>
			</table>
		</form>
		
		<form name='reserveCar2' id='reserveCar2' action='reserveCar.php' method='post'>
			<table border='0'>
				<td>
					<label for="location_select">Select a Pickup Location</label>
					<select name = 'location_select' id='location_select'>
						<option value="0">1234 Kingston Way</option>
						<option value="1">5678 Princess Street</option>
						<option value="3">8765 Division street</option>
					</select>
				</td>
				<td>
				<label for="reservation_date">Reservation Date</label>
                <input type="date" id="reservation_date" name="reservation_date">
				</td>
				<td>
                <input type='submit' id='reservation_confirmation' name='reservation_confirmation' value='Get Available Cars' />
				</td>
				<td>
				<input type='submit' id='testButton' name='testButton' value='test' />
				</td>
			</table>
		</form>
		
		
	</body>
</html>