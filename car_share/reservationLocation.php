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
        <title>Reservation Location</title>
    </head>
<body>
    <?php
    //Create a user session or resume an existing one
    session_start();
    ?>

   <?php
        if(isset($_POST['backButton'])){
        header('Location: reservations.php');
        exit;
    }
    ?>

    <form name='reservationLocation' id='reservationLocation' action='reservationLocation.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
            </td>
    </table>
    </form>
    <td>
    <?php
                include_once 'config/connection.php'; 
                $query = "SELECT * FROM cars right join reservations on cars.VIN=reservations.VIN where location_ID=?;";
                $stmt = $con -> prepare($query); 
                if (isset($_SESSION['currentReservationLocation'])) {
                    $currentLocation = $_SESSION['currentReservationLocation'];
                }
                $stmt->bind_Param("s", $currentLocation);
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
                $result = $stmt -> get_result();
                echo "<br />" . $result -> num_rows . " Reservation locations: " . $currentLocation . "<br />";

                echo '<table class="content" style="width:100%">
                  <tr class="content">
                    <th class="content">Retal ID #</th>
                    <th class="content">Reservation #</th>
					<th class="content">Location ID</th>
                    <th class="content">Member #</th>
                    <th class="content">VIN</th>
                    <th class="content">Access Code</th>
                    <th class="content">Reservation Length</th>
                    <th class="content">Date</th>
                  </tr>';
                while($row = $result->fetch_assoc())
                    {
                         echo '<tr class="content">
                                <td class="content">' . $row["rental_ID"] . '</td>
                                <td class="content">' . $row["reservation_number"] . '</td>
								<td class="content">' . $row["location_ID"] . '</td>
                                <td class="content">' . $row["member_number"] . '</td>
                                <td class="content">' . $row["VIN"] . '</td>
                                <td class="content">' . $row["access_code"] . '</td>
                                <td class="content">' . $row["reservation_length"] . '</td>
                                <td class="content">' . $row["date"] . '</td>
                            </tr>';
                    }
                echo '</table>';
                $result->close();
                $con->close();
            ?></td>
</body>
</html>