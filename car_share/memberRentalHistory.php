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
	<title>memberRentalHistory</title>
	<h1>RENTAL HISTORY</h1>
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
		
		<form name='memberRentalHistory' id='memberRentalHistory' action='memberRentalHistory.php' method='post'>
			<table border='0'>
				<td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
				</td>
			</table>
		</form>
		
		<td>
		<?php
                include_once 'config/connection.php'; 
                $query = "SELECT make, model, year, rental_ID, date FROM `mem_rental` NATURAL JOIN `car_rental` NATURAL JOIN `cars` WHERE member_number = ?";
                $stmt = $con -> prepare($query); 
                if (isset($_SESSION['member_number'])) {
                    $temp_mem_num = $_SESSION['member_number'];
                }
                $stmt->bind_Param("s", $temp_mem_num);
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
                $result = $stmt -> get_result();
                //echo "<br />" . $result -> num_rows . " rental(s) found for car " . $currentVIN . "<br />";

                echo '<table class="content" style="width:100%">
                  <tr class="content">
                    <th class="content">Make</th>
                    <th class="content">Model</th>
                    <th class="content">Year</th>
                    <th class="content">Rental ID</th>
                    <th class="content">Date</th>
                  </tr>';
                while($row = $result->fetch_assoc())
                    {
                         echo '<tr class="content">
                                <td class="content">' . $row["make"] . '</td>
                                <td class="content">' . $row["model"] . '</td>
                                <td class="content">' . $row["year"] . '</td>
                                <td class="content">' . $row["rental_ID"] . '</td>
                                <td class="content">' . $row["date"] . '</td>
                            </tr>';
                    }
                echo '</table>';
                $result->close();
                $con->close();
            ?></td>
		
	</body>
</html>