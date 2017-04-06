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
        <title>Invoice</title>
    </head>
<body>
    <?php
    //Create a user session or resume an existing one
    session_start();
    ?>

   <?php
        if(isset($_POST['backButton'])){
        header('Location: membersInfo.php');
        exit;
    }
    ?>

    <form name='invoice' id='invoice' action='invoice.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
            </td>
    </table>
    </form>
			<td>
			<?php
                include_once 'config/connection.php'; 
                $query = "SELECT *,daily_fee * reservation_length AS total_cost FROM reservations left join cars on reservations.VIN=cars.VIN where member_number=? and date BETWEEN ? and ?";
                $stmt = $con -> prepare($query); 
                if (isset($_SESSION['currentMemberInfoNum']) && isset($_SESSION['currentDateFrom']) && isset($_SESSION['currentDateTo'])) {
                    $currentMNum = $_SESSION['currentMemberInfoNum'];
					$currentDFrom = $_SESSION['currentDateFrom'];
					$currentDTo = $_SESSION['currentDateTo'];
                }
                $stmt->bind_Param("sss", $currentMNum,$currentDFrom,$currentDTo);
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
                $result = $stmt -> get_result();
                echo "<br />" . " Invoice for Member: " . $currentMNum . "<br />";

                echo '<table class="content" style="width:100%">
                  <tr class="content">
				    <th class="content">Date</th>
                    <th class="content">Rental ID</th>
                    <th class="content">Reservation #</th>
                    <th class="content">VIN</th>
					<th class="content">Make</th>
                    <th class="content">Model</th>
				    <th class="content">Reservation Length</th>
                    <th class="content">Daily Fee</th>
					<th class="content">Total Cost</th>
                  </tr>';
                while($row = $result->fetch_assoc())
                    {
                         echo '<tr class="content">
								<td class="content">' . $row["date"] . '</td>
                                <td class="content">' . $row["rental_ID"] . '</td>
                                <td class="content">' . $row["reservation_number"] . '</td>
                                <td class="content">' . $row["VIN"] . '</td>
								<td class="content">' . $row["make"] . '</td>
                                <td class="content">' . $row["model"] . '</td>
								<td class="content">' . $row["reservation_length"] . '</td>
                                <td class="content">' . $row["daily_fee"] . '</td>
								<td class="content">' . $row["total_cost"] . '</td>
                            </tr>';
                    }
                echo '</table> Total fee due:';
				
				
				$query = "SELECT SUM(daily_fee * reservation_length) +25 as fee_due FROM reservations left join cars on reservations.VIN=cars.VIN where member_number=? and date BETWEEN ? and ?";
                $stmt = $con -> prepare($query); 
               if (isset($_SESSION['currentMemberInfoNum']) && isset($_SESSION['currentDateFrom']) && isset($_SESSION['currentDateTo'])) {
                    $currentMNum = $_SESSION['currentMemberInfoNum'];
					$currentDFrom = $_SESSION['currentDateFrom'];
					$currentDTo = $_SESSION['currentDateTo'];
                }
                $stmt->bind_Param("sss", $currentMNum,$currentDFrom,$currentDTo);
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
                $result = $stmt -> get_result();
				
                while($row = $result->fetch_assoc())
                    {
                         echo '<tr class="content">
								<td class="content">' . $row["fee_due"] . '</td>
                            </tr>';
                    }
                echo '</table>';
                $result->close();
                $con->close();
            ?></td>
</body>
</html>