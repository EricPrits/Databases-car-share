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
        <title>member</title>
		<h1>WELCOME TO KTOWN CAR SHARE</h1>
    </head>
<body>
	<?php
		session_start();
	 ?>


   <?php
        if(isset($_POST['rentalHistoryButton'])){
        header('Location: memberRentalHistory.php');
        exit;
}
 ?>
 
    <?php
        if(isset($_POST['pickupFormButton'])){
        header('Location: pickupForm.php');
        exit;
}
 ?>
 
	<?php
        if(isset($_POST['dropoffFormButton'])){
        header('Location: dropoffForm.php');
        exit;
}
 ?>
 
	<?php
        if(isset($_POST['reserveCarButton'])){
        header('Location: reserveCar.php');
        exit;
}
 ?>

    <form name='member' id='member' action='member.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='rentalHistoryButton' name='rentalHistoryButton' value='Rental History' />
            </td>
			<td>
                <input type='submit' id='pickupFormButton' name='pickupFormButton' value='Pick Up Car' />
            </td>
			<td>
                <input type='submit' id='dropoffFormButton' name='dropoffFormButton' value='Drop Off Car' />
            </td>
			<td>
                <input type='submit' id='reserveCarButton' name='reserveCarButton' value='Reserve Car' />
            </td>	
        </tr>
    </table>
    </form>
		<h2>Your Reservations</h2>
	<td><?php
                include_once 'config/connection.php'; 
                $query = "SELECT rental_ID, reservation_number, date, make, model, year FROM reservations NATURAL JOIN cars WHERE 	member_number=?;";
				$stmt = $con -> prepare($query); 
				if (isset($_SESSION['member_number'])) {
                    $temp_mem_num = $_SESSION['member_number'];
                }
                $stmt->bind_Param("s", $temp_mem_num);
				//$stmt->bind_Param("s", $_SESSION['member_number']);
         				
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
                $result = $stmt -> get_result();
                //echo "<br />" . $result -> num_rows . " rows in result <br />";

                echo '<table class="content" style="width:100%">
                  <tr class="content">
					<th class="content">reservation_number</th>
                    <th class="content">date</th>
                    <th class="content">make</th>
                    <th class="content">model</th>
                    <th class="content">year</th>
					<th class="content">rental_ID</th>
                  </tr>';
                while($row = $result->fetch_assoc())
                    {
                         echo '<tr class="content">
						        <td class="content">' . $row["reservation_number"] . '</td>
                                <td class="content">' . $row["date"] . '</td>
                                <td class="content">' . $row["make"] . '</td>
                                <td class="content">' . $row["model"] . '</td>
                                <td class="content">' . $row["year"] . '</td>
								<td class="content">' . $row["rental_ID"] . '</td>
                            </tr>';
                    }
                echo '</table>';
                $result->close();
                $con->close();
            ?></td>
	
</body>
</html>