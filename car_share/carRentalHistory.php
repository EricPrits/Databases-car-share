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
        <title>rentalHistory</title>
    </head>
<body>
    <?php
    //Create a user session or resume an existing one
    session_start();
    include_once 'config/connection.php'; 
    if(!isset($_SESSION['member_number'])){
        //User is not logged in. Redirect the browser to the login index.php page and kill this page.
        header("Location: startup.php");
        die();
    }
    ?>

   <?php
        if(isset($_POST['backButton'])){
        header('Location: cars.php');
        exit;
    }
    ?>
    <form name='carRentalHistory' id='carRentalHistory' action='carRentalHistory.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
            </td>
            <td><a href="startup.php?logout=1">Log Out</a><br/></td>
    </table>
    </form>
    <td>
    <?php
                include_once 'config/connection.php'; 
                $query = "SELECT * FROM car_rental natural join rental where vin=?;";
                $stmt = $con -> prepare($query); 
                if (isset($_SESSION['currentRentalHistoryVIN'])) {
                    $currentVIN = $_SESSION['currentRentalHistoryVIN'];
                }
                $stmt->bind_Param("s", $currentVIN);
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
                $result = $stmt -> get_result();
                echo "<br />" . $result -> num_rows . " rental(s) found for car " . $currentVIN . "<br />";

                echo '<table class="content" style="width:100%">
                  <tr class="content">
                    <th class="content">Rental ID</th>
                    <th class="content">Date</th>
                    <th class="content">Pickup Odemeter</th>
                    <th class="content">Dropoff Odemeter</th>
                    <th class="content">Pickup Time</th>
                    <th class="content">Dropoff Time</th>
                    <th class="content">Return Status</th>
                  </tr>';
                while($row = $result->fetch_assoc())
                    {
                         echo '<tr class="content">
                                <td class="content">' . $row["rental_ID"] . '</td>
                                <td class="content">' . $row["date"] . '</td>
                                <td class="content">' . $row["pickup_odemeter"] . '</td>
                                <td class="content">' . $row["dropoff_odemeter"] . '</td>
                                <td class="content">' . $row["pickup_time"] . '</td>
                                <td class="content">' . $row["dropoff_time"] . '</td>
                                <td class="content">' . $row["return_status"] . '</td>
                            </tr>';
                    }
                echo '</table>';
                $result->close();
                $con->close();
            ?></td>
</body>
</html>